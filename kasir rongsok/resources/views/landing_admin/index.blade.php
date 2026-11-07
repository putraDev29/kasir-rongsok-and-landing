@extends('layouts.app', ['header' => 'Pengelolaan Landing Page Website'])

@push('styles')
<style>
    /* Scope styles for Bento Hero showcase in landing admin */
    .hero-bento-card {
        background-color: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 0.875rem;
        padding: 1.25rem;
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.05);
    }
    .hero-main-layout {
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
        width: 100%;
    }
    @media (min-width: 768px) {
        .hero-main-layout {
            display: grid;
            grid-template-columns: 360px 1fr;
            align-items: start;
            gap: 1.5rem;
        }
    }
    .hero-preview-box-main {
        width: 100%;
        height: 220px;
        border-radius: 0.75rem;
        overflow: hidden;
        background-color: #0f172a;
        border: 1px solid #cbd5e1;
        position: relative;
    }
    .hero-preview-box-main img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .hero-sub-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 1.25rem;
        width: 100%;
    }
    @media (min-width: 768px) {
        .hero-sub-grid {
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 1.25rem;
        }
    }
    .hero-sub-card {
        background-color: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 0.875rem;
        padding: 1.1rem;
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.05);
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        gap: 0.875rem;
        width: 100%;
        box-sizing: border-box;
    }
    .hero-preview-box-sub {
        width: 100%;
        height: 140px;
        border-radius: 0.5rem;
        overflow: hidden;
        background-color: #0f172a;
        border: 1px solid #cbd5e1;
        position: relative;
    }
    .hero-preview-box-sub img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .logo-upload-layout {
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
        width: 100%;
    }
    @media (min-width: 768px) {
        .logo-upload-layout {
            display: grid;
            grid-template-columns: 240px 1fr;
            align-items: start;
            gap: 1.5rem;
        }
    }
    /* Polyfill missing Tailwind classes */
    .md\:col-span-2 { grid-column: span 2 / span 2; }
    .w-fit { width: fit-content; }
</style>
@endpush

@section('content')
<div class="max-w-7xl mx-auto space-y-6" x-data="{ activeTab: '{{ request('tab', 'settings') }}' }">

    <!-- Top Alert Messages -->
    @if(session('success'))
        <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl flex items-center justify-between text-sm shadow-sm">
            <div class="flex items-center gap-2">
                <i data-lucide="check-circle" class="w-5 h-5 text-emerald-600"></i>
                <span class="font-semibold">{{ session('success') }}</span>
            </div>
            <button @click="$el.parentElement.remove()" class="text-emerald-500 hover:text-emerald-800">
                <i data-lucide="x" class="w-4 h-4"></i>
            </button>
        </div>
    @endif

    @if(session('error'))
        <div class="p-4 bg-rose-50 border border-rose-200 text-rose-800 rounded-xl flex items-center justify-between text-sm shadow-sm">
            <div class="flex items-center gap-2">
                <i data-lucide="alert-triangle" class="w-5 h-5 text-rose-600"></i>
                <span class="font-semibold">{{ session('error') }}</span>
            </div>
            <button @click="$el.parentElement.remove()" class="text-rose-500 hover:text-rose-800">
                <i data-lucide="x" class="w-4 h-4"></i>
            </button>
        </div>
    @endif

    <!-- Header Banner -->
    <div class="bg-gradient-to-r from-slate-900 via-slate-800 to-emerald-950 text-white rounded-2xl p-6 shadow-md border border-slate-700 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2.5">
                <div class="w-10 h-10 rounded-xl bg-emerald-500/20 text-emerald-400 border border-emerald-500/30 flex items-center justify-center font-bold">
                    <i data-lucide="globe" class="w-6 h-6"></i>
                </div>
                <div>
                    <h2 class="text-xl font-black tracking-tight text-white">Manajemen Landing Page Website</h2>
                    <p class="text-xs text-slate-300 mt-0.5">Kelola informasi publik, kontak WhatsApp, Google Maps, layanan, galeri foto, testimoni, dan SEO secara dinamis</p>
                </div>
            </div>
        </div>

        <div class="flex items-center gap-3">
            <a href="http://localhost:3000" target="_blank" class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-600 hover:bg-emerald-500 text-white text-xs font-bold rounded-xl transition shadow-sm">
                <i data-lucide="external-link" class="w-4 h-4"></i>
                <span>Lihat Website (Port 3000)</span>
            </a>
            <a href="{{ url('/api/landing-page') }}" target="_blank" class="inline-flex items-center gap-2 px-3 py-2 bg-slate-800 hover:bg-slate-700 text-slate-200 text-xs font-semibold rounded-xl border border-slate-600 transition">
                <i data-lucide="code" class="w-4 h-4 text-emerald-400"></i>
                <span>Cek JSON API</span>
            </a>
        </div>
    </div>

    <!-- Navigation Tabs -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-2 flex flex-wrap gap-1.5 text-xs font-semibold">
        <button type="button" @click="activeTab = 'settings'; history.replaceState(null, '', '?tab=settings')" :class="activeTab === 'settings' ? 'bg-emerald-600 text-white shadow-sm' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900'" class="px-3.5 py-2 rounded-xl transition flex items-center gap-2">
            <i data-lucide="sliders" class="w-4 h-4"></i>
            <span>Logo, Kontak & SEO</span>
        </button>

        <button type="button" @click="activeTab = 'hero-about'; history.replaceState(null, '', '?tab=hero-about')" :class="activeTab === 'hero-about' ? 'bg-emerald-600 text-white shadow-sm' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900'" class="px-3.5 py-2 rounded-xl transition flex items-center gap-2">
            <i data-lucide="layout" class="w-4 h-4"></i>
            <span>Hero & Tentang Kami</span>
        </button>

        <button type="button" @click="activeTab = 'stories'; history.replaceState(null, '', '?tab=stories')" :class="activeTab === 'stories' ? 'bg-emerald-600 text-white shadow-sm' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900'" class="px-3.5 py-2 rounded-xl transition flex items-center gap-2">
            <i data-lucide="play-circle" class="w-4 h-4 text-amber-300"></i>
            <span>Hero Story Reel ({{ $stories->count() }})</span>
        </button>

        <button type="button" @click="activeTab = 'services'; history.replaceState(null, '', '?tab=services')" :class="activeTab === 'services' ? 'bg-emerald-600 text-white shadow-sm' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900'" class="px-3.5 py-2 rounded-xl transition flex items-center gap-2">
            <i data-lucide="briefcase" class="w-4 h-4"></i>
            <span>Layanan ({{ $services->count() }})</span>
        </button>

        <button type="button" @click="activeTab = 'gallery'; history.replaceState(null, '', '?tab=gallery')" :class="activeTab === 'gallery' ? 'bg-emerald-600 text-white shadow-sm' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900'" class="px-3.5 py-2 rounded-xl transition flex items-center gap-2">
            <i data-lucide="image" class="w-4 h-4"></i>
            <span>Galeri Foto ({{ $galleries->count() }})</span>
        </button>

        <button type="button" @click="activeTab = 'testimonials'; history.replaceState(null, '', '?tab=testimonials')" :class="activeTab === 'testimonials' ? 'bg-emerald-600 text-white shadow-sm' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900'" class="px-3.5 py-2 rounded-xl transition flex items-center gap-2">
            <i data-lucide="message-square" class="w-4 h-4"></i>
            <span>Testimoni ({{ $testimonials->count() }})</span>
        </button>

        <button type="button" @click="activeTab = 'faqs'; history.replaceState(null, '', '?tab=faqs')" :class="activeTab === 'faqs' ? 'bg-emerald-600 text-white shadow-sm' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900'" class="px-3.5 py-2 rounded-xl transition flex items-center gap-2">
            <i data-lucide="help-circle" class="w-4 h-4"></i>
            <span>FAQ ({{ $faqs->count() }})</span>
        </button>

        <button type="button" @click="activeTab = 'statistics'; history.replaceState(null, '', '?tab=statistics')" :class="activeTab === 'statistics' ? 'bg-emerald-600 text-white shadow-sm' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900'" class="px-3.5 py-2 rounded-xl transition flex items-center gap-2">
            <i data-lucide="trending-up" class="w-4 h-4"></i>
            <span>Statistik ({{ $statistics->count() }})</span>
        </button>

        <button type="button" @click="activeTab = 'inquiries'; history.replaceState(null, '', '?tab=inquiries')" :class="activeTab === 'inquiries' ? 'bg-emerald-600 text-white shadow-sm' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900'" class="px-3.5 py-2 rounded-xl transition flex items-center gap-2">
            <i data-lucide="inbox" class="w-4 h-4"></i>
            <span>Kotak Masuk ({{ $inquiries->count() }})</span>
        </button>

        <button type="button" @click="activeTab = 'cloud-sync'; history.replaceState(null, '', '?tab=cloud-sync')" :class="activeTab === 'cloud-sync' ? 'bg-indigo-600 text-white shadow-sm' : 'text-indigo-700 bg-indigo-50 hover:bg-indigo-100'" class="px-3.5 py-2 rounded-xl transition flex items-center gap-2 border border-indigo-200">
            <i data-lucide="cloud-lightning" class="w-4 h-4 text-indigo-500" :class="activeTab === 'cloud-sync' ? 'text-white' : ''"></i>
            <span>Sync Hosting cPanel</span>
            @if($syncConfig['enabled'])
                <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
            @endif
        </button>
    </div>

    <!-- TAB 1: LOGO, KONTAK, MAPS & SEO -->
    <div x-show="activeTab === 'settings'" class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 sm:p-8 space-y-6">
        <div class="border-b border-slate-200 pb-4">
            <h3 class="text-base font-bold text-slate-900">Pengaturan Logo Header, Identitas Usaha, Kontak & SEO</h3>
            <p class="text-xs text-slate-500 mt-1">Kelola logo/ikon header website, nama perusahaan, nomor WhatsApp, alamat Maps, jam operasional, dan SEO</p>
        </div>

        <form action="{{ route('landing-admin.settings.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <!-- Section Identitas & Logo / Ikon Header Website -->
            <div class="bg-slate-50 p-5 sm:p-6 rounded-xl border border-slate-200 space-y-5">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 border-b border-slate-200 pb-3">
                    <h4 class="text-xs font-bold uppercase tracking-wider text-emerald-800 flex items-center gap-2">
                        <i data-lucide="shield" class="w-4 h-4 text-emerald-600"></i>
                        <span>Logo & Ikon Header Website (Navigasi & Favicon)</span>
                    </h4>
                    <span class="text-[11px] font-semibold text-emerald-700 bg-emerald-100 border border-emerald-200 px-2.5 py-0.5 rounded-full w-fit">
                        Tampil di Navigasi Header, Footer & Tab Browser
                    </span>
                </div>

                <div class="logo-upload-layout">
                    <!-- Preview Logo Kiri -->
                    <div class="space-y-2">
                        <label class="block text-xs font-semibold text-slate-700 uppercase">Pratinjau Logo Saat Ini</label>
                        <div class="w-full h-36 rounded-xl bg-white border border-slate-300 shadow-sm flex items-center justify-center p-3 relative overflow-hidden group">
                            @php
                                $currentLogo = !empty($settings['landing_header_logo']) 
                                    ? $settings['landing_header_logo'] 
                                    : (!empty($settings['app_logo']) ? $settings['app_logo'] : null);
                                $currentLogoUrl = $currentLogo 
                                    ? (str_starts_with($currentLogo, 'http') ? $currentLogo : asset($currentLogo)) 
                                    : asset('icon-default.svg');
                            @endphp
                            <img id="preview-header-logo" 
                                 src="{{ $currentLogoUrl }}" 
                                 alt="Logo Header" 
                                 class="max-h-24 max-w-full object-contain transition group-hover:scale-105">
                        </div>
                        <span class="text-[11px] text-slate-400 block text-center">Format PNG / JPG / SVG transparan direkomendasikan.</span>
                    </div>

                    <!-- Input Upload & Teks Kanan -->
                    <div class="space-y-4">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Nama Perusahaan / Usaha *</label>
                                <input type="text" name="company_name" 
                                       value="{{ old('company_name', $settings['company_name'] ?? 'PT. Seberaya Akses Multi') }}" required
                                       class="w-full py-2 px-3 text-xs rounded-lg border border-slate-300 font-bold text-slate-900 bg-white">
                                <span class="text-[11px] text-slate-400">Nama brand di samping icon/logo pada navigasi header.</span>
                            </div>

                            <div>
                                <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Tagline Singkat Header</label>
                                <input type="text" name="company_tagline" 
                                       value="{{ old('company_tagline', $settings['company_tagline'] ?? 'Seberaya Logam • Scrap & Rongsok') }}"
                                       class="w-full py-2 px-3 text-xs rounded-lg border border-slate-300 font-semibold text-slate-700 bg-white">
                                <span class="text-[11px] text-slate-400">Teks kecil di bawah nama perusahaan pada header & footer.</span>
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Unggah Berkas File Logo / Ikon Baru (Laptop/PC)</label>
                            <input type="file" name="header_logo_file" accept="image/*"
                                   onchange="previewHeroImage(this, 'preview-header-logo')"
                                   class="w-full text-xs text-slate-600 file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 border border-slate-300 rounded-lg p-1 bg-white cursor-pointer">
                            <span class="text-[11px] text-slate-400">Pilih berkas logo usaha Anda (format PNG, JPG, WEBP, SVG maks 2MB).</span>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Atau Gunakan Tautan URL Gambar Logo</label>
                            <input type="text" name="header_logo_url" 
                                   oninput="previewHeroUrl(this.value, 'preview-header-logo')"
                                   value="{{ old('header_logo_url', !empty($settings['landing_header_logo']) && str_starts_with($settings['landing_header_logo'], 'http') ? $settings['landing_header_logo'] : '') }}"
                                   placeholder="https://..." class="w-full py-2 px-3 text-xs rounded-lg border border-slate-300 bg-white">
                        </div>

                        <div class="flex items-center gap-2 pt-1">
                            <input type="checkbox" name="remove_header_logo" value="1" id="remove_header_logo" class="rounded text-rose-600 border-slate-300">
                            <label for="remove_header_logo" class="text-xs text-rose-600 font-medium">Reset & hapus logo kustom (Gunakan icon default)</label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Section WhatsApp & Kontak -->
            <div class="bg-slate-50 p-5 rounded-xl border border-slate-200 space-y-4">
                <h4 class="text-xs font-bold uppercase tracking-wider text-emerald-800 flex items-center gap-2">
                    <i data-lucide="phone" class="w-4 h-4"></i>
                    <span>Integrasi WhatsApp & Kontak Langsung</span>
                </h4>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Nomor WhatsApp Usaha *</label>
                        <input type="text" name="landing_whatsapp_number" value="{{ old('landing_whatsapp_number', $settings['landing_whatsapp_number'] ?? '081234567890') }}" required
                               placeholder="Contoh: 081234567890 atau 6281234567890"
                               class="w-full py-2.5 px-3 text-xs rounded-lg border border-slate-300 focus:ring-emerald-500 font-semibold bg-white">
                        <span class="text-[11px] text-slate-400">Digunakan pada WhatsApp Floating Button dan tombol CTA di landing page.</span>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Email Resmi Usaha</label>
                        <input type="email" name="landing_email" value="{{ old('landing_email', $settings['landing_email'] ?? 'kontak@berkahrongsok.com') }}"
                               placeholder="kontak@berkahrongsok.com"
                               class="w-full py-2.5 px-3 text-xs rounded-lg border border-slate-300 focus:ring-emerald-500 bg-white">
                        <span class="text-[11px] text-slate-400">Email untuk korespondensi pabrik atau penawaran resmi.</span>
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Pesan Pembuka Otomatis WhatsApp (Greeting Text)</label>
                        <textarea name="landing_whatsapp_message" rows="2" class="w-full p-2.5 text-xs rounded-lg border border-slate-300 focus:ring-emerald-500 bg-white">{{ old('landing_whatsapp_message', $settings['landing_whatsapp_message'] ?? 'Halo Admin, saya ingin bertanya mengenai penjualan barang rongsok. Apakah bisa diinformasikan penawaran harga dan jadwal jemput armada?') }}</textarea>
                        <span class="text-[11px] text-slate-400">Teks template yang otomatis terisi ketika pelanggan mengklik tombol WhatsApp.</span>
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Jam Operasional Depo</label>
                        <input type="text" name="landing_operating_hours" value="{{ old('landing_operating_hours', $settings['landing_operating_hours'] ?? 'Senin - Sabtu: 07.30 - 17.30 WIB | Minggu: 08.00 - 14.00 WIB') }}"
                               class="w-full py-2.5 px-3 text-xs rounded-lg border border-slate-300 focus:ring-emerald-500 bg-white">
                        <span class="text-[11px] text-slate-400">Informasi jam buka timbangan depo pada section lokasi dan footer.</span>
                    </div>
                </div>
            </div>

            <!-- Section Google Maps -->
            <div class="bg-slate-50 p-5 rounded-xl border border-slate-200 space-y-4">
                <h4 class="text-xs font-bold uppercase tracking-wider text-emerald-800 flex items-center gap-2">
                    <i data-lucide="map-pin" class="w-4 h-4"></i>
                    <span>Lokasi Usaha & Google Maps Embed</span>
                </h4>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="md:col-span-2">
                        <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Google Maps Embed URL (Iframe Source)</label>
                        <input type="text" name="landing_maps_embed_url" value="{{ old('landing_maps_embed_url', $settings['landing_maps_embed_url'] ?? '') }}"
                               placeholder="https://www.google.com/maps/embed?pb=..."
                               class="w-full py-2.5 px-3 text-xs rounded-lg border border-slate-300 focus:ring-emerald-500 bg-white">
                        <span class="text-[11px] text-slate-400">Dapat disalin dari Google Maps (Bagikan $\rightarrow$ Sematkan Peta $\rightarrow$ Salin URL src di dalam iframe).</span>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Tautan Direct Google Maps (Buka Peta / Petunjuk Arah)</label>
                        <input type="text" name="landing_maps_url" value="{{ old('landing_maps_url', $settings['landing_maps_url'] ?? 'https://maps.google.com/?q=-6.273898,107.086386') }}"
                               placeholder="https://maps.google.com/?q=..."
                               class="w-full py-2.5 px-3 text-xs rounded-lg border border-slate-300 focus:ring-emerald-500 bg-white">
                    </div>

                    <div class="grid grid-cols-2 gap-2">
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Latitude</label>
                            <input type="text" name="landing_maps_latitude" value="{{ old('landing_maps_latitude', $settings['landing_maps_latitude'] ?? '-6.273898') }}"
                                   class="w-full py-2.5 px-3 text-xs rounded-lg border border-slate-300 focus:ring-emerald-500 bg-white">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Longitude</label>
                            <input type="text" name="landing_maps_longitude" value="{{ old('landing_maps_longitude', $settings['landing_maps_longitude'] ?? '107.086386') }}"
                                   class="w-full py-2.5 px-3 text-xs rounded-lg border border-slate-300 focus:ring-emerald-500 bg-white">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Section Media Sosial & SEO -->
            <div class="bg-slate-50 p-5 rounded-xl border border-slate-200 space-y-4">
                <h4 class="text-xs font-bold uppercase tracking-wider text-emerald-800 flex items-center gap-2">
                    <i data-lucide="search" class="w-4 h-4"></i>
                    <span>Media Sosial & Optimasi SEO Mesin Pencari</span>
                </h4>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Instagram URL</label>
                        <input type="url" name="landing_social_instagram" value="{{ old('landing_social_instagram', $settings['landing_social_instagram'] ?? '') }}"
                               placeholder="https://instagram.com/..." class="w-full py-2 px-3 text-xs rounded-lg border border-slate-300 bg-white">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Facebook URL</label>
                        <input type="url" name="landing_social_facebook" value="{{ old('landing_social_facebook', $settings['landing_social_facebook'] ?? '') }}"
                               placeholder="https://facebook.com/..." class="w-full py-2 px-3 text-xs rounded-lg border border-slate-300 bg-white">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">TikTok URL</label>
                        <input type="url" name="landing_social_tiktok" value="{{ old('landing_social_tiktok', $settings['landing_social_tiktok'] ?? '') }}"
                               placeholder="https://tiktok.com/@..." class="w-full py-2 px-3 text-xs rounded-lg border border-slate-300 bg-white">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">YouTube URL</label>
                        <input type="url" name="landing_social_youtube" value="{{ old('landing_social_youtube', $settings['landing_social_youtube'] ?? '') }}"
                               placeholder="https://youtube.com/@..." class="w-full py-2 px-3 text-xs rounded-lg border border-slate-300 bg-white">
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Meta Title SEO (Judul di Google Search)</label>
                        <input type="text" name="landing_seo_meta_title" value="{{ old('landing_seo_meta_title', $settings['landing_seo_meta_title'] ?? 'Jual Beli Rongsok & Pengepul Besi Tua Terpercaya | UD. Berkah Rongsok Makmur') }}"
                               class="w-full py-2 px-3 text-xs rounded-lg border border-slate-300 bg-white font-semibold">
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Meta Description SEO</label>
                        <textarea name="landing_seo_meta_description" rows="2" class="w-full p-2.5 text-xs rounded-lg border border-slate-300 bg-white">{{ old('landing_seo_meta_description', $settings['landing_seo_meta_description'] ?? 'Pengepul rongsok terpercaya terima besi tua, tembaga, kuningan, kardus, plastik, dan aki bekas harga tinggi. Timbangan digital transparan, bayar tunai di tempat, siap jemput gudang & pabrik.') }}</textarea>
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Keywords SEO (Pisahkan dengan koma)</label>
                        <input type="text" name="landing_seo_keywords" value="{{ old('landing_seo_keywords', $settings['landing_seo_keywords'] ?? 'jual beli rongsok, pengepul rongsok terpercaya, jual besi tua cikarang, harga kardus bekas per kg, rongsokan daur ulang, depo rongsok terdekat') }}"
                               class="w-full py-2 px-3 text-xs rounded-lg border border-slate-300 bg-white">
                    </div>
                </div>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="px-6 py-2.5 bg-emerald-600 hover:bg-emerald-500 text-white text-xs font-bold rounded-xl shadow-md transition flex items-center gap-2">
                    <i data-lucide="save" class="w-4 h-4"></i>
                    <span>Simpan Pengaturan Profil & SEO</span>
                </button>
            </div>
        </form>
    </div>

    <!-- TAB 2: HERO & TENTANG KAMI -->
    <div x-show="activeTab === 'hero-about'" class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 sm:p-8 space-y-6">
        <div class="border-b border-slate-200 pb-4">
            <h3 class="text-base font-bold text-slate-900">Pengaturan Hero Banner & Profil Tentang Kami</h3>
            <p class="text-xs text-slate-500 mt-1">Sesuaikan headline utama, deskripsi bisnis, visi, misi, dan tahun pengalaman yang tampil di bagian atas website</p>
        </div>

        <form action="{{ route('landing-admin.hero-about.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <!-- Hero Settings -->
            <div class="bg-slate-50 p-5 rounded-xl border border-slate-200 space-y-4">
                <h4 class="text-xs font-bold uppercase tracking-wider text-emerald-800 flex items-center gap-2">
                    <i data-lucide="sparkles" class="w-4 h-4"></i>
                    <span>Teks & Konten Hero (Bagian Utama Atas)</span>
                </h4>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="md:col-span-2">
                        <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Badge Tagline Kecil di Atas Headline</label>
                        <input type="text" name="landing_hero_badge" value="{{ old('landing_hero_badge', $settings['landing_hero_badge'] ?? 'PT. Seberaya Akses Multi • Spesialis Logam Scrap & Rongsok') }}"
                               class="w-full py-2 px-3 text-xs rounded-lg border border-slate-300 bg-white">
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Headline Utama Hero (Maks. 150 karakter) *</label>
                        <input type="text" name="landing_hero_headline" value="{{ old('landing_hero_headline', $settings['landing_hero_headline'] ?? 'Pusat Jual Beli Besi Tua, Scrap Logam & Bongkaran') }}" required
                               class="w-full py-2.5 px-3 text-sm font-bold rounded-lg border border-slate-300 bg-white text-slate-900">
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Subheadline / Deskripsi Singkat Hero *</label>
                        <textarea name="landing_hero_subheadline" rows="2" required class="w-full p-2.5 text-xs rounded-lg border border-slate-300 bg-white">{{ old('landing_hero_subheadline', $settings['landing_hero_subheadline'] ?? 'Menerima besi tua, tembaga, kuningan, aluminium, timah, nikel, tabung gas & bongkaran bangunan. Timbangan digital presisi & pelunasan tunai di tempat.') }}</textarea>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Teks Tombol CTA Utama (WhatsApp)</label>
                        <input type="text" name="landing_hero_cta_primary" value="{{ old('landing_hero_cta_primary', $settings['landing_hero_cta_primary'] ?? 'Chat WhatsApp') }}"
                               class="w-full py-2 px-3 text-xs rounded-lg border border-slate-300 bg-white font-semibold">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Teks Tombol CTA Kedua (Harga)</label>
                        <input type="text" name="landing_hero_cta_secondary" value="{{ old('landing_hero_cta_secondary', $settings['landing_hero_cta_secondary'] ?? 'Cek Harga') }}"
                               class="w-full py-2 px-3 text-xs rounded-lg border border-slate-300 bg-white font-semibold">
                    </div>
                </div>
            </div>

            <!-- Story Reel Announcement Banner -->
            <div class="p-4 bg-gradient-to-r from-amber-50 to-emerald-50 border border-amber-200 rounded-xl flex flex-col sm:flex-row sm:items-center justify-between gap-3 shadow-xs">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-amber-500 to-rose-500 text-white flex items-center justify-center shrink-0 shadow-sm">
                        <i data-lucide="play-circle" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <span class="text-xs font-bold text-slate-900 flex items-center gap-1.5">
                            <span>Ingin Mengunggah Banyak Foto Story Tanpa Batas?</span>
                            <span class="px-1.5 py-0.5 rounded text-[9px] font-bold bg-amber-500 text-white">BARU</span>
                        </span>
                        <span class="text-[11px] text-slate-600">Foto utama hero kini mendukung Story tak terbatas dengan fitur Like, Komentar Otomatis Bahasa Indonesia, dan Tanya WhatsApp di Tab <strong>Hero Story Reel</strong>.</span>
                    </div>
                </div>
                <button type="button" @click="activeTab = 'stories'; history.replaceState(null, '', '?tab=stories')" class="px-3.5 py-1.5 bg-slate-900 hover:bg-slate-800 text-white text-xs font-bold rounded-lg transition shrink-0 flex items-center gap-1.5 shadow-sm">
                    <span>Kelola Story Hero ({{ $stories->count() }})</span>
                    <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
                </button>
            </div>

            <!-- Hero Visual Showcase Images (Bento Grid) -->
            <div class="bg-slate-50 p-6 sm:p-7 rounded-2xl border border-slate-200 space-y-6">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 border-b border-slate-200 pb-4">
                    <div>
                        <h4 class="text-sm font-bold uppercase tracking-wider text-slate-900 flex items-center gap-2">
                            <i data-lucide="image" class="w-4 h-4 text-emerald-600"></i>
                            <span>Kelola Foto Hero Halaman Utama (Bento Showcase 4 Foto)</span>
                        </h4>
                        <p class="text-xs text-slate-500 mt-1">
                            Atur 1 Foto Utama dan 3 Foto Cuplikan yang tampil di halaman depan website. Anda dapat mengunggah file foto atau memasukkan URL gambar.
                        </p>
                    </div>
                    <span class="text-xs font-semibold text-emerald-700 bg-emerald-100 border border-emerald-200 px-3 py-1 rounded-full w-fit">
                        Upload File atau Tautan URL
                    </span>
                </div>

                <!-- 1. FOTO UTAMA DEPO (KARTU BESAR DI ATAS) -->
                <div class="hero-bento-card space-y-4">
                    <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                        <div class="flex items-center gap-2">
                            <span class="w-6 h-6 rounded-full bg-emerald-600 text-white flex items-center justify-center text-xs font-black">1</span>
                            <span class="text-xs font-bold uppercase text-slate-900">Foto Utama Depo (Tampilan Utama Besar)</span>
                        </div>
                        <span class="text-[11px] font-bold text-emerald-700 bg-emerald-50 border border-emerald-200 px-2.5 py-0.5 rounded-full">
                            Badge 24 Jam Aktif
                        </span>
                    </div>

                    <div class="hero-main-layout" style="display: flex; flex-wrap: wrap; gap: 1.5rem; width: 100%;">
                        <!-- Preview Kiri -->
                        <div class="space-y-2" style="flex: 1 1 320px; min-width: 260px; max-width: 100%;">
                            <label class="block text-xs font-semibold text-slate-700 uppercase">Pratinjau Foto Utama Saat Ini</label>
                            <div class="hero-preview-box-main shadow-inner" style="width: 100%; height: 220px; border-radius: 0.75rem; overflow: hidden; background: #0f172a; border: 1px solid #cbd5e1;">
                                <img id="preview-hero-main"
                                     src="{{ !empty($settings['landing_hero_main_image']) ? (str_starts_with($settings['landing_hero_main_image'], 'http') ? $settings['landing_hero_main_image'] : asset($settings['landing_hero_main_image'])) : 'https://images.unsplash.com/photo-1532996122724-e3c354a0b15b?q=80&w=1200&auto=format&fit=crop' }}"
                                     alt="Foto Utama Depo" style="width: 100%; height: 100%; object-fit: cover;">
                            </div>
                            <span class="text-[11px] text-slate-400 block">Rekomendasi rasio foto horizontal (landscape / 16:9).</span>
                        </div>

                        <!-- Input Kanan -->
                        <div class="space-y-3.5" style="flex: 2 1 360px; min-width: 260px;">
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Unggah File Foto Baru</label>
                                <input type="file" name="landing_hero_main_image_file" accept="image/*"
                                       onchange="previewHeroImage(this, 'preview-hero-main')"
                                       class="w-full text-xs text-slate-600 file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 border border-slate-300 rounded-lg p-1 bg-slate-50 cursor-pointer">
                                <span class="text-[11px] text-slate-400">Pilih file foto dari laptop/PC Anda (format JPG, PNG, WEBP maks 3MB).</span>
                            </div>

                            <div>
                                <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Atau Gunakan Tautan URL Gambar</label>
                                <input type="text" name="landing_hero_main_image"
                                       oninput="previewHeroUrl(this.value, 'preview-hero-main')"
                                       value="{{ old('landing_hero_main_image', $settings['landing_hero_main_image'] ?? '') }}"
                                       placeholder="https://images.unsplash.com/photo-..." class="w-full py-2 px-3 text-xs rounded-lg border border-slate-300 bg-white">
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 pt-1">
                                <div>
                                    <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Judul Caption Foto</label>
                                    <input type="text" name="landing_hero_main_title" value="{{ old('landing_hero_main_title', $settings['landing_hero_main_title'] ?? 'Penimbangan Digital & Penampungan Logam Scrap') }}"
                                           class="w-full py-2 px-3 text-xs rounded-lg border border-slate-300 bg-white">
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Subjudul / Lokasi</label>
                                    <input type="text" name="landing_hero_main_subtitle" value="{{ old('landing_hero_main_subtitle', $settings['landing_hero_main_subtitle'] ?? 'Depo Srengseng Sawah • Jagakarsa') }}"
                                           class="w-full py-2 px-3 text-xs rounded-lg border border-slate-300 bg-white">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 2, 3, 4: 3 FOTO CUPLIKAN (3 KOLOM BERJAJAR RAPI) -->
                <div>
                    <h5 class="text-xs font-bold uppercase tracking-wider text-slate-700 mb-3 flex items-center gap-1.5">
                        <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                        <span>3 Foto Cuplikan Pendamping (Slot 1, 2, 3)</span>
                    </h5>

                    <div class="hero-sub-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.25rem; width: 100%;">
                        <!-- Cuplikan 1 -->
                        <div class="hero-sub-card">
                            <div class="flex items-center justify-between border-b border-slate-100 pb-2">
                                <span class="text-xs font-bold text-slate-900 flex items-center gap-1.5">
                                    <span class="w-5 h-5 rounded-full bg-amber-500 text-white flex items-center justify-center text-[10px] font-bold">2</span>
                                    <span>Cuplikan 1 (Logam Presisi)</span>
                                </span>
                                <span class="text-[10px] text-amber-700 bg-amber-50 px-2 py-0.5 rounded font-mono font-bold">Slot 1</span>
                            </div>

                            <div class="hero-preview-box-sub">
                                <img id="preview-hero-sub1"
                                     src="{{ !empty($settings['landing_hero_sub1_image']) ? (str_starts_with($settings['landing_hero_sub1_image'], 'http') ? $settings['landing_hero_sub1_image'] : asset($settings['landing_hero_sub1_image'])) : 'https://images.unsplash.com/photo-1611284446314-60a58ac0deb9?q=80&w=800&auto=format&fit=crop' }}"
                                     alt="Cuplikan 1">
                            </div>

                            <div class="space-y-2">
                                <div>
                                    <label class="block text-[10px] font-semibold text-slate-700 uppercase mb-0.5">Unggah Foto Baru</label>
                                    <input type="file" name="landing_hero_sub1_image_file" accept="image/*"
                                           onchange="previewHeroImage(this, 'preview-hero-sub1')"
                                           class="w-full text-[11px] text-slate-600 file:mr-2 file:py-1 file:px-2.5 file:rounded file:border-0 file:text-[10px] file:font-semibold file:bg-slate-100 file:text-slate-700 border border-slate-300 rounded p-1 cursor-pointer bg-white">
                                </div>
                                <div>
                                    <label class="block text-[10px] font-semibold text-slate-700 uppercase mb-0.5">Atau URL Gambar</label>
                                    <input type="text" name="landing_hero_sub1_image"
                                           oninput="previewHeroUrl(this.value, 'preview-hero-sub1')"
                                           value="{{ old('landing_hero_sub1_image', $settings['landing_hero_sub1_image'] ?? '') }}"
                                           placeholder="https://..." class="w-full py-1.5 px-2.5 text-xs rounded border border-slate-300 bg-white">
                                </div>
                                <div class="grid grid-cols-2 gap-2 pt-1">
                                    <div>
                                        <label class="block text-[10px] font-semibold text-slate-600 uppercase mb-0.5">Tag Badge</label>
                                        <input type="text" name="landing_hero_sub1_tag" value="{{ old('landing_hero_sub1_tag', $settings['landing_hero_sub1_tag'] ?? 'Logam Presisi') }}"
                                               class="w-full py-1.5 px-2 text-xs rounded border border-slate-300 bg-white">
                                    </div>
                                    <div>
                                        <label class="block text-[10px] font-semibold text-slate-600 uppercase mb-0.5">Judul</label>
                                        <input type="text" name="landing_hero_sub1_title" value="{{ old('landing_hero_sub1_title', $settings['landing_hero_sub1_title'] ?? 'Tembaga, Kuningan & Nikel') }}"
                                               class="w-full py-1.5 px-2 text-xs rounded border border-slate-300 bg-white">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Cuplikan 2 -->
                        <div class="hero-sub-card">
                            <div class="flex items-center justify-between border-b border-slate-100 pb-2">
                                <span class="text-xs font-bold text-slate-900 flex items-center gap-1.5">
                                    <span class="w-5 h-5 rounded-full bg-sky-500 text-white flex items-center justify-center text-[10px] font-bold">3</span>
                                    <span>Cuplikan 2 (Armada Jemput)</span>
                                </span>
                                <span class="text-[10px] text-sky-700 bg-sky-50 px-2 py-0.5 rounded font-mono font-bold">Slot 2</span>
                            </div>

                            <div class="hero-preview-box-sub">
                                <img id="preview-hero-sub2"
                                     src="{{ !empty($settings['landing_hero_sub2_image']) ? (str_starts_with($settings['landing_hero_sub2_image'], 'http') ? $settings['landing_hero_sub2_image'] : asset($settings['landing_hero_sub2_image'])) : 'https://images.unsplash.com/photo-1601584115197-04ecc0da31d7?q=80&w=800&auto=format&fit=crop' }}"
                                     alt="Cuplikan 2">
                            </div>

                            <div class="space-y-2">
                                <div>
                                    <label class="block text-[10px] font-semibold text-slate-700 uppercase mb-0.5">Unggah Foto Baru</label>
                                    <input type="file" name="landing_hero_sub2_image_file" accept="image/*"
                                           onchange="previewHeroImage(this, 'preview-hero-sub2')"
                                           class="w-full text-[11px] text-slate-600 file:mr-2 file:py-1 file:px-2.5 file:rounded file:border-0 file:text-[10px] file:font-semibold file:bg-slate-100 file:text-slate-700 border border-slate-300 rounded p-1 cursor-pointer bg-white">
                                </div>
                                <div>
                                    <label class="block text-[10px] font-semibold text-slate-700 uppercase mb-0.5">Atau URL Gambar</label>
                                    <input type="text" name="landing_hero_sub2_image"
                                           oninput="previewHeroUrl(this.value, 'preview-hero-sub2')"
                                           value="{{ old('landing_hero_sub2_image', $settings['landing_hero_sub2_image'] ?? '') }}"
                                           placeholder="https://..." class="w-full py-1.5 px-2.5 text-xs rounded border border-slate-300 bg-white">
                                </div>
                                <div class="grid grid-cols-2 gap-2 pt-1">
                                    <div>
                                        <label class="block text-[10px] font-semibold text-slate-600 uppercase mb-0.5">Tag Badge</label>
                                        <input type="text" name="landing_hero_sub2_tag" value="{{ old('landing_hero_sub2_tag', $settings['landing_hero_sub2_tag'] ?? 'Armada Jemput') }}"
                                               class="w-full py-1.5 px-2 text-xs rounded border border-slate-300 bg-white">
                                    </div>
                                    <div>
                                        <label class="block text-[10px] font-semibold text-slate-600 uppercase mb-0.5">Judul</label>
                                        <input type="text" name="landing_hero_sub2_title" value="{{ old('landing_hero_sub2_title', $settings['landing_hero_sub2_title'] ?? 'Truk & Pick-Up Siap 24 Jam') }}"
                                               class="w-full py-1.5 px-2 text-xs rounded border border-slate-300 bg-white">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Cuplikan 3 -->
                        <div class="hero-sub-card">
                            <div class="flex items-center justify-between border-b border-slate-100 pb-2">
                                <span class="text-xs font-bold text-slate-900 flex items-center gap-1.5">
                                    <span class="w-5 h-5 rounded-full bg-teal-500 text-white flex items-center justify-center text-[10px] font-bold">4</span>
                                    <span>Cuplikan 3 (Bongkaran & Gas)</span>
                                </span>
                                <span class="text-[10px] text-teal-700 bg-teal-50 px-2 py-0.5 rounded font-mono font-bold">Slot 3</span>
                            </div>

                            <div class="hero-preview-box-sub">
                                <img id="preview-hero-sub3"
                                     src="{{ !empty($settings['landing_hero_sub3_image']) ? (str_starts_with($settings['landing_hero_sub3_image'], 'http') ? $settings['landing_hero_sub3_image'] : asset($settings['landing_hero_sub3_image'])) : 'https://images.unsplash.com/photo-1526951521990-620dc14c214b?q=80&w=800&auto=format&fit=crop' }}"
                                     alt="Cuplikan 3">
                            </div>

                            <div class="space-y-2">
                                <div>
                                    <label class="block text-[10px] font-semibold text-slate-700 uppercase mb-0.5">Unggah Foto Baru</label>
                                    <input type="file" name="landing_hero_sub3_image_file" accept="image/*"
                                           onchange="previewHeroImage(this, 'preview-hero-sub3')"
                                           class="w-full text-[11px] text-slate-600 file:mr-2 file:py-1 file:px-2.5 file:rounded file:border-0 file:text-[10px] file:font-semibold file:bg-slate-100 file:text-slate-700 border border-slate-300 rounded p-1 cursor-pointer bg-white">
                                </div>
                                <div>
                                    <label class="block text-[10px] font-semibold text-slate-700 uppercase mb-0.5">Atau URL Gambar</label>
                                    <input type="text" name="landing_hero_sub3_image"
                                           oninput="previewHeroUrl(this.value, 'preview-hero-sub3')"
                                           value="{{ old('landing_hero_sub3_image', $settings['landing_hero_sub3_image'] ?? '') }}"
                                           placeholder="https://..." class="w-full py-1.5 px-2.5 text-xs rounded border border-slate-300 bg-white">
                                </div>
                                <div class="grid grid-cols-2 gap-2 pt-1">
                                    <div>
                                        <label class="block text-[10px] font-semibold text-slate-600 uppercase mb-0.5">Tag Badge</label>
                                        <input type="text" name="landing_hero_sub3_tag" value="{{ old('landing_hero_sub3_tag', $settings['landing_hero_sub3_tag'] ?? 'Bongkar & Gas') }}"
                                               class="w-full py-1.5 px-2 text-xs rounded border border-slate-300 bg-white">
                                    </div>
                                    <div>
                                        <label class="block text-[10px] font-semibold text-slate-600 uppercase mb-0.5">Judul</label>
                                        <input type="text" name="landing_hero_sub3_title" value="{{ old('landing_hero_sub3_title', $settings['landing_hero_sub3_title'] ?? 'Bongkar Gedung & Tabung Gas') }}"
                                               class="w-full py-1.5 px-2 text-xs rounded border border-slate-300 bg-white">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- About Settings -->
            <div class="bg-slate-50 p-5 sm:p-6 rounded-xl border border-slate-200 space-y-5">
                <div class="flex items-center justify-between border-b border-slate-200 pb-3">
                    <h4 class="text-xs font-bold uppercase tracking-wider text-emerald-800 flex items-center gap-2">
                        <i data-lucide="info" class="w-4 h-4"></i>
                        <span>Section Tentang Kami (Halaman Kedua)</span>
                    </h4>
                    <span class="text-[11px] font-semibold text-emerald-700 bg-emerald-100 px-2.5 py-0.5 rounded-full">
                        Foto & Profil Depo
                    </span>
                </div>

                <!-- Foto Depo Tentang Kami (Halaman Kedua) -->
                <div class="p-4 bg-white rounded-xl border border-slate-200 space-y-3">
                    <label class="block text-xs font-bold text-slate-800 uppercase">
                        Foto Depo / Operasional (Halaman Kedua)
                    </label>
                    <div style="display: flex; flex-wrap: wrap; gap: 1.25rem; align-items: start; width: 100%;">
                        <div style="flex: 1 1 280px; min-width: 240px; max-width: 360px;">
                            <div class="rounded-xl overflow-hidden border border-slate-200 bg-slate-900 shadow-sm" style="height: 200px;">
                                <img id="preview-about-image"
                                     src="{{ !empty($settings['landing_about_image']) ? (str_starts_with($settings['landing_about_image'], 'http') ? $settings['landing_about_image'] : asset($settings['landing_about_image'])) : asset('uploads/about/about_depo_seberaya.jpg') }}"
                                     alt="Foto Depo Tentang Kami"
                                     style="width: 100%; height: 100%; object-fit: cover;">
                            </div>
                            <span class="text-[10px] text-slate-400 mt-1 block">Foto ini tampil besar di halaman kedua (Tentang Usaha Kami) dengan badge tahun pengalaman.</span>
                        </div>
                        <div style="flex: 2 1 320px; min-width: 260px;" class="space-y-3">
                            <div>
                                <label class="block text-[11px] font-semibold text-slate-700 uppercase mb-1">Unggah Foto Baru (JPG, PNG, WEBP)</label>
                                <input type="file" name="landing_about_image_file" accept="image/*"
                                       onchange="previewHeroImage(this, 'preview-about-image')"
                                       class="w-full text-xs text-slate-600 file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 border border-slate-300 rounded-lg p-1 bg-slate-50 cursor-pointer">
                            </div>
                            <div>
                                <label class="block text-[11px] font-semibold text-slate-700 uppercase mb-1">Atau Gunakan Tautan URL Gambar Online</label>
                                <input type="text" name="landing_about_image"
                                       oninput="previewHeroUrl(this.value, 'preview-about-image')"
                                       value="{{ old('landing_about_image', $settings['landing_about_image'] ?? 'uploads/about/about_depo_seberaya.jpg') }}"
                                       placeholder="https://..." class="w-full py-2 px-3 text-xs rounded-lg border border-slate-300 bg-white">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="md:col-span-2">
                        <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Judul Section Tentang Kami</label>
                        <input type="text" name="landing_about_title" value="{{ old('landing_about_title', $settings['landing_about_title'] ?? 'Komitmen Menjaga Lingkungan dengan Nilai Ekonomi Maksimal') }}"
                               class="w-full py-2 px-3 text-xs font-bold rounded-lg border border-slate-300 bg-white">
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Deskripsi Lengkap Usaha</label>
                        <textarea name="landing_about_description" rows="4" class="w-full p-2.5 text-xs rounded-lg border border-slate-300 bg-white">{{ old('landing_about_description', $settings['landing_about_description'] ?? 'PT. Seberaya Akses Multi adalah perusahaan pengelolaan dan pengepul material daur ulang terintegrasi yang telah beroperasi selama lebih dari 3 tahun. Kami menjembatani industri manufaktur, perkantoran, bengkel, serta masyarakat dengan sistem timbangan digital bersertifikasi dan pembayaran kontan langsung di tempat.') }}</textarea>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Visi Usaha</label>
                        <textarea name="landing_about_vision" rows="3" class="w-full p-2.5 text-xs rounded-lg border border-slate-300 bg-white">{{ old('landing_about_vision', $settings['landing_about_vision'] ?? 'Menjadi rantai pasok material daur ulang terdepan, modern, dan paling terpercaya di Indonesia yang memberikan dampak ekonomi nyata bagi mitra sekaligus menjaga kelestarian lingkungan hidup.') }}</textarea>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Misi Usaha (Gunakan enter/baris baru)</label>
                        <textarea name="landing_about_mission" rows="3" class="w-full p-2.5 text-xs rounded-lg border border-slate-300 bg-white">{{ old('landing_about_mission', $settings['landing_about_mission'] ?? "1. Memberikan transparansi penimbangan digital presisi dan harga pasar terbaik setiap hari.\n2. Menyediakan layanan penjemputan armada cepat, bersih, dan profesional.\n3. Membangun ekosistem sirkular ekonomi berkelanjutan.") }}</textarea>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Tahun Pengalaman (Teks Badge)</label>
                        <input type="text" name="landing_about_years_experience" value="{{ old('landing_about_years_experience', $settings['landing_about_years_experience'] ?? '3+') }}"
                               placeholder="Contoh: 3+" class="w-full py-2 px-3 text-xs rounded-lg border border-slate-300 bg-white font-bold">
                    </div>
                </div>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="px-6 py-2.5 bg-emerald-600 hover:bg-emerald-500 text-white text-xs font-bold rounded-xl shadow-md transition flex items-center gap-2">
                    <i data-lucide="save" class="w-4 h-4"></i>
                    <span>Simpan Konten Hero & About</span>
                </button>
            </div>
        </form>
    </div>

    <!-- TAB: HERO STORY REEL -->
    <div x-show="activeTab === 'stories'" class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 sm:p-8 space-y-6">
        <!-- Feature Highlights Info Banner -->
        <div class="p-5 bg-gradient-to-r from-slate-900 to-emerald-950 rounded-2xl border border-slate-800 text-white flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div class="flex items-start sm:items-center gap-3.5">
                <div class="w-12 h-12 rounded-xl bg-gradient-to-tr from-amber-500 to-rose-500 text-white flex items-center justify-center shrink-0 shadow-lg">
                    <i data-lucide="play-circle" class="w-7 h-7"></i>
                </div>
                <div>
                    <h3 class="text-sm font-bold tracking-tight text-white flex items-center gap-2">
                        <span>Hero Story Reel Interaktif (Live Stories)</span>
                        <span class="px-2 py-0.5 rounded-full text-[10px] font-extrabold bg-amber-400 text-slate-950 uppercase tracking-wider">Fitur Unggulan</span>
                    </h3>
                    <p class="text-xs text-slate-300 mt-1 max-w-2xl leading-relaxed">
                        Foto-foto ini tampil sebagai <strong>Story Interaktif</strong> di slot foto utama Hero landing page. Foto terakhir yang Anda unggah otomatis menjadi yang <strong>terdepan (#1)</strong>. Pengunjung dapat menyukai (like), berkomentar per-foto (otomatis diterjemahkan ke Bahasa Indonesia), dan mengirim pertanyaan langsung ke WhatsApp.
                    </p>
                </div>
            </div>

            <!-- Modal Trigger: Upload Story Baru -->
            <div x-data="{ openStoryModal: false }" class="shrink-0">
                <button type="button" @click="openStoryModal = true" class="px-4 py-2.5 bg-emerald-500 hover:bg-emerald-400 text-slate-950 text-xs font-black rounded-xl transition flex items-center gap-2 shadow-lg">
                    <i data-lucide="upload-cloud" class="w-4 h-4"></i>
                    <span>+ Upload Foto Story Baru</span>
                </button>

                <!-- Upload Modal -->
                <div x-show="openStoryModal" class="fixed inset-0 z-50 overflow-y-auto flex items-center justify-center p-4 bg-slate-950/70 backdrop-blur-xs" style="display: none;">
                    <div @click.away="openStoryModal = false" class="bg-white rounded-2xl max-w-xl w-full p-6 sm:p-7 space-y-5 shadow-2xl text-slate-800">
                        <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                            <div class="flex items-center gap-2.5">
                                <span class="w-8 h-8 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center">
                                    <i data-lucide="image" class="w-4 h-4"></i>
                                </span>
                                <div>
                                    <h4 class="font-bold text-sm text-slate-900">Upload Foto Story Hero Baru</h4>
                                    <p class="text-[11px] text-slate-500">Foto baru akan otomatis berada di urutan pertama (paling depan)</p>
                                </div>
                            </div>
                            <button type="button" @click="openStoryModal = false" class="text-slate-400 hover:text-slate-600 p-1">
                                <i data-lucide="x" class="w-5 h-5"></i>
                            </button>
                        </div>

                        <form action="{{ route('landing-admin.stories.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                            @csrf
                            <div>
                                <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Judul Story / Aktivitas *</label>
                                <input type="text" name="title" required placeholder="Contoh: Bongkaran Konstruksi Besi WF & H-Beam" class="w-full p-2.5 text-xs border border-slate-300 rounded-xl focus:ring-2 focus:ring-emerald-500">
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                <div>
                                    <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Subjudul / Lokasi</label>
                                    <input type="text" name="subtitle" placeholder="Depo Srengseng Sawah • Jagakarsa" class="w-full p-2.5 text-xs border border-slate-300 rounded-xl">
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Tag Kategori Badge</label>
                                    <input type="text" name="tag" placeholder="Bongkaran Pabrik / Tembaga Super" class="w-full p-2.5 text-xs border border-slate-300 rounded-xl">
                                </div>
                            </div>

                            <div>
                                <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Pilih File Foto (JPG, PNG, WEBP maks 5MB)</label>
                                <input type="file" name="image_file" accept="image/*" class="w-full text-xs text-slate-600 file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 border border-slate-300 rounded-xl p-1.5 bg-slate-50 cursor-pointer">
                            </div>

                            <div>
                                <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Atau Gunakan Tautan URL Gambar Online</label>
                                <input type="url" name="image_url" placeholder="https://images.unsplash.com/photo-..." class="w-full p-2.5 text-xs border border-slate-300 rounded-xl">
                            </div>

                            <div>
                                <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Keterangan / Caption Singkat</label>
                                <textarea name="caption" rows="2" placeholder="Catatan atau informasi tambahan seputar aktivitas di foto ini..." class="w-full p-2.5 text-xs border border-slate-300 rounded-xl"></textarea>
                            </div>

                            <div class="flex items-center justify-end gap-2.5 pt-3 border-t border-slate-100">
                                <button type="button" @click="openStoryModal = false" class="px-4 py-2 border border-slate-300 rounded-xl text-xs font-semibold text-slate-600 hover:bg-slate-50">Batal</button>
                                <button type="submit" class="px-5 py-2 bg-emerald-600 hover:bg-emerald-500 text-white rounded-xl text-xs font-bold shadow-sm">Simpan & Terbitkan Story</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Daftar Story (Urutan Descending - Newest at Top) -->
        <div class="space-y-4">
            <div class="flex items-center justify-between">
                <h4 class="text-xs font-bold uppercase tracking-wider text-slate-700 flex items-center gap-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 animate-pulse"></span>
                    <span>Daftar Story Aktif ({{ $stories->count() }} Foto — Terakhir Upload Paling Depan)</span>
                </h4>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                @forelse($stories as $index => $story)
                    <div class="bg-white border rounded-2xl overflow-hidden shadow-xs hover:shadow-md transition flex flex-col justify-between {{ $index === 0 ? 'border-emerald-400 ring-2 ring-emerald-500/20' : 'border-slate-200' }}">
                        <div>
                            <!-- Header Foto with Badges -->
                            <div class="relative h-48 w-full bg-slate-900 overflow-hidden">
                                <img src="{{ $story->image_url }}" alt="{{ $story->title }}" class="w-full h-full object-cover">
                                <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-transparent to-black/30"></div>
                                
                                <div class="absolute top-3 left-3 flex items-center gap-2">
                                    @if($index === 0)
                                        <span class="px-2.5 py-1 rounded-full text-[10px] font-black bg-emerald-500 text-slate-950 uppercase tracking-wider shadow-sm flex items-center gap-1">
                                            <i data-lucide="star" class="w-3 h-3 fill-slate-950"></i> #1 Slide Terdepan
                                        </span>
                                    @else
                                        <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-slate-900/80 text-white backdrop-blur-sm border border-white/20">
                                            Slide #{{ $index + 1 }}
                                        </span>
                                    @endif

                                    @if($story->tag)
                                        <span class="px-2 py-0.5 rounded-full text-[10px] font-semibold bg-white/90 text-slate-800 backdrop-blur-sm">
                                            {{ $story->tag }}
                                        </span>
                                    @endif
                                </div>

                                <div class="absolute top-3 right-3 flex items-center gap-1.5">
                                    <form action="{{ route('landing-admin.stories.destroy', $story->id) }}" method="POST" onsubmit="return confirm('Hapus foto story ini beserta seluruh komentarnya?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-1.5 rounded-lg bg-rose-600/90 hover:bg-rose-600 text-white text-xs shadow-sm transition" title="Hapus Story">
                                            <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                                        </button>
                                    </form>
                                </div>

                                <div class="absolute bottom-3 left-3 right-3 text-white">
                                    <span class="text-[10px] text-amber-300 font-semibold block">{{ $story->subtitle }}</span>
                                    <h5 class="text-xs sm:text-sm font-bold leading-snug truncate">{{ $story->title }}</h5>
                                </div>
                            </div>

                            <!-- Content Info -->
                            <div class="p-4 space-y-3">
                                @if($story->caption)
                                    <p class="text-xs text-slate-600 line-clamp-2">{{ $story->caption }}</p>
                                @endif

                                <div class="flex items-center justify-between text-xs pt-1 border-t border-slate-100 text-slate-500">
                                    <div class="flex items-center gap-3">
                                        <span class="flex items-center gap-1 font-semibold text-rose-500">
                                            <i data-lucide="heart" class="w-3.5 h-3.5 fill-rose-500"></i> {{ $story->likes_count }} Suka
                                        </span>
                                        <span class="flex items-center gap-1 font-semibold text-sky-600">
                                            <i data-lucide="message-circle" class="w-3.5 h-3.5"></i> {{ $story->comments_count }} Komentar
                                        </span>
                                    </div>
                                    <span class="text-[11px] text-slate-400">{{ $story->created_at ? $story->created_at->diffForHumans() : '' }}</span>
                                </div>

                                <!-- Comments Accordion / Dropdown -->
                                <div x-data="{ showComments: false }" class="pt-1">
                                    <button type="button" @click="showComments = !showComments" class="w-full py-1.5 px-3 bg-slate-50 hover:bg-slate-100 text-slate-700 text-xs font-semibold rounded-lg flex items-center justify-between transition border border-slate-200">
                                        <span class="flex items-center gap-1.5">
                                            <i data-lucide="messages-square" class="w-3.5 h-3.5 text-slate-500"></i>
                                            <span>Lihat Komentar ({{ $story->comments->count() }})</span>
                                        </span>
                                        <i data-lucide="chevron-down" class="w-3.5 h-3.5 transition-transform" :class="showComments ? 'rotate-180' : ''"></i>
                                    </button>

                                    <div x-show="showComments" class="mt-2.5 space-y-2 max-h-56 overflow-y-auto pr-1" style="display: none;">
                                        @forelse($story->comments as $cmt)
                                            <div class="p-2.5 rounded-lg bg-slate-50 border border-slate-200 text-xs space-y-1">
                                                <div class="flex items-center justify-between">
                                                    <span class="font-bold text-slate-800">{{ $cmt->user_name }}</span>
                                                    <div class="flex items-center gap-2">
                                                        <span class="text-[10px] text-slate-400">{{ $cmt->created_at ? $cmt->created_at->diffForHumans() : '' }}</span>
                                                        <form action="{{ route('landing-admin.stories.comments.destroy', $cmt->id) }}" method="POST" onsubmit="return confirm('Hapus komentar ini?')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="text-rose-500 hover:text-rose-700" title="Hapus Komentar">
                                                                <i data-lucide="x" class="w-3 h-3"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                                
                                                <!-- Komentar Bahasa Indonesia -->
                                                <p class="text-slate-700 font-medium">{{ $cmt->comment }}</p>

                                                <!-- Info Terjemahan Otomatis jika bahasa asing -->
                                                @if($cmt->is_translated && $cmt->original_comment)
                                                    <div class="pt-1 text-[10px] text-emerald-700 bg-emerald-50 px-2 py-1 rounded flex items-center gap-1.5 border border-emerald-100">
                                                        <i data-lucide="languages" class="w-3 h-3 shrink-0"></i>
                                                        <span class="truncate">Diterjemahkan dari ({{ strtoupper($cmt->detected_language ?: 'ASING') }}): "<em>{{ $cmt->original_comment }}</em>"</span>
                                                    </div>
                                                @endif
                                            </div>
                                        @empty
                                            <p class="text-[11px] text-slate-400 text-center py-2 italic">Belum ada komentar pada foto story ini.</p>
                                        @endforelse
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full py-12 text-center text-slate-400">
                        <i data-lucide="image-off" class="w-10 h-10 mx-auto text-slate-300 mb-2"></i>
                        <p class="text-sm font-semibold">Belum ada foto story yang diunggah</p>
                        <p class="text-xs text-slate-400 mt-1">Klik tombol "+ Upload Foto Story Baru" di atas untuk menambahkan foto pertama.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- TAB 3: LAYANAN (SERVICES) -->
    <div x-show="activeTab === 'services'" class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 sm:p-8 space-y-6">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-slate-200 pb-4">
            <div>
                <h3 class="text-base font-bold text-slate-900">Kelola Layanan Usaha Rongsok & Daur Ulang</h3>
                <p class="text-xs text-slate-500 mt-1">Layanan yang ditawarkan akan ditampilkan dalam bentuk card interaktif di landing page</p>
            </div>

            <!-- Modal Trigger: Add Service -->
            <div x-data="{ open: false }">
                <button type="button" @click="open = true" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-500 text-white text-xs font-bold rounded-xl transition flex items-center gap-2 shadow-sm">
                    <i data-lucide="plus" class="w-4 h-4"></i>
                    <span>Tambah Layanan Baru</span>
                </button>

                <!-- Modal Dialog -->
                <div x-show="open" class="fixed inset-0 z-50 overflow-y-auto flex items-center justify-center p-4 bg-slate-900/60" style="display: none;">
                    <div @click.away="open = false" class="bg-white rounded-2xl max-w-lg w-full p-6 space-y-4 shadow-xl">
                        <div class="flex items-center justify-between border-b pb-3">
                            <h4 class="font-bold text-sm text-slate-900">Tambah Layanan Baru</h4>
                            <button @click="open = false" class="text-slate-400 hover:text-slate-600"><i data-lucide="x" class="w-4 h-4"></i></button>
                        </div>
                        <form action="{{ route('landing-admin.services.store') }}" method="POST" class="space-y-4">
                            @csrf
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Nama Layanan *</label>
                                <input type="text" name="title" required placeholder="Contoh: Pembelian Besi Tua & Logam" class="w-full p-2 text-xs border rounded-lg">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Nama Ikon Lucide *</label>
                                <select name="icon" class="w-full p-2 text-xs border rounded-lg">
                                    <option value="Recycle">Recycle</option>
                                    <option value="ShieldCheck">ShieldCheck</option>
                                    <option value="Coins">Coins</option>
                                    <option value="PackageCheck">PackageCheck</option>
                                    <option value="BatteryCharging">BatteryCharging</option>
                                    <option value="Truck">Truck</option>
                                    <option value="Scale">Scale</option>
                                    <option value="Factory">Factory</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Deskripsi Singkat *</label>
                                <textarea name="short_description" rows="3" required placeholder="Ringkasan layanan untuk kartu di website..." class="w-full p-2 text-xs border rounded-lg"></textarea>
                            </div>
                            <div class="flex items-center gap-2">
                                <input type="checkbox" name="is_active" value="1" checked id="srv_active" class="rounded text-emerald-600">
                                <label for="srv_active" class="text-xs text-slate-700 font-medium">Tampilkan di website (Aktif)</label>
                            </div>
                            <div class="flex justify-end gap-2 pt-2">
                                <button type="button" @click="open = false" class="px-4 py-2 border rounded-xl text-xs font-semibold text-slate-600 hover:bg-slate-50">Batal</button>
                                <button type="submit" class="px-4 py-2 bg-emerald-600 text-white rounded-xl text-xs font-bold hover:bg-emerald-500">Simpan Layanan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($services as $srv)
                <div class="p-4 rounded-xl border border-slate-200 bg-slate-50 hover:bg-white transition flex flex-col justify-between space-y-3">
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-emerald-100 text-emerald-800 text-[11px] font-bold">
                                <i data-lucide="tag" class="w-3 h-3"></i>
                                {{ $srv->icon }}
                            </span>
                            <span class="text-[10px] text-slate-400 font-mono">Urutan: #{{ $srv->order }}</span>
                        </div>
                        <h4 class="font-bold text-sm text-slate-900">{{ $srv->title }}</h4>
                        <p class="text-xs text-slate-600 mt-1 line-clamp-3">{{ $srv->short_description }}</p>
                    </div>

                    <div class="pt-2 border-t border-slate-200 flex items-center justify-between">
                        <span class="text-[11px] {{ $srv->is_active ? 'text-emerald-600' : 'text-slate-400' }} font-semibold flex items-center gap-1">
                            <i data-lucide="{{ $srv->is_active ? 'check' : 'eye-off' }}" class="w-3.5 h-3.5"></i>
                            {{ $srv->is_active ? 'Aktif' : 'Nonaktif' }}
                        </span>

                        <form action="{{ route('landing-admin.services.destroy', $srv->id) }}" method="POST" onsubmit="return confirm('Hapus layanan ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-rose-500 hover:text-rose-700 text-xs font-semibold flex items-center gap-1">
                                <i data-lucide="trash-2" class="w-3.5 h-3.5"></i> Hapus
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- TAB 4: GALERI FOTO -->
    <div x-show="activeTab === 'gallery'" class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 sm:p-8 space-y-6">
        <!-- Quick Switch Tip Banner -->
        <div class="p-4 bg-emerald-50 border border-emerald-200 rounded-xl flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl bg-gradient-to-tr from-amber-500 to-rose-500 text-white flex items-center justify-center shrink-0 shadow-sm">
                    <i data-lucide="play-circle" class="w-4 h-4"></i>
                </div>
                <div>
                    <span class="text-xs font-bold text-emerald-950 block">Mencari Foto Story Hero Halaman Utama?</span>
                    <span class="text-[11px] text-emerald-700">Foto Story tak terbatas dengan Like, Komentar Otomatis Bahasa Indonesia, dan Tanya WhatsApp diatur di tab Hero Story Reel.</span>
                </div>
            </div>
            <button type="button" @click="activeTab = 'stories'; history.replaceState(null, '', '?tab=stories')" class="px-3.5 py-1.5 bg-emerald-600 hover:bg-emerald-500 text-white text-xs font-bold rounded-lg transition shrink-0 flex items-center gap-1.5 shadow-sm">
                <span>Buka Hero Story Reel</span>
                <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
            </button>
        </div>

        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-slate-200 pb-4">
            <div>
                <h3 class="text-base font-bold text-slate-900">Galeri Foto & Dokumentasi Operasional</h3>
                <p class="text-xs text-slate-500 mt-1">Upload foto gudang, proses penimbangan, armada truk, dan aktivitas depo rongsok</p>
            </div>

            <!-- Upload Photo Modal Trigger -->
            <div x-data="{ open: false }">
                <button type="button" @click="open = true" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-500 text-white text-xs font-bold rounded-xl transition flex items-center gap-2 shadow-sm">
                    <i data-lucide="upload" class="w-4 h-4"></i>
                    <span>Tambah Foto Galeri</span>
                </button>

                <div x-show="open" class="fixed inset-0 z-50 overflow-y-auto flex items-center justify-center p-4 bg-slate-900/60" style="display: none;">
                    <div @click.away="open = false" class="bg-white rounded-2xl max-w-lg w-full p-6 space-y-4 shadow-xl">
                        <div class="flex items-center justify-between border-b pb-3">
                            <h4 class="font-bold text-sm text-slate-900">Upload Foto Galeri</h4>
                            <button @click="open = false" class="text-slate-400 hover:text-slate-600"><i data-lucide="x" class="w-4 h-4"></i></button>
                        </div>
                        <form action="{{ route('landing-admin.gallery.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                            @csrf
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Judul Foto *</label>
                                <input type="text" name="title" required placeholder="Contoh: Proses Penimbangan Besi Tua" class="w-full p-2 text-xs border rounded-lg">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Kategori *</label>
                                <select name="category" class="w-full p-2 text-xs border rounded-lg">
                                    <option value="Gudang">Gudang & Sortir</option>
                                    <option value="Penimbangan">Penimbangan Digital</option>
                                    <option value="Armada">Armada Angkut</option>
                                    <option value="Daur Ulang">Daur Ulang & Baling</option>
                                    <option value="Operasional">Operasional Harian</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Upload File Foto</label>
                                <input type="file" name="image_file" accept="image/*" class="w-full text-xs border rounded-lg p-1.5">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Atau Gunakan Tautan URL Foto</label>
                                <input type="url" name="image_url" placeholder="https://..." class="w-full p-2 text-xs border rounded-lg">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Keterangan / Caption</label>
                                <textarea name="caption" rows="2" placeholder="Catatan singkat foto..." class="w-full p-2 text-xs border rounded-lg"></textarea>
                            </div>
                            <div class="flex justify-end gap-2 pt-2">
                                <button type="button" @click="open = false" class="px-4 py-2 border rounded-xl text-xs font-semibold text-slate-600 hover:bg-slate-50">Batal</button>
                                <button type="submit" class="px-4 py-2 bg-emerald-600 text-white rounded-xl text-xs font-bold hover:bg-emerald-500">Upload & Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            @foreach($galleries as $gal)
                <div class="group relative rounded-xl border border-slate-200 overflow-hidden bg-slate-900 shadow-sm">
                    <img src="{{ $gal->image_url }}" alt="{{ $gal->title }}" class="w-full h-44 object-cover group-hover:scale-105 transition duration-300">
                    <div class="p-3 bg-white space-y-1">
                        <div class="flex items-center justify-between">
                            <span class="text-[10px] font-bold uppercase tracking-wider text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded">{{ $gal->category }}</span>
                            <form action="{{ route('landing-admin.gallery.destroy', $gal->id) }}" method="POST" onsubmit="return confirm('Hapus foto ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-rose-500 hover:text-rose-700 text-xs p-1"><i data-lucide="trash-2" class="w-4 h-4"></i></button>
                            </form>
                        </div>
                        <h5 class="text-xs font-bold text-slate-900 truncate">{{ $gal->title }}</h5>
                        <p class="text-[11px] text-slate-500 truncate">{{ $gal->caption }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- TAB 5: TESTIMONI -->
    <div x-show="activeTab === 'testimonials'" class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 sm:p-8 space-y-6">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-slate-200 pb-4">
            <div>
                <h3 class="text-base font-bold text-slate-900">Kelola Testimoni & Ulasan Pelanggan</h3>
                <p class="text-xs text-slate-500 mt-1">Ulasan positif dari pabrik, mitra pengepul, bengkel, dan masyarakat umum</p>
            </div>

            <!-- Add Testimonial Trigger -->
            <div x-data="{ open: false }">
                <button type="button" @click="open = true" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-500 text-white text-xs font-bold rounded-xl transition flex items-center gap-2 shadow-sm">
                    <i data-lucide="plus" class="w-4 h-4"></i>
                    <span>Tambah Testimoni</span>
                </button>

                <div x-show="open" class="fixed inset-0 z-50 overflow-y-auto flex items-center justify-center p-4 bg-slate-900/60" style="display: none;">
                    <div @click.away="open = false" class="bg-white rounded-2xl max-w-lg w-full p-6 space-y-4 shadow-xl">
                        <div class="flex items-center justify-between border-b pb-3">
                            <h4 class="font-bold text-sm text-slate-900">Tambah Ulasan Baru</h4>
                            <button @click="open = false" class="text-slate-400 hover:text-slate-600"><i data-lucide="x" class="w-4 h-4"></i></button>
                        </div>
                        <form action="{{ route('landing-admin.testimonials.store') }}" method="POST" class="space-y-4">
                            @csrf
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Nama Klien / Pelanggan *</label>
                                <input type="text" name="client_name" required placeholder="Bpk. Hendra Wijaya" class="w-full p-2 text-xs border rounded-lg">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Peran / Instansi *</label>
                                <input type="text" name="client_role" required placeholder="Manajer Pergudangan PT. Jaya Logam" class="w-full p-2 text-xs border rounded-lg">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Rating Bintang (1 - 5) *</label>
                                <select name="rating" class="w-full p-2 text-xs border rounded-lg">
                                    <option value="5">⭐⭐⭐⭐⭐ (5 Bintang - Sangat Puas)</option>
                                    <option value="4">⭐⭐⭐⭐ (4 Bintang - Puas)</option>
                                    <option value="3">⭐⭐⭐ (3 Bintang - Cukup)</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Isi Testimoni *</label>
                                <textarea name="content" rows="3" required placeholder="Pengalaman bertransaksi dan kepuasan pelayanan timbangan..." class="w-full p-2 text-xs border rounded-lg"></textarea>
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">URL Avatar / Foto (Opsional)</label>
                                <input type="url" name="avatar_url" placeholder="https://..." class="w-full p-2 text-xs border rounded-lg">
                            </div>
                            <div class="flex justify-end gap-2 pt-2">
                                <button type="button" @click="open = false" class="px-4 py-2 border rounded-xl text-xs font-semibold text-slate-600 hover:bg-slate-50">Batal</button>
                                <button type="submit" class="px-4 py-2 bg-emerald-600 text-white rounded-xl text-xs font-bold hover:bg-emerald-500">Simpan Testimoni</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @foreach($testimonials as $t)
                <div class="p-4 rounded-xl border border-slate-200 bg-slate-50 flex flex-col justify-between space-y-3">
                    <div>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                @if($t->avatar_url)
                                    <img src="{{ $t->avatar_url }}" alt="{{ $t->client_name }}" class="w-8 h-8 rounded-full object-cover">
                                @else
                                    <div class="w-8 h-8 rounded-full bg-emerald-600 text-white font-bold text-xs flex items-center justify-center">
                                        {{ substr($t->client_name, 0, 1) }}
                                    </div>
                                @endif
                                <div>
                                    <h5 class="text-xs font-bold text-slate-900">{{ $t->client_name }}</h5>
                                    <p class="text-[10px] text-slate-500">{{ $t->client_role }}</p>
                                </div>
                            </div>
                            <div class="text-amber-400 text-xs">
                                @for($i = 0; $i < $t->rating; $i++) ★ @endfor
                            </div>
                        </div>
                        <p class="text-xs text-slate-600 italic mt-3">"{{ $t->content }}"</p>
                    </div>

                    <div class="pt-2 border-t border-slate-200 flex justify-end">
                        <form action="{{ route('landing-admin.testimonials.destroy', $t->id) }}" method="POST" onsubmit="return confirm('Hapus ulasan ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-rose-500 hover:text-rose-700 text-xs flex items-center gap-1 font-semibold">
                                <i data-lucide="trash-2" class="w-3.5 h-3.5"></i> Hapus
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- TAB 6: FAQ -->
    <div x-show="activeTab === 'faqs'" class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 sm:p-8 space-y-6">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-slate-200 pb-4">
            <div>
                <h3 class="text-base font-bold text-slate-900">Kelola Pertanyaan Populer (FAQ)</h3>
                <p class="text-xs text-slate-500 mt-1">Daftar tanya jawab umum seputar penjemputan rongsok, akurasi timbangan, dan sistem pembayaran</p>
            </div>

            <!-- Add FAQ Trigger -->
            <div x-data="{ open: false }">
                <button type="button" @click="open = true" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-500 text-white text-xs font-bold rounded-xl transition flex items-center gap-2 shadow-sm">
                    <i data-lucide="plus" class="w-4 h-4"></i>
                    <span>Tambah Pertanyaan FAQ</span>
                </button>

                <div x-show="open" class="fixed inset-0 z-50 overflow-y-auto flex items-center justify-center p-4 bg-slate-900/60" style="display: none;">
                    <div @click.away="open = false" class="bg-white rounded-2xl max-w-lg w-full p-6 space-y-4 shadow-xl">
                        <div class="flex items-center justify-between border-b pb-3">
                            <h4 class="font-bold text-sm text-slate-900">Tambah Tanya Jawab</h4>
                            <button @click="open = false" class="text-slate-400 hover:text-slate-600"><i data-lucide="x" class="w-4 h-4"></i></button>
                        </div>
                        <form action="{{ route('landing-admin.faqs.store') }}" method="POST" class="space-y-4">
                            @csrf
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Pertanyaan *</label>
                                <input type="text" name="question" required placeholder="Contoh: Apakah melayani jemput ke rumah/pabrik?" class="w-full p-2 text-xs border rounded-lg">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Jawaban Lengkap *</label>
                                <textarea name="answer" rows="4" required placeholder="Jelaskan secara ramah, jelas, dan meyakinkan..." class="w-full p-2 text-xs border rounded-lg"></textarea>
                            </div>
                            <div class="flex justify-end gap-2 pt-2">
                                <button type="button" @click="open = false" class="px-4 py-2 border rounded-xl text-xs font-semibold text-slate-600 hover:bg-slate-50">Batal</button>
                                <button type="submit" class="px-4 py-2 bg-emerald-600 text-white rounded-xl text-xs font-bold hover:bg-emerald-500">Simpan FAQ</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="space-y-3">
            @foreach($faqs as $f)
                <div class="p-4 rounded-xl border border-slate-200 bg-slate-50 space-y-2">
                    <div class="flex items-start justify-between gap-3">
                        <h5 class="text-xs font-bold text-slate-900 flex items-center gap-2">
                            <i data-lucide="help-circle" class="w-4 h-4 text-emerald-600 shrink-0"></i>
                            <span>{{ $f->question }}</span>
                        </h5>
                        <form action="{{ route('landing-admin.faqs.destroy', $f->id) }}" method="POST" onsubmit="return confirm('Hapus pertanyaan ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-rose-500 hover:text-rose-700 text-xs p-1"><i data-lucide="trash-2" class="w-4 h-4"></i></button>
                        </form>
                    </div>
                    <p class="text-xs text-slate-600 pl-6">{{ $f->answer }}</p>
                </div>
            @endforeach
        </div>
    </div>

    <!-- TAB 7: STATISTIK COUNTER -->
    <div x-show="activeTab === 'statistics'" class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 sm:p-8 space-y-6">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-slate-200 pb-4">
            <div>
                <h3 class="text-base font-bold text-slate-900">Kelola Angka Pencapaian Usaha (Statistics Counter)</h3>
                <p class="text-xs text-slate-500 mt-1">Angka statistik ini beranimasi naik saat pengunjung menggulir ke section statistik</p>
            </div>

            <!-- Add Stat Trigger -->
            <div x-data="{ open: false }">
                <button type="button" @click="open = true" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-500 text-white text-xs font-bold rounded-xl transition flex items-center gap-2 shadow-sm">
                    <i data-lucide="plus" class="w-4 h-4"></i>
                    <span>Tambah Statistik</span>
                </button>

                <div x-show="open" class="fixed inset-0 z-50 overflow-y-auto flex items-center justify-center p-4 bg-slate-900/60" style="display: none;">
                    <div @click.away="open = false" class="bg-white rounded-2xl max-w-lg w-full p-6 space-y-4 shadow-xl">
                        <div class="flex items-center justify-between border-b pb-3">
                            <h4 class="font-bold text-sm text-slate-900">Tambah Angka Statistik</h4>
                            <button @click="open = false" class="text-slate-400 hover:text-slate-600"><i data-lucide="x" class="w-4 h-4"></i></button>
                        </div>
                        <form action="{{ route('landing-admin.statistics.store') }}" method="POST" class="space-y-4">
                            @csrf
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Label / Keterangan *</label>
                                <input type="text" name="label" required placeholder="Contoh: Ton Daur Ulang / Bulan" class="w-full p-2 text-xs border rounded-lg">
                            </div>
                            <div class="grid grid-cols-2 gap-2">
                                <div>
                                    <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Nilai Angka *</label>
                                    <input type="text" name="value" required placeholder="5000" class="w-full p-2 text-xs border rounded-lg font-bold">
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Akhiran (Suffix)</label>
                                    <input type="text" name="suffix" placeholder="+ atau %" class="w-full p-2 text-xs border rounded-lg font-bold">
                                </div>
                            </div>
                            <div class="flex justify-end gap-2 pt-2">
                                <button type="button" @click="open = false" class="px-4 py-2 border rounded-xl text-xs font-semibold text-slate-600 hover:bg-slate-50">Batal</button>
                                <button type="submit" class="px-4 py-2 bg-emerald-600 text-white rounded-xl text-xs font-bold hover:bg-emerald-500">Simpan Statistik</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
            @foreach($statistics as $stat)
                <div class="p-5 rounded-xl border border-slate-200 bg-slate-50 text-center relative group">
                    <form action="{{ route('landing-admin.statistics.destroy', $stat->id) }}" method="POST" onsubmit="return confirm('Hapus statistik ini?')" class="absolute top-2 right-2 opacity-0 group-hover:opacity-100 transition">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-rose-500 hover:text-rose-700 text-xs p-1"><i data-lucide="trash-2" class="w-3.5 h-3.5"></i></button>
                    </form>
                    <div class="text-2xl sm:text-3xl font-black text-emerald-600 font-mono">
                        {{ $stat->prefix }}{{ $stat->value }}{{ $stat->suffix }}
                    </div>
                    <div class="text-xs font-semibold text-slate-700 mt-1">{{ $stat->label }}</div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- TAB 8: KOTAK MASUK PENAWARAN (INQUIRIES) -->
    <div x-show="activeTab === 'inquiries'" class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 sm:p-8 space-y-6">
        <div class="border-b border-slate-200 pb-4">
            <h3 class="text-base font-bold text-slate-900">Kotak Masuk Permintaan Penjemputan & Penawaran Rongsok</h3>
            <p class="text-xs text-slate-500 mt-1">Daftar calon pelanggan atau pabrik yang mengirim pesan formulir penjemputan dari website</p>
        </div>

        @if($inquiries->isEmpty())
            <div class="py-12 text-center text-slate-400 space-y-2">
                <i data-lucide="inbox" class="w-12 h-12 mx-auto text-slate-300"></i>
                <p class="text-xs">Belum ada pesan penawaran masuk dari website.</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-xs text-left">
                    <thead class="bg-slate-50 text-slate-700 uppercase font-bold text-[10px] border-b">
                        <tr>
                            <th class="p-3">Tanggal</th>
                            <th class="p-3">Nama Pengirim</th>
                            <th class="p-3">WhatsApp / Telp</th>
                            <th class="p-3">Jenis Rongsok</th>
                            <th class="p-3">Est. Berat</th>
                            <th class="p-3">Alamat / Lokasi</th>
                            <th class="p-3">Aksi Kontak</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($inquiries as $inq)
                            <tr class="hover:bg-slate-50">
                                <td class="p-3 text-slate-500">{{ $inq->created_at->format('d/m/Y H:i') }}</td>
                                <td class="p-3 font-bold text-slate-900">{{ $inq->name }}</td>
                                <td class="p-3 font-mono font-semibold text-emerald-700">{{ $inq->phone }}</td>
                                <td class="p-3">{{ $inq->material_type ?? '-' }}</td>
                                <td class="p-3 font-semibold">{{ $inq->estimated_weight ?? '-' }}</td>
                                <td class="p-3 max-w-xs truncate" title="{{ $inq->address }}">{{ $inq->address ?? '-' }}</td>
                                <td class="p-3">
                                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $inq->phone) }}?text=Halo%20{{ rawurlencode($inq->name) }}%2C%20kami%20dari%20Depo%20Berkah%20Rongsok%20menanggapi%20permintaan%20penjemputan%20rongsok%20Anda." target="_blank" class="inline-flex items-center gap-1 px-2.5 py-1 bg-emerald-600 hover:bg-emerald-500 text-white font-semibold rounded-lg text-[10px]">
                                        <i data-lucide="message-circle" class="w-3 h-3"></i> Chat WA
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

    <!-- TAB 10: CLOUD SYNC HOSTING CPANEL -->
    <div x-show="activeTab === 'cloud-sync'" class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 sm:p-8 space-y-6">
        <!-- Top Hero Banner -->
        <div class="p-6 bg-gradient-to-r from-slate-900 via-indigo-950 to-slate-900 rounded-2xl border border-indigo-900 text-white flex flex-col md:flex-row md:items-center justify-between gap-5">
            <div class="flex items-start sm:items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-indigo-500/20 text-indigo-400 border border-indigo-500/30 flex items-center justify-center shrink-0 shadow-lg">
                    <i data-lucide="cloud-lightning" class="w-7 h-7"></i>
                </div>
                <div>
                    <div class="flex items-center gap-2">
                        <h3 class="text-base font-black tracking-tight text-white">Sinkronisasi Otomatis ke Hosting cPanel</h3>
                        @if($syncConfig['enabled'])
                            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black bg-emerald-500 text-slate-950 uppercase tracking-wider">
                                Aktif (Online Sync)
                            </span>
                        @else
                            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-amber-400 text-slate-950 uppercase tracking-wider">
                                Nonaktif (Hanya Lokal)
                            </span>
                        @endif
                    </div>
                    <p class="text-xs text-slate-300 mt-1 max-w-2xl leading-relaxed">
                        Input data kasir, master barang, harga rongsok harian, dan story dilakukan dari <strong>komputer lokal depo</strong>. Saat Anda submit atau update harga, sistem secara otomatis mengirimkan dan memperbarui data ke <strong>database hosting cPanel</strong> agar website landing page online selalu menampilkan harga dan foto terbaru!
                    </p>
                </div>
            </div>

            <!-- Full Sync Button -->
            <form action="{{ route('landing-admin.sync.now') }}" method="POST" class="shrink-0" onsubmit="return confirm('Mulai proses sinkronisasi penuh (Full Sync) ke hosting cPanel sekarang?')">
                @csrf
                <button type="submit" class="px-5 py-3 bg-gradient-to-r from-indigo-500 to-sky-500 hover:from-indigo-400 hover:to-sky-400 text-white text-xs font-black rounded-xl transition flex items-center gap-2 shadow-lg shadow-indigo-500/20 hover:scale-105 active:scale-95">
                    <i data-lucide="refresh-cw" class="w-4 h-4"></i>
                    <span>Sinkronkan Sekarang (Full Sync)</span>
                </button>
            </form>
        </div>

        <!-- Sync Status Dashboard Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <!-- Card 1: Status Koneksi -->
            <div class="p-4 rounded-xl border border-slate-200 bg-slate-50 space-y-1">
                <span class="text-[11px] font-bold uppercase tracking-wider text-slate-500">Status Sinkronisasi</span>
                <div class="flex items-center gap-2">
                    @if($syncConfig['last_status'] === 'success')
                        <span class="w-3 h-3 rounded-full bg-emerald-500 animate-pulse"></span>
                        <span class="text-sm font-black text-emerald-700">Berhasil Sinkron</span>
                    @elseif($syncConfig['last_status'] === 'failed')
                        <span class="w-3 h-3 rounded-full bg-rose-500"></span>
                        <span class="text-sm font-black text-rose-600">Gagal Terhubung</span>
                    @else
                        <span class="w-3 h-3 rounded-full bg-slate-400"></span>
                        <span class="text-sm font-bold text-slate-600">Belum Sinkron</span>
                    @endif
                </div>
                <p class="text-[11px] text-slate-500 truncate" title="{{ $syncConfig['last_message'] }}">
                    {{ $syncConfig['last_message'] }}
                </p>
            </div>

            <!-- Card 2: Terakhir Sinkron -->
            <div class="p-4 rounded-xl border border-slate-200 bg-slate-50 space-y-1">
                <span class="text-[11px] font-bold uppercase tracking-wider text-slate-500">Waktu Terakhir Sync</span>
                <div class="text-sm font-black text-slate-900">
                    {{ $syncConfig['last_synced_at'] ? \Carbon\Carbon::parse($syncConfig['last_synced_at'])->diffForHumans() : 'Belum pernah' }}
                </div>
                <span class="text-[10px] text-slate-400 font-mono">
                    {{ $syncConfig['last_synced_at'] ?: '-' }}
                </span>
            </div>

            <!-- Card 3: Master Barang & Harga -->
            <div class="p-4 rounded-xl border border-slate-200 bg-slate-50 space-y-1">
                <span class="text-[11px] font-bold uppercase tracking-wider text-slate-500">Master Barang & Harga</span>
                <div class="text-sm font-black text-slate-900 flex items-center gap-1.5">
                    <i data-lucide="package" class="w-4 h-4 text-emerald-600"></i>
                    <span>{{ $syncCounts['items'] ?? 0 }} Barang</span>
                </div>
                <span class="text-[11px] text-slate-500">{{ $syncCounts['categories'] ?? 0 }} Kategori Logam & Rongsok</span>
            </div>

            <!-- Card 4: Story & Media -->
            <div class="p-4 rounded-xl border border-slate-200 bg-slate-50 space-y-1">
                <span class="text-[11px] font-bold uppercase tracking-wider text-slate-500">Story & Konten Landing</span>
                <div class="text-sm font-black text-slate-900 flex items-center gap-1.5">
                    <i data-lucide="play-circle" class="w-4 h-4 text-amber-500"></i>
                    <span>{{ $syncCounts['stories'] ?? 0 }} Story Foto Reel</span>
                </div>
                <span class="text-[11px] text-slate-500">{{ $syncCounts['services'] ?? 0 }} Layanan, {{ $syncCounts['galleries'] ?? 0 }} Galeri</span>
            </div>
        </div>

        <!-- Configuration Form & Test Connection -->
        <div class="p-6 bg-white rounded-2xl border border-slate-200 shadow-xs space-y-5" x-data="{
            testingConnection: false,
            testResult: null,
            targetUrl: '{{ old('cloud_sync_url', $syncConfig['url']) }}',
            targetSecret: '{{ old('cloud_sync_secret_key', $syncConfig['secret_key']) }}',
            generateSecret() {
                const chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
                let res = 'sync_';
                for (let i = 0; i < 32; i++) {
                    res += chars.charAt(Math.floor(Math.random() * chars.length));
                }
                this.targetSecret = res;
            },
            async runTest() {
                if (!this.targetUrl) {
                    alert('Silakan masukkan URL hosting cPanel terlebih dahulu.');
                    return;
                }
                this.testingConnection = true;
                this.testResult = null;
                try {
                    const res = await fetch('{{ route('landing-admin.sync.test') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            url: this.targetUrl,
                            secret_key: this.targetSecret
                        })
                    });
                    const json = await res.json();
                    this.testResult = json;
                } catch (e) {
                    this.testResult = { success: false, message: 'Gagal melakukan tes: ' + e.message };
                } finally {
                    this.testingConnection = false;
                }
            }
        }">
            <div class="border-b border-slate-100 pb-3 flex items-center justify-between">
                <div>
                    <h4 class="font-bold text-sm text-slate-900 flex items-center gap-2">
                        <i data-lucide="sliders" class="w-4 h-4 text-indigo-600"></i>
                        <span>Pengaturan Parameter Sinkronisasi</span>
                    </h4>
                    <p class="text-xs text-slate-500 mt-0.5">Konfigurasi alamat server cPanel hosting Anda dan token rahasia untuk otorisasi sinkronisasi data.</p>
                </div>
            </div>

            <form action="{{ route('landing-admin.sync.config') }}" method="POST" class="space-y-4">
                @csrf

                <!-- Switches -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 p-4 rounded-xl bg-slate-50 border border-slate-200">
                    <label class="flex items-start gap-3 cursor-pointer">
                        <input type="checkbox" name="cloud_sync_enabled" value="1" {{ $syncConfig['enabled'] ? 'checked' : '' }} class="mt-0.5 rounded border-slate-300 text-indigo-600 focus:ring-indigo-500 w-4 h-4">
                        <div>
                            <span class="text-xs font-bold text-slate-800 block">Aktifkan Cloud Sync ke Hosting cPanel</span>
                            <span class="text-[11px] text-slate-500">Bila diaktifkan, komputer lokal depo dapat mengirimkan data ke hosting online.</span>
                        </div>
                    </label>

                    <label class="flex items-start gap-3 cursor-pointer">
                        <input type="checkbox" name="cloud_sync_auto_on_submit" value="1" {{ $syncConfig['auto_sync'] ? 'checked' : '' }} class="mt-0.5 rounded border-slate-300 text-indigo-600 focus:ring-indigo-500 w-4 h-4">
                        <div>
                            <span class="text-xs font-bold text-slate-800 block">Otomatis Sync Setiap Submit (Auto-Sync on Submit)</span>
                            <span class="text-[11px] text-slate-500">Saat Anda ubah harga barang atau simpan manajemen landing page di lokal, data langsung otomatis dikirim ke cPanel hosting.</span>
                        </div>
                    </label>
                </div>

                <!-- URL & Secret Key Input -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1">URL Hosting cPanel Website *</label>
                        <input type="url" name="cloud_sync_url" x-model="targetUrl" required placeholder="https://domainanda.com atau https://api.domainanda.com" class="w-full p-2.5 text-xs border border-slate-300 rounded-xl focus:ring-2 focus:ring-indigo-500 font-mono">
                        <span class="text-[11px] text-slate-400 mt-1 block">Contoh: <code>https://seberayalogam.com</code> (tanpa garis miring di akhir)</span>
                    </div>

                    <div>
                        <div class="flex items-center justify-between mb-1">
                            <label class="text-xs font-bold text-slate-700 uppercase">Secret Sync Key (Token Keamanan) *</label>
                            <button type="button" @click="generateSecret()" class="text-[10px] text-indigo-600 hover:text-indigo-800 font-semibold flex items-center gap-1">
                                <i data-lucide="key" class="w-3 h-3"></i> Buat Token Baru
                            </button>
                        </div>
                        <input type="text" name="cloud_sync_secret_key" x-model="targetSecret" required placeholder="sync_xxxxxxxxxxxxxxxxxxxxxxxx" class="w-full p-2.5 text-xs border border-slate-300 rounded-xl focus:ring-2 focus:ring-indigo-500 font-mono">
                        <span class="text-[11px] text-slate-400 mt-1 block">Token ini harus sama persis dengan yang dipasang di hosting cPanel untuk keamanan.</span>
                    </div>
                </div>

                <!-- Test Connection Feedback Banner -->
                <template x-if="testResult">
                    <div :class="testResult.success ? 'bg-emerald-50 border-emerald-300 text-emerald-800' : 'bg-rose-50 border-rose-300 text-rose-800'" class="p-3.5 rounded-xl border text-xs flex items-center justify-between gap-3">
                        <div class="flex items-center gap-2">
                            <i :data-lucide="testResult.success ? 'check-circle' : 'alert-circle'" class="w-4 h-4 shrink-0"></i>
                            <span x-text="testResult.message" class="font-medium"></span>
                        </div>
                        <button type="button" @click="testResult = null" class="text-slate-400 hover:text-slate-600"><i data-lucide="x" class="w-3.5 h-3.5"></i></button>
                    </div>
                </template>

                <!-- Action Footer -->
                <div class="flex flex-col sm:flex-row items-center justify-between gap-3 pt-3 border-t border-slate-100">
                    <button type="button" @click="runTest()" :disabled="testingConnection" class="w-full sm:w-auto px-4 py-2 border border-slate-300 hover:border-slate-400 text-slate-700 text-xs font-bold rounded-xl transition flex items-center justify-center gap-2">
                        <i data-lucide="zap" class="w-3.5 h-3.5 text-amber-500" :class="testingConnection ? 'animate-spin' : ''"></i>
                        <span x-text="testingConnection ? 'Sedang Menghubungi Hosting...' : 'Tes Koneksi ke Hosting'"></span>
                    </button>

                    <button type="submit" class="w-full sm:w-auto px-6 py-2.5 bg-indigo-600 hover:bg-indigo-500 text-white text-xs font-bold rounded-xl shadow-md transition flex items-center justify-center gap-2">
                        <i data-lucide="save" class="w-4 h-4"></i>
                        <span>Simpan Pengaturan Sync</span>
                    </button>
                </div>
            </form>
        </div>

        <!-- Panduan Praktis Deploy Hosting cPanel -->
        <div class="p-5 rounded-2xl bg-slate-900 text-slate-200 border border-slate-800 space-y-4">
            <div class="flex items-center gap-2.5">
                <span class="w-8 h-8 rounded-lg bg-indigo-500/20 text-indigo-400 flex items-center justify-center font-bold">
                    <i data-lucide="book-open" class="w-4 h-4"></i>
                </span>
                <div>
                    <h5 class="text-xs font-bold uppercase tracking-wider text-white">Panduan Praktis Setup Hosting cPanel</h5>
                    <p class="text-[11px] text-slate-400">Ikuti 3 langkah mudah berikut agar hosting cPanel siap menerima sinkronisasi data dari komputer lokal depo:</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-3.5 text-xs">
                <div class="p-3.5 rounded-xl bg-slate-800/80 border border-slate-700 space-y-1.5">
                    <span class="w-5 h-5 rounded-full bg-indigo-500 text-white flex items-center justify-center text-[10px] font-black">1</span>
                    <h6 class="font-bold text-white">Upload Backend ke cPanel</h6>
                    <p class="text-[11px] text-slate-300 leading-relaxed">
                        Upload source code Laravel ke File Manager cPanel (atau subdomain <code>api.domainanda.com</code>). Jalankan <code>php artisan migrate</code> di Terminal cPanel.
                    </p>
                </div>

                <div class="p-3.5 rounded-xl bg-slate-800/80 border border-slate-700 space-y-1.5">
                    <span class="w-5 h-5 rounded-full bg-indigo-500 text-white flex items-center justify-center text-[10px] font-black">2</span>
                    <h6 class="font-bold text-white">Pasang Secret Sync Key di .env</h6>
                    <p class="text-[11px] text-slate-300 leading-relaxed">
                        Buka file <code>.env</code> di hosting cPanel, tambahkan baris:<br>
                        <code class="text-amber-400 bg-slate-950 px-1 py-0.5 rounded text-[10px]">CLOUD_SYNC_SECRET=sync_xxxxxxxx...</code><br>
                        (Gunakan token yang sama persis dengan yang ada di menu ini).
                    </p>
                </div>

                <div class="p-3.5 rounded-xl bg-slate-800/80 border border-slate-700 space-y-1.5">
                    <span class="w-5 h-5 rounded-full bg-emerald-500 text-slate-950 flex items-center justify-center text-[10px] font-black">3</span>
                    <h6 class="font-bold text-white">Tes & Mulai Sinkronisasi</h6>
                    <p class="text-[11px] text-slate-300 leading-relaxed">
                        Masukkan URL hosting di atas, klik <strong>"Tes Koneksi"</strong>. Bila terhubung, klik <strong>"Sinkronkan Sekarang"</strong>. Setiap Anda update harga di kasir lokal, landing page online otomatis terupdate!
                    </p>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
    function previewHeroImage(input, targetId) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const img = document.getElementById(targetId);
                if (img) img.src = e.target.result;
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
    function previewHeroUrl(url, targetId) {
        if (url && url.trim().length > 7) {
            const img = document.getElementById(targetId);
            if (img) img.src = url.trim();
        }
    }
</script>
@endpush


