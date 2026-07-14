// Dummy Service Worker
// Dibuat secara otomatis untuk mencegah error "Tenant could not be identified" pada routing Laravel
// karena browser sering mencari file sw.js secara otomatis.
self.addEventListener('install', () => {
  self.skipWaiting();
});
