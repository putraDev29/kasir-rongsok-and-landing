const fs = require('fs');
let file = fs.readFileSync('landing-page/src/services/landing-page.service.ts', 'utf8');

file = file.replace(
  'company_tagline: "Jual Beli Besi Tua, Scrap Logam, Tabung Gas & Bongkaran Bangunan",',
  'company_tagline: "Lelang Aset Barang Tak Bergerak & Pengelolaan Aset Terpercaya",'
);

file = file.replace(
  'company_address: "Kontrakan Ibu H. Ani, Jalan Kp. Kalibata / Jl. Mangga Bolong, RT.4/RW.7, Kelurahan Srengseng Sawah, Kecamatan Jagakarsa, Kota Jakarta Selatan, Daerah Khusus Ibukota Jakarta 12640",',
  'company_address: "Jalan raya Lenteng Agung Gg.H.Ali Rt.009 Rw.05 No.10, Kel.Lenteng Agung , Kec.Jagakarsa, Jakarta Selatan, 12610",'
);

file = file.replace(
  'email: "kontak@seberayalogam.com",',
  'email: "pt.seberayaaksesmulti@gmail.com",'
);

file = file.replace(
  'hero_headline: "Solusi Jual Beli Besi Tua, Scrap Logam, Tabung Gas & Bongkaran",',
  'hero_headline: "Lelang Aset Barang Tak Bergerak & Pengelolaan Aset Terpercaya",'
);

file = file.replace(
  'hero_badge: "PT. Seberaya Akses Multi • Spesialis Logam Scrap & Rongsok Jakarta Selatan",',
  'hero_badge: "PT. Seberaya Akses Multi • Solusi Lelang Aset & Pengelolaan Aset Terpercaya",'
);

file = file.replace(
  'about_title: "Komitmen Transparansi Timbangan & Nilai Scrap Logam Maksimal",',
  'about_title: "Tentang PT. Seberaya Akses Multi",'
);

file = file.replace(
  'about_description: "PT. Seberaya Akses Multi (Seberaya Logam) adalah perusahaan pengelolaan limbah logam, rongsokan, dan jasa bongkaran terpercaya yang berlokasi di Jagakarsa, Jakarta Selatan. Kami melayani jual beli besi tua, scrap logam presisi (tembaga, kuningan, aluminium, timah, nikel, karbait/carbide), penerimaan bongkaran bangunan ruko/gedung/rumah, serta jual beli aneka tabung gas dengan standar penimbangan digital bersertifikasi dan pelunasan tunai/transfer langsung di tempat.",',
  'about_description: "Kami adalah perusahaan yang bergerak dibidang lelang aset berupa barang tak bergerak yang merupakan salah satu jasa lelang utama yang kami sediakan mengingat semakin meningkatnya minat dan kebutuhan dari berbagai pihak. Kunci utama kesuksesan lelang adalah harga yang sesuai dengan kondisi pasar, kondisi fisik dan program pemasaran yang efektif. Pada setiap obyek yang akan dilelang perlu dilaksanakan survey awal, penilaian (appraisal) singkat dan penelitian atas kondisi fisiknya sebelum diproses lebih lanjut untuk dipasarkan (marketing) dan dilelang. Didukung oleh Sumber Daya Manusia yang handal, berkompeten dalam bidangnya serta komitmen memberikan pelayanan terbaik, kami siap membantu penjualan berbagai aset melalui sistem lelang.",'
);

file = file.replace(
  'about_vision: "Menjadi perusahaan pengelolaan scrap logam, perdagangan tabung gas, dan jasa bongkaran bangunan terdepan di Jakarta Selatan dan Jabodetabek yang terpercaya, transparan, dan ramah lingkungan.",',
  'about_vision: "1. Memberikan pelayanan yang terbaik, bertanggungjawab dan dapat dipercaya bagi pengguna jasa lelang.\\n2. Lelang merupakan salah satu “service” kami, yaitu sistem penjualan yang cepat, efisien, terbuka, obyektif, terbentuk harga yang optimum dan aspek legalitas yang pasti.",'
);

file = file.replace(
  'about_mission: "1. Transparansi timbangan digital presisi dan penawaran harga beli scrap tertinggi setiap hari.\\n2. Layanan cepat dan tuntas untuk penerimaan bongkaran bangunan serta jual beli tabung gas.\\n3. Menyediakan armada penjemputan 24 jam untuk skala bengkel, pabrik, toko, gudang, maupun rumah tangga.",',
  'about_mission: "Menjadi mitra kerja yang profesional, terpercaya dan kunci kesuksesan bagi mitra bisnis.",'
);

// Update Location
file = file.replace(
  'address: "Kontrakan Ibu H. Ani, Jalan Kp. Kalibata / Jl. Mangga Bolong, RT.4/RW.7, Kelurahan Srengseng Sawah, Kecamatan Jagakarsa, Kota Jakarta Selatan, Daerah Khusus Ibukota Jakarta 12640",',
  'address: "Jalan raya Lenteng Agung Gg.H.Ali Rt.009 Rw.05 No.10, Kel.Lenteng Agung , Kec.Jagakarsa, Jakarta Selatan, 12610",'
);

fs.writeFileSync('landing-page/src/services/landing-page.service.ts', file, 'utf8');
console.log('Successfully updated landing-page.service.ts!');

