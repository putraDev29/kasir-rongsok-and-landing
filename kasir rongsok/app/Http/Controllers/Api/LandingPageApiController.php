<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\BusinessSetting;
use App\Models\ItemCategory;
use App\Models\LandingFaq;
use App\Models\LandingGallery;
use App\Models\LandingInquiry;
use App\Models\LandingService;
use App\Models\LandingStatistic;
use App\Models\LandingStory;
use App\Models\LandingStoryComment;
use App\Models\LandingTestimonial;
use App\Models\ScrapItem;
use App\Services\TranslationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LandingPageApiController extends Controller
{
    /**
     * Get Aggregated Landing Page Data (Single fast request for Next.js).
     */
    public function index(): JsonResponse
    {
        $settings = $this->getFormattedSettings();
        $services = LandingService::where('is_active', true)->orderBy('order')->get();
        $categories = $this->getCategoriesWithItems();
        $gallery = LandingGallery::where('is_active', true)->orderBy('order')->get()->map(function ($g) {
            return [
                'id' => $g->id,
                'title' => $g->title,
                'category' => $g->category,
                'image_path' => $g->image_path,
                'image_url' => $g->image_url,
                'caption' => $g->caption,
                'order' => $g->order,
            ];
        });
        $testimonials = LandingTestimonial::where('is_active', true)->orderBy('order')->get();
        $faqs = LandingFaq::where('is_active', true)->orderBy('order')->get();
        $statistics = LandingStatistic::where('is_active', true)->orderBy('order')->get();

        $whyChooseUs = [
            [
                'icon' => 'ShieldCheck',
                'title' => 'Pelayanan Terbaik & Terpercaya',
                'description' => 'Didukung Sumber Daya Manusia yang handal dan berkompeten dalam bidangnya serta komitmen memberikan pelayanan terbaik bagi pengguna jasa lelang.',
            ],
            [
                'icon' => 'TrendingUp',
                'title' => 'Harga Optimum Sesuai Pasar',
                'description' => 'Kunci utama kesuksesan lelang adalah harga yang sesuai dengan kondisi pasar, kondisi fisik, dan program pemasaran yang efektif.',
            ],
            [
                'icon' => 'Scale',
                'title' => 'Aspek Legalitas yang Pasti',
                'description' => 'Sistem penjualan lelang kami cepat, efisien, terbuka, obyektif, terbentuk harga optimum dan didukung aspek legalitas yang pasti.',
            ],
            [
                'icon' => 'Truck',
                'title' => 'Tempat Penyimpanan Aset yang Luas',
                'description' => 'Memiliki fasilitas area dan tempat penyimpanan aset yang luas dan aman untuk menampung berbagai aset sebelum maupun sesudah lelang.',
            ],
            [
                'icon' => 'Users',
                'title' => 'Database Calon Pembeli Aktif',
                'description' => 'Memiliki database calon pembeli dan investor aktif yang siap mengikuti dan menunggu jadwal lelang kami secara berkala.',
            ],
            [
                'icon' => 'Banknote',
                'title' => 'Penjualan Cepat & Tepat Waktu',
                'description' => 'Kemampuan menjual dalam waktu yang singkat dengan cara seefisien mungkin dan tepat waktu sesuai kebutuhan mitra bisnis.',
            ],
        ];

        $processSteps = [
            [
                'step' => 1,
                'title' => 'Konsultasi & Pengajuan Aset',
                'description' => 'Hubungi tim kami via WhatsApp/Telepon untuk menginformasikan obyek aset tak bergerak atau material yang ingin dilelang/dijual.',
                'icon' => 'PhoneCall',
            ],
            [
                'step' => 2,
                'title' => 'Survey Awal & Appraisal Fisik',
                'description' => 'Pelaksanaan survey awal, penilaian (appraisal) singkat dan penelitian atas kondisi fisiknya secara detail di lapangan.',
                'icon' => 'Scale',
            ],
            [
                'step' => 3,
                'title' => 'Penetapan Harga & Strategi Marketing',
                'description' => 'Menetapkan nilai harga yang optimum sesuai pasar dan mempersiapkan program pemasaran lelang yang efektif.',
                'icon' => 'MessageSquareQuote',
            ],
            [
                'step' => 4,
                'title' => 'Pelaksanaan Lelang Terbuka',
                'description' => 'Pelaksanaan penjualan melalui sistem lelang yang cepat, efisien, terbuka, dan mempertemukan dengan database pembeli aktif.',
                'icon' => 'Truck',
            ],
            [
                'step' => 5,
                'title' => 'Penyelesaian Transaksi & Legalitas',
                'description' => 'Penyelesaian pembayaran optimum, aspek legalitas yang pasti, dan serah terima aset secara profesional.',
                'icon' => 'Wallet',
            ],
        ];

        return response()->json([
            'success' => true,
            'message' => 'Landing page data fetched successfully',
            'data' => [
                'settings' => $settings,
                'hero' => [
                    'badge' => $settings['hero_badge'],
                    'headline' => $settings['hero_headline'],
                    'subheadline' => $settings['hero_subheadline'],
                    'cta_primary' => $settings['hero_cta_primary'],
                    'cta_secondary' => $settings['hero_cta_secondary'],
                    'background_image' => $this->formatImageUrl(
                        BusinessSetting::get('landing_hero_main_image'),
                        'https://images.unsplash.com/photo-1532996122724-e3c354a0b15b?q=80&w=1200&auto=format&fit=crop'
                    ),
                    'main_image' => $this->formatImageUrl(
                        BusinessSetting::get('landing_hero_main_image'),
                        'https://images.unsplash.com/photo-1532996122724-e3c354a0b15b?q=80&w=1200&auto=format&fit=crop'
                    ),
                    'main_title' => BusinessSetting::get('landing_hero_main_title', 'Penimbangan Digital & Penampungan Logam Scrap'),
                    'main_subtitle' => BusinessSetting::get('landing_hero_main_subtitle', 'Depo Srengseng Sawah • Jagakarsa'),
                    'sub1_image' => $this->formatImageUrl(
                        BusinessSetting::get('landing_hero_sub1_image'),
                        'https://images.unsplash.com/photo-1611284446314-60a58ac0deb9?q=80&w=800&auto=format&fit=crop'
                    ),
                    'sub1_title' => BusinessSetting::get('landing_hero_sub1_title', 'Tembaga, Kuningan & Nikel'),
                    'sub1_tag' => BusinessSetting::get('landing_hero_sub1_tag', 'Logam Presisi'),
                    'sub2_image' => $this->formatImageUrl(
                        BusinessSetting::get('landing_hero_sub2_image'),
                        'https://images.unsplash.com/photo-1601584115197-04ecc0da31d7?q=80&w=800&auto=format&fit=crop'
                    ),
                    'sub2_title' => BusinessSetting::get('landing_hero_sub2_title', 'Truk & Pick-Up Siap 24 Jam'),
                    'sub2_tag' => BusinessSetting::get('landing_hero_sub2_tag', 'Armada Jemput'),
                    'sub3_image' => $this->formatImageUrl(
                        BusinessSetting::get('landing_hero_sub3_image'),
                        'https://images.unsplash.com/photo-1526951521990-620dc14c214b?q=80&w=800&auto=format&fit=crop'
                    ),
                    'sub3_title' => BusinessSetting::get('landing_hero_sub3_title', 'Bongkar Gedung & Tabung Gas'),
                    'sub3_tag' => BusinessSetting::get('landing_hero_sub3_tag', 'Bongkar & Gas'),
                ],
                'about' => [
                    'title' => $settings['about_title'],
                    'description' => $settings['about_description'],
                    'vision' => $settings['about_vision'],
                    'mission' => $settings['about_mission'],
                    'years_experience' => $settings['about_years_experience'],
                    'image' => $this->formatImageUrl(
                        BusinessSetting::get('landing_about_image'),
                        asset('uploads/about/about_depo_seberaya.jpg')
                    ),
                ],
                'services' => $services,
                'categories' => $categories,
                'why_choose_us' => $whyChooseUs,
                'process' => $processSteps,
                'gallery' => $gallery,
                'stories' => $this->getStoriesData(),
                'statistics' => $statistics,
                'location' => [
                    'company_name' => $settings['company_name'],
                    'address' => $settings['company_address'],
                    'phone' => $settings['company_phone'],
                    'whatsapp' => $settings['whatsapp_number'],
                    'whatsapp_url' => $settings['whatsapp_url'],
                    'operating_hours' => $settings['operating_hours'],
                    'maps_url' => $settings['maps_url'],
                    'maps_embed_url' => $settings['maps_embed_url'],
                    'latitude' => $settings['latitude'],
                    'longitude' => $settings['longitude'],
                ],
                'testimonials' => $testimonials,
                'faqs' => $faqs,
                'seo' => [
                    'meta_title' => $settings['seo_meta_title'],
                    'meta_description' => $settings['seo_meta_description'],
                    'keywords' => $settings['seo_keywords'],
                    'company_name' => $settings['company_name'],
                    'canonical_url' => url('/'),
                    'og_image' => $settings['logo_url'],
                ],
            ],
        ], 200, [
            'Access-Control-Allow-Origin' => '*',
            'Access-Control-Allow-Methods' => 'GET, POST, OPTIONS',
            'Access-Control-Allow-Headers' => 'Content-Type, Authorization, X-Requested-With',
        ]);
    }

    /**
     * Get Settings Only
     */
    public function settings(): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => $this->getFormattedSettings(),
        ], 200, ['Access-Control-Allow-Origin' => '*']);
    }

    /**
     * Get Services Only
     */
    public function services(): JsonResponse
    {
        $services = LandingService::where('is_active', true)->orderBy('order')->get();
        return response()->json([
            'success' => true,
            'data' => $services,
        ], 200, ['Access-Control-Allow-Origin' => '*']);
    }

    /**
     * Get Categories & Live Scrap Items
     */
    public function categories(): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => $this->getCategoriesWithItems(),
        ], 200, ['Access-Control-Allow-Origin' => '*']);
    }

    /**
     * Get Galleries Only
     */
    public function gallery(): JsonResponse
    {
        $galleries = LandingGallery::where('is_active', true)->orderBy('order')->get()->map(function ($g) {
            return [
                'id' => $g->id,
                'title' => $g->title,
                'category' => $g->category,
                'image_path' => $g->image_path,
                'image_url' => $g->image_url,
                'caption' => $g->caption,
                'order' => $g->order,
            ];
        });
        return response()->json([
            'success' => true,
            'data' => $galleries,
        ], 200, ['Access-Control-Allow-Origin' => '*']);
    }

    /**
     * Get Stories (Hero Story Reel) ordered newest first (id DESC)
     */
    public function stories(): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => $this->getStoriesData(),
        ], 200, ['Access-Control-Allow-Origin' => '*']);
    }

    /**
     * Store comment for a specific Story photo (auto-translates foreign languages to Indonesian)
     */
    public function storeStoryComment(Request $request, int $id): JsonResponse
    {
        $story = LandingStory::find($id);
        if (!$story) {
            return response()->json([
                'success' => false,
                'message' => 'Story tidak ditemukan.',
            ], 4404, ['Access-Control-Allow-Origin' => '*']);
        }

        $validator = Validator::make($request->all(), [
            'user_name' => 'required|string|max:100',
            'comment' => 'required|string|max:1000',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors(),
            ], 422, ['Access-Control-Allow-Origin' => '*']);
        }

        $rawComment = trim($request->input('comment'));
        $userName = trim($request->input('user_name'));

        // Auto-translate to natural Indonesian
        $translation = TranslationService::translateToIndonesian($rawComment);

        $comment = LandingStoryComment::create([
            'story_id' => $story->id,
            'user_name' => $userName,
            'comment' => $translation['translated_text'],
            'original_comment' => $translation['original_text'],
            'detected_language' => $translation['detected_language'],
            'is_translated' => $translation['is_translated'],
            'likes_count' => 0,
            'is_approved' => true,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Komentar berhasil dikirim!',
            'data' => [
                'id' => $comment->id,
                'story_id' => $comment->story_id,
                'user_name' => $comment->user_name,
                'comment' => $comment->comment,
                'original_comment' => $comment->original_comment,
                'detected_language' => $comment->detected_language,
                'is_translated' => (bool) $comment->is_translated,
                'likes_count' => $comment->likes_count,
                'created_at' => 'Baru saja',
            ],
        ], 201, ['Access-Control-Allow-Origin' => '*']);
    }

    /**
     * Like a Story Photo
     */
    public function likeStory(int $id): JsonResponse
    {
        $story = LandingStory::find($id);
        if (!$story) {
            return response()->json(['success' => false, 'message' => 'Story tidak ditemukan'], 404);
        }

        $story->increment('likes_count');

        return response()->json([
            'success' => true,
            'likes_count' => $story->fresh()->likes_count,
        ], 200, ['Access-Control-Allow-Origin' => '*']);
    }

    /**
     * Like a Story Comment
     */
    public function likeStoryComment(int $id): JsonResponse
    {
        $comment = LandingStoryComment::find($id);
        if (!$comment) {
            return response()->json(['success' => false, 'message' => 'Komentar tidak ditemukan'], 404);
        }

        $comment->increment('likes_count');

        return response()->json([
            'success' => true,
            'likes_count' => $comment->fresh()->likes_count,
        ], 200, ['Access-Control-Allow-Origin' => '*']);
    }

    /**
     * Get Testimonials Only
     */
    public function testimonials(): JsonResponse
    {
        $testimonials = LandingTestimonial::where('is_active', true)->orderBy('order')->get();
        return response()->json([
            'success' => true,
            'data' => $testimonials,
        ], 200, ['Access-Control-Allow-Origin' => '*']);
    }

    /**
     * Get FAQs Only
     */
    public function faqs(): JsonResponse
    {
        $faqs = LandingFaq::where('is_active', true)->orderBy('order')->get();
        return response()->json([
            'success' => true,
            'data' => $faqs,
        ], 200, ['Access-Control-Allow-Origin' => '*']);
    }

    /**
     * Get Statistics Only
     */
    public function statistics(): JsonResponse
    {
        $statistics = LandingStatistic::where('is_active', true)->orderBy('order')->get();
        return response()->json([
            'success' => true,
            'data' => $statistics,
        ], 200, ['Access-Control-Allow-Origin' => '*']);
    }

    /**
     * Submit Contact / Pickup Inquiry
     */
    public function contact(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:150',
            'phone' => 'required|string|max:50',
            'material_type' => 'nullable|string|max:150',
            'estimated_weight' => 'nullable|string|max:100',
            'address' => 'nullable|string|max:500',
            'message' => 'nullable|string|max:1000',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors(),
            ], 422, ['Access-Control-Allow-Origin' => '*']);
        }

        $inquiry = LandingInquiry::create([
            'name' => $request->input('name'),
            'phone' => $request->input('phone'),
            'material_type' => $request->input('material_type'),
            'estimated_weight' => $request->input('estimated_weight'),
            'address' => $request->input('address'),
            'message' => $request->input('message'),
            'status' => 'new',
        ]);

        // WhatsApp direct link for convenience
        $waNumber = $this->cleanPhoneNumber(BusinessSetting::get('landing_whatsapp_number', '081234567890'));
        $waText = "Halo Admin, saya {$inquiry->name} ({$inquiry->phone}). Saya berminat menjual rongsok: {$inquiry->material_type} (Est. {$inquiry->estimated_weight}). Alamat: {$inquiry->address}. Catatan: {$inquiry->message}";
        $directWaUrl = "https://wa.me/{$waNumber}?text=" . rawurlencode($waText);

        return response()->json([
            'success' => true,
            'message' => 'Pesan penawaran Anda berhasil terkirim. Tim kami akan segera menghubungi Anda.',
            'data' => [
                'id' => $inquiry->id,
                'direct_whatsapp_url' => $directWaUrl,
            ],
        ], 201, ['Access-Control-Allow-Origin' => '*']);
    }

    /**
     * Submit Customer Review / Testimonial
     */
    public function submitTestimonial(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'client_name' => 'required|string|max:150',
            'client_role' => 'nullable|string|max:150',
            'rating' => 'required|integer|min:1|max:5',
            'content' => 'required|string|max:1000',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal. Pastikan nama, rating, dan ulasan terisi dengan benar.',
                'errors' => $validator->errors(),
            ], 422, ['Access-Control-Allow-Origin' => '*']);
        }

        $testimonial = LandingTestimonial::create([
            'client_name' => $request->input('client_name'),
            'client_role' => $request->input('client_role') ?: 'Pelanggan Setia',
            'rating' => (int) $request->input('rating', 5),
            'content' => $request->input('content'),
            'avatar_url' => null,
            'order' => 99,
            'is_active' => true,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Terima kasih! Ulasan Anda berhasil dikirim dan ditampilkan.',
            'data' => $testimonial,
        ], 201, ['Access-Control-Allow-Origin' => '*']);
    }

    /**
     * Helper: Format and retrieve all settings
     */
    protected function getFormattedSettings(): array
    {
        $companyName = BusinessSetting::get('company_name', 'UD. Berkah Rongsok Makmur');
        $appName = BusinessSetting::get('app_name', 'Kasir Rongsok');
        $tagline = BusinessSetting::get('company_tagline', 'Pusat Pembelian & Pengelolaan Daur Ulang Terpercaya');
        $phone = BusinessSetting::get('company_phone', '0812-3456-7890');
        $address = BusinessSetting::get('company_address', 'Jl. Industri Daur Ulang No. 88, Kel. Sukamaju, Kec. Cikarang');
        
        $waRaw = BusinessSetting::get('landing_whatsapp_number') ?: BusinessSetting::get('company_phone', '081234567890');
        $waClean = $this->cleanPhoneNumber($waRaw);
        $waMessage = BusinessSetting::get('landing_whatsapp_message', 'Halo Admin, saya ingin bertanya mengenai penjualan rongsok. Bisa dibantu informasi harga dan penjemputannya?');
        $waUrl = "https://wa.me/{$waClean}?text=" . rawurlencode($waMessage);

        $logoPath = BusinessSetting::get('landing_header_logo') ?: BusinessSetting::get('app_logo');
        if ($logoPath) {
            $logoUrl = str_starts_with($logoPath, 'http') ? $logoPath : asset($logoPath);
        } else {
            $logoUrl = asset('icon-default.svg');
        }

        return [
            'app_name' => $appName,
            'company_name' => $companyName,
            'company_tagline' => $tagline,
            'company_phone' => $phone,
            'company_address' => $address,
            'logo_url' => $logoUrl,
            'whatsapp_number' => $waClean,
            'whatsapp_raw' => $waRaw,
            'whatsapp_message' => $waMessage,
            'whatsapp_url' => $waUrl,
            'email' => BusinessSetting::get('landing_email', 'kontak@berkahrongsok.com'),
            'operating_hours' => BusinessSetting::get('landing_operating_hours', 'Senin - Sabtu: 07.30 - 17.30 WIB | Minggu: 08.00 - 14.00 WIB'),
            'maps_embed_url' => BusinessSetting::get('landing_maps_embed_url', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d126915.93278964724!2d107.08638663806203!3d-6.273898234676116!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e6985a9757f4955%3A0xc3b5e408ec21d46!2sKawasan%20Industri%20Jababeka!5e0!3m2!1sid!2sid!4v1700000000000!5m2!1sid!2sid'),
            'maps_url' => BusinessSetting::get('landing_maps_url', 'https://maps.google.com/?q=-6.273898,107.086386'),
            'latitude' => BusinessSetting::get('landing_maps_latitude', '-6.273898'),
            'longitude' => BusinessSetting::get('landing_maps_longitude', '107.086386'),
            
            // Hero
            'hero_badge' => BusinessSetting::get('landing_hero_badge', 'Pusat Daur Ulang & Pengepul Terpercaya Sejak 2012'),
            'hero_headline' => BusinessSetting::get('landing_hero_headline', 'Solusi Jual Beli Rongsok Terpercaya, Transparan & Menguntungkan'),
            'hero_subheadline' => BusinessSetting::get('landing_hero_subheadline', 'Kami menerima segala jenis rongsokan logam, besi tua, kardus/kertas, plastik, dan aki bekas dengan timbangan digital presisi, harga pasar kompetitif tertinggi, serta armada jemput siap langsung ke lokasi Anda.'),
            'hero_cta_primary' => BusinessSetting::get('landing_hero_cta_primary', 'Hubungi via WhatsApp'),
            'hero_cta_secondary' => BusinessSetting::get('landing_hero_cta_secondary', 'Lihat Daftar Harga Rongsok'),

            // About
            'about_title' => BusinessSetting::get('landing_about_title', 'Komitmen Menjaga Lingkungan dengan Nilai Ekonomi Maksimal'),
            'about_description' => BusinessSetting::get('landing_about_description', 'PT. Seberaya Akses Multi adalah perusahaan pengelolaan dan pengepul material daur ulang terintegrasi yang telah beroperasi selama lebih dari 3 tahun.'),
            'about_vision' => BusinessSetting::get('landing_about_vision', 'Menjadi rantai pasok material daur ulang terdepan, modern, dan paling terpercaya di Indonesia.'),
            'about_mission' => BusinessSetting::get('landing_about_mission', "1. Transparansi timbangan digital presisi.\n2. Layanan penjemputan armada cepat dan profesional.\n3. Membangun ekosistem sirkular ekonomi berkelanjutan."),
            'about_years_experience' => BusinessSetting::get('landing_about_years_experience', '3+'),
            'about_image' => $this->formatImageUrl(
                BusinessSetting::get('landing_about_image'),
                asset('uploads/about/about_depo_seberaya.jpg')
            ),

            // Socials
            'social_facebook' => BusinessSetting::get('landing_social_facebook', ''),
            'social_instagram' => BusinessSetting::get('landing_social_instagram', ''),
            'social_tiktok' => BusinessSetting::get('landing_social_tiktok', ''),
            'social_youtube' => BusinessSetting::get('landing_social_youtube', ''),

            // SEO
            'seo_meta_title' => BusinessSetting::get('landing_seo_meta_title', 'Jual Beli Rongsok & Pengepul Besi Tua Terpercaya | UD. Berkah Rongsok Makmur'),
            'seo_meta_description' => BusinessSetting::get('landing_seo_meta_description', 'Pengepul rongsok terpercaya terima besi tua, tembaga, kardus, plastik, dan aki bekas harga tinggi. Timbangan digital transparan, bayar tunai di tempat.'),
            'seo_keywords' => BusinessSetting::get('landing_seo_keywords', 'jual beli rongsok, pengepul rongsok terpercaya, jual besi tua, harga kardus bekas per kg'),
        ];
    }

    /**
     * Helper: Clean phone number to E.164 without plus sign
     */
    protected function cleanPhoneNumber(string $phone): string
    {
        $cleaned = preg_replace('/[^0-9]/', '', $phone);
        if (str_starts_with($cleaned, '0')) {
            $cleaned = '62' . substr($cleaned, 1);
        } elseif (str_starts_with($cleaned, '8')) {
            $cleaned = '62' . $cleaned;
        }
        return $cleaned;
    }

    /**
     * Helper: Get Item Categories along with active Scrap Items and prices
     */
    protected function getCategoriesWithItems(): array
    {
        $categories = ItemCategory::where('is_active', true)
            ->with(['scrapItems' => function ($query) {
                $query->where('is_active', true)->orderBy('name');
            }])
            ->get();

        return $categories->map(function ($cat) {
            return [
                'id' => $cat->id,
                'name' => $cat->name,
                'slug' => $cat->slug,
                'description' => $cat->description,
                'items_count' => $cat->scrapItems->count(),
                'items' => $cat->scrapItems->map(function ($item) {
                    return [
                        'id' => $item->id,
                        'code' => $item->code,
                        'name' => $item->name,
                        'unit' => $item->unit ?: 'kg',
                        'buy_price_per_kg' => (float) $item->buy_price_per_kg,
                        'description' => $item->description,
                    ];
                }),
            ];
        })->toArray();
    }

    /**
     * Helper: Get formatted stories list (Newest first)
     */
    protected function getStoriesData(): array
    {
        return LandingStory::where('is_active', true)
            ->with(['comments' => function ($q) {
                $q->where('is_approved', true)->orderBy('id', 'desc');
            }])
            ->orderBy('id', 'desc')
            ->get()
            ->map(function ($s) {
                return [
                    'id' => $s->id,
                    'title' => $s->title,
                    'subtitle' => $s->subtitle ?: 'Depo Srengseng Sawah • Jagakarsa',
                    'tag' => $s->tag ?: 'Cerita Depo',
                    'image_path' => $s->image_path,
                    'image_url' => $s->image_url,
                    'caption' => $s->caption,
                    'likes_count' => (int) $s->likes_count,
                    'comments_count' => $s->comments->count(),
                    'created_at' => $s->created_at ? $s->created_at->toISOString() : null,
                    'created_at_human' => $s->created_at ? $s->created_at->diffForHumans() : 'Baru saja',
                    'comments' => $s->comments->map(function ($c) {
                        return [
                            'id' => $c->id,
                            'story_id' => $c->story_id,
                            'user_name' => $c->user_name,
                            'comment' => $c->comment,
                            'original_comment' => $c->original_comment,
                            'detected_language' => $c->detected_language,
                            'is_translated' => (bool) $c->is_translated,
                            'likes_count' => (int) $c->likes_count,
                            'created_at' => $c->created_at ? $c->created_at->diffForHumans() : 'Baru saja',
                        ];
                    })->values()->toArray(),
                ];
            })
            ->values()
            ->toArray();
    }

    /**
     * Helper: Format image path to full URL
     */
    protected function formatImageUrl(?string $path, string $fallback): string
    {
        if (empty($path)) {
            return $fallback;
        }
        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }
        return url(ltrim($path, '/'));
    }
}

