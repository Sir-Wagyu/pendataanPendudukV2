<div>
     <div class="bg-white shadow-md rounded-lg p-6 w-full pb-10">
        <h2 class="text-xl font-semibold mb-4">Ringkasan Cepat</h2>
        
        <div class="flex gap-4 lg:gap-6 w-full flex-col md:flex-row items-center flex-wrap mt-5">
            <!-- Penduduk Aktif -->
            <div class="w-full md:w-[45%] lg:w-[40%] xl:w-[25%] border-3 border-green-400 bg-green-400/8 rounded-xl py-3 px-4 flex flex-col lg:flex-row items-center text-center gap-3 lg:gap-5 group transition-all duration-300 active:scale-95 relative">
                <i class="fa-solid fa-user-check text-4xl text-green-400 bg-green-400/30 p-3 rounded-lg"></i>
                <div class="flex lg:flex-col items-center justify-center lg:items-start gap-3 lg:gap-1"> 
                    <p class="text-4xl font-semibold lg:order-2 text-green-400">{{ $totalPendudukAktif }}</p>
                    <p class="text-sm lg:text-base text-left font-semibold text-warna-300/50">Penduduk Pendatang Aktif</p>
                </div>
            </div>

            <!-- Penduduk Baru Bulan Ini -->
            <div class="w-full md:w-[45%] lg:w-[40%] xl:w-[25%] border-3 border-blue-400 bg-blue-400/8 rounded-xl py-3 px-4 flex flex-col lg:flex-row items-center text-center gap-3 lg:gap-5 group transition-all duration-300 active:scale-95 relative">
                <i class="fa-solid fa-user-plus text-4xl text-blue-400 bg-blue-400/30 p-3 rounded-lg"></i>
                <div class="flex lg:flex-col items-center justify-center lg:items-start gap-3 lg:gap-1"> 
                    <p class="text-4xl font-semibold lg:order-2 text-blue-400">{{ $pendudukBaruBulanIni }}</p>
                    <p class="text-sm lg:text-base text-left font-semibold text-warna-300/50">Penduduk Baru Bulan Ini</p>
                </div>
            </div>

            <!-- Penduduk Keluar Bulan Ini -->
            <div class="w-full md:w-[45%] lg:w-[40%] xl:w-[25%] border-3 border-red-400 bg-red-400/8 rounded-xl py-3 px-4 flex flex-col lg:flex-row items-center text-center gap-3 lg:gap-5 group transition-all duration-300 active:scale-95 relative">
                <i class="fa-solid fa-user-minus text-4xl text-red-400 bg-red-400/30 p-3 rounded-lg"></i>
                <div class="flex lg:flex-col items-center justify-center lg:items-start gap-3 lg:gap-1"> 
                    <p class="text-4xl font-semibold lg:order-2 text-red-400">{{ $pendudukKeluarBulanIni }}</p>
                    <p class="text-sm lg:text-base text-left font-semibold text-warna-300/50">Penduduk Keluar Bulan Ini</p>
                </div>
            </div>

            <!-- Penduduk Menunggu Verifikasi -->
            <div class="w-full md:w-[45%] lg:w-[40%] xl:w-[25%] border-3 border-yellow-400 bg-yellow-400/8 rounded-xl py-3 px-4 flex flex-col lg:flex-row items-center text-center gap-3 lg:gap-5 group transition-all duration-300 active:scale-95 relative">
                <i class="fa-solid fa-user-clock text-4xl text-yellow-400 bg-yellow-400/30 p-3 rounded-lg"></i>
                <div class="flex lg:flex-col items-center justify-center lg:items-start gap-3 lg:gap-1"> 
                    <p class="text-4xl font-semibold lg:order-2 text-yellow-400">{{ $pendudukMenungguVerifikasi }}</p>
                    <p class="text-sm lg:text-base text-left font-semibold text-warna-300/50">Menunggu Verifikasi</p>
                </div>
            </div>
        </div>

        <!-- Info Box Tambahan -->
        <div class="mt-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            <!-- Status Breakdown -->
            <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                <h3 class="text-sm font-semibold text-gray-700 mb-3">Status Verifikasi</h3>
                <div class="space-y-2">
                    <div class="flex justify-between items-center">
                        <span class="text-xs text-gray-600">Terverifikasi</span>
                        <span class="text-sm font-semibold text-green-600">{{ $totalPendudukAktif }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-xs text-gray-600">Menunggu</span>
                        <span class="text-sm font-semibold text-yellow-600">{{ $pendudukMenungguVerifikasi }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-xs text-gray-600">Ditolak</span>
                        <span class="text-sm font-semibold text-red-600">{{ $pendudukDitolak }}</span>
                    </div>
                </div>
            </div>

            <!-- Statistik Gender -->
            <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                <h3 class="text-sm font-semibold text-gray-700 mb-3">Berdasarkan Gender</h3>
                <div class="space-y-2">
                    <div class="flex justify-between items-center">
                        <span class="text-xs text-gray-600">Laki-laki</span>
                        <span class="text-sm font-semibold text-blue-600">{{ $totalLakilaki }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-xs text-gray-600">Perempuan</span>
                        <span class="text-sm font-semibold text-pink-600">{{ $totalPerempuan }}</span>
                    </div>
                </div>
            </div>

            
        </div>
    </div>
    <div class="bg-white shadow-md rounded-lg p-6 w-full mt-6 pb-10">
        <h2 class="text-xl font-semibold mb-8">Daftar Penduduk Pendatang</h2>
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
                        
                        <!-- Status Verifikasi Filter -->
                        <div class="mb-4">
                            <label for="filterStatus" class="block text-xs font-medium text-gray-700 mb-1">Status Verifikasi</label>
                            <select wire:model.live="filterStatus" id="filterStatus"
                                    class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-warna-400 focus:border-warna-400">
                                <option value="">Semua Status</option>
                                <option value="pending">Menunggu Verifikasi</option>
                                <option value="diterima">Terverifikasi</option>
                                <option value="ditolak">Ditolak</option>
                                <option value="ulangi">Ulangi Verifikasi</option>
                            </select>
                        </div>

                        <!-- Jenis Kelamin Filter -->
                        <div class="mb-4">
                            <label for="filterJenisKelamin" class="block text-xs font-medium text-gray-700 mb-1">Jenis Kelamin</label>
                            <select wire:model.live="filterJenisKelamin" id="filterJenisKelamin"
                                    class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-warna-400 focus:border-warna-400">
                                <option value="">Semua Jenis Kelamin</option>
                                <option value="laki-laki">Laki-laki</option>
                                <option value="perempuan">Perempuan</option>
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
                           placeholder="Cari berdasarkan NIK, nama, atau alamat..."
                           class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-warna-400 focus:border-warna-400 text-sm">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fa-solid fa-search text-gray-400"></i>
                    </div>
                </div>
            </div>

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
                        
                        <a href="{{ route('export.csv', ['search' => $search, 'filterStatus' => $filterStatus, 'filterJenisKelamin' => $filterJenisKelamin]) }}" 
                           class="flex items-center w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors duration-200 no-underline"
                           target="_blank">
                            <i class="fa-solid fa-file-csv mr-3 text-green-600"></i>
                            <div>
                                <div class="font-medium">Export CSV</div>
                                <div class="text-xs text-gray-500">Data lengkap dalam format CSV</div>
                            </div>
                        </a>
                        
                        <a href="{{ route('export.excel', ['search' => $search, 'filterStatus' => $filterStatus, 'filterJenisKelamin' => $filterJenisKelamin]) }}" 
                           class="flex items-center w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors duration-200 no-underline"
                           target="_blank">
                            <i class="fa-solid fa-file-excel mr-3 text-blue-600"></i>
                            <div>
                                <div class="font-medium">Export Excel</div>
                                <div class="text-xs text-gray-500">Laporan dengan format tabel</div>
                            </div>
                        </a>

                        <hr class="my-2">
                        
                        <div class="px-4 py-2 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            Laporan Khusus
                        </div>
                        
                        <a href="{{ route('export.summary') }}" 
                           class="flex items-center w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors duration-200 no-underline"
                           target="_blank">
                            <i class="fa-solid fa-chart-pie mr-3 text-orange-600"></i>
                            <div>
                                <div class="font-medium">Ringkasan Data</div>
                                <div class="text-xs text-gray-500">Statistik dan ringkasan</div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table
                class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400 border-collapse border border-gray-200 bg-warna-100">
                <thead class="text-xs text-warna-300 uppercase border-y-3 border-gray-200 ">
                    <tr>
                        <th scope="col" class="px-5 py-2 md:px-7 md:py-3  whitespace-nowrap    ">
                            No
                        </th>
                        <th scope="col" class="px-7 py-4  whitespace-nowrap  ">
                            NIK
                        </th>
                        <th scope="col" class="px-7 py-4  whitespace-nowrap  ">
                            Nama Lengkap
                        </th>
                        <th scope="col" class="px-7 py-4  whitespace-nowrap ">
                            Jenis Kelamin 
                        </th>
                        <th scope="col" class="px-7 py-4  whitespace-nowrap ">
                            Alamat Sekarang
                        </th>
                        <th scope="col" class="px-7 py-4  whitespace-nowrap ">
                            Tanggal Masuk
                        </th>
                        <th scope="col" class="px-7 py-4  whitespace-nowrap ">
                            Penanggung Jawab
                        </th>
                        <th scope="col" class="px-7 py-4  whitespace-nowrap ">
                            Status Verifikasi
                        </th>
                        <th scope="col" class="px-7 py-4  whitespace-nowrap ">
                            Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="text-sm text-gray-500 dark:text-gray-400">
                    <!-- Check if penduduk is empty -->
                   @if(empty($penduduk))
                        <tr>
                            <td colspan="9" class="text-center py-4">Tidak ada data yang ditemukan.</td>
                        </tr>
                    @else
                        @foreach($penduduk as $index => $item)
                            <tr class="border-b border-gray-200 text-warna-300 odd:bg-white even:bg-gray-100">
                                <td class="px-5 py-2 md:px-7 md:py-3">{{ $index + 1 }}</td>
                                <td class="px-7 py-4">{{ $item->nik }}</td>
                                <td class="px-7 py-4">{{ $item->nama_lengkap }}</td>
                                <td class="px-7 py-4">{{ $item->jenis_kelamin }}</td>
                                <td class="px-7 py-4">{{ $item->alamat_sekarang }}</td>
                                <td class="px-7 py-4">{{ $item->tanggal_masuk }}</td>
                                <td class="px-7 py-4">{{ $item->penanggungJawab->name ?? 'Tidak ada' }}</td>
                                <td class="px-7 py-4">
                                    @if($item->status_akun == 'ditolak' || $item->status_akun == 'ulangi')
                                        <div class="py-2 {{ $item->status_akun == 'ditolak' ? 'bg-warna-800' : 'bg-warna-700' }} rounded-full text-xs font-semibold">
                                            <p class="text-white font-semibold text-center">{{ $item->status_akun == 'ditolak' ? 'Ditolak' : 'Ulangi' }}</p>
                                        </div>
                                    @elseif($item->status_akun == 'diterima')
                                        <div class="py-2 bg-warna-500 rounded-full text-xs font-semibold">
                                            <p class="text-white font-semibold text-center">Disetujui</p>
                                        </div>
                                    @elseif($item->status_akun == 'pending')
                                        <div class="py-2 bg-warna-700 rounded-full text-xs font-semibold">
                                            <p class="text-white font-semibold text-center">Menunggu</p>
                                        </div>
                                    @else
                                        <div class="py-2 border-2 border-warna-800 rounded-full text-xs font-semibold">
                                            <p class="text-warna-800 font-semibold text-center">Pergi</p>
                                        </div>
                                    @endif
                                </td>
                                <td class="px-7 py-4">
                                    <div class="flex items-center gap-2">
                                        <button 
                                            type="button" 
                                            wire:click="previewPenduduk({{ $item->id }})"
                                            class="bg-warna-400 hover:bg-warna-400/80 active:scale-95 transition-all text-white px-4 py-2 rounded-lg cursor-pointer relative disabled:opacity-50 disabled:cursor-not-allowed"
                                            wire:loading.attr="disabled"
                                            wire:target="previewPenduduk({{ $item->id }})">
                                            
                                            <!-- Icon normal -->
                                            <i class="fa-solid fa-eye"></i>
                                            
                                        </button>
                                        <div id="tooltip-preview-{{ $item->id }}" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-xs font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-xs opacity-0 tooltip dark:bg-gray-700">
                                            <p>Lihat Detail Penduduk</p>
                                            <div class="tooltip-arrow" data-popper-arrow></div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>

        {{-- detail modal --}}
        @if($showPreviewModal)
        
        <div class="fixed z-50 inset-0 flex items-center justify-center bg-warna-300/50 ">
            <x-modal class="relative flex flex-col items-center bg-white w-[90%] lg:w-[80%] px-5 md:px-10 lg:px-13 py-8 ">
                <i class="absolute -top-12 fa-solid fa-circle-user text-warna-400 bg-white p-4 rounded-full  text-6xl md:text-7xl xl:text-8xl"></i>
                <div class="w-full flex flex-col justify-center items-center">
                    <div class="flex flex-col items-center mt-5 lg:mt-7 xl:mt-14 mb-8 lg:mb-10 ">
                        <h2 class="text-lg md:text-xl xl:text-2xl text-center font-bold mb-1 md:mb-2">Data Penduduk Atas Nama  {{ $pendudukPreview->nama_lengkap }}</h2>
                    </div>

                    <div class="max-h-[45dvh] md:max-h-[55dvh] overflow-y-auto pr-2 w-full">
                        <div class="flex flex-col justify-center md:flex-row gap-7 md:gap-3 lg:gap-8 w-full">
                            <div class="w-full md:w-1/2 xl:w-1/3">
                                <div class="flex items-center justify-between mb-2">
                                    <label for="foto_ktp" class="block text-sm font-medium text-gray-700">Foto KTP</label>
                                </div>
                                <div 
                                    class="flex items-center justify-center border-2 border-dashed border-gray-300 rounded-lg bg-gray-200 hover:bg-gray-300 transition cursor-pointer aspect-video overflow-hidden"
                                >
                                    
                                        <button type="button" wire:click="$set('isPreviewKtpOpen', true)" class="w-max h-full flex items-center justify-center">
                                            <img src="{{ asset('storage/' . $pendudukPreview->foto_ktp) }}" alt="Preview Foto KTP" class="w-full h-full rounded shadow object-cover" />
                                        </button>

                                    @if($isPreviewKtpOpen)
                                        <div class="fixed inset-0 z-[999] flex items-center justify-center bg-black/50">
                                            <div class="bg-white rounded-lg shadow-lg p-3 md:p-6 relative max-w-2xl w-[90%] md:w-full">
                                                <button type="button" wire:click="$set('isPreviewKtpOpen', false)" class="absolute top-2 right-2 text-gray-500 hover:text-gray-700 text-3xl">&times;</button>
                                                <img src="{{ asset('storage/' . $pendudukPreview->foto_ktp) }}" alt="Preview Foto KTP" class="max-h-126 w-auto mx-auto rounded shadow" />
                                            </div>
                                        </div>
                                    @endif
                    
                                </div>
                            </div>
                            <div class="w-full md:w-1/2 xl:w-1/3">
                                <div class="flex items-center justify-between mb-2">
                                    <label for="foto_ktp" class="block text-sm font-medium text-gray-700">Foto Selfie KTP</label>
                                </div>
                                <div 
                                    class="flex items-center justify-center border-2 border-dashed border-gray-300 rounded-lg bg-gray-200 hover:bg-gray-300 transition cursor-pointer aspect-video overflow-hidden"
                                >

                                        <button type="button" wire:click="$set('isPreviewKtpSelfieOpen', true)" class="w-max h-full flex items-center justify-center">
                                            <img src="{{ asset('storage/' . $pendudukPreview->foto_selfie_ktp) }}" alt="Preview Foto Selfie KTP" class="w-full h-full rounded shadow object-cover" />
                                        </button>

                                    @if($isPreviewKtpSelfieOpen)
                                        <div class="fixed inset-0 z-[999] flex items-center justify-center bg-black/50">
                                            <div class="bg-white rounded-lg shadow-lg p-3 md:p-6 relative max-w-2xl w-[90%] md:w-full">
                                                <button type="button" wire:click="$set('isPreviewKtpSelfieOpen', false)" class="absolute top-2 right-2 text-gray-500 hover:text-gray-700 text-3xl">&times;</button>
                                                <img src="{{ asset('storage/' . $pendudukPreview->foto_selfie_ktp) }}" alt="Preview Foto Selfie KTP" class="max-h-126 w-auto mx-auto rounded shadow" />
                                            </div>
                                        </div>
                                    @endif
                    
                                </div>
                            </div>

                            
                        </div>

                        <div class="mt-10 md:mt-12 mb-10 md:mb-12 w-full">
                            <label class="block text-sm lg:text-base font-semibold text-gray-700 mb-4 md:mb-6">Data Diri Penduduk</label>

                            <div class="w-full flex flex-col lg:flex-row lg:gap-6">
                                <div class="w-full lg:w-1/2">
                                    

                                    <div class="relative mt-5 md:mt-6">
                                        <label class="absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-warna-400 peer-focus:dark:text-indigo-400 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 left-3">NIK</label>
                                        <input type="text" 
                                            class="block w-full px-3 py-2 md:py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-warna-400 focus:border-warna-400 sm:text-sm  peer disabled:text-gray-500"
                                            value="{{ $pendudukPreview->nik ?? '-' }}" disabled>
                                    </div>
                                    <div class="relative mt-5 md:mt-6">
                                        <label class="absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-warna-400 peer-focus:dark:text-indigo-400 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 left-3">Nama Lengkap</label>
                                        <input type="text" 
                                            class="block w-full px-3 py-2 md:py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-warna-400 focus:border-warna-400 sm:text-sm  peer disabled:text-gray-500"
                                            value="{{ $pendudukPreview->nama_lengkap ?? '-' }}" disabled>
                                    </div>
                                    <div class="relative mt-5 md:mt-6">
                                        <label class="absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-warna-400 peer-focus:dark:text-indigo-400 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 left-3">Telepon</label>
                                        <input type="text" 
                                            class="block w-full px-3 py-2 md:py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-warna-400 focus:border-warna-400 sm:text-sm  peer disabled:text-gray-500"
                                            value="{{ $pendudukPreview->telepon ?? '-' }}" disabled>
                                    </div>
                                    <div class="w-full flex gap-4">
                                        <div class="relative mt-5 md:mt-6 w-1/2">
                                            <label class="absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-warna-400 peer-focus:dark:text-indigo-400 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 left-3">Tempat Lahir</label>
                                            <input type="text" 
                                                class="block w-full px-3 py-2 md:py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-warna-400 focus:border-warna-400 sm:text-sm  peer disabled:text-gray-500"
                                                value="{{ $pendudukPreview->tempat_lahir ?? '-' }}" disabled>
                                        </div>
                                        <div class="relative mt-5 md:mt-6 w-1/2">
                                            <label class="absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-warna-400 peer-focus:dark:text-indigo-400 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 left-3">Tanggal Lahir</label>
                                            <input type="date" 
                                                class="block w-full px-3 py-2 md:py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-warna-400 focus:border-warna-400 sm:text-sm  peer disabled:text-gray-500"
                                                value="{{ $pendudukPreview->tanggal_lahir ?? '-' }}" disabled>
                                        </div>
                                        
                                    </div>

                                    <div class="relative mt-5 md:mt-6">
                                        <label class="absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-warna-400 peer-focus:dark:text-indigo-400 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 left-3">Jenis Kelamin</label>
                                        <select class="block w-full px-3 py-2 md:py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-warna-400 focus:border-warna-400 sm:text-sm  peer disabled:text-gray-500" disabled>
                                            <option value="">Pilih Jenis Kelamin</option>
                                            <option value="Laki-laki" {{ ($pendudukPreview->jenis_kelamin ?? '') == 'laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                            <option value="Perempuan" {{ ($pendudukPreview->jenis_kelamin ?? '') == 'perempuan' ? 'selected' : '' }}>Perempuan</option>
                                        </select>
                                        
                                    </div>
                                    
                                    <div class="relative mt-5 md:mt-6">
                                        <label class="absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-warna-400 peer-focus:dark:text-indigo-400 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 left-3">Golongan Darah</label>
                                        <select class="block w-full px-3 py-2 md:py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-warna-400 focus:border-warna-400 sm:text-sm  peer disabled:text-gray-500" disabled>
                                            <option value="">Pilih Golongan Darah</option>
                                            <option value="A" {{ ($pendudukPreview->golongan_darah ?? '') == 'A' ? 'selected' : '' }}>A</option>
                                            <option value="B" {{ ($pendudukPreview->golongan_darah ?? '') == 'B' ? 'selected' : '' }}>B</option>
                                            <option value="AB" {{ ($pendudukPreview->golongan_darah ?? '') == 'AB' ? 'selected' : '' }}>AB</option>
                                            <option value="O" {{ ($pendudukPreview->golongan_darah ?? '') == 'O' ? 'selected' : '' }}>O</option>
                                        </select>
                                    </div>
                                    <div class="relative mt-5 md:mt-6">
                                        <label class="absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-warna-400 peer-focus:dark:text-indigo-400 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 left-3">Agama</label>
                                        <input type="text" 
                                            class="block w-full px-3 py-2 md:py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-warna-400 focus:border-warna-400 sm:text-sm  peer disabled:text-gray-500"
                                            value="{{ $pendudukPreview->agama ?? '-' }}" disabled>
                                    </div>
                                    <div class="relative mt-5 md:mt-6">
                                        <label class="absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-warna-400 peer-focus:dark:text-indigo-400 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 left-3">Status Perkawinan</label>
                                        <select class="block w-full px-3 py-2 md:py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-warna-400 focus:border-warna-400 sm:text-sm  peer disabled:text-gray-500" disabled>
                                            <option value="">Pilih Status Perkawinan</option>
                                            <option value="kawin" {{ ($pendudukPreview->status_perkawinan ?? '') == 'kawin' ? 'selected' : '' }}>Kawin</option>
                                            <option value="belum_kawin" {{ ($pendudukPreview->status_perkawinan ?? '') == 'belum_kawin' ? 'selected' : '' }}>Belum Kawin</option>
                                            <option value="cerai" {{ ($pendudukPreview->status_perkawinan ?? '') == 'cerai' ? 'selected' : '' }}>Cerai</option>
                                        </select>
                                    </div>
                                    <div class="relative mt-5 md:mt-6">
                                        <label class="absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-warna-400 peer-focus:dark:text-indigo-400 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 left-3">Provinsi Asal</label>
                                        <select class="block w-full px-3 py-2 md:py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-warna-400 focus:border-warna-400 sm:text-sm  peer disabled:text-gray-500" disabled>
                                            <option value="">Pilih Provinsi Asal</option>
                                            @foreach($provinsiNames as $key => $value)
                                                <option value="{{ $key }}" {{ ($pendudukPreview->provinsi_asal ?? '') == $key ? 'selected' : '' }}>{{ $value }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="relative mt-5 md:mt-6">
                                        <label class="absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-warna-400 peer-focus:dark:text-indigo-400 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 left-3">Kabupaten Asal</label>
                                        <select class="block w-full px-3 py-2 md:py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-warna-400 focus:border-warna-400 sm:text-sm  peer disabled:text-gray-500" disabled>
                                            <option value="">Pilih Kabupaten Asal</option>
                                            @foreach($kabupatenNames as $key => $value)
                                                <option value="{{ $key }}" {{ ($pendudukPreview->kabupaten_asal ?? '') == $key ? 'selected' : '' }}>{{ $value }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="relative mt-5 md:mt-6">
                                        <label class="absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-warna-400 peer-focus:dark:text-indigo-400 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 left-3">Kecamatan Asal</label>
                                        <select class="block w-full px-3 py-2 md:py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-warna-400 focus:border-warna-400 sm:text-sm  peer disabled:text-gray-500" disabled>
                                            <option value="">Pilih Kecamatan Asal</option>
                                            @foreach($kecamatanNames as $key => $value)
                                                <option value="{{ $key }}" {{ ($pendudukPreview->kecamatan_asal ?? '') == $key ? 'selected' : '' }}>{{ $value }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="relative mt-5 md:mt-6">
                                        <label class="absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-warna-400 peer-focus:dark:text-indigo-400 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 left-3">Kelurahan Asal</label>
                                        <select class="block w-full px-3 py-2 md:py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-warna-400 focus:border-warna-400 sm:text-sm  peer disabled:text-gray-500" disabled>
                                            <option value="">Pilih Kelurahan Asal</option>
                                            @foreach($kelurahanNames as $key => $value)
                                                <option value="{{ $key }}" {{ ($pendudukPreview->kelurahan_asal ?? '') == $key ? 'selected' : '' }}>{{ $value }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="w-full flex gap-5">
                                        <div class="relative mt-5 md:mt-6 w-1/2">
                                            <label class="absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-warna-400 peer-focus:dark:text-indigo-400 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 left-3">RT</label>
                                            <input type="number" 
                                                class="block w-full px-3 py-2 md:py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-warna-400 focus:border-warna-400 sm:text-sm  peer disabled:text-gray-500"
                                                value="{{ $pendudukPreview->rt_asal ?? '-' }}" disabled>
                                        </div>
                                        <div class="relative mt-5 md:mt-6 w-1/2">
                                            <label class="absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-warna-400 peer-focus:dark:text-indigo-400 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 left-3">RW</label>
                                            <input type="number" 
                                                class="block w-full px-3 py-2 md:py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-warna-400 focus:border-warna-400 sm:text-sm  peer disabled:text-gray-500"
                                                value="{{ $pendudukPreview->rw_asal ?? '-' }}" disabled>
                                        </div>
                                    </div>
                                    <div class="relative mt-5 md:mt-6 ">
                                            <label class="absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-warna-400 peer-focus:dark:text-indigo-400 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 left-3">Alamat Asal</label>
                                            <input type="text" 
                                                class="block w-full px-3 py-2 md:py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-warna-400 focus:border-warna-400 sm:text-sm  peer disabled:text-gray-500"
                                                value="{{ $pendudukPreview->alamat_asal ?? '-' }}" disabled>
                                        </div>
                                </div>
                                <div class="w-full lg:w-1/2">
                                        @if($pendudukPreview && $pendudukPreview->latitude && $pendudukPreview->longitude)
                                        <div 
                                            id="map3" 
                                            style="height: 300px; width: 100%;" 
                                            class="my-4 rounded shadow"
                                            wire:ignore
                                            x-data
                                            x-init="
                                                setTimeout(() => {
                                                    if(window.leafletMap) window.leafletMap.remove();
                                                    window.leafletMap = L.map('map3').setView([{{ $pendudukPreview->latitude }}, {{ $pendudukPreview->longitude }}], 15);
                                                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                                                        attribution: '© OpenStreetMap contributors'
                                                    }).addTo(window.leafletMap);
                                                    L.marker([{{ $pendudukPreview->latitude }}, {{ $pendudukPreview->longitude }}]).addTo(window.leafletMap)
                                                        .bindPopup('Lokasi Penduduk').openPopup();
                                                }, 300);
                                            "
                                        ></div>
                                    @else
                                        <div class="text-gray-500 my-4">Koordinat belum tersedia.</div>
                                    @endif
                                    <div class="w-full flex gap-4">
                                        <div class="relative mt-5 md:mt-6 w-1/2">
                                            <label class="absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-warna-400 peer-focus:dark:text-indigo-400 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 left-3">Longitude</label>
                                            <input type="text" 
                                                class="block w-full px-3 py-2 md:py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-warna-400 focus:border-warna-400 sm:text-sm  peer disabled:text-gray-500"
                                                value="{{ $pendudukPreview->longitude ?? '-' }}" disabled>
                                        </div>
                                        <div class="relative mt-5 md:mt-6 w-1/2">
                                            <label class="absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-warna-400 peer-focus:dark:text-indigo-400 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 left-3">Latitude</label>
                                            <input type="text" 
                                                class="block w-full px-3 py-2 md:py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-warna-400 focus:border-warna-400 sm:text-sm  peer disabled:text-gray-500"
                                                value="{{ $pendudukPreview->latitude ?? '-' }}" disabled>
                                        </div> 
                                    </div>
                                    <div class="relative mt-5 md:mt-6">
                                        <textarea name="" id="" class="block w-full px-3 py-2 md:py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-warna-400 focus:border-warna-400 sm:text-sm peer disabled:text-gray-500" rows="3" disabled>{{ $pendudukPreview->alamat_sekarang ?? '-' }}</textarea>
                                        <label class="absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-warna-400 peer-focus:dark:text-indigo-400 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 left-3">Domisili</label>
                                    </div>
                                    <div class="relative mt-5 md:mt-6">
                                        <textarea name="" id="" class="block w-full px-3 py-2 md:py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-warna-400 focus:border-warna-400 sm:text-sm peer disabled:text-gray-500" rows="3" disabled>{{ $pendudukPreview->tujuan ?? '-' }}</textarea>
                                        <label class="absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-warna-400 peer-focus:dark:text-indigo-400 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 left-3">Tujuan kedatangan</label>
                                    </div>
                                    <div class="relative mt-5 md:mt-6">
                                        <label class="absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-warna-400 peer-focus:dark:text-indigo-400 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 left-3">Tanggal Kedatangan</label>
                                        <input type="date" 
                                            class="block w-full px-3 py-2 md:py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-warna-400 focus:border-warna-400 sm:text-sm  peer disabled:text-gray-500"
                                            value="{{ $pendudukPreview->tanggal_masuk ?? '-' }}" disabled>
                                    </div>
                                    
                                    <x-g-input
                                        type="text" 
                                        class="mt-5 md:mt-6 disabled:text-gray-500"
                                        label="Kepala Lingkungan"
                                        value="{{ $pendudukPreview->kepalaLingkungan->name ?? '-' }}" disabled />
                                    
                                </div>

                                
                            </div>
                        </div>
                    </div>
                    
                    
                    <div class="flex justify-center md:justify-end w-full pt-6">
                        <button type="button" wire:click="closePreviewModal" class="mr-2 bg-gray-300 hover:bg-gray-300/90 active:scale-95 transition-all text-warna-300 w-full md:w-1/4   px-7 py-2 md:py-3 rounded-lg cursor-pointer">Tutup</button>
                    </div>
                </div>
            </x-modal>     
        </div>
        @endif

        {{-- loading modal --}}

        <div wire:loading wire:target="previewPenduduk" class="fixed z-50 inset-0 flex items-center justify-center bg-warna-300/50">
            <div class="relative top-1/2 transform -translate-y-1/2 bg-white rounded-lg p-8 flex flex-col items-center justify-center max-w-md mx-auto">
                <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-warna-400 mb-4"></div>
                <p class="text-warna-300 font-medium">Memuat data penduduk...</p>
            </div>
        </div>
f
    </div>
</div>
