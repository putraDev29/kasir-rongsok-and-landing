<?php

namespace App\Services;

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
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class CloudSyncService
{
    /**
     * Check if cloud sync is enabled and configured.
     */
    public static function isConfigured(): bool
    {
        $enabled = (bool) BusinessSetting::get('cloud_sync_enabled', false);
        $url = BusinessSetting::get('cloud_sync_url');
        $secret = BusinessSetting::get('cloud_sync_secret_key');

        return $enabled && !empty(trim($url)) && !empty(trim($secret));
    }

    /**
     * Get Cloud Sync Configuration settings.
     */
    public static function getConfig(): array
    {
        $secret = BusinessSetting::get('cloud_sync_secret_key');
        if (empty($secret)) {
            // Auto generate a strong default secret key if none exists
            $secret = 'sync_' . Str::random(32);
            BusinessSetting::set('cloud_sync_secret_key', $secret, 'cloud_sync');
        }

        return [
            'enabled' => (bool) BusinessSetting::get('cloud_sync_enabled', false),
            'url' => rtrim((string) BusinessSetting::get('cloud_sync_url', ''), '/'),
            'secret_key' => $secret,
            'auto_sync' => (bool) BusinessSetting::get('cloud_sync_auto_on_submit', true),
            'last_status' => BusinessSetting::get('cloud_sync_last_status', 'never'),
            'last_message' => BusinessSetting::get('cloud_sync_last_message', 'Belum pernah disinkronkan ke hosting cPanel'),
            'last_synced_at' => BusinessSetting::get('cloud_sync_last_synced_at', null),
        ];
    }

    /**
     * Save Cloud Sync Configuration.
     */
    public static function saveConfig(array $data): void
    {
        if (isset($data['enabled'])) {
            BusinessSetting::set('cloud_sync_enabled', (bool) $data['enabled'] ? '1' : '0', 'cloud_sync');
        }
        if (isset($data['url'])) {
            BusinessSetting::set('cloud_sync_url', rtrim(trim($data['url']), '/'), 'cloud_sync');
        }
        if (!empty($data['secret_key'])) {
            BusinessSetting::set('cloud_sync_secret_key', trim($data['secret_key']), 'cloud_sync');
        }
        if (isset($data['auto_sync'])) {
            BusinessSetting::set('cloud_sync_auto_on_submit', (bool) $data['auto_sync'] ? '1' : '0', 'cloud_sync');
        }
    }

    /**
     * Test connection to target hosting URL.
     */
    public static function testConnection(?string $targetUrl = null, ?string $targetSecret = null): array
    {
        $url = rtrim($targetUrl ?: BusinessSetting::get('cloud_sync_url', ''), '/');
        $secret = $targetSecret ?: BusinessSetting::get('cloud_sync_secret_key', '');

        if (empty($url)) {
            return [
                'success' => false,
                'message' => 'URL hosting belum diisi. Masukkan URL website hosting cPanel Anda.',
            ];
        }

        if (empty($secret)) {
            return [
                'success' => false,
                'message' => 'Secret Sync Key belum diatur.',
            ];
        }

        $pingUrl = $url . '/api/sync/ping';

        try {
            $response = Http::timeout(8)
                ->withHeaders([
                    'X-Sync-Secret' => $secret,
                    'Accept' => 'application/json',
                ])
                ->get($pingUrl);

            if ($response->successful()) {
                $json = $response->json();
                return [
                    'success' => true,
                    'message' => $json['message'] ?? 'Koneksi ke hosting cPanel berhasil terhubung!',
                    'data' => $json,
                ];
            }

            if ($response->status() === 401 || $response->status() === 403) {
                return [
                    'success' => false,
                    'message' => 'Autentikasi ditolak (Status ' . $response->status() . '). Pastikan Secret Key di server cPanel hosting sama persis dengan yang ada di lokal.',
                ];
            }

            return [
                'success' => false,
                'message' => 'Server hosting merespons dengan status ' . $response->status() . ': ' . $response->body(),
            ];
        } catch (\Throwable $e) {
            return [
                'success' => false,
                'message' => 'Gagal menghubungi server hosting di ' . $pingUrl . ' (' . $e->getMessage() . '). Pastikan hosting aktif dan terkoneksi internet.',
            ];
        }
    }

    /**
     * Build the complete data payload for cloud sync.
     */
    public static function buildSyncPayload(): array
    {
        // 1. Categories & Master Items with Prices
        $categories = ItemCategory::all()->map(function ($c) {
            return [
                'name' => $c->name,
                'slug' => $c->slug,
                'description' => $c->description,
                'is_active' => (bool) $c->is_active,
            ];
        })->toArray();

        $items = ScrapItem::with('category')->get()->map(function ($it) {
            return [
                'category_slug' => $it->category?->slug,
                'code' => $it->code,
                'name' => $it->name,
                'unit' => $it->unit ?: 'kg',
                'buy_price_per_kg' => (float) $it->buy_price_per_kg,
                'sell_price_per_kg' => (float) $it->sell_price_per_kg,
                'min_stock_alert' => (float) $it->min_stock_alert,
                'description' => $it->description,
                'is_active' => (bool) $it->is_active,
            ];
        })->toArray();

        // 2. Landing Settings & Company Identity
        $settings = BusinessSetting::all()->pluck('value', 'key')->toArray();

        // 3. Hero Stories & Comments
        $stories = LandingStory::with(['comments' => function ($q) {
            $q->orderBy('id', 'asc');
        }])->orderBy('id', 'asc')->get()->map(function ($s) {
            return [
                'title' => $s->title,
                'subtitle' => $s->subtitle,
                'tag' => $s->tag,
                'image_path' => $s->image_path,
                'caption' => $s->caption,
                'likes_count' => (int) $s->likes_count,
                'order' => (int) $s->order,
                'is_active' => (bool) $s->is_active,
                'comments' => $s->comments->map(function ($c) {
                    return [
                        'user_name' => $c->user_name,
                        'comment' => $c->comment,
                        'original_comment' => $c->original_comment,
                        'detected_language' => $c->detected_language,
                        'is_translated' => (bool) $c->is_translated,
                        'likes_count' => (int) $c->likes_count,
                        'is_approved' => (bool) $c->is_approved,
                    ];
                })->toArray(),
            ];
        })->toArray();

        // 4. Other Landing Page Components
        $services = LandingService::all()->toArray();
        $galleries = LandingGallery::all()->toArray();
        $testimonials = LandingTestimonial::all()->toArray();
        $faqs = LandingFaq::all()->toArray();
        $statistics = LandingStatistic::all()->toArray();

        // 5. Gather referenced image files to transfer
        $files = self::collectReferencedFiles($settings, $stories, $galleries);

        return [
            'source' => 'local_pos_depo',
            'synced_at' => now()->toISOString(),
            'counts' => [
                'categories' => count($categories),
                'items' => count($items),
                'stories' => count($stories),
                'services' => count($services),
                'galleries' => count($galleries),
                'testimonials' => count($testimonials),
                'faqs' => count($faqs),
                'statistics' => count($statistics),
                'files' => count($files),
            ],
            'categories' => $categories,
            'items' => $items,
            'settings' => $settings,
            'stories' => $stories,
            'services' => $services,
            'galleries' => $galleries,
            'testimonials' => $testimonials,
            'faqs' => $faqs,
            'statistics' => $statistics,
            'files' => $files,
        ];
    }

    /**
     * Push all local data to the Cloud Hosting receiver endpoint.
     */
    public static function pushToCloud(): array
    {
        $config = self::getConfig();
        $url = $config['url'];
        $secret = $config['secret_key'];

        if (empty($url) || empty($secret)) {
            $msg = 'Konfigurasi Cloud Sync belum lengkap (URL atau Secret Key kosong).';
            BusinessSetting::set('cloud_sync_last_status', 'failed', 'cloud_sync');
            BusinessSetting::set('cloud_sync_last_message', $msg, 'cloud_sync');
            return ['success' => false, 'message' => $msg];
        }

        $receiveUrl = $url . '/api/sync/receive';
        $payload = self::buildSyncPayload();

        try {
            $response = Http::timeout(25)
                ->withHeaders([
                    'X-Sync-Secret' => $secret,
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                ])
                ->post($receiveUrl, $payload);

            if ($response->successful()) {
                $json = $response->json();
                $msg = $json['message'] ?? 'Sinkronisasi berhasil! ' . $payload['counts']['items'] . ' master barang & harga telah masuk ke hosting cPanel.';
                
                BusinessSetting::set('cloud_sync_last_status', 'success', 'cloud_sync');
                BusinessSetting::set('cloud_sync_last_message', $msg, 'cloud_sync');
                BusinessSetting::set('cloud_sync_last_synced_at', now()->toDateTimeString(), 'cloud_sync');

                Log::info('Cloud sync success: ' . $msg);
                return [
                    'success' => true,
                    'message' => $msg,
                    'counts' => $payload['counts'],
                    'response' => $json,
                ];
            }

            $errMsg = 'Hosting merespons status ' . $response->status() . ': ' . Str::limit($response->body(), 200);
            BusinessSetting::set('cloud_sync_last_status', 'failed', 'cloud_sync');
            BusinessSetting::set('cloud_sync_last_message', $errMsg, 'cloud_sync');
            Log::warning('Cloud sync error: ' . $errMsg);

            return ['success' => false, 'message' => $errMsg];
        } catch (\Throwable $e) {
            $errMsg = 'Gagal sinkronisasi ke hosting (' . $e->getMessage() . '). Pastikan koneksi internet lokal aktif.';
            BusinessSetting::set('cloud_sync_last_status', 'failed', 'cloud_sync');
            BusinessSetting::set('cloud_sync_last_message', $errMsg, 'cloud_sync');
            Log::warning('Cloud sync exception: ' . $errMsg);

            return ['success' => false, 'message' => $errMsg];
        }
    }

    /**
     * Non-blocking auto-sync trigger to be called on submit.
     */
    public static function autoSyncIfEnabled(): void
    {
        $config = self::getConfig();
        if (!$config['enabled'] || !$config['auto_sync'] || empty($config['url']) || empty($config['secret_key'])) {
            return;
        }

        try {
            self::pushToCloud();
        } catch (\Throwable $e) {
            Log::warning('Auto sync on submit failed gracefully: ' . $e->getMessage());
        }
    }

    /**
     * Helper to collect referenced local files and encode them to base64.
     */
    protected static function collectReferencedFiles(array $settings, array $stories, array $galleries): array
    {
        $paths = [];

        // Logo
        if (!empty($settings['landing_header_logo']) && !str_starts_with($settings['landing_header_logo'], 'http')) {
            $paths[] = $settings['landing_header_logo'];
        }
        if (!empty($settings['app_logo']) && !str_starts_with($settings['app_logo'], 'http')) {
            $paths[] = $settings['app_logo'];
        }

        // About Image
        if (!empty($settings['landing_about_image']) && !str_starts_with($settings['landing_about_image'], 'http')) {
            $paths[] = $settings['landing_about_image'];
        }

        // Hero Images
        foreach (['landing_hero_main_image', 'landing_hero_sub1_image', 'landing_hero_sub2_image', 'landing_hero_sub3_image'] as $k) {
            if (!empty($settings[$k]) && !str_starts_with($settings[$k], 'http')) {
                $paths[] = $settings[$k];
            }
        }

        // Stories Images
        foreach ($stories as $s) {
            if (!empty($s['image_path']) && !str_starts_with($s['image_path'], 'http')) {
                $paths[] = $s['image_path'];
            }
        }

        // Gallery Images
        foreach ($galleries as $g) {
            if (!empty($g['image_path']) && !str_starts_with($g['image_path'], 'http')) {
                $paths[] = $g['image_path'];
            }
        }

        $paths = array_unique(array_filter($paths));
        $files = [];

        foreach ($paths as $relativePath) {
            $fullPath = public_path(ltrim($relativePath, '/\\'));
            if (file_exists($fullPath) && is_file($fullPath)) {
                // Skip if file is unreasonably large (> 6MB) to keep payload manageable
                if (filesize($fullPath) <= 6 * 1024 * 1024) {
                    $files[] = [
                        'path' => str_replace('\\', '/', ltrim($relativePath, '/\\')),
                        'mime' => mime_content_type($fullPath) ?: 'image/jpeg',
                        'data' => base64_encode(file_get_contents($fullPath)),
                    ];
                }
            }
        }

        return $files;
    }
}
