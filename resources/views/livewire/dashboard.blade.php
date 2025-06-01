<div class="py-7 ">
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />

    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

    <div class="bg-white mb-6 px-5 py-8 rounded-3xl shadow-md flex gap-4 lg:gap-6 w-full flex-col md:flex-row items-center flex-wrap">
        @if(auth()->user()->role === 'admin')
            <a href='/verifikasi-akun' class="w-full md:w-[45%] lg:w-[40%] xl:w-[25%] border-3 border-warna-400 rounded-xl py-3 px-4 flex flex-col lg:flex-row items-center text-center gap-3 lg:gap-5 group hover:bg-warna-400 transition-all duration-300 active:scale-95 relative">
                <i class="fa-solid fa-users-gear text-4xl text-warna-400 group-hover:text-white"></i>
                <div class="flex flex-col items-center lg:items-start gap-1"> 
                    <p class="text-sm lg:text-base text-left whitespace-nowrap font-medium group-hover:text-white">Total Akun</p>
                    <p class="text-lg md:text-xl font-bold text-warna-300 group-hover:text-white">{{ $totalAkun }}</p>
                    @if($totalAkunPending > 0)
                    <div class="absolute -top-3 -right-3 bg-white text-warna-800 border-2 border-warna-800 px-3 py-1 text-xs md:tex-sm font-semibold rounded-full group-hover:text-white group-hover:bg-warna-800 transition-all duration-300 flex items-center justify-center">
                        {{$totalAkunPending}} Pending
                    </div>
                    @endif
                </div>
            </a>
        @endif
        <a href='/data-penduduk' class="w-full md:w-[45%] lg:w-[40%] xl:w-[25%] border-3 border-warna-400 rounded-xl py-3 px-4 flex flex-col lg:flex-row items-center text-center gap-3 lg:gap-5 group hover:bg-warna-400 transition-all duration-300 active:scale-95 relative">
            <i class="fa-solid fa-users text-4xl text-warna-400 group-hover:text-white"></i>
            <div class="flex flex-col items-center lg:items-start gap-1"> 
                <p class="text-sm lg:text-base text-left whitespace-nowrap font-medium group-hover:text-white">Total Penduduk</p>
                <p class="text-lg md:text-xl font-bold text-warna-300 group-hover:text-white">{{ $totalPendudukDatang }}</p>
            </div>
            @if(auth()->user()->role === 'kepalaLingkungan')
                @if($totalPendudukPending > 0)
                    <div class="absolute -top-3 -right-3 bg-white text-warna-800 border-2 border-warna-800 px-3 py-1 text-xs md:tex-sm font-semibold rounded-full group-hover:text-white group-hover:bg-warna-800 transition-all duration-300 shadow-lg flex items-center justify-center">
                        {{ $totalPendudukPending }} Pending
                    </div>
                @endif
            @endif
        </a>
        
         <a href="{{ $totalSuratPenduduk > 0 ? '/layanan-surat' : '/data-penduduk' }}" class="w-full md:w-[45%] lg:w-[40%] xl:w-[25%] border-3 border-warna-400 rounded-xl py-3 px-4 flex flex-col lg:flex-row items-center text-center gap-3 lg:gap-5 group hover:bg-warna-400 transition-all duration-300 active:scale-95 relative">
            <i class="fa-solid fa-file-lines text-4xl text-warna-400 group-hover:text-white"></i>
            <div class="flex flex-col items-center lg:items-start gap-1"> 
                <p class="text-sm lg:text-base text-left whitespace-nowrap font-medium group-hover:text-white">Total Surat Pengajuan </p>
                <p class="text-lg md:text-xl font-bold text-warna-300 group-hover:text-white">{{ $totalSuratPenduduk }}</p>
            </div>
            @if(auth()->user()->role === 'kepalaLingkungan' || auth()->user()->role === 'penanggungJawab')
                @if($totalSuratPendudukPending > 0)
                    <div class="absolute -top-3 -right-3 bg-white text-warna-800 border-2 border-warna-800 px-3 py-1 text-xs md:tex-sm font-semibold rounded-full group-hover:text-white group-hover:bg-warna-800 transition-all duration-300 shadow-lg flex items-center justify-center">
                        {{ $totalSuratPendudukPending }} Pending
                    </div>
                @endif
            @endif
        </a>
    </div>

    <div class="my-6 bg-white rounded-xl shadow-lg border border-gray-200 p-6">
        <div class="mb-4">
            <h3 class="text-xl font-bold text-gray-800 mb-2">Peta Lokasi Penduduk</h3>
            <p class="text-gray-600">Sebaran lokasi penduduk pendatang</p>
        </div>
        
        <div 
            id="dashboard-map" 
            style="height: 400px; width: 100%;" 
            class="my-4 rounded shadow w-full border z-0"
            wire:ignore
            x-data="mapComponent()"
            x-init="initMap()">
        </div>
        
        {{-- Info total marker --}}
        <div class="mt-3 text-sm text-gray-600">
            <i class="fa-solid fa-map-marker-alt text-red-500"></i>
            <span id="marker-count">0</span> lokasi penduduk ditampilkan
        </div>
    </div>

    <div class="grid {{ auth()->user()->role === 'admin' ? 'grid-cols-1 xl:grid-cols-2' : 'grid-cols-1' }} gap-6">
        
        {{-- Chart Akun --}}
        @if(auth()->user()->role === 'admin')
        <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-6">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6">
                <div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Statistik Pendaftaran Akun</h3>
                    <p class="text-gray-600">Grafik pendaftaran akun berdasarkan periode waktu</p>
                </div>
                
                <div class="mt-4 md:mt-0">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Periode:</label>
                    <select 
                        wire:model.live="filterWaktu" 
                        class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white text-sm">
                        <option value="mingguan">7 Hari Terakhir</option>
                        <option value="bulanan">30 Hari Terakhir</option>
                        <option value="tahunan">12 Bulan Terakhir</option>
                    </select>
                </div>
            </div>

            <div wire:loading.flex wire:target="filterWaktu" class="justify-center items-center h-64">
                <div class="flex items-center space-x-2">
                    <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-500"></div>
                    <span class="text-gray-600">Memuat data...</span>
                </div>
            </div>

            <div wire:loading.remove wire:target="filterWaktu" class="relative" style="height: 300px;">
                @if(count($chartLabels) > 0 && count($chartData) > 0)
                    <canvas 
                        id="chart-akun-{{ $filterWaktu }}-{{ md5(json_encode($chartData)) }}" 
                        wire:key="chart-akun-{{ $filterWaktu }}-{{ md5(json_encode($chartData)) }}"
                        class="w-full h-full"
                        data-labels="{{ json_encode($chartLabels) }}"
                        data-chart-data="{{ json_encode($chartData) }}"
                        data-filter="{{ $filterWaktu }}"
                        data-chart-type="akun">
                    </canvas>
                @else
                    <div class="flex items-center justify-center h-full">
                        <div class="text-center">
                            <i class="fa-solid fa-chart-bar text-4xl text-gray-300 mb-4"></i>
                            <p class="text-gray-500">Tidak ada data untuk ditampilkan</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
        @endif

        {{-- Chart Penduduk --}}
        <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-6">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6">
                <div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Statistik Penduduk Pendatang</h3>
                    <p class="text-gray-600">Grafik penduduk pendatang berdasarkan periode waktu</p>
                </div>
                
                <div class="mt-4 md:mt-0">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Periode:</label>
                    <select 
                        wire:model.live="filterWaktuPenduduk" 
                        class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 bg-white text-sm">
                        <option value="mingguan">7 Hari Terakhir</option>
                        <option value="bulanan">30 Hari Terakhir</option>
                        <option value="tahunan">12 Bulan Terakhir</option>
                    </select>
                </div>
            </div>

            <div wire:loading.flex wire:target="filterWaktuPenduduk" class="justify-center items-center h-64">
                <div class="flex items-center space-x-2">
                    <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-green-500"></div>
                    <span class="text-gray-600">Memuat data...</span>
                </div>
            </div>

            <div wire:loading.remove wire:target="filterWaktuPenduduk" class="relative" style="height: 300px;">
                @if(count($chartLabelsPenduduk) > 0 && count($chartDataPenduduk) > 0)
                    <canvas 
                        id="chart-penduduk-{{ $filterWaktuPenduduk }}-{{ md5(json_encode($chartDataPenduduk)) }}" 
                        wire:key="chart-penduduk-{{ $filterWaktuPenduduk }}-{{ md5(json_encode($chartDataPenduduk)) }}"
                        class="w-full h-full"
                        data-labels="{{ json_encode($chartLabelsPenduduk) }}"
                        data-chart-data="{{ json_encode($chartDataPenduduk) }}"
                        data-filter="{{ $filterWaktuPenduduk }}"
                        data-chart-type="penduduk">
                    </canvas>
                @else
                    <div class="flex items-center justify-center h-full">
                        <div class="text-center">
                            <i class="fa-solid fa-chart-bar text-4xl text-gray-300 mb-4"></i>
                            <p class="text-gray-500">Tidak ada data untuk ditampilkan</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>

    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    
    function createChart(canvas) {
        if (!canvas) return null;
        
        const labels = JSON.parse(canvas.getAttribute('data-labels') || '[]');
        const chartData = JSON.parse(canvas.getAttribute('data-chart-data') || '[]');
        const filter = canvas.getAttribute('data-filter') || 'mingguan';
        const chartType = canvas.getAttribute('data-chart-type') || 'akun';
        
        console.log(`Creating ${chartType} chart with data:`, { labels, chartData, filter });
        
        const ctx = canvas.getContext('2d');
        
        let backgroundColor, borderColor, labelText;
        if (chartType === 'penduduk') {
            backgroundColor = 'rgba(34, 197, 94, 0.8)'; // Green
            borderColor = 'rgba(34, 197, 94, 1)';
            labelText = 'Jumlah Penduduk Pendatang';
        } else {
            backgroundColor = 'rgba(59, 130, 246, 0.8)'; // Blue
            borderColor = 'rgba(59, 130, 246, 1)';
            labelText = 'Jumlah Pendaftaran Akun';
        }
        
        const chart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: labelText,
                    data: chartData,
                    backgroundColor: backgroundColor,
                    borderColor: borderColor,
                    borderWidth: 1,
                    borderRadius: 4,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top',
                        labels: {
                            color: '#374151',
                            font: { size: 12, weight: '500' }
                        }
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        titleColor: 'white',
                        bodyColor: 'white',
                        borderColor: borderColor,
                        borderWidth: 1,
                        cornerRadius: 8,
                        displayColors: false,
                        callbacks: {
                            title: function(context) {
                                return context[0].label;
                            },
                            label: function(context) {
                                const label = chartType === 'penduduk' ? 'Penduduk' : 'Pendaftaran';
                                return `${label}: ${context.parsed.y} ${chartType === 'penduduk' ? 'orang' : 'akun'}`;
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1,
                            color: '#6B7280',
                            font: { size: 11 },
                            callback: function(value) {
                                return Number.isInteger(value) ? value : '';
                            }
                        },
                        grid: {
                            color: 'rgba(0, 0, 0, 0.1)',
                            drawBorder: false
                        },
                        title: {
                            display: true,
                            text: chartType === 'penduduk' ? 'Jumlah Penduduk' : 'Jumlah Akun',
                            color: '#374151',
                            font: { size: 12, weight: '600' }
                        }
                    },
                    x: {
                        ticks: {
                            color: '#6B7280',
                            font: { size: 11 },
                            maxRotation: 45
                        },
                        grid: { display: false },
                        title: {
                            display: true,
                            text: 'Periode',
                            color: '#374151',
                            font: { size: 12, weight: '600' }
                        }
                    }
                },
                animation: {
                    duration: 800,
                    easing: 'easeInOutQuart'
                }
            }
        });
        
        canvas.chartInstance = chart;
        
        console.log(`${chartType} chart created successfully for filter:`, filter);
        return chart;
    }
    
    function initializeCharts() {
        const canvases = document.querySelectorAll('canvas[id^="chart-"]');
        
        canvases.forEach(canvas => {
            if (canvas.chartInstance) {
                canvas.chartInstance.destroy();
                canvas.chartInstance = null;
            }
            
            // Create new chart
            createChart(canvas);
        });
    }
    
    initializeCharts();
    
    document.addEventListener('livewire:navigated', function() {
        console.log('Livewire navigated, re-initializing charts...');
        setTimeout(initializeCharts, 100);
    });
    
    if (window.Livewire) {
        Livewire.hook('morph.updated', ({ el, component }) => {
            console.log('Livewire morph updated, re-initializing charts...');
            setTimeout(initializeCharts, 50);
        });
    }
    
    const observer = new MutationObserver(function(mutations) {
        let shouldReinitialize = false;
        
        mutations.forEach(function(mutation) {
            if (mutation.type === 'childList') {
                mutation.addedNodes.forEach(function(node) {
                    if (node.nodeType === 1 && node.querySelector && node.querySelector('canvas[id^="chart-"]')) {
                        shouldReinitialize = true;
                    }
                });
            }
        });
        
        if (shouldReinitialize) {
            console.log('DOM mutation detected, re-initializing charts...');
            setTimeout(initializeCharts, 100);
        }
    });
    
    observer.observe(document.body, {
        childList: true,
        subtree: true
    });
});
</script>

<script>
// Data penduduk dari server
const pendudukMapData = @json($mapData);

function mapComponent() {
    return {
        map: null,
        markers: [],
        
        initMap() {
            setTimeout(() => {
                this.createMap();
            }, 200);
        },
        
        createMap() {
            try {
                console.log('Initializing map with penduduk data:', pendudukMapData);
                
                // Check if Leaflet is available
                if (typeof L === 'undefined') {
                    console.error('Leaflet is not loaded!');
                    return;
                }
                
                const mapElement = document.getElementById('dashboard-map');
                if (!mapElement) {
                    console.error('Map element not found!');
                    return;
                }
                
                // Clear existing map
                if (this.map) {
                    this.map.remove();
                }
                
                // Determine map center
                let centerLat = -8.799884;
                let centerLng = 115.174342;
                let zoom = 13;
                
                // If we have penduduk data, center on first location or calculate center
                if (pendudukMapData && pendudukMapData.length > 0) {
                    // Calculate center from all points
                    const latSum = pendudukMapData.reduce((sum, p) => sum + p.latitude, 0);
                    const lngSum = pendudukMapData.reduce((sum, p) => sum + p.longitude, 0);
                    
                    centerLat = latSum / pendudukMapData.length;
                    centerLng = lngSum / pendudukMapData.length;
                    
                    // Adjust zoom based on data spread
                    zoom = pendudukMapData.length > 10 ? 12 : 14;
                }
                
                // Create map
                this.map = L.map('dashboard-map', {
                    center: [centerLat, centerLng],
                    zoom: zoom,
                    zoomControl: true,
                    scrollWheelZoom: true
                });
                
                // Add tile layer
                L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    maxZoom: 19,
                    attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
                }).addTo(this.map);
                
                // Add markers for each penduduk
                this.addPendudukMarkers();
                
                // Update marker count
                document.getElementById('marker-count').textContent = pendudukMapData.length;
                
                console.log(`Map created with ${pendudukMapData.length} markers`);
                
                // Force resize
                setTimeout(() => {
                    if (this.map) {
                        this.map.invalidateSize();
                    }
                }, 300);
                
            } catch (error) {
                console.error('Error creating map:', error);
            }
        },
        
        addPendudukMarkers() {
            // Clear existing markers
            this.markers.forEach(marker => {
                this.map.removeLayer(marker);
            });
            this.markers = [];
            
            // Add marker for each penduduk
            pendudukMapData.forEach((penduduk, index) => {
                try {
                    // Create custom icon (optional)
                    const customIcon = L.divIcon({
                        html: `<div class="bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center text-xs font-bold border-2 border-white shadow-lg">${index + 1}</div>`,
                        className: 'custom-marker',
                        iconSize: [24, 24],
                        iconAnchor: [12, 12]
                    });
                    
                    // Create marker
                    const marker = L.marker([penduduk.latitude, penduduk.longitude], {
                        icon: customIcon
                    }).addTo(this.map);
                    
                    // Add popup
                    marker.bindPopup(`
                        <div class="p-3 min-w-[200px]">
                            <h4 class="font-bold text-sm mb-2 text-gray-800">${penduduk.nama}</h4>
                            <div class="space-y-1 text-xs">
                                <p class="text-gray-600">
                                    <i class="fa-solid fa-map-marker-alt text-red-500 w-3"></i>
                                    ${penduduk.alamat}
                                </p>
                                <p class="text-blue-600">
                                    <i class="fa-solid fa-calendar text-blue-500 w-3"></i>
                                    Terdaftar: ${penduduk.tanggal_daftar}
                                </p>
                                <p class="text-green-600">
                                    <i class="fa-solid fa-location-dot text-green-500 w-3"></i>
                                    ${penduduk.latitude.toFixed(6)}, ${penduduk.longitude.toFixed(6)}
                                </p>
                            </div>
                        </div>
                    `, {
                        maxWidth: 250,
                        className: 'custom-popup'
                    });
                    
                    // Store marker reference
                    this.markers.push(marker);
                    
                } catch (error) {
                    console.error(`Error adding marker for ${penduduk.nama}:`, error);
                }
            });
            
            // Fit map to show all markers if we have data
            if (this.markers.length > 0) {
                const group = new L.featureGroup(this.markers);
                this.map.fitBounds(group.getBounds().pad(0.1));
                
                // Set minimum zoom
                if (this.map.getZoom() > 15) {
                    this.map.setZoom(15);
                }
            }
        }
    }
}

// Chart JavaScript (tetap sama seperti sebelumnya)
document.addEventListener('DOMContentLoaded', function() {
    // ... chart code yang sudah ada tetap sama ...
});
</script>