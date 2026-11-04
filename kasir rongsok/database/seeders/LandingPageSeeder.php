<?php

namespace Database\Seeders;

use App\Models\BusinessSetting;
use App\Models\LandingFaq;
use App\Models\LandingGallery;
use App\Models\LandingService;
use App\Models\LandingStatistic;
use App\Models\LandingTestimonial;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class LandingPageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Business Settings for Landing Page
        $defaultSettings = [
            'landing_hero_badge' => 'Pusat Daur Ulang & Pengepul Terpercaya Sejak 2012',
            'landing_hero_headline' => 'Solusi Jual Beli Rongsok Terpercaya, Transparan & Menguntungkan',
            'landing_hero_subheadline' => 'Kami menerima segala jenis rongsokan logam, besi tua, kardus/kertas, plastik, dan aki bekas dengan timbangan digital presisi, harga pasar kompetitif tertinggi, serta armada jemput siap langsung ke lokasi Anda.',
            'landing_hero_cta_primary' => 'Hubungi via WhatsApp',
            'landing_hero_cta_secondary' => 'Lihat Daftar Harga Rongsok',
            'landing_about_title' => 'Komitmen Menjaga Lingkungan dengan Nilai Ekonomi Maksimal',
            'landing_about_description' => 'UD. Berkah Rongsok Makmur adalah perusahaan pengelolaan dan pengepul material daur ulang terintegrasi yang telah beroperasi selama lebih dari 12 tahun. Kami menjembatani industri manufaktur, perkantoran, bengkel, serta masyarakat dengan sistem timbangan digital bersertifikasi dan pembayaran kontan langsung di tempat.',
            'landing_about_vision' => 'Menjadi rantai pasok material daur ulang terdepan, modern, dan paling terpercaya di Indonesia yang memberikan dampak ekonomi nyata bagi mitra sekaligus menjaga kelestarian lingkungan hidup.',
            'landing_about_mission' => "1. Memberikan transparansi penimbangan digital presisi dan harga pasar terbaik setiap hari.\n2. Menyediakan layanan penjemputan armada cepat, bersih, dan profesional untuk skala gudang, pabrik, maupun retail.\n3. Membangun ekosistem sirkular ekonomi berkelanjutan bersama mitra pengepul dan industri nasional.",
            'landing_about_years_experience' => '12+',
            'landing_maps_embed_url' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d126915.93278964724!2d107.08638663806203!3d-6.273898234676116!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e6985a9757f4955%3A0xc3b5e408ec21d46!2sKawasan%20Industri%20Jababeka!5e0!3m2!1sid!2sid!4v1700000000000!5m2!1sid!2sid',
            'landing_maps_url' => 'https://maps.google.com/?q=-6.273898,107.086386',
            'landing_maps_latitude' => '-6.273898',
            'landing_maps_longitude' => '107.086386',
            'landing_operating_hours' => 'Senin - Sabtu: 07.30 - 17.30 WIB | Minggu: 08.00 - 14.00 WIB',
            'landing_whatsapp_number' => '081234567890',
            'landing_whatsapp_message' => 'Halo Admin, saya ingin bertanya mengenai penjualan barang rongsok. Apakah bisa diinformasikan penawaran harga dan layanan jemput lokasi?',
            'landing_email' => 'kontak@berkahrongsok.com',
            'landing_social_facebook' => 'https://facebook.com/berkahrongsokmakmur',
            'landing_social_instagram' => 'https://instagram.com/berkahrongsok.id',
            'landing_social_tiktok' => 'https://tiktok.com/@berkahrongsok',
            'landing_social_youtube' => 'https://youtube.com/@berkahrongsok',
            'landing_seo_meta_title' => 'Jual Beli Rongsok & Pengepul Besi Tua Terpercaya | UD. Berkah Rongsok Makmur',
            'landing_seo_meta_description' => 'Pengepul rongsok terpercaya terima besi tua, tembaga, kuningan, kardus, plastik, dan aki bekas harga tinggi. Timbangan digital transparan, bayar tunai di tempat, siap jemput gudang & pabrik.',
            'landing_seo_keywords' => 'jual beli rongsok, pengepul rongsok terpercaya, jual besi tua cikarang, harga kardus bekas per kg, rongsokan daur ulang, depo rongsok terdekat, jasa angkut rongsok pabrik',
        ];

        foreach ($defaultSettings as $key => $value) {
            if (!BusinessSetting::where('key', $key)->exists()) {
                BusinessSetting::set($key, $value, 'landing_page');
            }
        }

        // 2. Landing Services
        if (LandingService::count() === 0) {
            $services = [
                [
                    'title' => 'Pembelian Besi Tua & Logam Ferrous',
                    'slug' => 'pembelian-besi-tua-logam-ferrous',
                    'icon' => 'ShieldCheck',
                    'short_description' => 'Menerima besi beton, plat besi, pipa, profil H-beam/I-beam, seng, dan rongsokan konstruksi dengan harga pasar tertinggi.',
                    'full_description' => 'Kami melayani pembelian berbagai macam limbah besi industri, scrap proyek, hingga perabot besi rumah tangga. Penimbangan menggunakan jembatan timbang dan timbangan digital terstandar.',
                    'order' => 1,
                    'is_active' => true,
                ],
                [
                    'title' => 'Pembelian Logam Non-Besi (Tembaga, Alumunium, Kuningan)',
                    'slug' => 'pembelian-logam-non-besi',
                    'icon' => 'Coins',
                    'short_description' => 'Terima tembaga kabel (kupas/bakar), tembaga merah, kuningan keran/plat, alumunium wajan/siku, dan timah dengan nilai jual optimal.',
                    'full_description' => 'Logam non-besi memiliki nilai ekonomi yang sangat tinggi. Kami mengukur kadar dan berat secara akurat di depan pelanggan dengan pembayaran tunai seketika.',
                    'order' => 2,
                    'is_active' => true,
                ],
                [
                    'title' => 'Pembelian Kardus, Kertas & Dokumen Arsip',
                    'slug' => 'pembelian-kardus-kertas-arsip',
                    'icon' => 'PackageCheck',
                    'short_description' => 'Menerima kardus box cokelat, buku tulis bekas, majalah, kertas buram koran, dan layanan pemusnahan dokumen arsip kantor bergaransi.',
                    'full_description' => 'Solusi tepat untuk pergudangan retail, distributor, dan instansi yang ingin mendaur ulang karton gelombang dan arsip lama secara aman dan menguntungkan.',
                    'order' => 3,
                    'is_active' => true,
                ],
                [
                    'title' => 'Pembelian Limbah Plastik & Botol Daur Ulang',
                    'slug' => 'pembelian-limbah-plastik-botol',
                    'icon' => 'Recycle',
                    'short_description' => 'Terima botol PET bening/warna, tutup botol HDPE, emberan/karung, galon rusak, dan botol oli bersih dalam jumlah besar maupun eceran.',
                    'full_description' => 'Mendukung gerakan anti-sampah plastik sekali pakai melalui penyaluran bahan baku cacahan plastik kembali ke pabrik pengolahan resin daur ulang.',
                    'order' => 4,
                    'is_active' => true,
                ],
                [
                    'title' => 'Pembelian Aki & Baterai Bekas Berlisensi',
                    'slug' => 'pembelian-aki-baterai-bekas',
                    'icon' => 'BatteryCharging',
                    'short_description' => 'Menampung aki basah motor/mobil, aki UPS server, baterai forklift, dan aki kering industri dengan penanganan aman lingkungan.',
                    'full_description' => 'Pengelolaan limbah aki bekas sesuai standar keselamatan lingkungan hidup dengan harga satuan/timbangan yang sangat kompetitif.',
                    'order' => 5,
                    'is_active' => true,
                ],
                [
                    'title' => 'Jasa Angkut Armada & Penjemputan Pabrik',
                    'slug' => 'jasa-angkut-armada-penjemputan-pabrik',
                    'icon' => 'Truck',
                    'short_description' => 'Fasilitas armada pick-up dan truk colt diesel siap jemput rongsokan langsung ke gudang, pabrik, atau proyek Anda tanpa repot.',
                    'full_description' => 'Bagi pelanggan dan industri dengan volume rongsok partai besar, tim kami siap mengangkut dan menimbang di tempat menggunakan timbangan portable digital.',
                    'order' => 6,
                    'is_active' => true,
                ],
            ];

            foreach ($services as $srv) {
                LandingService::create($srv);
            }
        }

        // 3. Landing Galleries
        if (LandingGallery::count() === 0) {
            $galleries = [
                [
                    'title' => 'Aktivitas Gudang & Penataan Material',
                    'category' => 'Gudang',
                    'image_path' => 'https://images.unsplash.com/photo-1532996122724-e3c354a0b15b?q=80&w=1200&auto=format&fit=crop',
                    'caption' => 'Area penataan dan sortir material rongsokan logam di depo utama.',
                    'order' => 1,
                    'is_active' => true,
                ],
                [
                    'title' => 'Armada Truk Pengangkutan Rongsok',
                    'category' => 'Armada',
                    'image_path' => 'https://images.unsplash.com/photo-1601584115197-04ecc0da31d7?q=80&w=1200&auto=format&fit=crop',
                    'caption' => 'Armada pengangkut siap melakukan penjemputan partai besar ke gudang dan pabrik mitra.',
                    'order' => 2,
                    'is_active' => true,
                ],
                [
                    'title' => 'Proses Penimbangan Digital Akurat',
                    'category' => 'Penimbangan',
                    'image_path' => 'https://images.unsplash.com/photo-1581092160607-ee22621dd758?q=80&w=1200&auto=format&fit=crop',
                    'caption' => 'Penimbangan transparan di depan pemilik barang menggunakan timbangan bersertifikasi tera metrologi.',
                    'order' => 3,
                    'is_active' => true,
                ],
                [
                    'title' => 'Pengepakan Karton & Kardus Daur Ulang',
                    'category' => 'Daur Ulang',
                    'image_path' => 'https://images.unsplash.com/photo-1586528116311-ad8dd3c8310d?q=80&w=1200&auto=format&fit=crop',
                    'caption' => 'Press baling kardus bekas berkualitas tinggi siap kirim ke pabrik kertas daur ulang.',
                    'order' => 4,
                    'is_active' => true,
                ],
                [
                    'title' => 'Sortir Logam Tembaga & Kuningan',
                    'category' => 'Operasional',
                    'image_path' => 'https://images.unsplash.com/photo-1509395176047-4a66953fa231?q=80&w=1200&auto=format&fit=crop',
                    'caption' => 'Pemisahan kualitas tembaga kabel dan kuningan industri dengan ketelitian tinggi.',
                    'order' => 5,
                    'is_active' => true,
                ],
                [
                    'title' => 'Stok Besi Scrap Konstruksi',
                    'category' => 'Gudang',
                    'image_path' => 'https://images.unsplash.com/photo-1504917599217-d4dc5ebe6122?q=80&w=1200&auto=format&fit=crop',
                    'caption' => 'Pengelompokan besi tua struktur tebal untuk pasokan pabrik peleburan baja nasional.',
                    'order' => 6,
                    'is_active' => true,
                ],
            ];

            foreach ($galleries as $gal) {
                LandingGallery::create($gal);
            }
        }

        // 4. Landing Testimonials
        if (LandingTestimonial::count() === 0) {
            $testimonials = [
                [
                    'client_name' => 'Bambang Sutrisno',
                    'client_role' => 'Manajer Operasional PT. Logam Presisi',
                    'rating' => 5,
                    'avatar_url' => 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?q=80&w=200&auto=format&fit=crop',
                    'content' => 'Sudah 4 tahun rutin menjual scrap sisa produksi pabrik kami ke Berkah Rongsok. Timbangannya selalu presisi tidak pernah ada selisih, pembayaran tunai langsung cair di tempat, dan armadanya selalu on-time saat penjemputan.',
                    'order' => 1,
                    'is_active' => true,
                ],
                [
                    'client_name' => 'Hj. Rini Kartika',
                    'client_role' => 'Pengelola Gudang Logistik Cikarang',
                    'rating' => 5,
                    'avatar_url' => 'https://images.unsplash.com/photo-1544005313-94ddf0286df2?q=80&w=200&auto=format&fit=crop',
                    'content' => 'Setiap akhir bulan kardus bekas kemasan barang kami mencapai belasan ton. Tim Berkah Rongsok sangat profesional, timbangan gantung digitalnya jelas bisa dilihat kedua belah pihak. Sangat direkomendasikan!',
                    'order' => 2,
                    'is_active' => true,
                ],
                [
                    'client_name' => 'Hendra Gunawan',
                    'client_role' => 'Mitra Pengepul Keliling',
                    'rating' => 5,
                    'avatar_url' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?q=80&w=200&auto=format&fit=crop',
                    'content' => 'Sebagai pengepul kecil yang setoran setiap hari, harga di depo ini paling tinggi dibanding lapak lain. Pelayanannya cepat, nota kasir rapi dicetak jelas, dan langsung transfer tanpa nunggu esok hari.',
                    'order' => 3,
                    'is_active' => true,
                ],
                [
                    'client_name' => 'Joko Widodo Santoso',
                    'client_role' => 'Pemilik Bengkel Bubut Mandiri',
                    'rating' => 5,
                    'avatar_url' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?q=80&w=200&auto=format&fit=crop',
                    'content' => 'Gram besi bubut dan potongan tembaga kabel selalu dibeli dengan harga terbaik. Bahkan ketika butuh pick-up darurat untuk membersihkan bengkel, supir dan kernetnya sangat cekatan dan sopan.',
                    'order' => 4,
                    'is_active' => true,
                ],
            ];

            foreach ($testimonials as $t) {
                LandingTestimonial::create($t);
            }
        }

        // 5. Landing FAQs
        if (LandingFaq::count() === 0) {
            $faqs = [
                [
                    'question' => 'Barang rongsok apa saja yang bisa dijual ke depo kami?',
                    'answer' => 'Kami menerima hampir semua jenis limbah daur ulang bernilai ekonomis, antara lain: Besi tua (besi super, siku, pipa, plat, seng, kawat), Logam non-besi (tembaga kabel, kuningan, alumunium, timah), Kardus box dan kertas bekas/arsip kantor, Plastik (botol PET, tutup botol, emberan, galon rusak), serta Aki/baterai bekas basah & kering.',
                    'category' => 'Material',
                    'order' => 1,
                    'is_active' => true,
                ],
                [
                    'question' => 'Apakah melayani penjemputan rongsok langsung ke lokasi?',
                    'answer' => 'Ya, kami menyediakan layanan armada penjemputan gratis ke rumah, gudang, kantor, toko, maupun pabrik industri untuk partai sedang hingga besar (tersedia armada pick-up dan truk engkel/colt diesel). Cukup hubungi kami melalui WhatsApp untuk menjadwalkan penjemputan.',
                    'category' => 'Layanan',
                    'order' => 2,
                    'is_active' => true,
                ],
                [
                    'question' => 'Berapa minimal berat barang untuk penjemputan armada?',
                    'answer' => 'Untuk penjemputan gratis armada pick-up dalam kota, estimasi total timbangan idealnya minimal 150 - 200 kg (atau kombinasi dengan logam non-besi/tembaga bernilai tinggi). Jika jumlah barang Anda di bawah kuota tersebut, Anda dapat mengantarkannya langsung ke depo penimbangan kami kapan saja selama jam operasional.',
                    'category' => 'Layanan',
                    'order' => 3,
                    'is_active' => true,
                ],
                [
                    'question' => 'Bagaimana sistem penimbangan barang dan apakah dijamin akurat?',
                    'answer' => 'Semua timbangan di depo kami menggunakan timbangan digital bersertifikasi metrologi berkala dengan tampilan display ganda yang dapat dilihat langsung oleh pelanggan secara transparan tanpa ada rekayasa berat.',
                    'category' => 'Transaksi',
                    'order' => 4,
                    'is_active' => true,
                ],
                [
                    'question' => 'Bagaimana cara dan kecepatan pembayaran hasil penjualan?',
                    'answer' => 'Pembayaran dilakukan seketika (langsung lunas) setelah proses penimbangan selesai. Anda dapat memilih metode pembayaran Tunai Kontan (Cash di Kasir) atau Transfer Bank instan (BCA, Mandiri, BRI, BNI, QRIS) lengkap dengan cetak nota struk resmi kasir.',
                    'category' => 'Transaksi',
                    'order' => 5,
                    'is_active' => true,
                ],
                [
                    'question' => 'Bagaimana cara mengetahui update harga rongsokan hari ini?',
                    'answer' => 'Daftar estimasi harga rongsokan selalu kami perbarui secara berkala pada bagian "Jenis & Harga Rongsok" di website ini. Untuk negosiasi harga partai besar pabrik atau material khusus, silakan hubungi admin WhatsApp kami secara langsung.',
                    'category' => 'Harga',
                    'order' => 6,
                    'is_active' => true,
                ],
            ];

            foreach ($faqs as $f) {
                LandingFaq::create($f);
            }
        }

        // 6. Landing Statistics
        if (LandingStatistic::count() === 0) {
            $stats = [
                [
                    'label' => 'Tahun Pengalaman',
                    'value' => '12',
                    'prefix' => '',
                    'suffix' => '+',
                    'icon' => 'Clock',
                    'order' => 1,
                    'is_active' => true,
                ],
                [
                    'label' => 'Ton Daur Ulang / Bulan',
                    'value' => '5000',
                    'prefix' => '',
                    'suffix' => '+',
                    'icon' => 'Recycle',
                    'order' => 2,
                    'is_active' => true,
                ],
                [
                    'label' => 'Mitra & Pelanggan Aktif',
                    'value' => '3500',
                    'prefix' => '',
                    'suffix' => '+',
                    'icon' => 'Users',
                    'order' => 3,
                    'is_active' => true,
                ],
                [
                    'label' => 'Akurasi Timbangan Digital',
                    'value' => '100',
                    'prefix' => '',
                    'suffix' => '%',
                    'icon' => 'Scale',
                    'order' => 4,
                    'is_active' => true,
                ],
            ];

            foreach ($stats as $s) {
                LandingStatistic::create($s);
            }
        }
    }
}

