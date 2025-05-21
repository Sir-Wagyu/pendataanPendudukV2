<div>
   <div>
        <label class="block text-sm font-medium text-gray-700 mb-2">Pilih Lokasi di Map</label>
        <div id="map2" style="height: 300px; border-radius: 8px;" wire:ignore></div>
        <div class="mt-2 text-xs text-gray-500">
            Latitude: <span id="lat-value">{{ $latitude }}</span>,
            Longitude: <span id="lng-value">{{ $longitude }}</span>
        </div>
    
    </div>

    
  <script>
    function initMap() {
        var latVal = document.getElementById('lat-value');
        var lngVal = document.getElementById('lng-value');

        var defaultLat = parseFloat(latVal?.innerText) || -2.5489;
        var defaultLng = parseFloat(lngVal?.innerText) || 118.0149;

        var mapContainer = document.getElementById('map2');
        if (!mapContainer) return;

        // Reset Leaflet instance if needed
        if (mapContainer._leaflet_id) {
            mapContainer._leaflet_id = null;
        }

        var map = L.map('map').setView([defaultLat, defaultLng], 5);

        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; OpenStreetMap'
        }).addTo(map);

        var marker = L.marker([defaultLat, defaultLng], { draggable: true }).addTo(map);

        marker.on('dragend', function (e) {
            var latlng = marker.getLatLng();
            latVal.innerText = latlng.lat;
            lngVal.innerText = latlng.lng;
            Livewire.dispatch('setMapLocation', { lat: latlng.lat, lng: latlng.lng });
        });

        map.on('click', function (e) {
            marker.setLatLng(e.latlng);
            latVal.innerText = e.latlng.lat;
            lngVal.innerText = e.latlng.lng;
            Livewire.dispatch('setMapLocation', { lat: e.latlng.lat, lng: e.latlng.lng });
        });

        // Paksa resize ulang agar muncul
        setTimeout(() => {
            map.invalidateSize();
        }, 200);
    }

    // Livewire 3: jalankan initMap setelah DOM update
    document.addEventListener("livewire:navigated", () => {
        // ini akan jalan saat navigasi antar komponen Livewire (kalau pakai navigasi SPA)
        setTimeout(() => {
            initMap();
        }, 300);
    });

    // Gunakan ini setelah state update
    window.Livewire.hook('commit', ({ component, succeed }) => {
        succeed(() => {
            if (document.getElementById('map')) {
                setTimeout(() => {
                    initMap();
                }, 300); // pastikan element sudah benar-benar render
            }
        });
    });
</script>
</div>
