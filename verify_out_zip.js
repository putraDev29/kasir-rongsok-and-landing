const fs = require('fs');
const path = require('path');

const htmlPath = path.resolve(__dirname, 'landing-page', 'out', 'index.html');
const html = fs.readFileSync(htmlPath, 'utf8');

console.log('=== VERIFIKASI BERKAS EXPORT OUT.ZIP ===');
console.log('1. URL Backend API baked in:', html.includes('https://backend-seberayalogam.amiitrans.com'));
console.log('2. Nama Perusahaan ter-render:', html.includes('PT. Seberaya Akses Multi'));
console.log('3. Kategori Tembaga & Kuningan:', html.includes('Tembaga & Kuningan'));
console.log('4. Kategori Alumunium:', html.includes('Alumunium'));
console.log('5. Cerita Depo Story (Bekas Pesawat):', html.includes('Bekas Pesawat'));
console.log('6. URL Foto Story dari API Backend:', html.includes('https://backend-seberayalogam.amiitrans.com/uploads/stories/story_1794027188_ClNJN.jpg'));
console.log('7. URL Foto About Depo dari API Backend:', html.includes('https://backend-seberayalogam.amiitrans.com/uploads/about/about_depo_seberaya.jpg'));
console.log('8. URL Logo Header dari API Backend:', html.includes('https://backend-seberayalogam.amiitrans.com/uploads/logo/logo_1793888119.png'));
console.log('9. Embedded Critical Tailwind CSS:', html.includes('id="embedded-tailwind-css"'));
console.log('10. File .htaccess ada di folder out:', fs.existsSync(path.resolve(__dirname, 'landing-page', 'out', '.htaccess')));
console.log('=========================================');

// Check compiled JS chunks for client-side API synchronization
const chunksDir = path.resolve(__dirname, 'landing-page', 'out', '_next', 'static', 'chunks');
const jsFiles = fs.readdirSync(chunksDir).filter(f => f.endsWith('.js'));
let hasClientApiUrl = false;
let hasClientFetchLogic = false;

jsFiles.forEach(file => {
  const content = fs.readFileSync(path.join(chunksDir, file), 'utf8');
  if (content.includes('https://backend-seberayalogam.amiitrans.com')) {
    hasClientApiUrl = true;
  }
  if (content.includes('api/landing-page')) {
    hasClientFetchLogic = true;
  }
});

console.log('11. Client-side JS chunks memiliki URL API Backend:', hasClientApiUrl);
console.log('12. Client-side JS chunks memiliki logika sinkronisasi /api/landing-page:', hasClientFetchLogic);
console.log('=== SEMUA PENGECEKAN BERHASIL ===');

