<?php

namespace App\Http\Controllers;

use App\Models\BusinessSetting;
use App\Models\LandingFaq;
use App\Models\LandingGallery;
use App\Models\LandingInquiry;
use App\Models\LandingService;
use App\Models\LandingStatistic;
use App\Models\LandingStory;
use App\Models\LandingStoryComment;
use App\Models\LandingTestimonial;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class LandingPageAdminController extends Controller
{
    /**
     * Show Landing Page Management Dashboard
     */
    public function index(): View
    {
        $settings = BusinessSetting::pluck('value', 'key')->all();
        $services = LandingService::orderBy('order')->get();
        $galleries = LandingGallery::orderBy('order')->get();
        $stories = LandingStory::withCount('comments')
            ->with(['comments' => function ($q) {
                $q->orderBy('id', 'desc');
            }])
            ->orderBy('id', 'desc')
            ->get();
        $testimonials = LandingTestimonial::orderBy('order')->get();
        $faqs = LandingFaq::orderBy('order')->get();
        $statistics = LandingStatistic::orderBy('order')->get();
        $inquiries = LandingInquiry::latest()->take(50)->get();

        return view('landing_admin.index', compact(
            'settings',
            'services',
            'galleries',
            'stories',
            'testimonials',
            'faqs',
            'statistics',
            'inquiries'
        ));
    }

    /**
     * Update Identity, Contact, Maps & SEO Settings
     */
    public function updateSettings(Request $request): RedirectResponse
    {
        $fields = [
            'company_name',
            'company_tagline',
            'landing_whatsapp_number',
            'landing_whatsapp_message',
            'landing_email',
            'landing_operating_hours',
            'landing_maps_url',
            'landing_maps_embed_url',
            'landing_maps_latitude',
            'landing_maps_longitude',
            'landing_social_facebook',
            'landing_social_instagram',
            'landing_social_tiktok',
            'landing_social_youtube',
            'landing_seo_meta_title',
            'landing_seo_meta_description',
            'landing_seo_keywords',
        ];

        foreach ($fields as $field) {
            if ($request->has($field)) {
                $category = in_array($field, ['company_name', 'company_tagline']) ? 'branding' : 'landing_page';
                BusinessSetting::set($field, $request->input($field), $category);
            }
        }

        // Handle Header Logo / Icon Upload
        $this->handleHeaderLogoUpload($request);

        return redirect()->route('landing-admin.index', ['tab' => 'settings'])
            ->with('success', 'Logo & ikon header, identitas usaha, kontak, dan SEO berhasil disimpan.');
    }

    /**
     * Process Header Logo / Icon upload or URL update
     */
    protected function handleHeaderLogoUpload(Request $request): void
    {
        $destination = public_path('uploads/logo');
        if (!file_exists($destination)) {
            @mkdir($destination, 0775, true);
        }

        if ($request->hasFile('header_logo_file')) {
            $file = $request->file('header_logo_file');
            $ext = $file->getClientOriginalExtension() ?: 'png';
            $filename = 'logo_' . time() . '.' . $ext;
            $file->move($destination, $filename);

            $relativeLogo = 'uploads/logo/' . $filename;
            BusinessSetting::set('app_logo', $relativeLogo, 'branding');
            BusinessSetting::set('landing_header_logo', $relativeLogo, 'branding');
            BusinessSetting::set('logo_url', asset($relativeLogo), 'landing_page');

            // Mirror to landing-page/public for instant favicon & icon reflection
            $landingPageIconPath = base_path('../landing-page/public/icon.png');
            $landingPageLogoPath = base_path('../landing-page/public/logo.png');
            @copy($destination . '/' . $filename, $landingPageIconPath);
            @copy($destination . '/' . $filename, $landingPageLogoPath);
        } elseif ($request->filled('header_logo_url')) {
            $logoUrl = $request->input('header_logo_url');
            BusinessSetting::set('app_logo', $logoUrl, 'branding');
            BusinessSetting::set('landing_header_logo', $logoUrl, 'branding');
            BusinessSetting::set('logo_url', $logoUrl, 'landing_page');
        } elseif ($request->boolean('remove_header_logo')) {
            BusinessSetting::set('app_logo', null, 'branding');
            BusinessSetting::set('landing_header_logo', null, 'branding');
            BusinessSetting::set('logo_url', null, 'landing_page');
        }
    }

    /**
     * Update Hero & About Sections
     */
    public function updateHeroAbout(Request $request): RedirectResponse
    {
        $fields = [
            'landing_hero_badge',
            'landing_hero_headline',
            'landing_hero_subheadline',
            'landing_hero_cta_primary',
            'landing_hero_cta_secondary',
            'landing_hero_main_title',
            'landing_hero_main_subtitle',
            'landing_hero_sub1_title',
            'landing_hero_sub1_tag',
            'landing_hero_sub2_title',
            'landing_hero_sub2_tag',
            'landing_hero_sub3_title',
            'landing_hero_sub3_tag',
            'landing_about_title',
            'landing_about_description',
            'landing_about_vision',
            'landing_about_mission',
            'landing_about_years_experience',
        ];

        foreach ($fields as $field) {
            if ($request->has($field)) {
                BusinessSetting::set($field, $request->input($field), 'landing_page');
            }
        }

        // Process Hero Showcase Image Uploads or Direct URLs
        $destination = public_path('uploads/hero');
        if (!file_exists($destination)) {
            @mkdir($destination, 0775, true);
        }

        $heroImageSlots = [
            'landing_hero_main_image' => 'main',
            'landing_hero_sub1_image' => 'sub1',
            'landing_hero_sub2_image' => 'sub2',
            'landing_hero_sub3_image' => 'sub3',
        ];

        foreach ($heroImageSlots as $key => $prefix) {
            $fileKey = $key . '_file';
            if ($request->hasFile($fileKey)) {
                $file = $request->file($fileKey);
                $ext = $file->getClientOriginalExtension() ?: 'jpg';
                $filename = 'hero_' . $prefix . '_' . time() . '.' . $ext;
                $file->move($destination, $filename);
                BusinessSetting::set($key, 'uploads/hero/' . $filename, 'landing_page');
            } elseif ($request->filled($key)) {
                BusinessSetting::set($key, $request->input($key), 'landing_page');
            }
        }

        return redirect()->route('landing-admin.index', ['tab' => 'hero-about'])
            ->with('success', 'Konten Hero, Foto Showcase, dan Profil Tentang Kami berhasil diperbarui.');
    }

    /**
     * Store new Service
     */
    public function storeService(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:150',
            'icon' => 'required|string|max:50',
            'short_description' => 'required|string|max:500',
            'full_description' => 'nullable|string|max:2000',
            'order' => 'nullable|integer',
        ]);

        $validated['slug'] = Str::slug($validated['title']) . '-' . time();
        $validated['order'] = $validated['order'] ?? (LandingService::max('order') + 1);
        $validated['is_active'] = $request->has('is_active');

        LandingService::create($validated);

        return redirect()->route('landing-admin.index', ['tab' => 'services'])
            ->with('success', 'Layanan baru berhasil ditambahkan.');
    }

    /**
     * Delete Service
     */
    public function destroyService(LandingService $service): RedirectResponse
    {
        $service->delete();
        return redirect()->route('landing-admin.index', ['tab' => 'services'])
            ->with('success', 'Layanan berhasil dihapus.');
    }

    /**
     * Store Gallery Photo (URL or File Upload)
     */
    public function storeGallery(Request $request): RedirectResponse
    {
        $request->validate([
            'title' => 'required|string|max:150',
            'category' => 'required|string|max:50',
            'caption' => 'nullable|string|max:300',
            'image_file' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
            'image_url' => 'nullable|url|max:500',
            'order' => 'nullable|integer',
        ]);

        $imagePath = $request->input('image_url');

        if ($request->hasFile('image_file')) {
            $file = $request->file('image_file');
            $filename = 'gallery_' . time() . '_' . Str::random(5) . '.' . ($file->getClientOriginalExtension() ?: 'jpg');
            $destination = public_path('uploads/gallery');
            if (!file_exists($destination)) {
                @mkdir($destination, 0775, true);
            }
            $file->move($destination, $filename);
            $imagePath = 'uploads/gallery/' . $filename;
        }

        if (empty($imagePath)) {
            return back()->with('error', 'Silakan upload file foto atau masukkan tautan URL gambar.');
        }

        LandingGallery::create([
            'title' => $request->input('title'),
            'category' => $request->input('category'),
            'image_path' => $imagePath,
            'caption' => $request->input('caption'),
            'order' => $request->input('order', LandingGallery::max('order') + 1),
            'is_active' => true,
        ]);

        return redirect()->route('landing-admin.index', ['tab' => 'gallery'])
            ->with('success', 'Foto galeri berhasil ditambahkan.');
    }

    /**
     * Delete Gallery Photo
     */
    public function destroyGallery(LandingGallery $gallery): RedirectResponse
    {
        if (!str_starts_with($gallery->image_path, 'http') && file_exists(public_path($gallery->image_path))) {
            @unlink(public_path($gallery->image_path));
        }
        $gallery->delete();

        return redirect()->route('landing-admin.index', ['tab' => 'gallery'])
            ->with('success', 'Foto galeri berhasil dihapus.');
    }

    /**
     * Store Story Photo (File Upload or URL)
     */
    public function storeStory(Request $request): RedirectResponse
    {
        $request->validate([
            'title' => 'required|string|max:150',
            'subtitle' => 'nullable|string|max:150',
            'tag' => 'nullable|string|max:80',
            'caption' => 'nullable|string|max:500',
            'image_file' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'image_url' => 'nullable|url|max:500',
        ]);

        $imagePath = $request->input('image_url');

        if ($request->hasFile('image_file')) {
            $file = $request->file('image_file');
            $dir = public_path('uploads/stories');
            if (!file_exists($dir)) {
                mkdir($dir, 0755, true);
            }
            $filename = 'story_' . time() . '_' . Str::random(5) . '.' . $file->getClientOriginalExtension();
            $file->move($dir, $filename);
            $imagePath = 'uploads/stories/' . $filename;
        }

        if (empty($imagePath)) {
            return back()->with('error', 'Silakan upload file foto atau masukkan tautan URL gambar untuk story.');
        }

        LandingStory::create([
            'title' => $request->input('title'),
            'subtitle' => $request->input('subtitle', 'PT. Seberaya Akses Multi'),
            'tag' => $request->input('tag', 'Cerita Depo'),
            'image_path' => $imagePath,
            'caption' => $request->input('caption'),
            'likes_count' => 0,
            'order' => 0,
            'is_active' => true,
        ]);

        return redirect()->route('landing-admin.index', ['tab' => 'stories'])
            ->with('success', 'Foto story baru berhasil ditambahkan! Foto ini langsung menjadi yang terdepan.');
    }

    /**
     * Delete Story Photo
     */
    public function destroyStory(LandingStory $story): RedirectResponse
    {
        if (!str_starts_with($story->image_path, 'http') && file_exists(public_path($story->image_path))) {
            @unlink(public_path($story->image_path));
        }
        $story->delete();

        return redirect()->route('landing-admin.index', ['tab' => 'stories'])
            ->with('success', 'Foto story berhasil dihapus.');
    }

    /**
     * Delete Story Comment
     */
    public function destroyStoryComment(LandingStoryComment $comment): RedirectResponse
    {
        $comment->delete();

        return redirect()->route('landing-admin.index', ['tab' => 'stories'])
            ->with('success', 'Komentar story berhasil dihapus.');
    }

    /**
     * Store Testimonial
     */
    public function storeTestimonial(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'client_name' => 'required|string|max:150',
            'client_role' => 'required|string|max:100',
            'rating' => 'required|integer|min:1|max:5',
            'content' => 'required|string|max:1000',
            'avatar_url' => 'nullable|url|max:500',
            'order' => 'nullable|integer',
        ]);

        $validated['order'] = $validated['order'] ?? (LandingTestimonial::max('order') + 1);
        $validated['is_active'] = true;

        LandingTestimonial::create($validated);

        return redirect()->route('landing-admin.index', ['tab' => 'testimonials'])
            ->with('success', 'Testimoni berhasil ditambahkan.');
    }

    /**
     * Delete Testimonial
     */
    public function destroyTestimonial(LandingTestimonial $testimonial): RedirectResponse
    {
        $testimonial->delete();
        return redirect()->route('landing-admin.index', ['tab' => 'testimonials'])
            ->with('success', 'Testimoni berhasil dihapus.');
    }

    /**
     * Store FAQ
     */
    public function storeFaq(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'question' => 'required|string|max:255',
            'answer' => 'required|string|max:2000',
            'category' => 'nullable|string|max:50',
            'order' => 'nullable|integer',
        ]);

        $validated['order'] = $validated['order'] ?? (LandingFaq::max('order') + 1);
        $validated['is_active'] = true;

        LandingFaq::create($validated);

        return redirect()->route('landing-admin.index', ['tab' => 'faqs'])
            ->with('success', 'Tanya Jawab (FAQ) berhasil ditambahkan.');
    }

    /**
     * Delete FAQ
     */
    public function destroyFaq(LandingFaq $faq): RedirectResponse
    {
        $faq->delete();
        return redirect()->route('landing-admin.index', ['tab' => 'faqs'])
            ->with('success', 'FAQ berhasil dihapus.');
    }

    /**
     * Store Statistic
     */
    public function storeStatistic(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'label' => 'required|string|max:100',
            'value' => 'required|string|max:50',
            'prefix' => 'nullable|string|max:10',
            'suffix' => 'nullable|string|max:10',
            'icon' => 'nullable|string|max:50',
            'order' => 'nullable|integer',
        ]);

        $validated['order'] = $validated['order'] ?? (LandingStatistic::max('order') + 1);
        $validated['is_active'] = true;

        LandingStatistic::create($validated);

        return redirect()->route('landing-admin.index', ['tab' => 'statistics'])
            ->with('success', 'Statistik berhasil ditambahkan.');
    }

    /**
     * Delete Statistic
     */
    public function destroyStatistic(LandingStatistic $statistic): RedirectResponse
    {
        $statistic->delete();
        return redirect()->route('landing-admin.index', ['tab' => 'statistics'])
            ->with('success', 'Statistik berhasil dihapus.');
    }
}

