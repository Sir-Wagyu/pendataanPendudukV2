<div>
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

    <div class="bg-white shadow-md rounded-lg p-6 w-full pb-10">
        <h2 class="text-xl font-semibold mb-4">Ringkasan Cepat Layanan Surat</h2>
        
        <div class="flex gap-4 lg:gap-6 w-full flex-col md:flex-row items-center flex-wrap mt-5">
            <div class="w-full md:w-[45%] lg:w-[40%] xl:w-[25%] border-3 border-warna-400 bg-warna-400/8 rounded-xl py-3 px-4 flex flex-col lg:flex-row items-center text-center gap-3 lg:gap-5 group  transition-all duration-300 active:scale-95 relative">
                <i class="fa-solid fa-file-text text-4xl text-warna-400 bg-warna-400/30 p-3 rounded-lg"></i>
                <div class="flex lg:flex-col items-center justify-center lg:items-start gap-3 lg:gap-1"> 
                    <p class="text-4xl font-semibold lg:order-2 text-warna-400">{{ $totalPengajuan }}</p>
                    <p class="text-sm lg:text-base text-left font-semibold text-warna-300/50">Total Pengajuan Surat</p>
                </div>
            </div>
            <div class="w-full md:w-[45%] lg:w-[40%] xl:w-[25%] border-3 border-green-400 bg-green-400/8 rounded-xl py-3 px-4 flex flex-col lg:flex-row items-center text-center gap-3 lg:gap-5 group  transition-all duration-300 active:scale-95 relative">
                <i class="fa-solid fa-file-circle-check text-4xl text-green-400 bg-green-400/30 p-3 rounded-lg"></i>
                <div class="flex lg:flex-col items-center justify-center lg:items-start gap-3 lg:gap-1"> 
                    <p class="text-4xl font-semibold lg:order-2 text-green-400">{{ $totalDisetujui }}</p>
                    <p class="text-sm lg:text-base text-left font-semibold text-warna-300/50">Surat Disetujui</p>
                </div>
            </div>
            <div class="w-full md:w-[45%] lg:w-[40%] xl:w-[25%] border-3 border-red-400 bg-red-400/8 rounded-xl py-3 px-4 flex flex-col lg:flex-row items-center text-center gap-3 lg:gap-5 group  transition-all duration-300 active:scale-95 relative">
                <i class="fa-solid fa-file-circle-xmark text-4xl text-red-400 bg-red-400/30 p-3 rounded-lg"></i>
                <div class="flex lg:flex-col items-center justify-center lg:items-start gap-3 lg:gap-1"> 
                    <p class="text-4xl font-semibold lg:order-2 text-red-400">{{ $totalDitolak }}</p>
                    <p class="text-sm lg:text-base text-left font-semibold text-warna-300/50">Surat Ditolak</p>
                </div>
            </div>
            <div class="w-full md:w-[45%] lg:w-[40%] xl:w-[25%] border-3 border-purple-400 bg-purple-400/8 rounded-xl py-3 px-4 flex flex-col lg:flex-row items-center text-center gap-3 lg:gap-5 group  transition-all duration-300 active:scale-95 relative">
                <i class="fa-solid fa-star text-4xl text-purple-400 bg-purple-400/30 p-3 rounded-lg"></i>
                <div class="flex lg:flex-col items-center justify-center lg:items-start gap-3 lg:gap-1"> 
                    <p class="text-lg lg:text-xl font-semibold lg:order-2 text-purple-400">{{ $jenisTerpopuler ?? 'Belum Ada' }}</p>
                    <p class="text-sm lg:text-base text-left font-semibold text-warna-300/50">Jenis Surat Terpopuler</p>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white shadow-md rounded-lg p-6 w-full mt-6 pb-10">
        <h2 class="text-xl font-semibold mb-8">Daftar Layanan Surat</h2>
        <div class="flex flex-col md:flex-row gap-4 mb-6">
            <!-- Filter Dropdown -->
            <div class="relative">
                <button id="dropdownFilterButton" data-dropdown-toggle="dropdownFilter" class="text-lg text-warna-300/80 px-3 py-2 rounded-lg hover:bg-gray-200 transition-colors duration-200 flex items-center gap-2 border border-gray-300" type="button">
                    <i class="fa-solid fa-sliders"></i>
                </button>

                <!-- Dropdown menu -->
                <div id="dropdownFilter" class="z-40 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-80">
                    <div class="p-4">
                        <h3 class="text-sm font-medium text-gray-900 mb-3">Filter Data</h3>
                        
                        <!-- Status Surat Filter -->
                        <div class="mb-4">
                            <label for="filterStatus" class="block text-xs font-medium text-gray-700 mb-1">Status Surat</label>
                            <select wire:model.live="filterStatus" id="filterStatus"
                                    class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-warna-400 focus:border-warna-400">
                                <option value="">Semua Status</option>
                                <option value="pending">Menunggu Persetujuan</option>
                                <option value="disetujui">Disetujui</option>
                                <option value="ditolak">Ditolak</option>
                            </select>
                        </div>

                        <!-- Jenis Surat Filter -->
                        <div class="mb-4">
                            <label for="filterJenisSurat" class="block text-xs font-medium text-gray-700 mb-1">Jenis Surat</label>
                            <select wire:model.live="filterJenisSurat" id="filterJenisSurat"
                                    class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-warna-400 focus:border-warna-400">
                                <option value="">Semua Jenis Surat</option>
                                <option value="surat_pengantar_umum">Surat Pengantar Umum</option>
                                <option value="surat_keterangan_domisili">Surat Keterangan Domisili</option>
                                <option value="surat_pengantar_skck">Surat Pengantar SKCK</option>
                                <option value="surat_keterangan_kehilangan_lokal">Surat Keterangan Kehilangan Lokal</option>
                                <option value="surat_keterangan_untuk_anak_sekolah">Surat Keterangan Untuk Anak Sekolah</option>
                            </select>
                        </div>

                        <!-- Reset Filter Button -->
                        <button wire:click="resetFilters" type="button"
                                class="w-full px-3 py-2 text-sm bg-gray-100 hover:bg-gray-200 border border-gray-300 rounded-lg transition-colors duration-200 text-gray-700">
                            <i class="fa-solid fa-refresh mr-1"></i>
                            Reset Filter
                        </button>
                    </div>
                </div>
            </div>

            <!-- Search Input -->
            <div class="flex-1 min-w-0">
                <div class="relative">
                    <input type="text" 
                           wire:model.live="search" 
                           placeholder="Cari berdasarkan nomor surat, nama pemohon, atau jenis surat..."
                           class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-warna-400 focus:border-warna-400 text-sm">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fa-solid fa-search text-gray-400"></i>
                    </div>
                </div>
            </div>

            <!-- Export Button -->
            <div class="relative">
                <button id="dropdownExportButton" data-dropdown-toggle="dropdownExport" 
                        class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg flex items-center gap-2 transition-colors duration-200 text-sm justify-center" 
                        type="button">
                    <i class="fa-solid fa-download"></i>
                    Export
                    <i class="fa-solid fa-chevron-down text-xs"></i>
                </button>

                <!-- Export Dropdown menu -->
                <div id="dropdownExport" class="z-40 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-56">
                    <div class="py-2">
                        <div class="px-4 py-2 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            Format Laporan
                        </div>
                        
                        <a href="{{ route('export.surat.csv', ['search' => $search, 'filterStatus' => $filterStatus, 'filterJenisSurat' => $filterJenisSurat]) }}" 
                           class="flex items-center w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors duration-200 no-underline"
                           target="_blank">
                            <i class="fa-solid fa-file-csv mr-3 text-green-600"></i>
                            <div>
                                <div class="font-medium">Export CSV</div>
                                <div class="text-xs text-gray-500">Data lengkap dalam format CSV</div>
                            </div>
                        </a>
                        
                        <a href="{{ route('export.surat.excel', ['search' => $search, 'filterStatus' => $filterStatus, 'filterJenisSurat' => $filterJenisSurat]) }}" 
                           class="flex items-center w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors duration-200 no-underline"
                           target="_blank">
                            <i class="fa-solid fa-file-excel mr-3 text-blue-600"></i>
                            <div>
                                <div class="font-medium">Export Excel</div>
                                <div class="text-xs text-gray-500">Laporan dengan format tabel</div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Table -->
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400 border-collapse border border-gray-200 bg-warna-100">
                <thead class="text-xs text-warna-300 uppercase border-y-3 border-gray-200">
                    <tr>
                        <th scope="col" class="px-5 py-2 md:px-7 md:py-3 whitespace-nowrap">No</th>
                        <th scope="col" class="px-7 py-4 whitespace-nowrap">Nomor Surat</th>
                        <th scope="col" class="px-7 py-4 whitespace-nowrap">Jenis Surat</th>
                        <th scope="col" class="px-7 py-4 whitespace-nowrap">Nama Pemohon</th>
                        <th scope="col" class="px-7 py-4 whitespace-nowrap">Penanggung Jawab</th>
                        <th scope="col" class="px-7 py-4 whitespace-nowrap">Tanggal Pengajuan</th>
                        <th scope="col" class="px-7 py-4 whitespace-nowrap">Kepala Lingkungan</th>
                        <th scope="col" class="px-7 py-4 whitespace-nowrap">Tanggal Keputusan</th>
                        <th scope="col" class="px-7 py-4 whitespace-nowrap">Status</th>
                        <th scope="col" class="px-7 py-4 whitespace-nowrap">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-sm text-gray-500 dark:text-gray-400">
                    @if($layananSurat->isEmpty())
                        <tr>
                            <td colspan="10" class="text-center py-8">
                                <div class="flex flex-col items-center">
                                    <i class="fa-solid fa-file-circle-exclamation text-4xl text-gray-400 mb-2"></i>
                                    <p class="text-gray-500">
                                        @if(!empty($search) || !empty($filterStatus) || !empty($filterJenisSurat))
                                            Tidak ada data yang sesuai dengan filter yang dipilih.
                                        @else
                                            Belum ada data layanan surat.
                                        @endif
                                    </p>
                                </div>
                            </td>
                        </tr>
                    @else
                        @foreach($layananSurat as $index => $item)
                            <tr class="border-b border-gray-200 text-warna-300 odd:bg-white even:bg-gray-100">
                                <td class="px-5 py-2 md:px-7 md:py-3">{{ $index + 1 }}</td>
                                <td class="px-7 py-4 font-semibold">{{ $item->nomor_surat_terbitan ?? 'Belum disetujui' }}</td>
                                <td class="px-7 py-4 whitespace-nowrap">
                                    @if($item->jenis_surat == 'surat_keterangan_domisili')
                                        Surat Keterangan Domisili
                                    @elseif($item->jenis_surat == 'surat_keterangan_kehilangan_lokal')
                                        Surat Keterangan Kehilangan Lokal
                                    @elseif($item->jenis_surat == 'surat_pengantar_umum')
                                        Surat Pengantar Umum
                                    @elseif($item->jenis_surat == 'surat_pengantar_skck')
                                        Surat Pengantar SCK
                                    @elseif($item->jenis_surat == 'surat_keterangan_untuk_sekolah_anak')
                                        Surat Keterangan Untuk Sekolah Anak
                                    @endif
                                </td>
                                <td class="px-7 py-4">{{ $item->penduduk->nama_lengkap ?? 'Tidak diketahui' }}</td>
                                <td class="px-7 py-4">{{ $item->penanggungJawab->name ?? 'Tidak ada' }}</td>
                                <td class="px-7 py-4">{{ $item->tanggal_pengajuan ? \Carbon\Carbon::parse($item->tanggal_pengajuan)->format('d/m/Y') : '-' }}</td>
                                <td class="px-7 py-4">{{ $item->kepalaLingkungan->name ?? 'Belum disetujui' }}</td>
                                <td class="px-7 py-4">{{ $item->tanggal_surat_diterbitkan ? \Carbon\Carbon::parse($item->tanggal_surat_diterbitkan)->format('d/m/Y') : '-' }}</td>
                                <td class="px-7 py-4 whitespace-nowrap">
                                    @if($item->status_pengajuan == 'ditolak')
                                        <div class="py-2 px-6 bg-warna-800 rounded-full text-xs font-semibold">
                                            <p class="text-white font-semibold text-center">Ditolak</p>
                                        </div>
                                    @elseif($item->status_pengajuan == 'disetujui')
                                        <div class="py-2 px-6 bg-warna-500 rounded-full text-xs font-semibold">
                                            <p class="text-white font-semibold text-center">Disetujui</p>
                                        </div>
                                    @elseif($item->status_pengajuan == 'diajukan')
                                        <div class="py-2 px-6 bg-warna-700 rounded-full text-xs font-semibold">
                                            <p class="text-white font-semibold text-center">Menunggu</p>
                                        </div>
                                    @elseif($item->status_pengajuan == 'dibatalkan')
                                        <div class="py-2 px-6 border-2 border-warna-800 rounded-full text-xs font-semibold">
                                            <p class="text-warna-800 font-semibold text-center">{{ ucfirst($item->status_pengajuan) }}</p>
                                        </div>
                                    @endif
                                </td>
                                <td class="px-7 py-4">
                                    <div class="flex items-center gap-2">
                                        <button 
                                            type="button" 
                                            wire:click="previewSurat({{ $item->id }})"
                                            class="bg-warna-400 hover:bg-warna-400/80 active:scale-95 transition-all text-white px-4 py-2 rounded-lg cursor-pointer relative disabled:opacity-50 disabled:cursor-not-allowed"
                                            wire:loading.attr="disabled"
                                            wire:target="previewSurat({{ $item->id }})">
                                            <i class="fa-solid fa-eye"></i>
                                        </button>
                                        @if($item->status_pengajuan == 'disetujui' && $item->nomor_surat_terbitan)
                                            <button 
                                                type="button" 
                                                wire:click="downloadSurat({{ $item->id }})"
                                                class="bg-warna-500 hover:bg-warna-500/80 active:scale-95 transition-all text-white px-4 py-2 rounded-lg cursor-pointer relative disabled:opacity-50 disabled:cursor-not-allowed"
                                                wire:loading.attr="disabled"
                                                wire:target="downloadSurat({{ $item->id }})">
                                                <i class="fa-solid fa-download"></i>
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>

        <!-- Preview Modal -->
        @if($showPreviewModal && $suratPreview)
        <div class="fixed z-50 inset-0 flex items-center justify-center bg-warna-300/50">
            <x-modal class="relative flex flex-col items-center bg-white w-[90%] lg:w-[80%] px-5 md:px-10 lg:px-13 py-8">
                <i class="absolute -top-12 fa-solid fa-file-text text-warna-400 bg-white p-4 rounded-full text-6xl md:text-7xl xl:text-8xl"></i>
                <div class="w-full flex flex-col justify-center items-center">
                    <div class="flex flex-col items-center mt-5 lg:mt-7 xl:mt-14 mb-8 lg:mb-10">
                        <h2 class="text-lg md:text-xl xl:text-2xl text-center font-bold mb-1 md:mb-2">
                            Detail {{ $this->getJenisSuratReadable($suratPreview->jenis_surat) }}
                        </h2>
                        <p class="text-sm text-gray-600">Nomor: {{ $suratPreview->nomor_surat_terbitan ?? 'Belum ditetapkan' }}</p>
                    </div>

                    <div class="max-h-[45dvh] md:max-h-[55dvh] overflow-y-auto pr-2 w-full">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Data Pemohon -->
                            <div class="space-y-4">
                                <h3 class="text-lg font-semibold text-gray-800 border-b pb-2">Data Pemohon</h3>
                                
                                <div class="relative">
                                    <label class="absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 z-10 origin-[0] bg-white px-2">Nama Lengkap</label>
                                    <input type="text" class="block w-full px-3 py-2 md:py-3 border border-gray-300 rounded-md focus:outline-none sm:text-sm peer disabled:text-gray-500" 
                                           value="{{ $suratPreview->penduduk->nama_lengkap ?? 'Tidak diketahui' }}" disabled>
                                </div>

                                <div class="relative">
                                    <label class="absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 z-10 origin-[0] bg-white px-2">NIK</label>
                                    <input type="text" class="block w-full px-3 py-2 md:py-3 border border-gray-300 rounded-md focus:outline-none sm:text-sm peer disabled:text-gray-500" 
                                           value="{{ $suratPreview->penduduk->nik ?? '-' }}" disabled>
                                </div>

                                <div class="relative">
                                    <label class="absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 z-10 origin-[0] bg-white px-2">Telepon</label>
                                    <input type="text" class="block w-full px-3 py-2 md:py-3 border border-gray-300 rounded-md focus:outline-none sm:text-sm peer disabled:text-gray-500" 
                                           value="{{ $suratPreview->penduduk->telepon ?? '-' }}" disabled>
                                </div>

                                <div
                                id="laporanSuratMap"
                                class="w-full h-48 md:h-60 lg:h-72 rounded-md border border-gray-300"
                                wire:ignore
                                x-data
                                x-init="
                                  setTimeout(() => {
                                        if(window.leafletMap) window.leafletMap.remove();
                                        window.leafletMap = L.map('laporanSuratMap').setView([{{ $suratPreview->penduduk->latitude }}, {{ $suratPreview->penduduk->longitude }}], 15);
                                        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                                            attribution: '© OpenStreetMap contributors'
                                        }).addTo(window.leafletMap);
                                        L.marker([{{ $suratPreview->penduduk->latitude }}, {{ $suratPreview->penduduk->longitude }}]).addTo(window.leafletMap)
                                            .bindPopup('Lokasi Penduduk').openPopup();
                                    }, 300);
                                "   
                                ></div>

                                <div class="relative">
                                    <label class="absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 z-10 origin-[0] bg-white px-2">Alamat Sekarang</label>
                                    <textarea class="block w-full px-3 py-2 md:py-3 border border-gray-300 rounded-md focus:outline-none sm:text-sm peer disabled:text-gray-500" 
                                              rows="3" disabled>{{ $suratPreview->penduduk->alamat_sekarang ?? '-' }}</textarea>
                                </div>

                                <div class="relative">
                                    <label class="absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 z-10 origin-[0] bg-white px-2">Tanggal Kedatangan</label>
                                    <input type="text" class="block w-full px-3 py-2 md:py-3 border border-gray-300 rounded-md focus:outline-none sm:text-sm peer disabled:text-gray-500" 
                                           value="{{ $suratPreview->penduduk->tanggal_masuk ?? '-' }}" disabled>
                                </div>
                                <div class="relative">
                                    <label class="absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 z-10 origin-[0] bg-white px-2">Tanggal Kedatangan</label>
                                    <input type="text" class="block w-full px-3 py-2 md:py-3 border border-gray-300 rounded-md focus:outline-none sm:text-sm peer disabled:text-gray-500" 
                                           value="{{ $suratPreview->penanggungJawab->name ?? '-' }}" disabled>
                                </div>
                            </div>

                            <!-- Data Surat -->
                            <div class="space-y-4">
                                <h3 class="text-lg font-semibold text-gray-800 border-b pb-2">Data Surat</h3>
                                
                                <div class="relative">
                                    <label class="absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 z-10 origin-[0] bg-white px-2">Jenis Surat</label>
                                    <input type="text" class="block w-full px-3 py-2 md:py-3 border border-gray-300 rounded-md focus:outline-none sm:text-sm peer disabled:text-gray-500" 
                                           value="{{ str_replace('_', ' ', $suratPreview->jenis_surat) }}" disabled>
                                </div>

                                <div class="relative">
                                    <label class="absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 z-10 origin-[0] bg-white px-2">Keperluan</label>
                                    <textarea class="block w-full px-3 py-2 md:py-3 border border-gray-300 rounded-md focus:outline-none sm:text-sm peer disabled:text-gray-500" 
                                              rows="3" disabled>{{ $suratPreview->keperluan_surat ?? '-' }}</textarea>
                                </div>

                                <div class="relative">
                                    <label class="absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 z-10 origin-[0] bg-white px-2">Tanggal Pengajuan</label>
                                    <input type="text" class="block w-full px-3 py-2 md:py-3 border border-gray-300 rounded-md focus:outline-none sm:text-sm peer disabled:text-gray-500" 
                                           value="{{ $suratPreview->tanggal_pengajuan ? \Carbon\Carbon::parse($suratPreview->tanggal_pengajuan)->format('d F Y') : '-' }}" disabled>
                                </div>

                                <div class="relative">
                                    <label class="absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 z-10 origin-[0] bg-white px-2">Status</label>
                                    <input type="text" class="block w-full px-3 py-2 md:py-3 border border-gray-300 rounded-md focus:outline-none sm:text-sm peer disabled:text-gray-500" 
                                           value="{{ ucfirst($suratPreview->status_pengajuan) }}" disabled>
                                </div>

                                @if($suratPreview->tanggal_surat_diterbitkan)
                                <div class="relative">
                                    <label class="absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 z-10 origin-[0] bg-white px-2">Kepala Lingkungan Penyutuju</label>
                                    <input type="text" class="block w-full px-3 py-2 md:py-3 border border-gray-300 rounded-md focus:outline-none sm:text-sm peer disabled:text-gray-500" 
                                           value="{{ $suratPreview->kepalaLingkungan->name }}" disabled>
                                </div>
                                <div class="relative">
                                    <label class="absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 z-10 origin-[0] bg-white px-2">Tanggal Keputusan</label>
                                    <input type="text" class="block w-full px-3 py-2 md:py-3 border border-gray-300 rounded-md focus:outline-none sm:text-sm peer disabled:text-gray-500" 
                                           value="{{ \Carbon\Carbon::parse($suratPreview->tanggal_surat_diterbitkan)->format('d F Y') }}" disabled>
                                </div>
                                <div class="relative">
                                    <label class="absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 z-10 origin-[0] bg-white px-2">Batas Waktu Cetak (bagi penanggung jawab)</label>
                                    <input type="text" class="block w-full px-3 py-2 md:py-3 border border-gray-300 rounded-md focus:outline-none sm:text-sm peer disabled:text-gray-500" 
                                           value="{{ \Carbon\Carbon::parse($suratPreview->batas_waktu_cetak)->format('d F Y') }}" disabled>
                                </div>
                                <div class="relative">
                                    <label class="absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 z-10 origin-[0] bg-white px-2">Batas Jumlah Cetak (bagi penanggung jawab)</label>
                                    <input type="text" class="block w-full px-3 py-2 md:py-3 border border-gray-300 rounded-md focus:outline-none sm:text-sm peer disabled:text-gray-500" 
                                           value="{{ $suratPreview->maksimal_generate_pdf }}" disabled>
                                </div>
                                <div class="relative">
                                    <label class="absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 z-10 origin-[0] bg-white px-2">Tanggal Cetak Pertama</label>
                                    <input type="text" class="block w-full px-3 py-2 md:py-3 border border-gray-300 rounded-md focus:outline-none sm:text-sm peer disabled:text-gray-500" 
                                           value="{{ $suratPreview->tanggal_surat_dicetak_pertama ?? 'Belum pernah dicetak' }}" disabled>
                                </div>
                                @endif



                                @if($suratPreview->keterangan)
                                <div class="relative">
                                    <label class="absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 z-10 origin-[0] bg-white px-2">Keterangan</label>
                                    <textarea class="block w-full px-3 py-2 md:py-3 border border-gray-300 rounded-md focus:outline-none sm:text-sm peer disabled:text-gray-500" 
                                              rows="3" disabled>{{ $suratPreview->keterangan }}</textarea>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    <div class="flex justify-center md:justify-end w-full pt-6 gap-2">
                        @if($suratPreview->status == 'disetujui' && $suratPreview->nomor_surat)
                            <a type="button" wire:click="downloadSurat({{ $suratPreview->id }})" 
                                    class="bg-green-500 hover:bg-green-600 active:scale-95 transition-all text-white px-6 py-2 md:py-3 rounded-lg cursor-pointer">
                                <i class="fa-solid fa-download mr-2"></i>
                                Download Surat
                            </a>
                        @endif
                        <button type="button" wire:click="closePreviewModal" 
                                class="bg-gray-300 hover:bg-gray-400 active:scale-95 transition-all text-warna-300 px-6 py-2 md:py-3 rounded-lg cursor-pointer">
                            Tutup
                        </button>
                    </div>
                </div>
            </x-modal>     
        </div>
        @endif

        <!-- Loading Modal -->
        <div wire:loading wire:target="previewSurat" class="fixed z-50 inset-0 flex items-center justify-center bg-warna-300/50">
            <div class="relative top-1/2 transform -translate-y-1/2 bg-white rounded-lg p-8 flex flex-col items-center justify-center max-w-md mx-auto">
                <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-warna-400 mb-4"></div>
                <p class="text-warna-300 font-medium">Memuat data surat...</p>
            </div>
        </div>
    </div>
</div>