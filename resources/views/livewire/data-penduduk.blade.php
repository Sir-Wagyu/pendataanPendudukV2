<div>
    <!-- Leaflet CSS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />

<!-- Leaflet JS -->
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>


    <div class="w-full flex justify-between items-center py-3  mb-6">
        <h2 class="font-semibold text-xl text-warna-300 leading-tight">
            Data Penduduk Pendatang
        </h2>
    </div>

    <div class="mb-4 flex justify-between items-center">
        <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari..." class="px-4 py-2 border border-gray-300 rounded-lg">

            <button data-tooltip-target='tooltip-bottom' data-tooltip-placement="bottom" type="button" wire:click="openUploadModal" class="w-9 md:w-11 h-9 md:h-11 bg-warna-500 rounded-lg flex justify-center items-center text-white shadow-lg hover:bg-warna-500/80 active:scale-95 transition-all cursor-pointer disabled:bg-gray-300"
                @if(auth()->user()->role != 'penanggungJawab') disabled  @endif
                >
                <i class="fa-solid fa-user-plus md:text-lg "></i>
            </button>
            <div id="tooltip-bottom" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-xs font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-xs opacity-0 tooltip dark:bg-gray-700">
                @if(auth()->user()->role != 'penanggungJawab' )
                    <p>Tambah data hanya untuk penanggung jawab</p>
                @else
                    <p>Tambah Data Penduduk</p>
                @endif
                <div class="tooltip-arrow" data-popper-arrow></div>
            </div>
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
                        Tanggal Masuk 
                    </th>
                    <th scope="col" class="px-10 py-4  whitespace-nowrap ">
                        Status Verifikasi
                    </th>
                    <th scope="col" class="px-10 py-4  whitespace-nowrap ">
                        Catatan Verifikasi
                    </th>
                    <th scope="col" class="px-10 py-4  whitespace-nowrap ">
                        Penanggung Jawab
                    </th>
                    <th scope="col" class="px-10 py-4  whitespace-nowrap ">
                        Aksi
                    </th>
                </tr>
            </thead>
            <tbody>
                @if($penduduk->isEmpty())
                    <tr>
                        <td colspan="7" class="text-center py-6 text-gray-500">Data tidak tersedia</td>
                    </tr>
                @else
                    @foreach ($penduduk as $penduduk)
                        <tr class="border-t-2 bg-white border-b text-warna-300 border-gray-200 xxl:hover:bg-gray-100">
                            <td class="px-5 py-2 md:px-10 md:py-3  whitespace-nowrap    ">{{ $penduduk->id }}</td>
                            <td class="px-10 py-3  whitespace-nowrap  ">{{ $penduduk->nama_lengkap }}</td>
                            <td class="px-10 py-3  whitespace-nowrap  ">{{ $penduduk->nik }}</td>
                            <td class="px-10 py-3  whitespace-nowrap ">{{ $penduduk->tanggal_masuk }}</td>
                            <td class="px-10 py-3  whitespace-nowrap ">
                                @if($penduduk->status_akun == 'ditolak' || $penduduk->status_akun == 'ulangi')
                                    <div class="p-2 {{ $penduduk->status_akun == 'ditolak' ? 'bg-warna-800' : 'bg-warna-700' }} rounded-full text-xs font-semibold">
                                        <p class="text-white font-semibold text-center">{{ $penduduk->status_akun == 'ditolak' ? 'Ditolak' : 'Ulangi' }}</p>
                                    </div>
                                @elseif($penduduk->status_akun == 'diterima')
                                    <div class="p-2 bg-warna-500 rounded-full text-xs font-semibold">
                                        <p class="text-white font-semibold text-center">Disetujui</p>
                                    </div>
                                @elseif($penduduk->status_akun == 'pending')
                                    <div class="p-2 bg-warna-700 rounded-full text-xs font-semibold">
                                        <p class="text-white font-semibold text-center">Menunggu</p>
                                    </div>
                                @else
                                    <div class="p-2 border-2 border-warna-800 rounded-full text-xs font-semibold">
                                        <p class="text-warna-800 font-semibold text-center">Pergi</p>
                                    </div>
                                @endif
                            </td>
                            <td class="px-10 py-3  whitespace-nowrap ">
                                @if( $penduduk->alasan_penolakan )
                                    <button type="button" wire:click="openAlasanModal({{ $penduduk->id }})" class="flex items-center justify-center px-4 py-2 bg-warna-100 hover:bg-warna-200 active:scale-95 transition-all border border-gray-300 rounded-lg ">
                                        <p>Lihat Pesan</p>
                                    </button>
                                    
                                @endif
                            </td>
                            <!-- minor change: penangggung jawab : catatan pengajuan -->
                            <td class="px-10 py-3  whitespace-nowrap ">
                                {{ $penanggungJawabNames[$penduduk->id_penanggungJawab] ?? '-' }}
                            </td>
                            <td class="px-10 py-3 whitespace-nowrap">
                                <!-- Preview Button -->
                                <button 
                                    data-tooltip-target='tooltip-preview-{{ $penduduk->id }}' 
                                    data-tooltip-placement="bottom" 
                                    type="button" 
                                    wire:click="openPreviewModal({{ $penduduk->id }})" 
                                    class="bg-warna-400 hover:bg-warna-400/80 active:scale-95 transition-all text-white px-4 py-2 rounded-lg cursor-pointer">
                                    <i class="fa-solid fa-eye"></i>
                                </button>
                                
                                @if(auth()->user()->role == 'penanggungJawab')
                                    <!-- Edit Button -->
                                    @if($penduduk->status_akun == 'pending' || $penduduk->status_akun == 'ulangi')
                                        <button 
                                            data-tooltip-target='tooltip-edit-{{ $penduduk->id }}' 
                                            data-tooltip-placement="bottom" 
                                            type="button" 
                                            wire:click="openEditModal({{ $penduduk->id }})" 
                                            class="bg-warna-500 hover:bg-warna-500/80 active:scale-95 transition-all text-white px-4 py-2 rounded-lg cursor-pointer">
                                            <i class="fa-solid fa-user-pen"></i>
                                        </button>
                                    @endif
                                    
                                    <!-- Keluar & pengajuan Button -->
                                    @if($penduduk->status_akun == 'diterima')
                                        <button 
                                            data-tooltip-target='tooltip-surat-{{ $penduduk->id }}' 
                                            data-tooltip-placement="bottom" 
                                            type="button"
                                            wire:click="openPengajuanModal({{ $penduduk->id }})" 
                                            class="bg-warna-400 hover:bg-warna-400/80 active:scale-95 transition-all text-white px-4 py-2 rounded-lg cursor-pointer ml-1">
                                            <i class="fa-solid fa-file-lines"></i>
                                        </button>
                                        <button 
                                            data-tooltip-target='tooltip-keluar-{{ $penduduk->id }}' 
                                            data-tooltip-placement="bottom" 
                                            type="button" 
                                            wire:click="openDeleteModal({{ $penduduk->id }})" 
                                            class="bg-warna-800 hover:bg-warna-800/80 active:scale-95 transition-all text-white px-4 py-2 rounded-lg cursor-pointer">
                                            <i class="fa-solid fa-right-from-bracket"></i>
                                        </button>
                                        
                                    @endif
                                    
                                    <!-- Kembali Button -->
                                    @if($penduduk->status_akun == 'keluar')
                                        <button 
                                            data-tooltip-target='tooltip-kembali-{{ $penduduk->id }}' 
                                            data-tooltip-placement="bottom" 
                                            type="button" 
                                            wire:click="openPendatangKembaliModal({{ $penduduk->id }})" 
                                            class="bg-warna-500 hover:bg-warna-500/80 active:scale-95 transition-all text-white px-4 py-2 rounded-lg cursor-pointer">
                                            <i class="fa-solid fa-right-to-bracket"></i>
                                        </button>
                                    @endif
                                    
                                    <!-- Verifikasi Ulang Button -->
                                    @if($penduduk->status_akun == 'ulangi')
                                        <button 
                                            data-tooltip-target='tooltip-verifikasi-{{ $penduduk->id }}' 
                                            data-tooltip-placement="bottom" 
                                            type="button" 
                                            wire:click="openVerifikasiUlangModal({{ $penduduk->id }})" 
                                            class="bg-warna-500 hover:bg-warna-500/80 active:scale-95 transition-all text-white px-4 py-2 rounded-lg cursor-pointer">
                                            <i class="fa-solid fa-check"></i>
                                        </button>
                                    @endif
                                @endif
                            </td>

                            <!-- Tooltip -->
                            <div id="tooltip-preview-{{ $penduduk->id }}" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-xs font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-xs opacity-0 tooltip dark:bg-gray-700">
                                <p>Lihat Detail Penduduk</p>
                                <div class="tooltip-arrow" data-popper-arrow></div>
                            </div>

                            <div id="tooltip-edit-{{ $penduduk->id }}" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-xs font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-xs opacity-0 tooltip dark:bg-gray-700">
                                <p>Edit Data Penduduk</p>
                                <div class="tooltip-arrow" data-popper-arrow></div>
                            </div>

                            <div id="tooltip-keluar-{{ $penduduk->id }}" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-xs font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-xs opacity-0 tooltip dark:bg-gray-700">
                                <p>Tandai Penduduk Keluar</p>
                                <div class="tooltip-arrow" data-popper-arrow></div>
                            </div>

                            <div id="tooltip-kembali-{{ $penduduk->id }}" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-xs font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-xs opacity-0 tooltip dark:bg-gray-700">
                                <p>Tandai Penduduk Kembali</p>
                                <div class="tooltip-arrow" data-popper-arrow></div>
                            </div>

                            <div id="tooltip-verifikasi-{{ $penduduk->id }}" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-xs font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-xs opacity-0 tooltip dark:bg-gray-700">
                                <p>Verifikasi Ulang Data</p>
                                <div class="tooltip-arrow" data-popper-arrow></div>
                            </div>

                            <div id="tooltip-surat-{{ $penduduk->id }}" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-xs font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-xs opacity-0 tooltip dark:bg-gray-700">
                                <p>Ajukan Pembuatan Surat</p>
                                <div class="tooltip-arrow" data-popper-arrow></div>
                            </div>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
        
    </div>

    @if($isPreviewAlasanModal)
        <div class="fixed z-50 inset-0 flex items-center justify-center bg-warna-300/50 ">
            <x-modal class="bg-white w-[90%] md:w-[50%] lg:w-[40%] xl:w-[30%] p-5 rounded-lg shadow-lg relative">
                <button type="button" wire:click="$set('isPreviewAlasanModal', false)" class="absolute top-2 right-2 text-gray-500 hover:text-gray-700 text-3xl">&times;</button>
                <h3 class="text-center text-lg font-semibold mb-4">Alasan Penolakan</h3>
                <textarea class="block w-full h-32 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-warna-400 focus:border-warna-400 text-sm md:text-base disabled:text-gray-500" disabled>{{ $alasan_penolakan }}</textarea>
            </x-modal>
        </div>
    @endif

    @if ($isModalUploadOpen === true)
        <div class="fixed z-50 inset-0 flex items-center justify-center bg-warna-300/50 ">
            <x-modal class="relative flex flex-col items-center bg-white w-[90%] lg:w-[80%] px-5 md:px-10 lg:px-13 py-8 ">
                <i class="absolute -top-12 fa-solid {{ $isEditMode ? 'fa-user-pen text-warna-500' : 'fa-user-plus text-warna-500' }} bg-white p-4 rounded-full  text-5xl md:text-6xl"></i>
                
                <form  class="w-full flex flex-col justify-center items-center" wire:submit.prevent="simpan">
                    <div class="flex flex-col items-center mt-5 lg:mt-7 mb-8 lg:mb-10 ">
                        <h2 class="text-lg md:text-xl xl:text-2xl text-center font-bold mb-1 md:mb-2">{{ $selectedId ? 'Edit Data Penduduk' : 'Tambah Data Penduduk' }}</h2>
                    </div>
                    <div class="max-h-[45dvh] md:max-h-[50dvh] overflow-y-auto pr-2 w-full">
                        <div class="flex flex-col justify-center md:flex-row gap-7 md:gap-3 lg:gap-8 w-full">
                            <div class="w-full md:w-1/2 xl:w-1/3">
                                <div class="flex items-center justify-between mb-2">
                                    <label for="foto_ktp" class="block text-sm font-medium text-gray-700">Foto KTP</label>
                                    @if($foto_ktp)
                                        <button onclick="document.getElementById('foto_ktp').click()" type="button" class="block md:hidden py-2 px-5 bg-warna-300 text-white rounded-lg hover:bg-warna-300/80 transition-all text-xs md:text-sm">Ganti Foto</button>
                                    @endif
                                </div>
                                <div 
                                    class="flex items-center justify-center border-2 border-dashed border-gray-300 rounded-lg {{ $foto_ktp ? 'bg-gray-200 hover:bg-gray-300' : 'bg-gray-50 hover:bg-gray-100' }} transition cursor-pointer aspect-video overflow-hidden"
                                    @if(!$foto_ktp) onclick="document.getElementById('foto_ktp').click()" @endif
                                >
                                    @if ($foto_ktp)
                                        @if (is_string($foto_ktp))
                                            <button type="button" wire:click="$set('isPreviewKtpOpen', true)" class="w-max h-full flex items-center justify-center">
                                                <img src="{{ asset('storage/' . $foto_ktp) }}" alt="Preview Foto KTP" class="w-full h-full rounded shadow object-cover" />
                                            </button>
                                            @if($isPreviewKtpOpen)
                                                <div class="fixed inset-0 z-[999] flex items-center justify-center bg-black/50">
                                                    <div class="bg-white rounded-lg shadow-lg p-3 md:p-6 relative max-w-2xl w-[90%] md:w-full">
                                                        <button type="button" wire:click="$set('isPreviewKtpOpen', false)" class="absolute top-2 right-2 text-gray-500 hover:text-gray-700 text-3xl">&times;</button>
                                                        <img src="{{ asset('storage/' . $foto_ktp) }}" alt="Preview Foto KTP" class="max-h-126 w-auto mx-auto rounded shadow" />
                                                    </div>
                                                </div>
                                            @endif
                                        @else
                                            <button type="button" wire:click="$set('isPreviewKtpOpen', true)" class="w-max h-full flex items-center justify-center">
                                                <img src="{{ $foto_ktp->temporaryUrl() }}" alt="Preview Foto KTP" class="w-full h-full rounded shadow object-cover" />
                                            </button>
                                            @if($isPreviewKtpOpen)
                                                <div class="fixed inset-0 z-[999] flex items-center justify-center bg-black/50">
                                                    <div class="bg-white rounded-lg shadow-lg p-3 md:p-6 relative max-w-2xl w-[90%] md:w-full">
                                                        <button type="button" wire:click="$set('isPreviewKtpOpen', false)" class="absolute top-2 right-2 text-gray-500 hover:text-gray-700 text-3xl">&times;</button>
                                                        <img src="{{ $foto_ktp->temporaryUrl() }}" alt="Preview Foto KTP" class="max-h-126 w-auto mx-auto rounded shadow" />
                                                    </div>
                                                </div>
                                            @endif
                                        @endif
                                    @else
                                        <div class="flex flex-col items-center">
                                            <!-- Icon KTP -->
                                            <i class="fa-solid fa-id-card text-gray-400 text-4xl"></i>
                                            <span class="text-gray-500 text-sm mt-2">Upload Foto KTP</span>
                                            <span class="text-gray-500 text-sm text-center">Klik di sini untuk upload foto KTP</span>
                                        </div>
                                    @endif
                                </div>
                                @if($foto_ktp)
                                    <button onclick="document.getElementById('foto_ktp').click()" type="button" class="hidden md:block mt-3 py-2 px-4 bg-warna-300 text-white rounded-lg hover:bg-warna-300/80 transition-all text-xs md:text-sm">Ganti Foto</button>
                                @endif

                                <input type="file" id="foto_ktp" wire:model="foto_ktp" accept="image/jpeg, image/png" class="hidden">
                                @error('foto_ktp')
                                    <span class="text-red-500 text-xs">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="w-full md:w-1/2 xl:w-1/3">
                                <div class="flex items-center justify-between mb-2">
                                    <label for="foto_selfie_ktp" class="block text-sm font-medium text-gray-700">Foto Selfie KTP</label>
                                    @if($foto_selfie_ktp)
                                        <button onclick="document.getElementById('foto_selfie_ktp').click()" type="button" class="block md:hidden py-2 px-5 bg-warna-300 text-white rounded-lg hover:bg-warna-300/80 transition-all text-xs md:text-sm">Ganti Foto</button>
                                    @endif
                                </div>

                                <div 
                                    class="flex items-center justify-center border-2 border-dashed border-gray-300 rounded-lg {{ $foto_selfie_ktp ? 'bg-gray-200 hover:bg-gray-300' : 'bg-gray-50 hover:bg-gray-100' }} transition cursor-pointer aspect-video overflow-hidden"
                                    @if(!$foto_selfie_ktp) onclick="document.getElementById('foto_selfie_ktp').click()" @endif
                                >
                                    @if ($foto_selfie_ktp)
                                        @if(is_String($foto_selfie_ktp))
                                            <button type="button" wire:click="$set('isPreviewKtpSelfieOpen', true)" class="w-max h-full flex items-center justify-center">
                                                <img src="{{ asset('storage/' . $foto_selfie_ktp) }}" alt="Preview Foto Selfie KTP" class="w-full h-full rounded shadow object-cover" />
                                            </button>
                                            @if($isPreviewKtpSelfieOpen)
                                                <div class="fixed inset-0 z-[999] flex items-center justify-center bg-black/50">
                                                    <div class="bg-white rounded-lg shadow-lg p-3 md:p-6 relative max-w-2xl w-[90%] md:w-full">
                                                        <button type="button" wire:click="$set('isPreviewKtpSelfieOpen', false)" class="absolute top-2 right-2 text-gray-500 hover:text-gray-700 text-3xl">&times;</button>
                                                        <img src="{{ asset('storage/' . $foto_selfie_ktp) }}" alt="Preview Foto Selfie KTP" class="max-h-126 w-auto mx-auto rounded shadow" />
                                                    </div>
                                                </div>
                                            @endif
                                        @else
                                            <button type="button" wire:click="$set('isPreviewSelfieKtpOpen', true)" class="w-max h-full flex items-center justify-center">
                                                <img src="{{ $foto_selfie_ktp->temporaryUrl() }}" alt="Preview Foto KTP" class="w-full h-full rounded shadow object-cover" />
                                            </button>

                                            @if($isPreviewSelfieKtpOpen)
                                            <div class="fixed inset-0 z-[999] flex items-center justify-center bg-black/50">
                                                <div class="bg-white rounded-lg shadow-lg p-3 md:p-6 relative max-w-2xl w-[90%] md:w-full">
                                                    <button type="button" wire:click="$set('isPreviewSelfieKtpOpen', false)" class="absolute top-2 right-2 text-gray-500 hover:text-gray-700 text-3xl">&times;</button>
                                                    <img src="{{ $foto_selfie_ktp->temporaryUrl() }}" alt="Preview Foto KTP" class="max-h-126 w-auto mx-auto rounded shadow" />
                                                </div>
                                            </div>
                                            @endif
                                        @endif
                                    @else
                                        <div class="flex flex-col items-center">
                                            <!-- Icon KTP -->
                                            <i class="fa-solid fa-id-card text-gray-400 text-4xl"></i>
                                            <span class="text-gray-500 text-sm mt-2">Upload Foto Selfie KTP</span>
                                            <span class="text-gray-500 text-sm text-center">Klik di sini untuk upload foto Selfie KTP</span>
                                        </div>
                                    @endif
                                </div>
                                @if($foto_selfie_ktp)
                                    <button onclick="document.getElementById('foto_selfie_ktp').click()" type="button" class="hidden md:block mt-3 py-2 px-4 bg-warna-300 text-white rounded-lg hover:bg-warna-300/80 transition-all text-xs md:text-sm">Ganti Foto</button>
                                @endif

                                <input type="file" id="foto_selfie_ktp" wire:model="foto_selfie_ktp" accept="image/jpeg, image/png" class="hidden">
                                @error('foto_selfie_ktp')
                                    
                                @enderror
                            </div>
                        </div>

                        <div class="mt-10 md:mt-12 w-full">
                            <label class="block text-sm lg:text-base font-semibold text-gray-700 mb-4 md:mb-6">Form Data Penduduk</label>

                            <div class="w-full flex flex-col lg:flex-row lg:gap-6">
                                <div class="w-full lg:w-1/2">
                                    
                                
                                <x-g-input type="number" name="nik" label="NIK" wireModel="nik" :error="$errors->first('nik')"/>
                                <x-g-input name="nama_lengkap" label="Nama Lengkap" wireModel="nama_lengkap" :error="$errors->first('nama_lengkap')"  class="mt-6 md:mt-7"/>

                                <x-g-input type="number" name="telepon" label="Nomor Handphone" wireModel="telepon" :error="$errors->first('telepon')" class="mt-6 md:mt-7"/>

                                

                                <div class="mt-6 flex w-full gap-2">

                                        <x-g-input name="tempat_lahir" label="Tempat Lahir" wireModel="tempat_lahir" :error="$errors->first('tempat_lahir')" size="w-1/2"/>

                                    <x-g-input type="date" name="tanggal_lahir" label="Tanggal Lahir" wireModel="tanggal_lahir" :error="$errors->first('tanggal_lahir')" size='w-1/2' />
                                </div>
                                    
                                <x-g-input 
                                    type="select" 
                                    name="jenis_kelamin" 
                                    label="Jenis Kelamin" 
                                    wire:model="jenis_kelamin" 
                                    :error="$errors->first('jenis_kelamin')" 
                                    class="mt-6 md:mt-7"
                                    :options="['Laki-laki' => 'Laki-laki', 'Perempuan' => 'Perempuan']"
                                />

                                <x-g-input 
                                    name="golongan_darah"
                                    type="select"
                                    label="Golongan Darah"
                                    wire:model="golongan_darah"
                                    :error="$errors->first('golongan_darah')"
                                    class="mt-6 md:mt-7"
                                    :options="['A' => 'A', 'B' => 'B', 'AB' => 'AB', 'O' => 'O']"
                                />

                                <x-g-input name="agama" label="Agama" wireModel="agama" :error="$errors->first('agama')" class="mt-6 md:mt-7"/>


                                <x-g-input 
                                        type="select" 
                                        name="status_perkawinan" 
                                        label="Status Perkawinan" 
                                        wire:model="status_perkawinan" 
                                        :error="$errors->first('status_perkawinan')" 
                                        class="mt-6 md:mt-7"
                                        :options="[
                                            'kawin' => 'Kawin',
                                            'belum_kawin' => 'Belum Kawin',
                                            'cerai' => 'Cerai'
                                        ]"
                                    />

                                <div class="mt-6 md:mt-7 relative">
                                    <label for="provinsi_asal" class="absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-warna-400 peer-focus:dark:text-indigo-400 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 left-3">Provinsi Asal</label>
                                    <select id="provinsi_asal" name="provinsi_asal" wire:model.live="provinsi_asal" class="block w-full px-3 py-2 md:py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-warna-400 focus:border-warna-400 sm:text-sm peer">
                                        <option value="" disabled selected>Pilih Provinsi</option>
                                        @foreach($provinsiOptions as $key => $value)
                                            <option value="{{ $key }}">{{ $value }}</option>
                                        @endforeach
                                    </select>
                                    
                                </div>
                                <div class="mt-6 md:mt-7 relative">
                                    <label for="kabupaten_asal" class="absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-warna-400 peer-focus:dark:text-indigo-400 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 left-3">Kabupaten/Kota Asal</label>
                                    <select id="kabupaten_asal" name="kabupaten_asal" wire:model.live="kabupaten_asal" class="block w-full px-3 py-2 md:py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-warna-400 focus:border-warna-400 sm:text-sm peer">
                                        <option value="" disabled selected>Pilih Kabupaten/Kota</option>
                                        @foreach($kabupatenOptions as $key => $value)
                                            <option value="{{ $key }}">{{ $value }}</option>
                                        @endforeach
                                    </select>
                                    
                                </div>
                                <div class="mt-6 md:mt-7 relative">
                                    <label for="kecamatan_asal" class="absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-warna-400 peer-focus:dark:text-indigo-400 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 left-3">Kecamatan Asal</label>
                                    <select id="kecamatan_asal" name="kecamatan_asal" wire:model.live="kecamatan_asal" class="block w-full px-3 py-2 md:py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-warna-400 focus:border-warna-400 sm:text-sm peer">
                                        <option value="" disabled selected>Pilih Kecamatan</option>
                                        @foreach($kecamatanOptions as $key => $value)
                                            <option value="{{ $key }}">{{ $value }}</option>
                                        @endforeach
                                    </select>
                                    
                                </div>
                                <div class="mt-6 md:mt-7 relative">
                                    <label for="kelurahan_asal" class="absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-warna-400 peer-focus:dark:text-indigo-400 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 left-3">Kelurahan Asal</label>
                                    <select id="kelurahan_asal" name="kelurahan_asal" wire:model.live="kelurahan_asal" class="block w-full px-3 py-2 md:py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-warna-400 focus:border-warna-400 sm:text-sm peer">
                                        <option value="" disabled selected>Pilih Kelurahan</option>
                                        @foreach($kelurahanOptions as $key => $value)
                                            <option value="{{ $key }}">{{ $value }}</option>
                                        @endforeach
                                    </select>
                                    
                                </div>

                                <div class="mt-6 md:mt-7 flex w-full gap-2">
                                    <x-g-input type="number" name="rt_asal" label="RT" wireModel="rt_asal" :error="$errors->first('rt_asal')" size="w-1/2"/>
                                    <x-g-input type="number" name="rw_asal" label="RW" wireModel="rw_asal" :error="$errors->first('rw_asal')" size='w-1/2'/>
                                </div>

                                <x-g-input type="textarea" name="alamat_asal" label="Alamat Asal" wireModel="alamat_asal" :error="$errors->first('alamat_asal')" class="mt-6 md:mt-7" rows="2"/>

                                </div>

                                <div class="w-full lg:w-1/2 mt-6 md:mt-7 lg:mt-0">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Pilih Lokasi Tempat Tinggal Saat ini Di Map</label>
                                        <div 
                                            id="map" 
                                            class="z-0 h-[300px] rounded-md" 
                                            wire:ignore 
                                            x-data 
                                            x-init="
                                                setTimeout(() => {
                                                    var latVal = document.getElementById('lat-value');
                                                    var lngVal = document.getElementById('lng-value');
                                                    var defaultLat = parseFloat(latVal?.innerText) || -8.8117467;
                                                    var defaultLng = parseFloat(lngVal?.innerText) || 115.1674989;
                                                    var mapContainer = document.getElementById('map');
                                                    if (!mapContainer) return;
                                                    if (mapContainer._leaflet_id) {
                                                        mapContainer._leaflet_id = null;
                                                    }
                                                    var map = L.map('map').setView([defaultLat, defaultLng], {{ $isEditMode ? 15 : 11 }});
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
                                                }, 300);
                                            "
                                        ></div>
                                        <div class="mt-2 text-xs text-gray-500 hidden">
                                            Latitude: <span id="lat-value">{{ $latitude }}</span>,
                                            Longitude: <span id="lng-value">{{ $longitude }}</span>
                                        </div>
                                    </div>
                                    <div class="flex w-full gap-3 mt-5 md:mt-6 lg:mt-9">
                                            <x-g-input type="number" name="latitude" label="Latitude" wireModel="latitude" :error="$errors->first('latitude')" class="w-1/2" disabled/>
                                                <x-g-input type="number" name="longitude" label="Longitude" wireModel="longitude" :error="$errors->first('longitude')" class="w-1/2" disabled/>
                                        </div>
                                    <x-g-input type="textarea" name="alamat_sekarang" label="Alamat Domisili" wireModel="alamat_sekarang" :error="$errors->first('alamat_sekarang')" class="mt-6 md:mt-7" rows="2"/>
                                    <x-g-input type="textarea" name="tujuan" label="Tujuan Kedatangan" wireModel="tujuan" :error="$errors->first('tujuan')" class="mt-6 md:mt-7" rows="5"/>
                                    <x-g-input type="date" name="tanggal_masuk" label="Tanggal Kedatangan" wireModel="tanggal_masuk" :error="$errors->first('tanggal_masuk')" class="mt-6 md:mt-7"/>

                                    <x-g-input 
                                            type="select" 
                                            name="id_kepalaLingkungan" 
                                            label="Kepala Lingkungan" 
                                            wire:model="id_kepalaLingkungan" 
                                            :error="$errors->first('id_kepalaLingkungan')" 
                                            class="mt-6 md:mt-7"
                                            :options="$kepalaLingkungan->pluck('name', 'id')->toArray()"
                                        />

                                        <input type="number" name="id_penanggungJawab" wire:model="id_penanggungJawab" class="hidden" value="{{ auth()->user()->id }}">
                                </div>
                            </div>
                        </div>

                            
                        @if($foto_ktp && $foto_selfie_ktp)
                            
                        @endif

                    </div>


                    <div class="flex justify-center md:justify-end w-full pt-6 gap-3">

                        <button 
                            type="button"
                            wire:click="closeUploadModal"
                            class="w-1/2 md:w-max py-3 px-10 bg-gray-400 text-white rounded-lg hover:bg-gray-500 transition-all disabled:bg-gray-300 disabled:text-gray-400 text-sm md:text-base" 

                        >
                            Batal
                        </button>
                        <button 
                            type="submit" 
                            class="w-1/2 md:w-max py-3 px-10 bg-warna-500 text-white rounded-lg hover:bg-warna-600 transition-all disabled:bg-gray-300 disabled:text-gray-400 text-sm md:text-base" 
                            @if(!$foto_ktp || !$foto_selfie_ktp) disabled @endif
                        >
                            {{ $isEditMode ? 'Perbarui' : 'Simpan' }}
                        </button>
                        
                    </div>
                </form>
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
                    <button type="button" wire:click="closeDeleteModal" class="mr-2 bg-gray-300 hover:bg-gray-300/90 active:scale-95 transition-all text-warna-300 w-full px-7 py-2 md:py-3 rounded-lg cursor-pointer">OK</button>
                </div>
            </x-modal>     
        </div>
    @endif

    @if($isPreviewModal)
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
                                            <option value="Laki-laki" {{ ($pendudukPreview->jenis_kelamin ?? '') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                            <option value="Perempuan" {{ ($pendudukPreview->jenis_kelamin ?? '') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
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
                                    
                                    <div class="relative mt-5 md:mt-6">
                                        <label class="absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-warna-400 peer-focus:dark:text-indigo-400 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 left-3">Kepala Lingkungan</label>
                                        <select class="block w-full px-3 py-2 md:py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-warna-400 focus:border-warna-400 sm:text-sm  peer disabled:text-gray-500" disabled>
                                            <option value="">Pilih Kepala Lingkungan</option>
                                            @foreach($kepalaLingkunganNames as $key => $value)
                                                <option value="{{ $key }}" {{ ($pendudukPreview->id_kepalaLingkungan ?? '') == $key ? 'selected' : '' }}>{{ $value }}</option>
                                            @endforeach
                                        </select>
                                    </div>
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

    @if($isVerifikasiModal)
    <div class="fixed z-50 inset-0 flex items-center justify-center bg-warna-300/50 ">
        <x-modal class="relative bg-white flex flex-col items-center  mx-5 md:mx-0 w-max md:w-[60%] lg:w-[50%] xl:w-[40%] py-10 ">
            <i class="absolute -top-12 p-5 rounded-full bg-white fa-solid fa-circle-exclamation
                {{ $isVerifikasiUlangMode ? 'text-warna-700' : ($isPendatangKembaliMode ? 'text-warna-500' : ($isPengajuanMode ? 'text-warna-400' : 'text-warna-800')) }}
                text-6xl md:text-7xl xl:text-8xl"></i>
            
            @if($isPengajuanMode)
                <form class="w-full flex flex-col items-center" wire:submit.prevent="pengajuanSurat">
                    <div class="flex flex-col w-full items-center mt-5 lg:mt-7 xl:mt-14 mb-8 lg:mb-10">
                        <h2 class="text-lg md:text-xl xl:text-2xl text-center font-bold mb-1 md:mb-2">
                            Pengajuan Surat Penduduk
                        </h2>
                        
                        <div class="w-full px-5 md:px-7 lg:px-10">
                            <div class="mt-6 md:mt-7 relative">
                                <label for="jenis_surat" class="absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-warna-400 peer-focus:dark:text-indigo-400 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 left-3">Jenis Surat</label>
                                <select id="jenis_surat" name="jenis_surat" wire:model="jenis_surat" class="block w-full px-3 py-2 md:py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-warna-400 focus:border-warna-400 sm:text-sm peer">
                                    <option value="" disabled selected>Pilih Jenis Surat</option>
                                    @foreach($jenisSuratOptions ?? [] as $key => $value)
                                        <option value="{{ $key }}">{{ $value }}</option>
                                    @endforeach
                                </select>
                                @error('jenis_surat')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                            
                            <div class="mt-6 md:mt-7 relative">
                                <label class="absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-warna-400 peer-focus:dark:text-indigo-400 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 left-3">Alasan Pengajuan</label>
                                <textarea 
                                    wire:model="keperluan_surat" 
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
                            wire:click="closePengajuanModal" 
                            class="mr-2 bg-gray-300 hover:bg-gray-300/90 active:scale-95 transition-all text-warna-300 w-1/2 px-7 py-2 md:py-3 rounded-lg cursor-pointer"
                        >
                            Batal
                        </button>
                        
                        <button 
                            type="submit" 
                            class="bg-warna-500 hover:bg-warna-500/90 active:scale-95 transition-all text-white w-1/2 px-7 py-2 md:py-3 rounded-lg cursor-pointer disabled:bg-warna-200 disabled:cursor-not-allowed"
                            @if($jenis_surat)
                                disabled
                            @endif
                        >
                            Ajukan
                        </button>
                    </div>
                </form>
            @else
                <div class="flex flex-col w-full items-center mt-5 lg:mt-7 xl:mt-14 mb-8 lg:mb-10">
                    <h2 class="text-lg md:text-xl xl:text-2xl text-center font-bold mb-1 md:mb-2">
                        @if($isVerifikasiUlangMode)
                            Verifikasi Ulang Data Penduduk
                        @elseif($isPendatangKembaliMode)
                            Verifikasi Kedatangan Kembali Penduduk
                        @else
                            Verifikasi Kepergian Penduduk
                        @endif
                    </h2>
                    <p class="text-center w-3/4 hidden md:block">
                        @if($isVerifikasiUlangMode)
                            Apakah anda sudah memeriksa keseluruhan data penduduk ini?
                        @elseif($isPendatangKembaliMode)
                            Apakah anda yakin penduduk yang bersangkutan telah datang kembali?
                        @else
                            Apakah anda yakin penduduk yang bersangkutan telah pergi atau akan pergi?
                        @endif
                    </p>
                </div>
                
                <div class="flex justify-center w-[90%] ">
                    <button 
                        type="button" 
                        wire:click="
                            @if($isVerifikasiUlangMode)
                                closeVerifikasiUlangModal
                            @elseif($isPendatangKembaliMode)
                                closePendatangKembaliModal
                            @else
                                closeDeleteModal
                            @endif
                        " 
                        class="mr-2 bg-gray-300 hover:bg-gray-300/90 active:scale-95 transition-all text-warna-300 w-1/2 px-7 py-2 md:py-3 rounded-lg cursor-pointer"
                    >
                        Batal
                    </button>
                    <button 
                        type="button" 
                        wire:click="
                            @if($isVerifikasiUlangMode)
                                verifikasiUlangPenduduk
                            @elseif($isPendatangKembaliMode)
                                pendatangKembali
                            @else
                                deletePenduduk
                            @endif
                        " 
                        class="{{ $isVerifikasiUlangMode || $isPendatangKembaliMode ? 'bg-warna-500 hover:bg-warna-500/90' : 'bg-warna-800 hover:bg-warna-800/90' }} active:scale-95 transition-all text-white w-1/2 px-7 py-2 md:py-3 rounded-lg cursor-pointer"
                    >
                        Ya
                    </button>
                </div>
            @endif
        </x-modal>
    </div>
    @endif

</div>