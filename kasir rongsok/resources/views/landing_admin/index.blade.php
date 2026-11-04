@extends('layouts.app', ['header' => 'Pengelolaan Landing Page Website'])

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
        <button type="button" @click="activeTab = 'settings'" :class="activeTab === 'settings' ? 'bg-emerald-600 text-white shadow-sm' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900'" class="px-3.5 py-2 rounded-xl transition flex items-center gap-2">
            <i data-lucide="sliders" class="w-4 h-4"></i>
            <span>Kontak, Maps & SEO</span>
        </button>

        <button type="button" @click="activeTab = 'hero-about'" :class="activeTab === 'hero-about' ? 'bg-emerald-600 text-white shadow-sm' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900'" class="px-3.5 py-2 rounded-xl transition flex items-center gap-2">
            <i data-lucide="layout" class="w-4 h-4"></i>
            <span>Hero & Tentang Kami</span>
        </button>

        <button type="button" @click="activeTab = 'services'" :class="activeTab === 'services' ? 'bg-emerald-600 text-white shadow-sm' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900'" class="px-3.5 py-2 rounded-xl transition flex items-center gap-2">
            <i data-lucide="briefcase" class="w-4 h-4"></i>
            <span>Layanan ({{ $services->count() }})</span>
        </button>

        <button type="button" @click="activeTab = 'gallery'" :class="activeTab === 'gallery' ? 'bg-emerald-600 text-white shadow-sm' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900'" class="px-3.5 py-2 rounded-xl transition flex items-center gap-2">
            <i data-lucide="image" class="w-4 h-4"></i>
            <span>Galeri Foto ({{ $galleries->count() }})</span>
        </button>

        <button type="button" @click="activeTab = 'testimonials'" :class="activeTab === 'testimonials' ? 'bg-emerald-600 text-white shadow-sm' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900'" class="px-3.5 py-2 rounded-xl transition flex items-center gap-2">
            <i data-lucide="message-square" class="w-4 h-4"></i>
            <span>Testimoni ({{ $testimonials->count() }})</span>
        </button>

        <button type="button" @click="activeTab = 'faqs'" :class="activeTab === 'faqs' ? 'bg-emerald-600 text-white shadow-sm' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900'" class="px-3.5 py-2 rounded-xl transition flex items-center gap-2">
            <i data-lucide="help-circle" class="w-4 h-4"></i>
            <span>FAQ ({{ $faqs->count() }})</span>
        </button>

        <button type="button" @click="activeTab = 'statistics'" :class="activeTab === 'statistics' ? 'bg-emerald-600 text-white shadow-sm' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900'" class="px-3.5 py-2 rounded-xl transition flex items-center gap-2">
            <i data-lucide="trending-up" class="w-4 h-4"></i>
            <span>Statistik ({{ $statistics->count() }})</span>
        </button>

        <button type="button" @click="activeTab = 'inquiries'" :class="activeTab === 'inquiries' ? 'bg-emerald-600 text-white shadow-sm' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900'" class="px-3.5 py-2 rounded-xl transition flex items-center gap-2">
            <i data-lucide="inbox" class="w-4 h-4"></i>
            <span>Kotak Masuk ({{ $inquiries->count() }})</span>
        </button>
    </div>

    <!-- TAB 1: KONTAK, MAPS & SEO -->
    <div x-show="activeTab === 'settings'" class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 sm:p-8 space-y-6">
        <div class="border-b border-slate-200 pb-4">
            <h3 class="text-base font-bold text-slate-900">Pengaturan WhatsApp, Google Maps, Operasional & SEO</h3>
            <p class="text-xs text-slate-500 mt-1">Data ini langsung disinkronkan ke Floating Button WhatsApp, Section Kontak, Footer, dan Meta Header Website</p>
        </div>

        <form action="{{ route('landing-admin.settings.update') }}" method="POST" class="space-y-6">
            @csrf

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

        <form action="{{ route('landing-admin.hero-about.update') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Hero Settings -->
            <div class="bg-slate-50 p-5 rounded-xl border border-slate-200 space-y-4">
                <h4 class="text-xs font-bold uppercase tracking-wider text-emerald-800 flex items-center gap-2">
                    <i data-lucide="sparkles" class="w-4 h-4"></i>
                    <span>Section Hero (Bagian Utama Atas)</span>
                </h4>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="md:col-span-2">
                        <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Badge Tagline Kecil di Atas Headline</label>
                        <input type="text" name="landing_hero_badge" value="{{ old('landing_hero_badge', $settings['landing_hero_badge'] ?? 'Pusat Daur Ulang & Pengepul Terpercaya Sejak 2012') }}"
                               class="w-full py-2 px-3 text-xs rounded-lg border border-slate-300 bg-white">
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Headline Utama Hero (Maks. 150 karakter) *</label>
                        <input type="text" name="landing_hero_headline" value="{{ old('landing_hero_headline', $settings['landing_hero_headline'] ?? 'Solusi Jual Beli Rongsok Terpercaya, Transparan & Menguntungkan') }}" required
                               class="w-full py-2.5 px-3 text-sm font-bold rounded-lg border border-slate-300 bg-white text-slate-900">
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Subheadline / Deskripsi Singkat Hero *</label>
                        <textarea name="landing_hero_subheadline" rows="3" required class="w-full p-2.5 text-xs rounded-lg border border-slate-300 bg-white">{{ old('landing_hero_subheadline', $settings['landing_hero_subheadline'] ?? 'Kami menerima segala jenis rongsokan logam, besi tua, kardus/kertas, plastik, dan aki bekas dengan timbangan digital presisi, harga pasar kompetitif tertinggi, serta armada jemput siap langsung ke lokasi Anda.') }}</textarea>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Teks Tombol CTA Utama (Hijau)</label>
                        <input type="text" name="landing_hero_cta_primary" value="{{ old('landing_hero_cta_primary', $settings['landing_hero_cta_primary'] ?? 'Hubungi via WhatsApp') }}"
                               class="w-full py-2 px-3 text-xs rounded-lg border border-slate-300 bg-white font-semibold">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Teks Tombol CTA Kedua (Outline)</label>
                        <input type="text" name="landing_hero_cta_secondary" value="{{ old('landing_hero_cta_secondary', $settings['landing_hero_cta_secondary'] ?? 'Lihat Daftar Harga Rongsok') }}"
                               class="w-full py-2 px-3 text-xs rounded-lg border border-slate-300 bg-white font-semibold">
                    </div>
                </div>
            </div>

            <!-- About Settings -->
            <div class="bg-slate-50 p-5 rounded-xl border border-slate-200 space-y-4">
                <h4 class="text-xs font-bold uppercase tracking-wider text-emerald-800 flex items-center gap-2">
                    <i data-lucide="info" class="w-4 h-4"></i>
                    <span>Section Tentang Kami (About Us)</span>
                </h4>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="md:col-span-2">
                        <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Judul Section Tentang Kami</label>
                        <input type="text" name="landing_about_title" value="{{ old('landing_about_title', $settings['landing_about_title'] ?? 'Komitmen Menjaga Lingkungan dengan Nilai Ekonomi Maksimal') }}"
                               class="w-full py-2 px-3 text-xs font-bold rounded-lg border border-slate-300 bg-white">
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Deskripsi Lengkap Usaha</label>
                        <textarea name="landing_about_description" rows="4" class="w-full p-2.5 text-xs rounded-lg border border-slate-300 bg-white">{{ old('landing_about_description', $settings['landing_about_description'] ?? 'UD. Berkah Rongsok Makmur adalah perusahaan pengelolaan dan pengepul material daur ulang terintegrasi yang telah beroperasi selama lebih dari 12 tahun. Kami menjembatani industri manufaktur, perkantoran, bengkel, serta masyarakat dengan sistem timbangan digital bersertifikasi dan pembayaran kontan langsung di tempat.') }}</textarea>
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
                        <input type="text" name="landing_about_years_experience" value="{{ old('landing_about_years_experience', $settings['landing_about_years_experience'] ?? '12+') }}"
                               placeholder="Contoh: 12+" class="w-full py-2 px-3 text-xs rounded-lg border border-slate-300 bg-white font-bold">
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

</div>
@endsection

