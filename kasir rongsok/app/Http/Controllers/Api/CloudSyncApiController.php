<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\BusinessSetting;
use App\Models\ItemCategory;
use App\Models\LandingFaq;
use App\Models\LandingGallery;
use App\Models\LandingService;
use App\Models\LandingStatistic;
use App\Models\LandingStory;
use App\Models\LandingStoryComment;
use App\Models\LandingTestimonial;
use App\Models\ScrapItem;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CloudSyncApiController extends Controller
{
    /**
     * Check authentication secret against stored secret key.
     */
    protected function authenticateSecret(Request $request): bool
    {
        $incomingSecret = $request->header('X-Sync-Secret') ?: $request->input('secret_key');
        $storedSecret = BusinessSetting::get('cloud_sync_secret_key');
        $envSecret = env('CLOUD_SYNC_SECRET');

        if (empty($incomingSecret)) {
            return false;
        }

        if (!empty($storedSecret) && hash_equals($storedSecret, $incomingSecret)) {
            return true;
        }

        if (!empty($envSecret) && hash_equals($envSecret, $incomingSecret)) {
            return true;
        }

        return false;
    }

    /**
     * Ping endpoint to verify connectivity.
     */
    public function ping(Request $request): JsonResponse
    {
        if (!$this->authenticateSecret($request)) {
            return response()->json([
                'success' => false,
                'message' => 'Autentikasi ditolak. Secret Sync Key tidak cocok.',
            ], 401);
        }

        return response()->json([
            'success' => true,
            'message' => 'Pong! Cloud Sync Server Terhubung!',
            'server_time' => now()->toDateTimeString(),
            'app_name' => BusinessSetting::get('company_name', 'PT. Seberaya Akses Multi'),
        ]);
    }

    /**
     * Receive and persist full sync data payload from local POS depo.
     */
    public function receive(Request $request): JsonResponse
    {
        if (!$this->authenticateSecret($request)) {
            return response()->json([
                'success' => false,
                'message' => 'Autentikasi ditolak. Secret Sync Key tidak cocok.',
            ], 401);
        }

        try {
            DB::beginTransaction();

            // 1. Sync Image & Media Files
            $files = $request->input('files', []);
            $filesWritten = 0;
            foreach ($files as $file) {
                if (!empty($file['path']) && !empty($file['data'])) {
                    $cleanPath = str_replace(['../', '..\\'], '', $file['path']);
                    $targetPath = public_path($cleanPath);
                    $dir = dirname($targetPath);
                    if (!file_exists($dir)) {
                        @mkdir($dir, 0755, true);
                    }
                    $binary = base64_decode($file['data']);
                    if ($binary !== false) {
                        @file_put_contents($targetPath, $binary);
                        $filesWritten++;
                    }
                }
            }

            // 2. Sync Business Settings (Only safe landing settings)
            $settings = $request->input('settings', []);
            $ignoredSettings = ['cloud_sync_url']; // Do not overwrite hosting's own target URL
            foreach ($settings as $key => $val) {
                if (!in_array($key, $ignoredSettings, true) && is_string($val)) {
                    BusinessSetting::set($key, $val, 'landing_page');
                }
            }

            // 3. Sync Item Categories
            $categories = $request->input('categories', []);
            $categoryIdMap = [];
            foreach ($categories as $cat) {
                $category = ItemCategory::updateOrCreate(
                    ['slug' => $cat['slug']],
                    [
                        'name' => $cat['name'],
                        'description' => $cat['description'] ?? null,
                        'is_active' => $cat['is_active'] ?? true,
                    ]
                );
                $categoryIdMap[$cat['slug']] = $category->id;
            }

            // 4. Sync Scrap Items (Master Barang & Harga Terkini)
            $items = $request->input('items', []);
            $itemsCount = 0;
            foreach ($items as $item) {
                $catId = isset($item['category_slug']) ? ($categoryIdMap[$item['category_slug']] ?? null) : null;
                ScrapItem::updateOrCreate(
                    ['code' => $item['code']],
                    [
                        'category_id' => $catId,
                        'name' => $item['name'],
                        'unit' => $item['unit'] ?? 'kg',
                        'buy_price_per_kg' => (float) ($item['buy_price_per_kg'] ?? 0),
                        'sell_price_per_kg' => (float) ($item['sell_price_per_kg'] ?? 0),
                        'min_stock_alert' => (float) ($item['min_stock_alert'] ?? 0),
                        'description' => $item['description'] ?? null,
                        'is_active' => $item['is_active'] ?? true,
                    ]
                );
                $itemsCount++;
            }

            // 5. Sync Hero Stories & Comments
            $stories = $request->input('stories', []);
            if (!empty($stories)) {
                // Delete existing stories and comments (comments first due to foreign key)
                LandingStoryComment::query()->delete();
                LandingStory::query()->delete();

                foreach ($stories as $idx => $s) {
                    $story = LandingStory::create([
                        'title' => $s['title'],
                        'subtitle' => $s['subtitle'] ?? null,
                        'tag' => $s['tag'] ?? 'Cerita Depo',
                        'image_path' => $s['image_path'],
                        'caption' => $s['caption'] ?? null,
                        'likes_count' => (int) ($s['likes_count'] ?? 0),
                        'order' => (int) ($s['order'] ?? $idx),
                        'is_active' => $s['is_active'] ?? true,
                    ]);

                    $comments = $s['comments'] ?? [];
                    foreach ($comments as $c) {
                        LandingStoryComment::create([
                            'story_id' => $story->id,
                            'user_name' => $c['user_name'],
                            'comment' => $c['comment'],
                            'original_comment' => $c['original_comment'] ?? null,
                            'detected_language' => $c['detected_language'] ?? 'id',
                            'is_translated' => (bool) ($c['is_translated'] ?? false),
                            'likes_count' => (int) ($c['likes_count'] ?? 0),
                            'is_approved' => (bool) ($c['is_approved'] ?? true),
                        ]);
                    }
                }
            }

            // 6. Sync Services
            $services = $request->input('services', []);
            if (!empty($services)) {
                LandingService::query()->delete();
                foreach ($services as $srv) {
                    LandingService::create([
                        'title' => $srv['title'],
                        'slug' => $srv['slug'] ?? \Illuminate\Support\Str::slug($srv['title']),
                        'icon' => $srv['icon'] ?? 'Recycle',
                        'short_description' => $srv['short_description'],
                        'full_description' => $srv['full_description'] ?? null,
                        'image_url' => $srv['image_url'] ?? null,
                        'order' => (int) ($srv['order'] ?? 0),
                        'is_active' => (bool) ($srv['is_active'] ?? true),
                    ]);
                }
            }

            // 7. Sync Galleries
            $galleries = $request->input('galleries', []);
            if (!empty($galleries)) {
                LandingGallery::query()->delete();
                foreach ($galleries as $gal) {
                    LandingGallery::create([
                        'title' => $gal['title'],
                        'category' => $gal['category'] ?? 'Operasional',
                        'image_path' => $gal['image_path'],
                        'caption' => $gal['caption'] ?? null,
                        'order' => (int) ($gal['order'] ?? 0),
                        'is_active' => (bool) ($gal['is_active'] ?? true),
                    ]);
                }
            }

            // 8. Sync Testimonials
            $testimonials = $request->input('testimonials', []);
            if (!empty($testimonials)) {
                LandingTestimonial::query()->delete();
                foreach ($testimonials as $t) {
                    LandingTestimonial::create([
                        'client_name' => $t['client_name'],
                        'client_role' => $t['client_role'],
                        'rating' => (int) ($t['rating'] ?? 5),
                        'content' => $t['content'],
                        'avatar_url' => $t['avatar_url'] ?? null,
                        'order' => (int) ($t['order'] ?? 0),
                        'is_active' => (bool) ($t['is_active'] ?? true),
                    ]);
                }
            }

            // 9. Sync FAQs
            $faqs = $request->input('faqs', []);
            if (!empty($faqs)) {
                LandingFaq::query()->delete();
                foreach ($faqs as $f) {
                    LandingFaq::create([
                        'question' => $f['question'],
                        'answer' => $f['answer'],
                        'category' => $f['category'] ?? 'Umum',
                        'order' => (int) ($f['order'] ?? 0),
                        'is_active' => (bool) ($f['is_active'] ?? true),
                    ]);
                }
            }

            // 10. Sync Statistics
            $statistics = $request->input('statistics', []);
            if (!empty($statistics)) {
                LandingStatistic::query()->delete();
                foreach ($statistics as $stat) {
                    LandingStatistic::create([
                        'label' => $stat['label'],
                        'value' => $stat['value'],
                        'prefix' => $stat['prefix'] ?? null,
                        'suffix' => $stat['suffix'] ?? null,
                        'icon' => $stat['icon'] ?? null,
                        'order' => (int) ($stat['order'] ?? 0),
                        'is_active' => (bool) ($stat['is_active'] ?? true),
                    ]);
                }
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => "Sinkronisasi berhasil! {$itemsCount} master barang & harga terkini, serta konten landing page berhasil diperbarui di hosting.",
                'synced_at' => now()->toDateTimeString(),
                'files_written' => $filesWritten,
                'counts' => [
                    'items' => $itemsCount,
                    'categories' => count($categories),
                    'stories' => count($stories),
                ],
            ]);
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('CloudSync receive error: ' . $e->getMessage() . "\n" . $e->getTraceAsString());

            return response()->json([
                'success' => false,
                'message' => 'Gagal memproses sinkronisasi di server hosting: ' . $e->getMessage(),
            ], 500);
        }
    }
}
