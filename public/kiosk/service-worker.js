const CACHE_NAME = 'kiosk-cache-v1';
const ASSETS = [
  '/kiosk',
  '/css/app.css',
  '/js/app.js'
];

self.addEventListener('install', event => {
  event.waitUntil(
    caches.open(CACHE_NAME).then(cache => cache.addAll(ASSETS))
  );
  self.skipWaiting();
});

self.addEventListener('activate', event => {
  event.waitUntil(self.clients.claim());
});

self.addEventListener('fetch', event => {
  const req = event.request;
  if (req.method === 'GET') {
    event.respondWith(
      caches.match(req).then(res => res || fetch(req))
    );
  } else if (req.method === 'POST') {
    event.respondWith(
      fetch(req.clone()).catch(() => new Response(JSON.stringify({queued: true}), {headers:{'Content-Type':'application/json'}}))
    );
  }
});
