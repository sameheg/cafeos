importScripts('/vendor/laravel-webpush/laravel-webpush.js');

const CACHE_NAME = 'cafeos-static-v1';
const STATIC_ASSETS = [
  '/',
  '/js/app.js',
  '/css/app.css'
];

self.addEventListener('install', event => {
  event.waitUntil(
    caches.open(CACHE_NAME).then(cache => cache.addAll(STATIC_ASSETS))
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
    return;
  }

  if (req.method === 'POST') {
    event.respondWith(
      fetch(req.clone()).catch(() => queueRequest(req))
    );
  }
});

// Handle incoming push notifications
self.addEventListener('push', event => {
  if (event.data) {
    const notification = event.data.json();
    event.waitUntil(
      self.registration.showNotification(notification.title, notification)
    );
  }
});

self.addEventListener('notificationclick', event => {
  event.notification.close();
  const url = event.notification.data && event.notification.data.url;
  if (url) {
    event.waitUntil(clients.openWindow(url));
  }
});

async function queueRequest(req) {
  const body = await req.clone().json();
  const db = await openDb();
  const tx = db.transaction('queue', 'readwrite');
  tx.objectStore('queue').add({ url: req.url, method: req.method, body });
  registerSync();
  return new Response(JSON.stringify({ queued: true }), {
    headers: { 'Content-Type': 'application/json' }
  });
}

self.addEventListener('sync', event => {
  if (event.tag === 'sync-sales') {
    event.waitUntil(processQueue());
  }
});

async function processQueue() {
  const db = await openDb();
  const tx = db.transaction('queue', 'readwrite');
  const store = tx.objectStore('queue');
  const all = await store.getAll();
  for (const item of all) {
    try {
      await fetch(item.url, {
        method: item.method,
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(item.body)
      });
      store.delete(item.id);
    } catch (e) {
      // still offline; leave in queue
    }
  }
}

function openDb() {
  return new Promise((resolve, reject) => {
    const request = indexedDB.open('cafeos-offline', 1);
    request.onupgradeneeded = () => {
      request.result.createObjectStore('queue', {
        keyPath: 'id',
        autoIncrement: true
      });
    };
    request.onsuccess = () => resolve(request.result);
    request.onerror = () => reject(request.error);
  });
}

function registerSync() {
  if ('sync' in self.registration) {
    self.registration.sync.register('sync-sales');
  }
}
