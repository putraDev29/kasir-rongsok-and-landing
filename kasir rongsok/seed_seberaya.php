<?php

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\BusinessSetting;
use App\Models\LandingService;
use App\Models\ItemCategory;
use App\Models\ScrapItem;
use Illuminate\Support\Str;

echo "Updating Business Settings to PT. Seberaya Akses Multi...\n";

$settings = [
    'company_name' => 'PT. Seberaya Akses Multi',
    'app_name' => 'PT. Seberaya Akses Multi - Kasir Rongsok',
    'company_tagline' => 'Seberaya Logam - Pusat Jual Beli Besi Tua, Scrap Logam & Bongkaran Bangunan',
    'company_address' => 'Kontrakan Ibu H. Ani, Jalan Kp. Kalibata / Jl. Mangga Bolong, RT.4/RW.7, Kelurahan Srengseng Sawah, Kecamatan Jagakarsa, Kota Jakarta Selatan, Daerah Khusus Ibukota Jakarta 12640',
    'company_phone' => '+62 815-8423-4353',
    'whatsapp_number' => '6281584234353',
    'operating_hours' => 'Setiap hari, 24 jam (Kantor: 07.00 - 20.00 WIB)',
    'logo_url' => '/uploads/logo/logo_seberaya.png',
    'latitude' => '-6.3475',
    'longitude' => '106.8285',
    'hero_headline' => 'Pusat Jual Beli Besi Tua, Scrap Logam & Bongkaran',
    'hero_subheadline' => 'Menerima besi tua, tembaga, kuningan, aluminium, timah, nikel, karbait, tabung gas & bongkaran bangunan. Timbangan digital presisi & bayar tunai.',
    'seo_meta_title' => 'PT. Seberaya Akses Multi | Jual Beli Besi Tua & Scrap Logam Terpercaya',
    'seo_meta_description' => 'Pusat jual beli besi tua, rongsokan, tembaga, kuningan, aluminium, timah, nikel, karbait, tabung gas dan bongkaran bangunan di Jakarta Selatan. Timbangan digital akurat, bayar tunai di tempat.',
];

foreach ($settings as $key => $value) {
    BusinessSetting::updateOrCreate(
        ['key' => $key],
        ['value' => $value]
    );
}

// Ensure Services match user's explicit services
LandingService::truncate();
$services = [
    [
        'title' => 'Jual Beli Besi Tua & Logam Berat',
        'slug' => 'jual-beli-besi-tua',
        'icon' => 'Layers',
        'short_description' => 'Menerima segala jenis besi tua, besi konstruksi, H-beam, pipa, pelat, dan besi cor dengan timbangan digital akurat.',
        'order' => 1,
        'is_active' => true,
    ],
    [
        'title' => 'Scrap Logam Non-Besi Presisi',
        'slug' => 'scrap-logam-non-besi',
        'icon' => 'Coins',
        'short_description' => 'Terima tembaga (super/BC/kabel), kuningan, aluminium, timah, nikel, karbait / carbide dengan harga kompetitif.',
        'order' => 2,
        'is_active' => true,
    ],
    [
        'title' => 'Penerimaan Bongkaran Bangunan & Gedung',
        'slug' => 'bongkaran-bangunan',
        'icon' => 'Hammer',
        'short_description' => 'Jasa terima bongkaran rumah, gudang, pabrik, dan gedung tua. Tim profesional dengan armada angkut lengkap.',
        'order' => 3,
        'is_active' => true,
    ],
    [
        'title' => 'Jual Beli Tabung Gas & Aksesoris',
        'slug' => 'jual-beli-tabung-gas',
        'icon' => 'Flame',
        'short_description' => 'Menerima dan melayani jual beli tabung gas berbagai ukuran kondisi baik maupun afkir dengan harga terbaik.',
        'order' => 4,
        'is_active' => true,
    ],
    [
        'title' => 'Layanan Penjemputan Armada 24 Jam',
        'slug' => 'layanan-penjemputan-armada',
        'icon' => 'Truck',
        'short_description' => 'Armada truk & pick-up siap menjemput rongsok ke lokasi proyek, gudang, dan bengkel di seluruh wilayah Jabodetabek.',
        'order' => 5,
        'is_active' => true,
    ],
    [
        'title' => 'Timbangan Digital & Bayar Tunai Langsung',
        'slug' => 'timbangan-digital-bayar-tunai',
        'icon' => 'Scale',
        'short_description' => 'Penimbangan transparan di hadapan pelanggan dan pelunasan kontan langsung di tempat saat transaksi selesai.',
        'order' => 6,
        'is_active' => true,
    ],
];

foreach ($services as $srv) {
    LandingService::create($srv);
}

echo "Successfully updated PT. Seberaya Akses Multi data!\n";

