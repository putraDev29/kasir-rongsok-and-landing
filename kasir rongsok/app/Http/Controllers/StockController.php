<?php

namespace App\Http\Controllers;

use App\Models\ItemCategory;
use App\Models\ScrapItem;
use App\Models\StockBalance;
use App\Models\StockMovement;
use App\Services\StockService;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class StockController extends Controller
{
    public function __construct(
        protected StockService $stockService
    ) {}

    public function index(Request $request): View
    {
        $user = Auth::user();
        $isGas = $user && $user->isAdminGas();

        $search = $request->query('search');
        $categoryId = $request->query('category_id');
        $lowStockOnly = $request->boolean('low_stock');

        $query = ScrapItem::with(['category', 'stockBalance', 'priceStocks'])
            ->when($isGas, function ($q) {
                $q->where('item_type', 'gas');
            }, function ($q) {
                $q->where(function ($sub) {
                    $sub->where('item_type', 'rongsok')->orWhereNull('item_type');
                });
            })
            ->when($search, function ($q) use ($search) {
                $q->where(function ($sub) use ($search) {
                    $sub->where('name', 'LIKE', "%{$search}%")
                        ->orWhere('code', 'LIKE', "%{$search}%");
                });
            })
            ->when($categoryId, function ($q) use ($categoryId) {
                $q->where('category_id', $categoryId);
            });

        if ($lowStockOnly) {
            $query->whereHas('stockBalance', function ($q) {
                $q->whereRaw('stock_balances.current_stock <= scrap_items.min_stock_alert');
            })->where('min_stock_alert', '>', 0);
        }

        $items = $query->paginate(15)->withQueryString();

        $catQuery = ItemCategory::where('is_active', true);
        if ($isGas) {
            $catQuery->where('type', 'gas');
        } else {
            $catQuery->where(function ($q) {
                $q->where('type', 'rongsok')->orWhereNull('type');
            });
        }
        $categories = $catQuery->get();

        // Overall stock totals
        $stockBalanceQuery = StockBalance::query();
        if ($isGas) {
            $stockBalanceQuery->whereHas('scrapItem', fn($q) => $q->where('item_type', 'gas'));
        } else {
            $stockBalanceQuery->whereHas('scrapItem', fn($q) => $q->where('item_type', 'rongsok')->orWhereNull('item_type'));
        }
        $totalStockKg = (float) $stockBalanceQuery->sum('current_stock');

        $valQuery = DB::table('stock_balances')->join('scrap_items', 'stock_balances.scrap_item_id', '=', 'scrap_items.id');
        if ($isGas) {
            $valQuery->where('scrap_items.item_type', 'gas');
        } else {
            $valQuery->where(function ($sub) {
                $sub->where('scrap_items.item_type', 'rongsok')->orWhereNull('scrap_items.item_type');
            });
        }
        $totalValuation = (float) $valQuery->selectRaw('SUM(stock_balances.current_stock * stock_balances.average_buy_price) as val')->value('val');

        return view('stock.index', compact('items', 'categories', 'search', 'categoryId', 'lowStockOnly', 'totalStockKg', 'totalValuation', 'isGas'));
    }

    public function movements(Request $request): View
    {
        $isGas = Auth::user() && Auth::user()->isAdminGas();
        $scrapItemId = $request->query('scrap_item_id');
        $type = $request->query('type');
        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');

        $query = StockMovement::with(['scrapItem', 'user'])
            ->when($isGas, function ($q) {
                $q->whereHas('scrapItem', fn($sq) => $sq->where('item_type', 'gas'));
            }, function ($q) {
                $q->whereHas('scrapItem', fn($sq) => $sq->where('item_type', 'rongsok'));
            })
            ->when($scrapItemId, function ($q) use ($scrapItemId) {
                $q->where('scrap_item_id', $scrapItemId);
            })
            ->when($type, function ($q) use ($type) {
                $q->where('type', $type);
            })
            ->when($startDate, function ($q) use ($startDate) {
                $q->whereDate('created_at', '>=', $startDate);
            })
            ->when($endDate, function ($q) use ($endDate) {
                $q->whereDate('created_at', '<=', $endDate);
            })
            ->latest();

        $movements = $query->paginate(20)->withQueryString();

        $scrapItemQuery = ScrapItem::query();
        if ($isGas) {
            $scrapItemQuery->where('item_type', 'gas');
        } else {
            $scrapItemQuery->where('item_type', 'rongsok');
        }
        $scrapItems = $scrapItemQuery->orderBy('name')->get();

        return view('stock.movements', compact('movements', 'scrapItems', 'scrapItemId', 'type', 'startDate', 'endDate', 'isGas'));
    }

    public function adjust(Request $request, ScrapItem $scrapItem): RedirectResponse
    {
        if (Auth::user() && Auth::user()->isAdminGas() && $scrapItem->item_type !== 'gas') {
            abort(403, 'Akses dibatasi. Anda hanya melayani produk Gas.');
        }

        $request->validate([
            'new_stock' => 'required|numeric|min:0',
            'reason' => 'required|string|max:255',
        ], [
            'reason.required' => 'Alasan penyesuaian stok (opname) wajib dicatat.',
        ]);

        try {
            $this->stockService->adjustStock(
                $scrapItem,
                (float) $request->input('new_stock'),
                $request->input('reason'),
                Auth::user()
            );

            return back()->with('success', "Stok barang '{$scrapItem->name}' berhasil disesuaikan.");
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}

