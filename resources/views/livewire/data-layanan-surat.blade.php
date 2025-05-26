<div>
    @if(Auth::user()->role == 'kepalaLingkungan')
    <div>
        <div class="w-full flex justify-between items-center py-3  mb-4">
            <h2 class="font-semibold text-xl text-warna-300 leading-tight">
                Verifikasi Pengajuan Surat
            </h2>
        </div>

        <div class="mb-4 flex justify-between items-center">
            <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari..." class="px-4 py-2 border border-gray-300 rounded-lg">
        </div>

        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table
                class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400 border-collapse border border-gray-200 bg-warna-100">
                <thead class="text-xs text-warna-300 uppercase border-y-3 border-gray-200 ">
                    <tr>
                        <th scope="col" class="px-5 py-2 md:px-10 md:py-3  whitespace-nowrap    ">
                            No
                        </th>
                        <th scope="col" class="px-10 py-4  whitespace-nowrap  ">
                            Nama Lengkap
                        </th>
                        <th scope="col" class="px-10 py-4  whitespace-nowrap  ">
                            NIK
                        </th>
                        <th scope="col" class="px-10 py-4  whitespace-nowrap ">
                            Jenis Surat 
                        </th>
                        <th scope="col" class="px-10 py-4  whitespace-nowrap ">
                            Alasan Pengajuan
                        </th>
                        <th scope="col" class="px-10 py-4  whitespace-nowrap ">
                            Tanggal Pengajuan
                        </th>
                       
                        <th scope="col" class="px-10 py-4  whitespace-nowrap ">
                            Aksi
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @if($suratVerifikasi->isEmpty())
                        <tr>
                            <td colspan="7" class="text-center py-6 text-gray-500">Tidak ada pengajuan surat untuk disetujui.</td>
                        </tr>
                    @else
                        @foreach ($suratVerifikasi as $suratV)
                            <tr class="border-t-2 bg-white border-b text-warna-300 border-gray-200 xxl:hover:bg-gray-100">
                                <td class="px-5 py-2 md:px-10 md:py-3 whitespace-nowrap">
                                    {{ $loop->iteration }}
                                </td>
                                <td class="px-10 py-4 whitespace-nowrap">
                                    {{ $suratV->nama_lengkap }}
                                </td>
                                <td class="px-10 py-4 whitespace-nowrap">
                                    {{ $suratV->nik }}
                                </td>
                                <td class="px-10 py-4 whitespace-nowrap capitalize">
                                    {{ str_replace('_', ' ', $suratV->jenis_surat) }}
                                </td>
                                <td class="px-10 py-4 whitespace-nowrap">
                                    @if( $suratV->keperluan_surat )
                                        <button type="button" wire:click="openCatatanPengajuanModal({{ $suratV->id }})"  class="flex items-center justify-center px-4 py-2 bg-warna-100 hover:bg-warna-400 hover:text-white active:scale-95 transition-all border-2 border-warna-400 rounded-xl font-medium ">
                                            <p>Lihat Pesan</p>
                                        </button>
                                       
                                    @endif
                                </td>
                                <td class="px-10 py-4 whitespace-nowrap">
                                    {{ $suratV->tanggal_pengajuan }}
                                </td>
                                
                                <td class="px-10 py-4 whitespace-nowrap">
                                    
                                        <button 
                                            data-tooltip-target='tooltip-setujui-{{ $suratV->id }}' 
                                            data-tooltip-placement="bottom" 
                                            type="button"
                                            wire:click="openSetujuiModal({{ $suratV->id }})" 
                                            class="bg-warna-500 hover:bg-warna-500/80 active:scale-95 transition-all text-white px-4 py-2 rounded-lg cursor-pointer ml-1">
                                            <i class="fa-solid fa-check"></i>
                                        </button>
                                    
                                        <button 
                                            data-tooltip-target='tooltip-tolak-{{ $suratV->id }}' 
                                            data-tooltip-placement="bottom" 
                                            type="button"
                                            wire:click="openTolakModal({{ $suratV->id }})" 
                                            class="bg-warna-800 hover:bg-warna-800/80 active:scale-95 transition-all text-white px-4 py-2 rounded-lg cursor-pointer ml-1">
                                            <i class="fa-solid fa-xmark"></i>
                                        </button>
                                </td>

                                <div id="tooltip-setujui-{{ $suratV->id }}" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-xs font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-xs opacity-0 tooltip dark:bg-gray-700">
                                    <p>Setujui pengajuan</p>
                                    <div class="tooltip-arrow" data-popper-arrow></div>
                                </div>
                                <div id="tooltip-tolak-{{ $suratV->id }}" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-xs font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-xs opacity-0 tooltip dark:bg-gray-700">
                                    <p>Tolak pengajuan</p>
                                    <div class="tooltip-arrow" data-popper-arrow></div>
                                </div>
                            </tr>
                            
                        @endforeach
                    @endif
                </tbody>
            </table>
            
        </div>
    </div>
    @endif

    <!-- full data preview -->
    <div class="mt-20">
        <div class="w-full flex justify-between items-center py-3  mb-4">
            <h2 class="font-semibold text-xl text-warna-300 leading-tight">
                Data Pengajuan Surat
            </h2>
        </div>

        <div class="mb-4 flex justify-between items-center">
            <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari..." class="px-4 py-2 border border-gray-300 rounded-lg">
        </div>

        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            
            @if(auth()->user()->role == 'penanggungJawab')
                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400 border-collapse border border-gray-200 bg-warna-100">
                    <thead class="text-xs text-warna-300 uppercase border-y-3 border-gray-200 ">
                        <tr>
                            <th class="px-5 py-2 md:px-10 md:py-3 whitespace-nowrap">No</th>
                            <th class="px-10 py-4 whitespace-nowrap">Status</th>
                            <th class="px-10 py-4 whitespace-nowrap">Nama Lengkap</th>
                            <th class="px-10 py-4 whitespace-nowrap">NIK</th>
                            <th class="px-10 py-4 whitespace-nowrap">Jenis Surat</th>
                            <th class="px-10 py-4 whitespace-nowrap">Tanggal Pengajuan</th>
                            <th class="px-10 py-4 whitespace-nowrap">Batas Waktu Cetak</th>
                            <th class="px-10 py-4 whitespace-nowrap">Catatan Kapling</th>
                            <th class="px-10 py-4 whitespace-nowrap">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($surat->isEmpty())
                            <tr>
                                <td colspan="9" class="text-center py-6 text-gray-500">Tidak ada data pengajuan surat.</td>
                            </tr>
                        @else
                            @foreach ($surat as $surat)
                                <tr class="border-t-2 bg-white border-b text-warna-300 border-gray-200 xxl:hover:bg-gray-100">
                                    <td class="px-5 py-2 md:px-10 md:py-3 whitespace-nowrap">{{ $loop->iteration }}</td>
                                    <td class="px-10 py-4 whitespace-nowrap">
                                        @if($surat->status_pengajuan == 'diajukan')
                                            <div class="p-2 bg-warna-700 rounded-full text-xs font-semibold">
                                                <p class="text-white font-semibold text-center">Diproses</p>
                                            </div>
                                        @elseif($surat->status_pengajuan == 'ditolak')
                                            <div class="p-2 bg-warna-800 rounded-full text-xs font-semibold">
                                                <p class="text-white font-semibold text-center">Ditolak</p>
                                            </div>
                                        @elseif($surat->status_pengajuan == 'disetujui')
                                            <div class="p-2 bg-warna-500 rounded-full text-xs font-semibold">
                                                <p class="text-white font-semibold text-center">Disetujui</p>
                                            </div>
                                        @elseif($surat->status_pengajuan == 'selesai')
                                            <div class="p-2 border-2 border-warna-600 rounded-full text-xs font-semibold">
                                                <p class="text-white font-semibold text-center">Selesai</p>
                                            </div>
                                        @else
                                            <div class="p-2 border-2 border-warna-300 rounded-full text-xs font-semibold">
                                                <p class="text-white font-semibold text-center">Tidak Diketahui</p>
                                            </div>
                                        @endif
                                    </td>
                                    <td class="px-10 py-4 whitespace-nowrap">{{ $surat->nama_lengkap }}</td>
                                    <td class="px-10 py-4 whitespace-nowrap">{{ $surat->nik }}</td>
                                    <td class="px-10 py-4 whitespace-nowrap capitalize">{{ str_replace('_', ' ', $surat->jenis_surat) }}</td>
                                    <td class="px-10 py-4 whitespace-nowrap">{{ $surat->tanggal_pengajuan }}</td>
                                    
                                    <td class="px-10 py-4 whitespace-nowrap">
                                        {{ $surat->cetak_sebelum_tanggal ?? '-' }}
                                    </td>
                                    <td class="px-10 py-4 whitespace-nowrap">
                                        {{ $surat->catatan_kepalaLingkungan ?? 'Tidak ada catatan' }}
                                    </td>
                                    <td class="px-10 py-4 whitespace-nowrap">
                                        <button 
                                            data-tooltip-target='tooltip-view-{{ $surat->id }}' 
                                            data-tooltip-placement="bottom" 
                                            type="button"
                                            wire:click="openViewDetailModal({{ $surat->id }})"
                                            class="bg-warna-400 hover:bg-warna-400/80 active:scale-95 transition-all text-white px-4 py-2 rounded-lg cursor-pointer ml-1">
                                            <i class="fa-solid fa-eye"></i>
                                        </button>
                                        
                                        {{-- Aksi sesuai kebutuhan --}}
                                        @if($surat->status_pengajuan == 'disetujui')
                                            @if($surat->cetak_sebelum_tanggal && \Carbon\Carbon::now()->gt(\Carbon\Carbon::parse($surat->cetak_sebelum_tanggal)))
                                                <button 
                                                    data-tooltip-target='tooltip-cetak-{{ $surat->id }}' 
                                                    data-tooltip-placement="bottom" 
                                                    type="button"
                                                    class="bg-gray-300 text-gray-400 px-4 py-2 rounded-lg cursor-not-allowed ml-1"
                                                    disabled
                                                >
                                                    <i class="fa-solid fa-print"></i>
                                                </button>
                                            @else
                                                <button 
                                                    data-tooltip-target='tooltip-cetak-{{ $surat->id }}' 
                                                    data-tooltip-placement="bottom" 
                                                    type="button"
                                                    wire:click="cetakSurat({{ $surat->id }})" 
                                                    class="bg-warna-500 hover:bg-warna-500/80 active:scale-95 transition-all text-white px-4 py-2 rounded-lg cursor-pointer ml-1">
                                                    <i class="fa-solid fa-print"></i>
                                                </button>
                                            @endif
                                        @elseif($surat->status_pengajuan == 'diajukan')
                                            <button 
                                                data-tooltip-target='tooltip-batal-{{ $surat->id }}' 
                                                data-tooltip-placement="bottom" 
                                                type="button"
                                                wire:click="openCatatanPengajuanModal({{ $surat->id }})" 
                                                class="bg-warna-800 hover:bg-warna-800/80 active:scale-95 transition-all text-white px-4 py-2 rounded-lg cursor-pointer ml-1">
                                                <i class="fa-solid fa-xmark"></i>
                                            </button>
                                        @endif
                                    </td>
                                    <div id="tooltip-batal-{{ $surat->id }}" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-xs font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-xs opacity-0 tooltip dark:bg-gray-700">
                                        <p>Batalkan pengajuan</p>
                                        <div class="tooltip-arrow" data-popper-arrow></div>
                                    </div>
                                    <div id="tooltip-cetak-{{ $surat->id }}" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-xs font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-xs opacity-0 tooltip dark:bg-gray-700">
                                        <p>Cetak Surat</p>
                                        <div class="tooltip-arrow" data-popper-arrow></div>
                                    </div>
                                    <div id="tooltip-view-{{ $surat->id }}" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-xs font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-xs opacity-0 tooltip dark:bg-gray-700">
                                        <p>Lihat Detail Pengajuan</p>
                                        <div class="tooltip-arrow" data-popper-arrow></div>
                                    </div>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            @elseif(auth()->user()->role == 'kepalaLingkungan' || auth()->user()->role == 'admin')
                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400 border-collapse border border-gray-200 bg-warna-100">
                    <thead class="text-xs text-warna-300 uppercase border-y-3 border-gray-200 ">
                        <tr>
                            <th class="px-5 py-2 md:px-10 md:py-3 whitespace-nowrap">No</th>
                            <th class="px-10 py-4 whitespace-nowrap">Nama Lengkap</th>
                            <th class="px-10 py-4 whitespace-nowrap">NIK</th>
                            <th class="px-10 py-4 whitespace-nowrap">Jenis Surat</th>
                            <th class="px-10 py-4 whitespace-nowrap">Nomor Surat</th>
                            <th class="px-10 py-4 whitespace-nowrap">Tanggal Pengajuan</th>
                            <th class="px-10 py-4 whitespace-nowrap">Status</th>
                            <th class="px-10 py-4 whitespace-nowrap">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($surat->isEmpty())
                            <tr>
                                <td colspan="8" class="text-center py-6 text-gray-500">Data tidak tersedia</td>
                            </tr>
                        @else
                            @foreach ($surat as $surat)
                                <tr class="border-t-2 bg-white border-b text-warna-300 border-gray-200 xxl:hover:bg-gray-100">
                                    <td class="px-5 py-2 md:px-10 md:py-3 whitespace-nowrap">{{ $loop->iteration }}</td>
                                    <td class="px-10 py-4 whitespace-nowrap">{{ $surat->nama_lengkap }}</td>
                                    <td class="px-10 py-4 whitespace-nowrap">{{ $surat->nik }}</td>
                                    <td class="px-10 py-4 whitespace-nowrap capitalize">{{ str_replace('_', ' ', $surat->jenis_surat) }}</td>
                                    <td class="px-10 py-4 whitespace-nowrap">{{ $surat->nomor_surat_terbitan ?? 'Surat belum disetujui.' }}</td>
                                    <td class="px-10 py-4 whitespace-nowrap">{{ $surat->tanggal_pengajuan }}</td>
                                    <td class="px-10 py-4 whitespace-nowrap">
                                        @if($surat->status_pengajuan == 'diajukan')
                                            <div class="px-4 py-2 bg-warna-700 rounded-full text-xs font-semibold">
                                                <p class="text-white font-semibold text-center">Diproses</p>
                                            </div>
                                        @elseif($surat->status_pengajuan == 'ditolak')
                                            <div class="px-4 py-2 bg-warna-800 rounded-full text-xs font-semibold">
                                                <p class="text-white font-semibold text-center">Ditolak</p>
                                            </div>
                                        @elseif($surat->status_pengajuan == 'disetujui')
                                            <div class="px-4 py-2 bg-warna-500 rounded-full text-xs font-semibold">
                                                <p class="text-white font-semibold text-center">Disetujui</p>
                                            </div>
                                        @elseif($surat->status_pengajuan == 'selesai')
                                            <div class="px-4 py-2 border-2 border-warna-500 rounded-full text-xs font-semibold">
                                                <p class="text-warna-500 font-semibold text-center">Selesai</p>
                                            </div>
                                        @else
                                            <div class="px-4 py-2 border-2 border-warna-300 rounded-full text-xs font-semibold">
                                                <p class="text-white font-semibold text-center">Tidak Diketahui</p>
                                            </div>
                                        @endif
                                    </td>
                                    <td class="px-10 py-4 whitespace-nowrap">
                                        <button 
                                            data-tooltip-target='tooltip-view-{{ $surat->id }}' 
                                            data-tooltip-placement="bottom" 
                                            type="button"
                                            wire:click="openViewDetailModal({{ $surat->id }})"
                                            class="bg-warna-400 hover:bg-warna-400/80 active:scale-95 transition-all text-white px-4 py-2 rounded-lg cursor-pointer ml-1">
                                            <i class="fa-solid fa-eye"></i>
                                            
                                        </button>
                                        
                                        <button 
                                            data-tooltip-target='tooltip-cetak-{{ $surat->id }}' 
                                            data-tooltip-placement="bottom" 
                                            type="button"
                                            wire:click="cetakSurat({{ $surat->id }})" 
                                            class="bg-warna-500 hover:bg-warna-500/80 active:scale-95 transition-all text-white px-4 py-2 rounded-lg cursor-pointer ml-1">
                                            <i class="fa-solid fa-print"></i>
                                        </button>
                                    </td>
                                    <div id="tooltip-cetak-{{ $surat->id }}" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-xs font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-xs opacity-0 tooltip dark:bg-gray-700">
                                        <p>Cetak Surat</p>
                                        <div class="tooltip-arrow" data-popper-arrow></div>
                                    </div>
                                    <div id="tooltip-view-{{ $surat->id }}" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-xs font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-xs opacity-0 tooltip dark:bg-gray-700">
                                        <p>Lihat Detail Pengajuan</p>
                                        <div class="tooltip-arrow" data-popper-arrow></div>
                                    </div>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            @endif
        </div>
    </div>

    @if($isPreviewCatatanModal)
        <div class="fixed z-50 inset-0 flex items-center justify-center bg-warna-300/50 ">
            <x-modal class="bg-white w-[90%] md:w-[50%] lg:w-[40%] xl:w-[30%] p-5 rounded-lg shadow-lg relative">
                <button type="button" wire:click="$set('isPreviewCatatanModal', false)" class="absolute top-2 right-2 text-gray-500 hover:text-gray-700 text-3xl">&times;</button>
                <h3 class="text-center text-lg font-semibold mb-4">Alasan Penolakan</h3>
                <textarea class="block w-full h-32 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-warna-400 focus:border-warna-400 text-sm md:text-base disabled:text-gray-500" disabled>{{ $keperluan_surat }}</textarea>
            </x-modal>
        </div>
    @endif

    @if($isVerifikasiModal)
    <div class="fixed z-50 inset-0 flex items-center justify-center bg-warna-300/50 ">
        <x-modal class="relative bg-white flex flex-col items-center  mx-5 md:mx-0 w-max md:w-[60%] lg:w-[50%] xl:w-[40%] py-10 ">
            <i class="absolute -top-12 p-5 rounded-full bg-white fa-solid fa-circle-exclamation
                {{ $isSetujuiMode ? 'text-warna-500' : 'text-warna-800' }}
                text-6xl md:text-7xl xl:text-8xl"></i>
            
            @if($isSetujuiMode)
                <form class="w-full flex flex-col items-center" wire:submit.prevent="suratDisetujui">
                    <div class="flex flex-col w-full items-center mt-5 lg:mt-7 xl:mt-14 mb-8 lg:mb-10">
                        <h2 class="text-lg md:text-xl xl:text-2xl text-center font-bold mb-1 md:mb-2">
                            Verifikasi Persetujuan Surat Ajuan
                        </h2>
                        <p class="text-center w-[85%]">
                            <span class="hidden md:inline">Berikan batas waktu cetak surat atau jumlah cetak yang diizinkan. </span> Pastikan untuk memberikan catatan yang jelas agar penduduk memahami keputusan ini.
                        </p>
                        <div class="w-full px-5 md:px-7 lg:px-10 mt-12 lg:mt-14 ">
                            <div class="w-full flex flex-col md:flex-row gap-4">
                                <x-g-input 
                                    type="date"
                                    label="Batas Waktu Cetak Surat"
                                    placeholder="Pilih tanggal batas waktu cetak surat"
                                    wireModel="cetak_sebelum_tanggal"
                                    class="w-full"
                                    x-data
                                    x-init="$el.min = new Date().toISOString().split('T')[0]"
                                />
                                
                                <x-g-input 
                                    type="number"
                                    label="Batas Jumlah Cetak Surat"
                                    wireModel="maksimal_generate_pdf"
                                    min="1"
                                    max="100"
                                    class="w-full"
                                />
                            </div>

                            <div class="mt-6 md:mt-7 relative">
                                <label class="absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-warna-400 peer-focus:dark:text-indigo-400 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 left-3">Alasan Pengajuan</label>
                                <textarea 
                                    wire:model="catatan_kepalaLingkungan" 
                                    class="block w-full px-3 py-2 md:py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-warna-400 focus:border-warna-400 sm:text-sm peer" 
                                    rows="3" 
                                    placeholder="Masukkan alasan pengajuan surat">
                                </textarea>
                            </div>
                            <div class="mt-4 md:mt-5 text-left text-xs md:text-sm w-full hidden md:block bg-amber-200/50 text-yellow-700 px-4 py-2 rounded-lg mb-4">
                                Catatan:
                                <ul class="list-disc pl-5">
                                    <li>Batas waktu cetak akan menjadi 7 hari sejak tanggal disetujui jika tidak diisi.</li>
                                    <li>Batas jumlah cetak akan menjadi 10 kali jika tidak diisi.</li>
                                </ul> 
                            </div>
                        </div>
                    </div>
                    
                    <div class="flex justify-center w-[90%] ">
                        <button 
                            type="button" 
                            wire:click="closeModal" 
                            class="mr-2 bg-gray-300 hover:bg-gray-300/90 active:scale-95 transition-all text-warna-300 w-1/2 px-7 py-2 md:py-3 rounded-lg cursor-pointer"
                        >
                            Batal
                        </button>
                        
                        <button 
                            type="submit" 
                            class="bg-warna-500 hover:bg-warna-500/90 active:scale-95 transition-all text-white w-1/2 px-7 py-2 md:py-3 rounded-lg cursor-pointer disabled:bg-warna-200 disabled:cursor-not-allowed"
                        >
                            Kirimkan
                        </button>
                    </div>
                </form>
            @else
                <div class="flex flex-col w-full items-center mt-5 lg:mt-7 xl:mt-14 mb-8 lg:mb-10">
                    <h2 class="text-lg md:text-xl xl:text-2xl text-center font-bold mb-1 md:mb-2">
                        Verifikasi Penolakan Surat Ajuan
                    </h2>
                    <p class="text-center w-3/4 hidden md:block">
                        Apakah Anda yakin ingin menolak pengajuan surat ini? Pastikan untuk memberikan alasan yang jelas agar penduduk memahami keputusan ini.
                    </p>
                    <div class="w-full px-5 md:px-7 lg:px-10 mt-8 lg:mt-10">

                        <div class="w-full mt-6 md:mt-7 relative">
                            <label class="absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-warna-400 peer-focus:dark:text-indigo-400 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 left-3">Alasan Pengajuan</label>
                            <textarea 
                                wire:model="catatan_kepalaLingkungan" 
                                class="block w-full px-3 py-2 md:py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-warna-400 focus:border-warna-400 sm:text-sm peer" 
                                rows="3" 
                                placeholder="Masukkan alasan pengajuan surat">
                            </textarea>
                        </div>
                    </div>
                </div>
                
                <div class="flex justify-center w-[90%] ">
                    <button 
                        type="button" 
                        wire:click="closeModal" 
                        class="mr-2 bg-gray-300 hover:bg-gray-300/90 active:scale-95 transition-all text-warna-300 w-1/2 px-7 py-2 md:py-3 rounded-lg cursor-pointer"
                    >
                        Batal
                    </button>
                    <button 
                        type="button" 
                        wire:click=""
                        class="bg-warna-800 hover:bg-warna-800/90 active:scale-95 transition-all text-white w-1/2 px-7 py-2 md:py-3 rounded-lg cursor-pointer"
                    >
                        Ya
                    </button>
                </div>
            @endif
        </x-modal>
    </div>
    @endif

    @if($isNotificationModal)
        <div class="fixed z-50 inset-0 flex items-center justify-center bg-warna-300/50 ">
            <x-modal class="relative bg-white flex flex-col items-center mx-5 md:mx-0 w-full md:w-1/2 lg:w-[45%] xl:w-[30%] py-7 md:py-10 ">
                <i class="absolute -top-12 {{ session('message.type') == 'success' ? 'fa-solid fa-circle-check text-warna-600' : 'fa-solid fa-triangle-exclamation text-warna-800' }} bg-white p-4 rounded-full  text-6xl md:text-7xl xl:text-8xl"></i>
                <div class="flex flex-col items-center mt-5 lg:mt-12 mb-8 lg:mb-10">
                    <h2 class="text-lg md:text-xl xl:text-2xl text-center font-bold mb-1 md:mb-2">{{ session('message.title') }}</h2>
                    <p class="text-center w-3/4">{{ session('message.description') }}</p>
                </div>
                <div class="flex justify-center w-[90%] ">
                    <button type="button" wire:click="closeNotificationModal" class="mr-2 bg-gray-300 hover:bg-gray-300/90 active:scale-95 transition-all text-warna-300 w-full px-7 py-2 md:py-3 rounded-lg cursor-pointer">OK</button>
                </div>
            </x-modal>     
        </div>
    @endif

    @if($isViewDetailModal)
    <div class="fixed z-50 inset-0 flex items-center justify-center bg-warna-300/50 ">
        <x-modal class="relative bg-white flex flex-col items-center mx-5 md:mx-0 w-full md:w-[80%] lg:w-[70%] xl:w-[50%] py-7 md:py-10 ">
            <i class="absolute -top-14 fa-solid fa-eye bg-warna-400 text-white border-8 border-white px-4 py-5 rounded-full text-3xl md:text-4xl lg:text-5xl"></i>
            <div class="flex flex-col items-center mt-5 lg:mt-12 mb-8 lg:mb-10">
                <h2 class="text-lg md:text-xl xl:text-2xl text-center font-bold mb-1 md:mb-2">Detail Pengajuan Surat</h2>
            </div>
            <div class="w-[90%]">
                <div class="max-h-[45dvh] md:max-h-[50dvh] overflow-y-auto pr-2 w-full">
                    @if(auth()->user()->role == 'kepalaLingkungan' || auth()->user()->role == 'admin')
                        <div class="w-full mb-6">
                            <p class="text-sm md:text-base text-gray-500">Nomor Surat:</p>
                            <p class="text-sm md:text-base font-semibold">{{ $nomor_surat_terbitan ?? 'Belum diterbitkan' }}</p>
                        </div>
                    @endif
                    
                    <div class="w-full flex flex-col md:flex-row gap-4">
                        <div class="w-full md:w-1/2">
                            <div class="w-full mb-3">
                                <p class="text-sm md:text-base text-gray-500">Nama Lengkap:</p>
                                <p class="text-sm md:text-base font-semibold">{{ $nama_lengkap }}</p>
                            </div>
                            <div class="w-full mb-3">
                                <p class="text-sm md:text-base text-gray-500">NIK:</p>
                                <p class="text-sm md:text-base">{{ $nik }}</p>
                            </div>
                            <div class="w-full mb-3">
                                <p class="text-sm md:text-base text-gray-500">Penanggung Jawab:</p>
                                <p class="text-sm md:text-base">{{ $penanggung_jawab }}</p>
                            </div>
                            <div class="w-full mb-3">
                                <p class="text-sm md:text-base text-gray-500">Alamat Domisili:</p>
                                <p class="text-sm md:text-base">{{ $alamat_asal }}</p>
                            </div>
                            <div class="w-full mb-3">
                                <p class="text-sm md:text-base text-gray-500">Jenis Surat:</p>
                                <p class="text-sm md:text-base capitalize">{{ str_replace('_', ' ', $jenis_surat) }}</p>
                            </div>
                        </div>
                        
                        <div class="w-full md:w-1/2">
                            <div class="w-full mb-3">
                                <p class="text-sm md:text-base text-gray-500">Status Pengajuan:</p>
                                <p class="text-sm md:text-base capitalize">{{ $status_pengajuan }}</p>
                            </div>
                            <div class="w-full mb-3">
                                <p class="text-sm md:text-base text-gray-500">Tanggal Pengajuan:</p>
                                <p class="text-sm md:text-base">{{ $tanggal_pengajuan }}</p>
                            </div>
                            <div class="w-full mb-3">
                                <p class="text-sm md:text-base text-gray-500">Tanggal Diterbitkan:</p>
                                <p class="text-sm md:text-base">
                                    @if($status_pengajuan == 'diajukan')
                                        <span class="text-yellow-600">Belum diterbitkan</span>
                                    @else
                                        {{ $tanggal_surat_diterbitkan }}
                                    @endif
                                </p>
                            </div>
                            @if($status_pengajuan == 'disetujui')
                                <div class="w-full mb-3">
                                    <p class="text-sm md:text-base text-gray-500">Batas Waktu Cetak:</p>
                                    <p class="text-sm md:text-base">{{ $cetak_sebelum_tanggal }}</p>
                                </div>
                                <div class="w-full mb-3">
                                    <p class="text-sm md:text-base text-gray-500">Maksimal Generate PDF:</p>
                                    <p class="text-sm md:text-base">{{ $maksimal_generate_pdf }} kali</p>
                                </div>
                            @endif
                        </div>
                    </div>
                    
                    <div class="w-full border-t-2 border-gray-200 mt-7 pt-5">
                        <div class="w-full mb-3">
                            <p class="text-sm md:text-base text-gray-500">Keperluan Surat:</p>
                            <div class="bg-gray-50 p-3 rounded-lg">
                                <p class="text-sm md:text-base">{{ $keperluan_surat ?: 'Tidak ada keterangan' }}</p>
                            </div>
                        </div>
                        
                        @if($catatan_kepalaLingkungan)
                            <div class="w-full mb-3">
                                <p class="text-sm md:text-base text-gray-500">Catatan Kepala Lingkungan:</p>
                                <div class="bg-blue-50 p-3 rounded-lg">
                                    <p class="text-sm md:text-base">{{ $catatan_kepalaLingkungan }}</p>
                                </div>
                            </div>
                        @endif
                        <div class="w-full flex mb-3">
                            @if($status_pengajuan == 'disetujui' && $cetak_sebelum_tanggal)
                                <div class="w-full md:w-1/2 ">
                                    <p class="text-sm md:text-base text-gray-500">Status Batas Waktu:</p>
                                    <p class="text-sm md:text-base font-semibold">
                                        @if(\Carbon\Carbon::now()->gt(\Carbon\Carbon::parse($cetak_sebelum_tanggal)))
                                            <span class="text-red-600">Batas waktu cetak sudah lewat</span>
                                        @else
                                            <span class="text-warna-500">
                                                {{ \Carbon\Carbon::parse($cetak_sebelum_tanggal)->diffForHumans() }}
                                            </span>
                                        @endif
                                    </p>
                                </div>
                            @endif
                            <div class="w-full md:w-1/2 ">
                                <p class="text-sm md:text-base text-gray-500">Jumlah Surat yang Telah Dicetak:</p>
                                <p class="text-sm md:text-base font-semibold">
                                    {{ $jumlah_sudah_digenerate }} kali
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="w-full mt-6 flex justify-center">
                    <button 
                        type="button"
                        wire:click="closeModal"
                        class="bg-gray-300 hover:bg-gray-400 active:scale-95 transition-all text-gray-700 px-8 py-2 md:py-3 rounded-lg cursor-pointer w-full">
                        Tutup
                    </button>
                </div>
            </div>
        </x-modal>     
    </div>
    @endif
</div>
