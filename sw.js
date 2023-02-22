const cacheName = 'fablefrog-v1.2';
const staticAssets = [
    './'
];

self.addEventListener('install', async e => {
    const cache = await caches.open(cacheName);
    await cache.addAll(staticAssets);
    console.log(`Install Called`);
    return self.skipWaiting();
});
self.addEventListener('activate', e => {
    console.log(`Activate Called`);
    self.clients.claim();
});

self.addEventListener('fetch', async e => {
    return true;
    /*const req = e.request;
    const url = new URL(req.url);
    if (url.origin === location.origin) {
        e.respondWith(cacheFirst(req));
    } else if(url.origin === "https://www.googleapis.com"){
        return false;
    } else if(url.origin === "https://parsefiles.back4app.com"){
        return false;
    }else {
        e.respondWith(networkAndCache(req));
    }*/
});

async function cacheFirst(req) {
    const cache = await caches.open(cacheName);
    const cached = await cache.match(req);
    return cached || fetch(req);
}

async function networkAndCache(req) {
    const cache = await caches.open(cacheName);
    try {
        const fresh = await fetch(req);
        await cache.put(req, fresh.clone());
        return fresh;
    } catch (e) {
        return await cache.match(req);
    }
}
