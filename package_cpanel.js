const fs = require('fs');
const path = require('path');
const { execSync } = require('child_process');

console.log('--- START CPANEL EXPORT PACKAGING ---');

const outDir = path.resolve(__dirname, 'landing-page', 'out');
if (!fs.existsSync(outDir)) {
  console.error('Error: landing-page/out directory does not exist!');
  process.exit(1);
}

// 1. Create robust .htaccess with ANTI-304 & NO-CACHE FOR HTML
const htaccessContent = `# ========================================================
# Apache / cPanel / Hostinger CDN Configuration
# PT. Seberaya Akses Multi
# Next.js Static Export SPA & Anti-304 Cache Controller
# ========================================================

<IfModule mod_rewrite.c>
  RewriteEngine On
  RewriteBase /

  # Serve existing files or directories directly
  RewriteCond %{REQUEST_FILENAME} -f [OR]
  RewriteCond %{REQUEST_FILENAME} -d
  RewriteRule ^ - [L]

  # Clean URLs: map /about to /about.html if it exists
  RewriteCond %{DOCUMENT_ROOT}/$1.html -f
  RewriteRule ^([^/]+)/?$ $1.html [L]

  # Fallback all other client-side routes to index.html
  RewriteRule ^ index.html [L]
</IfModule>

# Custom 404 error page
ErrorDocument 404 /404.html

# MIME Types Configuration
<IfModule mod_mime.c>
  AddType text/html .html .htm
  AddType text/css .css
  AddType application/javascript .js
  AddType application/json .json
  AddType image/svg+xml .svg
  AddType image/webp .webp
  AddType image/png .png
  AddType image/jpeg .jpg .jpeg
  AddType font/woff .woff
  AddType font/woff2 .woff2
</IfModule>

# GZIP / Deflate Compression
<IfModule mod_deflate.c>
  AddOutputFilterByType DEFLATE text/html
  AddOutputFilterByType DEFLATE text/css
  AddOutputFilterByType DEFLATE text/plain
  AddOutputFilterByType DEFLATE text/xml
  AddOutputFilterByType DEFLATE application/javascript
  AddOutputFilterByType DEFLATE application/x-javascript
  AddOutputFilterByType DEFLATE application/json
  AddOutputFilterByType DEFLATE image/svg+xml
</IfModule>

# CRITICAL ANTI-304 & IMMEDIATE UPDATE CACHE RULES
# NEVER CACHE HTML OR DATA FILES SO UPDATES APPEAR INSTANTLY
<FilesMatch "\\.(html|htm|json|txt)$">
  <IfModule mod_headers.c>
    Header set Cache-Control "no-cache, no-store, must-revalidate, max-age=0, post-check=0, pre-check=0"
    Header set Pragma "no-cache"
    Header set Expires "Wed, 11 Jan 1984 05:00:00 GMT"
    Header unset ETag
  </IfModule>
  FileETag None
</FilesMatch>

# AGGRESSIVELY CACHE VERSIONED ASSETS (_next/static)
<FilesMatch "\\.(css|js|webp|png|jpg|jpeg|gif|ico|svg|woff|woff2)$">
  <IfModule mod_headers.c>
    Header set Cache-Control "public, max-age=31536000, immutable"
  </IfModule>
</FilesMatch>

# CORS & SECURITY HEADERS
<IfModule mod_headers.c>
  Header set X-Content-Type-Options "nosniff"
  Header set Access-Control-Allow-Origin "*"
  Header set Access-Control-Allow-Methods "GET, POST, OPTIONS"
  Header set Access-Control-Allow-Headers "Content-Type, Authorization, X-Requested-With"
</IfModule>
`;

fs.writeFileSync(path.join(outDir, '.htaccess'), htaccessContent, 'utf8');
console.log('Created anti-cache .htaccess in out directory.');

// 2. Archive out directory to out.zip in root
const zipDest = path.resolve(__dirname, 'out.zip');
if (fs.existsSync(zipDest)) {
  try {
    fs.unlinkSync(zipDest);
    console.log('Removed old out.zip');
  } catch (e) {
    console.warn('Could not remove old out.zip, will overwrite.');
  }
}

console.log('Packaging out.zip using tar...');
try {
  execSync(`tar -a -cf "${zipDest}" * .htaccess`, { cwd: outDir, stdio: 'inherit' });
  console.log('Successfully created out.zip at:', zipDest);
} catch (err) {
  console.warn('tar with .htaccess failed, trying powershell Compress-Archive...');
  execSync(`powershell -Command "Compress-Archive -Path '${outDir}\\*' -DestinationPath '${zipDest}' -Force"`, { stdio: 'inherit' });
}

// Copy to landing-page/out.zip as well
const landingZip = path.resolve(__dirname, 'landing-page', 'out.zip');
try {
  fs.copyFileSync(zipDest, landingZip);
  console.log('Copied to:', landingZip);
} catch (e) {}

if (fs.existsSync(zipDest)) {
  const stats = fs.statSync(zipDest);
  console.log(`out.zip size: ${(stats.size / (1024 * 1024)).toFixed(2)} MB (${stats.size} bytes)`);
} else {
  console.error('out.zip was not generated!');
  process.exit(1);
}

console.log('--- PACKAGING COMPLETED SUCCESSFULLY ---');
