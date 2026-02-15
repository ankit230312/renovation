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
    }).catch(error => {
      // Catch all errors - network failures, cache issues, etc.
      console.error("Fetch failed:", error);
      // For image requests, return a placeholder
      if (event.request.destination === "image") {
        return new Response(
          "<svg xmlns='http://www.w3.org/2000/svg' width='240' height='240'><rect fill='#ddd' width='240' height='240'/><text x='50%' y='50%' dominant-baseline='middle' text-anchor='middle' font-family='Arial' font-size='14' fill='#999'>Image unavailable</text></svg>",
          { headers: { "Content-Type": "image/svg+xml" } }
        );
      }
      return new Response("Network error", { status: 503 });
    })
  );
});
