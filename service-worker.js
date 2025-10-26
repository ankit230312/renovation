const CACHE_NAME = "splitfloor-cache-v1";
const urlsToCache = [
  "/splitfloor/",
  "/splitfloor/index.php",
  "/splitfloor/icons/icon-192x192.png",
  "/splitfloor/icons/icon-512x512.png"
];

// Install service worker
self.addEventListener("install", event => {
  event.waitUntil(
    caches.open(CACHE_NAME).then(cache => {
      return cache.addAll(urlsToCache);
    })
  );
});

// Fetch requests
self.addEventListener("fetch", event => {
  event.respondWith(
    caches.match(event.request).then(response => {
      return response || fetch(event.request);
    })
  );
});
