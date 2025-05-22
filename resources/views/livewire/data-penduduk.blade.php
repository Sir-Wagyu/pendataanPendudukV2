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

            <button data-tooltip-target='tooltip-bottom' data-tooltip-placement="bottom" type="button" wire:click="openUploadModal" class="w-9 md:w-11 h-9 md:h-11 bg-warna-500 rounded-lg flex justify-center items-center text-white shadow-lg hover:bg-warna-500/80 active:scale-95 transition-all cursor-pointer"><i class="fa-solid fa-user-plus md:text-lg "></i></button>

        <div id="tooltip-bottom" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-xs font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-xs opacity-0 tooltip dark:bg-gray-700">
            Tambah Data
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
                        Alasan Penolakan
                    </th>
                    <th scope="col" class="px-10 py-4  whitespace-nowrap ">
                        Aksi
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($penduduk as $penduduk)
                    <tr class="border-t-2 bg-white border-b text-warna-300 border-gray-200 xxl:hover:bg-gray-100">
                        <td class="px-5 py-2 md:px-10 md:py-3  whitespace-nowrap    ">{{ $penduduk->id }}</td>
                        <td class="px-10 py-3  whitespace-nowrap  ">{{ $penduduk->nama_lengkap }}</td>
                        <td class="px-10 py-3  whitespace-nowrap  ">{{ $penduduk->nik }}</td>
                        <td class="px-10 py-3  whitespace-nowrap ">{{ $penduduk->tanggal_masuk }}</td>
                        <td class="px-10 py-3  whitespace-nowrap ">
                            @if($penduduk->status_akun == 'ditolak')
                                <span class="text-warna-800 font-semibold">Ditolak</span>
                            @elseif($penduduk->status_akun == 'diterima')
                                <span class="text-warna-600 font-semibold">Diterima</span>
                            @else
                                <span class="text-warna-700 font-semibold">Menunggu</span>
                            @endif
                        </td>
                        <td class="px-10 py-3  whitespace-nowrap ">
                            @if( $penduduk->alasan_penolakan )
                                <span class="text-red-500 font-semibold">{{ $penduduk->alasan_penolakan }}</span>
                            @else
                                <span class="text-gray-500">-</span>
                            @endif
                        </td>
                        <td class="px-10 py-3  whitespace-nowrap ">
                                <button type="button" wire:click="openDetailModal({{ $penduduk->id }})" class="bg-warna-500 hover:bg-warna-500/80 active:scale-95 transition-all text-white px-4 py-2 rounded-lg cursor-pointer"><i class="fa-solid fa-eye "></i></button>

                        </td>
                    </tr>
                @endforeach
                
            </tbody>
        </table>

        
    </div>

           
    @if ($isModalUploadOpen === true)
        <div class="fixed z-50 inset-0 flex items-center justify-center bg-warna-300/50 ">
            <x-modal class="bg-white w-[90%] lg:w-[80%] px-5 md:px-10 lg:px-13 py-8 ">
                <h2 class="text-lg lg:text-xl font-bold mb-10">Tambah Data Penduduk</h2>
                <form  class="space-y-4" wire:submit.prevent="simpan">

                    <div class="max-h-[60dvh] overflow-y-auto pr-2 w-full">
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
                                        <div id="map" class="z-0 h-[300px] rounded-md" wire:ignore></div>
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
                                    <x-g-input type="date" name="tanggal_keluar" label="Tanggal Kepergian (Optional)" wireModel="tanggal_keluar" :error="$errors->first('tanggal_keluar')" class="mt-6 md:mt-7"/>

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


                    <div class="flex justify-center md:justify-end gap-5 mt-8">
                        <button type="button" wire:click="closeUploadModal" class="w-max py-3 px-10 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition-all ">Batal</button>
                        <button 
                            type="submit" 
                            class="w-max py-3 px-10 bg-warna-500 text-white rounded-lg hover:bg-warna-600 transition-all disabled:bg-gray-300 disabled:text-gray-400" 
                            @if(!$foto_ktp || !$foto_selfie_ktp) disabled @endif
                        >
                            Tambah Data
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



</div>