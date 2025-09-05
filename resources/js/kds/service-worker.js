const DB_NAME = 'cafeos-offline';
const QUEUE_STORE = 'kds-queue';
const CONFLICT_STORE = 'kds-conflicts';

function openDb() {
  return new Promise((resolve, reject) => {
    const request = indexedDB.open(DB_NAME, 1);
    request.onupgradeneeded = () => {
      const db = request.result;
      if (!db.objectStoreNames.contains(QUEUE_STORE)) {
        db.createObjectStore(QUEUE_STORE, { keyPath: 'id', autoIncrement: true });
      }
      if (!db.objectStoreNames.contains(CONFLICT_STORE)) {
        db.createObjectStore(CONFLICT_STORE, { keyPath: 'id', autoIncrement: true });
      }
    };
    request.onsuccess = () => resolve(request.result);
    request.onerror = () => reject(request.error);
  });
}

async function serializeRequest(request) {
  const headers = {};
  for (const [key, value] of request.headers.entries()) {
    headers[key] = value;
  }
  let body = {};
  try {
    body = await request.clone().json();
  } catch {
    const formData = await request.clone().formData();
    for (const [key, value] of formData.entries()) {
      if (value instanceof File) {
        const buffer = await value.arrayBuffer();
        body[key] = {
          __file: true,
          name: value.name,
          type: value.type,
          data: Array.from(new Uint8Array(buffer))
        };
      } else {
        body[key] = value;
      }
    }
  }
  return { headers, body };
}

async function queueRequest(request) {
  const db = await openDb();
  const { headers, body } = await serializeRequest(request);
  const tx = db.transaction(QUEUE_STORE, 'readwrite');
  await tx.objectStore(QUEUE_STORE).add({
    url: request.url,
    method: request.method,
    headers,
    body
  });
}

async function syncQueue() {
  const db = await openDb();
  const tx = db.transaction([QUEUE_STORE, CONFLICT_STORE], 'readwrite');
  const queue = tx.objectStore(QUEUE_STORE);
  const conflictStore = tx.objectStore(CONFLICT_STORE);

  const all = await queue.getAll();
  for (const item of all) {
    try {
      let conflict = false;
      if (item.body && item.body.id) {
        const resp = await fetch(`${item.url}/${item.body.id}`);
        if (resp.ok) {
          const server = await resp.json();
          if (
            server.updated_at &&
            item.body.updated_at &&
            new Date(server.updated_at) > new Date(item.body.updated_at)
          ) {
            conflict = true;
          }
        }
      }

      if (conflict) {
        await conflictStore.add(item);
        await queue.delete(item.id);
        continue;
      }

      const headers = item.headers || {};
      let body;

      if (headers['content-type'] && headers['content-type'].includes('application/json')) {
        body = JSON.stringify(item.body);
      } else {
        const form = new FormData();
        for (const [key, value] of Object.entries(item.body)) {
          if (value && value.__file) {
            const blob = new Blob([new Uint8Array(value.data)], { type: value.type });
            form.append(key, new File([blob], value.name, { type: value.type }));
          } else {
            form.append(key, value);
          }
        }
        body = form;
        delete headers['content-type'];
      }

      await fetch(item.url, { method: item.method, headers, body });
      await queue.delete(item.id);
    } catch {
      // still offline or request failed; keep item in queue
    }
  }
}

self.addEventListener('fetch', event => {
  const { request } = event;
  if (
    (request.method === 'POST' || request.method === 'PUT') &&
    request.url.includes('/tickets')
  ) {
    event.respondWith(
      fetch(request.clone()).catch(async () => {
        await queueRequest(request);
        await self.registration.sync.register('sync-kds');
        return new Response(JSON.stringify({ offline: true }), {
          status: 202,
          headers: { 'Content-Type': 'application/json' }
        });
      })
    );
  }
});

self.addEventListener('sync', event => {
  if (event.tag === 'sync-kds') {
    event.waitUntil(syncQueue());
  }
});
