<div>
    <div class="bg-white px-6 py-9 rounded-lg shadow-md">
        <h2 class="font-semibold text-xl text-warna-300 leading-tight mb-5">
            Verifikasi Penduduk Pendatang
        </h2>

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
                            Provinsi Asal
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
                    @if ($penduduks->isNotEmpty())
                        @foreach ($penduduks as $key => $data)
                        <tr class="border-t-2 bg-white border-b text-warna-300 border-gray-200 xxl:hover:bg-gray-100">
                            <td class="px-10 py-4  whitespace-nowrap border-r border-warna-200">
                                {{ $key + 1 }}
                            </td>
                            <td class="px-10 py-4  whitespace-nowrap border-r border-warna-200">
                                {{ $data->nama_lengkap }}
                            </td>
                            <td class="px-10 py-4  whitespace-nowrap border-r border-warna-200">
                                {{ $data->nik }}
                            </td>
                            <td class="px-10 py-4  whitespace-nowrap border-r border-warna-200">
                                {{ $data->tanggal_masuk }}
                            </td>
                            <td class="px-10 py-4 whitespace-nowrap">
                                <span class="capitalize">{{ strtolower($provinsiNames[$data->provinsi_asal] ?? '-') }}</span>
                            </td>
                            <td class="px-10 py-4 whitespace-nowrap">
                                {{ $penanggungJawabNames[$data->id_penanggungJawab] }}
                            </td>
                            <td class="px-10 py-3 whitespace-nowrap flex  gap-1">
                                    
                                <button type="submit" id="tooltip-preview-{{ $data->id }}" name="status_akun" wire:click="showPreviewModal({{ $data->id }})"  class="bg-warna-400 hover:bg-warna-400/80 active:scale-95 transition-all text-white px-4 py-2 rounded-lg cursor-pointer" 
                                data-tooltip-target="tooltip-preview-content-{{ $data->id }}" data-tooltip-trigger="hover">
                                    <i class="fa-solid fa-eye"></i>
                                </button>
                                <div id="tooltip-preview-content-{{ $data->id }}" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-xs font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                                    Lihat Detail Penduduk
                                    <div class="tooltip-arrow" data-popper-arrow></div>
                                </div>

                                <button type="submit" id="tooltip-terima-{{ $data->id }}" wire:click="showTerimaModal({{ $data->id }})" name="status_akun" value="diterima" class="bg-warna-500 hover:bg-warna-500/80 active:scale-95 transition-all text-white px-4 py-2 rounded-lg cursor-pointer"
                                data-tooltip-target="tooltip-terima-content-{{ $data->id }}" data-tooltip-trigger="hover">
                                    <i class="fa-solid fa-check"></i>
                                </button>
                                <div id="tooltip-terima-content-{{ $data->id }}" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-xs font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                                    Terima Penduduk
                                    <div class="tooltip-arrow" data-popper-arrow></div>
                                </div>

                                <button type="submit" id="tooltip-perbaikan-{{ $data->id }}" wire:click="showAlasanPerbaikanModal({{ $data->id }})" name="status_akun" value="diterima" class="bg-warna-500 hover:bg-warna-500/80 active:scale-95 transition-all text-white px-4 py-2 rounded-lg cursor-pointer"
                                data-tooltip-target="tooltip-perbaikan-content-{{ $data->id }}" data-tooltip-trigger="hover">
                                    <i class="fa-solid fa-arrow-rotate-left"></i>
                                </button>
                                <div id="tooltip-perbaikan-content-{{ $data->id }}" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-xs font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                                    Minta Perbaikan Data
                                    <div class="tooltip-arrow" data-popper-arrow></div>
                                </div>

                                <button type="submit" id="tooltip-tolak-{{ $data->id }}" wire:click="showAlasanModal({{ $data->id }})" name="status_akun" value="ditolak" class="bg-warna-800 hover:bg-warna-800/80 active:scale-95 transition-all text-white px-4 py-2 rounded-lg cursor-pointer"
                                data-tooltip-target="tooltip-tolak-content-{{ $data->id }}" data-tooltip-trigger="hover">
                                    <i class="fa-solid fa-times"></i>
                                </button>
                                <div id="tooltip-tolak-content-{{ $data->id }}" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-xs font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                                    Tolak Penduduk
                                    <div class="tooltip-arrow" data-popper-arrow></div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    @else
                        <tr>
                            <td colspan="7" class="text-center py-4 text-gray-500">
                                Tidak ada data penduduk yang perlu diverifikasi.
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
        

        @if($isAlasanModal)
            <div class="fixed z-50 inset-0 flex items-center justify-center bg-warna-300/50 ">
                <x-modal class="relative bg-white flex flex-col items-center  mx-5 md:mx-0 w-max md:w-[60%] lg:w-[50%] xl:w-[40%] py-10 ">
                    @if($isPerbaikanMode)
                    <div class="border-16 border-white absolute -top-14 xl:-top-12 flex items-center justify-center p-6 text-4xl lg:text-5xl text-white bg-warna-500 rounded-full w-max">
                        <i class="fa-solid fa-arrow-rotate-left"></i>
                    </div>
                    @else
                    <i class="absolute -top-12 p-5 rounded-full bg-white fa-solid fa-circle-exclamation text-warna-800 text-6xl md:text-7xl xl:text-8xl"></i>
                    @endif
                    <div class="flex flex-col items-center mt-5 lg:mt-7 xl:mt-14 mb-8 lg:mb-10">
                        <h2 class="text-lg md:text-xl xl:text-2xl text-center font-bold mb-1 md:mb-2">{{ $isPerbaikanMode ? 'Verifikasi Alasan Perbaikan Data Penduduk' : 'Verifikasi Penolakan Status Penduduk' }}</h2>
                        <p class="text-center w-3/4 hidden md:block">Berikan alasan {{ $isPerbaikanMode ? 'perbaikan' : 'penolakan' }} yang objektif untuk menolak penduduk ini.</p>

                        <textarea wire:model="alasan_penolakan" class="w-[85%] lg:w-[90%] xl:w-full mt-5 rounded-md" rows="3" placeholder="Masukkan {{ $isPerbaikanMode ? 'alasan perbaikan...' : 'alasan penolakan...' }}"></textarea>
                        @error('alasan')
                            <span class="text-red-500 text-sm mt-2">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="flex justify-center w-[90%] ">
                        <button type="button" wire:click="{{ $isPerbaikanMode ? 'closeAlasanPerbaikanModal' : 'closeAlasanModal' }}" class="mr-2 bg-gray-300 hover:bg-gray-300/90 active:scale-95 transition-all text-warna-300 w-1/2 px-7 py-2 md:py-3 rounded-lg cursor-pointer">Batal</button>
                        <button type="button" wire:click="{{ $isPerbaikanMode ? 'perbaikanDataPenduduk' : 'tolakPenduduk' }}" class="active:scale-95 transition-all text-white w-1/2 px-7 py-2 md:py-3 rounded-lg cursor-pointer {{ $isPerbaikanMode ? 'bg-warna-500 hover:bg-warna-500/90' : 'bg-warna-800 hover:bg-warna-800/90' }}">{{ $isPerbaikanMode ? 'Minta Perbaikan' : 'Tolak' }}</button>
                    </div>
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

        @if($isTerimaModal)
            <div class="fixed z-50 inset-0 flex items-center justify-center bg-warna-300/50 ">
                <x-modal class="relative bg-white flex flex-col items-center  mx-5 md:mx-0 w-max  py-10 ">
                    <i class="absolute -top-12 p-5 rounded-full bg-white fa-solid fa-circle-exclamation text-warna-700 text-6xl md:text-7xl xl:text-8xl"></i>
                    <div class="flex flex-col items-center mt-5 lg:mt-7 xl:mt-14 mb-8 lg:mb-10">
                        <h2 class="text-lg md:text-xl xl:text-2xl text-center font-bold mb-1 md:mb-2">Verifikasi Penerimaan Penduduk</h2>
                        <p class="text-center w-3/4"> <span class="hidden md:inline">Apakah anda sudah memeriksa keseluruhan data penduduk ini?</span> Pastikan seluruh data penduduk telah disetujui.</p>
                    </div>
                    <div class="flex justify-center w-[90%] ">
                        <button type="button" wire:click="closeTerimaModal" class="mr-2 bg-gray-300 hover:bg-gray-300/90 active:scale-95 transition-all text-warna-300 w-1/2 px-7 py-2 md:py-3 rounded-lg cursor-pointer">Batal</button>
                        <button type="button" wire:click="terimaPenduduk" class="bg-warna-600 hover:bg-warna-600/90 active:scale-95 transition-all text-white w-1/2 px-7 py-2 md:py-3 rounded-lg cursor-pointer">Terima</button>
                    </div>
                </x-modal>
            </div>
        @endif

        {{-- loadingModal --}}
        <div
            id="loadingModal"
            class="hidden fixed inset-0 z-50 items-center justify-center bg-black/40"
        >
            <div class="bg-white p-6 rounded shadow text-center">
                <span class="animate-spin inline-block text-2xl">&#9696;</span>
                <div class="mt-2">Loading...</div>
            </div>
        </div>

    @if($isPreviewModal)
        <div class="fixed z-50 inset-0 flex items-center justify-center bg-warna-300/50 ">
                <x-modal class="relative flex flex-col items-center bg-white w-[90%] lg:w-[80%] px-5 md:px-10 lg:px-13 py-8 ">
                    <i class="absolute -top-12 fa-solid fa-circle-user text-warna-400 bg-white p-4 rounded-full  text-6xl md:text-7xl xl:text-8xl"></i>
                    <div class="w-full flex flex-col justify-center items-center">
                        <div class="flex flex-col items-center mt-5 lg:mt-7 xl:mt-14 mb-8 lg:mb-10 ">
                            <h2 class="text-lg md:text-xl xl:text-2xl text-center font-bold mb-1 md:mb-2">Data Penduduk Atas Nama  {{ $pendudukPreview->nama_lengkap }}</h2>
                        </div>

                        <div class="max-h-[55dvh] overflow-y-auto pr-2 w-full">
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
                                                id="map2" 
                                                style="height: 300px; width: 100%;" 
                                                class="my-4 rounded shadow"
                                                x-data
                                                x-init="
                                                    setTimeout(() => {
                                                        if(window.leafletMap) window.leafletMap.remove();
                                                        window.leafletMap = L.map('map2').setView([{{ $pendudukPreview->latitude }}, {{ $pendudukPreview->longitude }}], 15);
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
                                                <input type="date" 
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
                                            <label class="absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-warna-400 peer-focus:dark:text-indigo-400 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 left-3">Tanggal Keluar</label>
                                            <input type="date" 
                                                class="block w-full px-3 py-2 md:py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-warna-400 focus:border-warna-400 sm:text-sm  peer disabled:text-gray-500"
                                                value="{{ $pendudukPreview->tanggal_keluar ?? '-' }}" disabled>
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
                    
                    </div>
                    <div class="flex justify-center md:justify-end w-full pt-6">
                        <button type="button" wire:click="closePreviewModal" class="mr-2 bg-gray-300 hover:bg-gray-300/90 active:scale-95 transition-all text-warna-300 w-full md:w-1/4   px-7 py-2 md:py-3 rounded-lg cursor-pointer">Tutup</button>
                    
                    </div>
                    
                </x-modal>     
            </div>
        @endif

        <script>
            const form = document.getElementById('verifikasiForm');
            const loadingModal = document.getElementById('loadingModal');

            form.addEventListener('submit', function () {
                loadingModal.classList.remove('hidden');
                loadingModal.classList.add('flex');
            });
        </script>

</div>
