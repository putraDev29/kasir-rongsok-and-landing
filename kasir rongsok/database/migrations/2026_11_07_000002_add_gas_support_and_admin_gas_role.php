<?php

use App\Models\ItemCategory;
use App\Models\ItemPriceStock;
use App\Models\ScrapItem;
use App\Models\StockBalance;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Tambah kolom type pada item_categories jika belum ada
        if (Schema::hasTable('item_categories') && !Schema::hasColumn('item_categories', 'type')) {
            Schema::table('item_categories', function (Blueprint $table) {
                $table->string('type', 20)->default('rongsok')->index()->after('slug');
            });
        }

        // 2. Tambah kolom item_type pada scrap_items jika belum ada
        if (Schema::hasTable('scrap_items') && !Schema::hasColumn('scrap_items', 'item_type')) {
            Schema::table('scrap_items', function (Blueprint $table) {
                $table->string('item_type', 20)->default('rongsok')->index()->after('category_id');
            });
        }

        // 3. Seed Kategori Khusus Gas
        $catLpg = ItemCategory::firstOrCreate(
            ['slug' => 'gas-elpiji'],
            [
                'name' => 'Gas Elpiji (LPG)',
                'type' => 'gas',
                'description' => 'Aneka ukuran tabung gas elpiji dan isi ulang (3kg, 5.5kg, 12kg, 50kg)',
                'is_active' => true,
            ]
        );
        $catLpg->update(['type' => 'gas']);

        $catOksigen = ItemCategory::firstOrCreate(
            ['slug' => 'gas-oksigen'],
            [
                'name' => 'Gas Oksigen & Medis',
                'type' => 'gas',
                'description' => 'Tabung gas oksigen medis, rumah sakit, dan las industri (1m3, 6m3)',
                'is_active' => true,
            ]
        );
        $catOksigen->update(['type' => 'gas']);

        $catIndustri = ItemCategory::firstOrCreate(
            ['slug' => 'gas-industri'],
            [
                'name' => 'Gas Industri (Karbit, Argon & CO2)',
                'type' => 'gas',
                'description' => 'Tabung gas karbit/acetylene, argon, dan gas industri lainnya',
                'is_active' => true,
            ]
        );
        $catIndustri->update(['type' => 'gas']);

        // 4. Seed Produk Master Gas Awal beserta Stok & Harga
        $gasItems = [
            [
                'category_id' => $catLpg->id,
                'code' => 'GAS-LPG03',
                'name' => 'Tabung Gas LPG 3 Kg (Melon)',
                'unit' => 'tabung',
                'unit_type' => 'tabung',
                'item_type' => 'gas',
                'buy_price_per_kg' => 19000,
                'sell_price_per_kg' => 23000,
                'min_stock_alert' => 20,
                'description' => 'Tabung gas elpiji 3kg subsidi, melayani isi ulang & tukar tabung.',
                'stock' => 150,
            ],
            [
                'category_id' => $catLpg->id,
                'code' => 'GAS-BG05',
                'name' => 'Tabung Bright Gas 5.5 Kg',
                'unit' => 'tabung',
                'unit_type' => 'tabung',
                'item_type' => 'gas',
                'buy_price_per_kg' => 95000,
                'sell_price_per_kg' => 115000,
                'min_stock_alert' => 10,
                'description' => 'Tabung Bright Gas 5.5kg nonsubsidi warna pink.',
                'stock' => 30,
            ],
            [
                'category_id' => $catLpg->id,
                'code' => 'GAS-LPG12',
                'name' => 'Tabung Gas LPG 12 Kg (Biru / Bright)',
                'unit' => 'tabung',
                'unit_type' => 'tabung',
                'item_type' => 'gas',
                'buy_price_per_kg' => 195000,
                'sell_price_per_kg' => 225000,
                'min_stock_alert' => 15,
                'description' => 'Tabung gas elpiji 12kg untuk rumah tangga & usaha kuliner.',
                'stock' => 45,
            ],
            [
                'category_id' => $catLpg->id,
                'code' => 'GAS-LPG50',
                'name' => 'Tabung Gas LPG 50 Kg Industri',
                'unit' => 'tabung',
                'unit_type' => 'tabung',
                'item_type' => 'gas',
                'buy_price_per_kg' => 820000,
                'sell_price_per_kg' => 920000,
                'min_stock_alert' => 5,
                'description' => 'Tabung gas elpiji 50kg untuk kebutuhan pabrik, hotel & restoran besar.',
                'stock' => 12,
            ],
            [
                'category_id' => $catOksigen->id,
                'code' => 'GAS-OKS01',
                'name' => 'Tabung Oksigen 1 m³ (Medis & Las)',
                'unit' => 'tabung',
                'unit_type' => 'tabung',
                'item_type' => 'gas',
                'buy_price_per_kg' => 650000,
                'sell_price_per_kg' => 750000,
                'min_stock_alert' => 5,
                'description' => 'Tabung oksigen portabel 1m3 lengkap siap pakai.',
                'stock' => 18,
            ],
            [
                'category_id' => $catOksigen->id,
                'code' => 'GAS-OKS06',
                'name' => 'Tabung Oksigen 6 m³ (Industri / Workshop)',
                'unit' => 'tabung',
                'unit_type' => 'tabung',
                'item_type' => 'gas',
                'buy_price_per_kg' => 1400000,
                'sell_price_per_kg' => 1650000,
                'min_stock_alert' => 5,
                'description' => 'Tabung oksigen kapasitas 6m3 untuk bengkel las, proyek potong besi & industri.',
                'stock' => 25,
            ],
            [
                'category_id' => $catIndustri->id,
                'code' => 'GAS-KBT01',
                'name' => 'Tabung Gas Acetylene / Karbit',
                'unit' => 'tabung',
                'unit_type' => 'tabung',
                'item_type' => 'gas',
                'buy_price_per_kg' => 1100000,
                'sell_price_per_kg' => 1300000,
                'min_stock_alert' => 3,
                'description' => 'Tabung gas karbit acetylene untuk proses pengelasan dan pemotongan logam.',
                'stock' => 10,
            ],
            [
                'category_id' => $catIndustri->id,
                'code' => 'GAS-ARG01',
                'name' => 'Tabung Gas Argon Murni',
                'unit' => 'tabung',
                'unit_type' => 'tabung',
                'item_type' => 'gas',
                'buy_price_per_kg' => 1350000,
                'sell_price_per_kg' => 1550000,
                'min_stock_alert' => 3,
                'description' => 'Tabung gas argon murni (High Purity) untuk las argon TIG stainless & aluminium.',
                'stock' => 14,
            ],
        ];

        foreach ($gasItems as $itemData) {
            $initialStock = $itemData['stock'];
            unset($itemData['stock']);

            $item = ScrapItem::firstOrCreate(
                ['code' => $itemData['code']],
                $itemData
            );
            $item->update([
                'item_type' => 'gas',
                'unit' => $itemData['unit'],
                'unit_type' => $itemData['unit_type'],
                'buy_price_per_kg' => $itemData['buy_price_per_kg'],
                'sell_price_per_kg' => $itemData['sell_price_per_kg'],
            ]);

            // Set StockBalance
            $balance = StockBalance::firstOrCreate(
                ['scrap_item_id' => $item->id],
                [
                    'current_stock' => $initialStock,
                    'total_in' => $initialStock,
                    'total_out' => 0,
                    'average_buy_price' => $itemData['buy_price_per_kg'],
                ]
            );
            if ($balance->wasRecentlyCreated || $balance->current_stock <= 0) {
                $balance->update([
                    'current_stock' => $initialStock,
                    'total_in' => $initialStock,
                    'average_buy_price' => $itemData['buy_price_per_kg'],
                ]);
            }

            // Set ItemPriceStock
            if (Schema::hasTable('item_price_stocks')) {
                $tier = ItemPriceStock::firstOrCreate(
                    [
                        'scrap_item_id' => $item->id,
                        'price_per_kg' => $itemData['buy_price_per_kg'],
                    ],
                    [
                        'current_stock' => $initialStock,
                        'total_in' => $initialStock,
                        'total_out' => 0,
                    ]
                );
                if ($tier->wasRecentlyCreated || $tier->current_stock <= 0) {
                    $tier->update([
                        'current_stock' => $initialStock,
                        'total_in' => $initialStock,
                    ]);
                }
            }
        }

        // 5. Seed User Admin Gas
        User::firstOrCreate(
            ['email' => 'admingas@kasirrongsok.com'],
            [
                'name' => 'Admin Gas (LPG & Oksigen)',
                'password' => Hash::make('password'),
                'role' => User::ROLE_ADMIN_GAS ?? 'admin_gas',
                'phone' => '081584234353',
                'is_active' => true,
            ]
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('item_categories', 'type')) {
            Schema::table('item_categories', function (Blueprint $table) {
                $table->dropColumn('type');
            });
        }

        if (Schema::hasColumn('scrap_items', 'item_type')) {
            Schema::table('scrap_items', function (Blueprint $table) {
                $table->dropColumn('item_type');
            });
        }

        User::where('email', 'admingas@kasirrongsok.com')->delete();
    }
};

