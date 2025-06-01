<div>
    <div class="bg-white shadow-md rounded-lg p-6 mt-7">
        <div class="w-full flex justify-between items-center py-3  mb-6">
            <h2 class="font-semibold text-xl text-warna-300 leading-tight">
                Data Penanggung Jawab
            </h2>
        </div>

        <div class="mb-4 flex justify-between items-center">
            <x-g-input 
                type='text'
                wire:model.live.debounce.300ms="search"
                label="Cari"
                size="w-3/4 md:w-1/2 xl:w-1/3"
            />

            <button data-tooltip-target='tooltip-bottom' data-tooltip-placement="bottom" type="button" wire:click="openModal" class="w-9 md:w-11 h-9 md:h-11 bg-warna-500 rounded-lg flex justify-center items-center text-white shadow-lg hover:bg-warna-500/80 active:scale-95 transition-all cursor-pointer"><i class="fa-solid fa-user-plus md:text-lg "></i></button>

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
                        <th scope="col"
                            class="px-10 py-4  whitespace-nowrap  ">
                            Nama Lengkap
                        </th>
                        <th scope="col" class="px-10 py-4  whitespace-nowrap  ">
                            NIK
                        </th>
                        <th scope="col" class="px-10 py-4  whitespace-nowrap ">
                            Email
                        </th>
                        <th scope="col" class="px-10 py-4  whitespace-nowrap ">
                            No Telepon
                        </th>
                        <th scope="col" class="px-10 py-4  whitespace-nowrap ">
                            Alamat
                        </th>
                        <th scope="col" class="px-10 py-4  whitespace-nowrap ">
                            Status Akun
                        </th>
                        <th scope="col" class="px-10 py-4  whitespace-nowrap ">
                            Aksi
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $index => $user)
                        <tr class="border-t-2 bg-white border-b text-warna-300 border-gray-200 xxl:hover:bg-gray-100">
                            <td class="px-5 py-2 md:px-10 md:py-3  ">{{ $index + 1 }}</td>
                            <td class="px-10 py-3 whitespace-nowrap  ">{{ $user->name }}</td>
                            <td class="px-10 py-3">{{ $user->nik }}</td>
                            <td class="px-10 py-3">{{ $user->email }}</td>
                            <td class="px-10 py-3">{{ $user->telepon }}</td>
                            <td class="px-10 py-3 whitespace-nowrap">{{ $user->alamat }}</td>
                            <td class="px-10 py-3">
                                @if($user->status === 'approved')
                                    <div class="bg-warna-500 text-white px-4 py-2 rounded-full text-center">
                                        <span class="text-sm">Aktif</span>
                                    </div>
                                    @elseif($user->status === 'pending')
                                        <div class="bg-warna-700 text-white px-4 py-2 rounded-full text-center">
                                            <span class="text-sm">Pending</span>
                                        </div>
                                    @elseif($user->status === 'rejected')
                                        <div class="bg-warna-800 text-white px-4 py-2 rounded-full text-center">
                                            <span class="text-sm">Ditolak</span>
                                        </div>
                                    @else
                                        <div class="bg-white border-2 border-warna-800 text-warna-800 px-4 py-2 rounded-full text-center">
                                            <span class="text-sm">Tidak Aktif</span>
                                        </div>
                                    @endif
                            </td>
                            <td class="px-10 py-3 flex gap-2">
                                @if($user->status == 'rejected' || $user->status == 'nonactive')
                                    @else
                                        <button data-tooltip-target='tooltip-edit-{{ $user->id }}' data-tooltip-placement="bottom" wire:click="edit({{ $user->id }})" class="bg-warna-500 hover:bg-warna-500/80 active:scale-95 transition-all text-white px-4 py-2 rounded-lg cursor-pointer"><i class="fa-solid fa-user-pen"></i></button>
                                        <div id="tooltip-edit-{{ $user->id }}" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-xs font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-xs opacity-0 tooltip dark:bg-gray-700">
                                            Edit Akun
                                            <div class="tooltip-arrow" data-popper-arrow></div>
                                        </div>

                                        @if($user->status == 'approved')
                                            <button data-tooltip-target='tooltip-delete-{{ $user->id }}' data-tooltip-placement="bottom" wire:click="openDeleteModal({{ $user->id }})" class="bg-warna-800 hover:bg-warna-800/80 active:scale-95 transition-all text-white px-4 py-2 rounded-lg cursor-pointer"><i class="fa-solid fa-right-to-bracket"></i></button>
                                            <div id="tooltip-delete-{{ $user->id }}" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-xs font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-xs opacity-0 tooltip dark:bg-gray-700">
                                                Nonaktifkan Akun
                                                <div class="tooltip-arrow" data-popper-arrow></div>
                                            </div> 
                                        @endif
                                    @endif
                                </td>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-4">Tidak ada data</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if ($isModalOpen === true)
        <div class="fixed z-50 inset-0 flex items-center justify-center bg-warna-300/50 ">
                <x-modal class="relative flex flex-col items-center bg-white w-[90%] lg:w-[80%] px-5 md:px-10 lg:px-13 py-8 ">
                    <i class="absolute -top-12 left-1/2 transform -translate-x-1/2 px-6  py-7 rounded-full bg-warna-500 fa-solid f {{ $selectedId ? 'fa-user-pen' : 'fa-user-plus' }} mx-auto
                    text-4xl lg:text-5xl  text-white border-10 border-white"></i>
                    <h2 class="mt-10 lg:mt-13 text-center text-lg lg:text-xl font-bold md:mb-5">{{ $selectedId ? 'Edit Data Kepala Lingkungan' : 'Tambah Data Kepala Lingkungan' }}</h2>
                    <form wire:submit.prevent="save" class="w-full">
                        <div class="max-h-[45dvh] md:max-h-[50dvh] overflow-y-auto pr-2 w-full">
                            <div class="flex flex-col md:flex-row gap-3 md:gap-6">
                                <div class="w-full md:w-1/2">
                                    <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div class="relative">
                                            <input type="text" id="name" name="name" class="block w-full px-3 py-2 md:py-3 border border-gray-300 rounded-md  focus:outline-none focus:ring-warna-400 focus:border-warna-400 sm:text-sm peer" placeholder=" "  wire:model="name"/>
                                            <label for="nama" class="absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-warna-400 peer-focus:dark:text-indigo-400 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 left-3">Nama Lengkap</label>
                                        </div>
                                        <div class="relative ">
                                            <input type="email" id="email" name="email" class="block w-full px-3 py-2 md:py-3 border border-gray-300 rounded-md  focus:outline-none focus:ring-warna-400 focus:border-warna-400 sm:text-sm peer" placeholder=" "  wire:model="email"/>
                                            <label for="nama" class="absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-warna-400 peer-focus:dark:text-indigo-400 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 left-3">Email</label>
                                        </div>
                                    </div>
                                    <div class="relative mt-6">
                                        <input type="number" id="nik" name="nik" class="block w-full px-3 py-2 md:py-3 border border-gray-300 rounded-md  focus:outline-none focus:ring-warna-400 focus:border-warna-400 sm:text-sm peer" placeholder=" " wire:model="nik"/>
                                        <label for="nama" class="absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-warna-400 peer-focus:dark:text-indigo-400 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 left-3">NIK</label>
                                    </div>
                                    <div class="relative mt-6">
                                        <input type="number" id="telepon" name="telepon" class="block w-full px-3 py-2 md:py-3 border border-gray-300 rounded-md  focus:outline-none focus:ring-warna-400 focus:border-warna-400 sm:text-sm peer" placeholder=" " wire:model="telepon"/>
                                        <label for="nama" class="absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-warna-400 peer-focus:dark:text-indigo-400 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 left-3">No Telepon</label>
                                    </div>
                                    <div class="relative mt-6">
                                        <input type="text" id="username" name="username" class="block w-full px-3 py-2 md:py-3 border border-gray-300 rounded-md  focus:outline-none focus:ring-warna-400 focus:border-warna-400 sm:text-sm peer disabled:text-gray-500" placeholder=" " wire:model="username" {{ $selectedId? "disabled" : null }}/>
                                        <label for="nama" class="absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-warna-400 peer-focus:dark:text-indigo-400 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 left-3">Username</label>
                                    </div> 
                                    <div class="relative mt-6">
                                        <input type="text" id="alamat" name="alamat" class="block w-full px-3 py-2 md:py-3 border border-gray-300 rounded-md  focus:outline-none focus:ring-warna-400 focus:border-warna-400 sm:text-sm peer" placeholder=" " wire:model="alamat"/>
                                        <label for="nama" class="absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-warna-400 peer-focus:dark:text-indigo-400 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 left-3">Alamat</label>
                                    </div>
                                </div>

                                <div class="w-full md:w-1/2">
                                    <p class="text-sm text-gray-500 mt-6">Pilih Lokasi Kepala Lingkungan</p>
                                    <div
                                    id="pjMap"
                                    class="z-0 h-[200px] lg:h-[300px] rounded-md"
                                    wire:ignore
                                    x-data
                                    x-init="
                                        setTimeout(() => {
                                            const lat = @this.latitude || -8.8117467;
                                            const lng = @this.longitude || 115.1674989;
                                            
                                            const mapContainer = document.getElementById('pjMap');
                                            if (mapContainer._leaflet_id) {
                                                mapContainer._leaflet_id = null;
                                                mapContainer.innerHTML = '';
                                            }

                                            const map = L.map('pjMap').setView([lat, lng], 15);

                                            L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                                                maxZoom: 19,
                                                attribution: '&copy; OpenStreetMap'
                                            }).addTo(map);
                                            var marker = L.marker([lat, lng], { draggable: true }).addTo(map);
                                            marker.on('dragend', function(e) {
                                                const latlng = marker.getLatLng();
                                                // Send coordinates to Livewire component
                                                @this.set('latitude', latlng.lat);
                                                @this.set('longitude', latlng.lng);
                                            });
                                            
                                            map.on('click', function(e) {
                                                marker.setLatLng(e.latlng);
                                                // Send coordinates to Livewire component
                                                @this.set('latitude', e.latlng.lat);
                                                @this.set('longitude', e.latlng.lng);
                                            });
                                        }, 300);
                                        ">
                                    </div>

                                    <div class="w-full flex gap-3  mt-6">
                                        <x-g-input
                                            type="text"
                                            label="Latitude"
                                            size="w-1/2"
                                            wireModel="latitude"
                                            
                                            disabled
                                        />
                                        <x-g-input
                                            type="text"
                                            label="Longitude"
                                            size="w-1/2"
                                            wireModel="longitude"
                                            
                                            disabled
                                        />

                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="flex justify-end mt-10">
                            <button type="button" wire:click="closeModal" class="mr-2 bg-gray-300 hover:bg-gray-300/90 active:scale-95 transition-all text-warna-300 px-7 py-2 rounded-lg cursor-pointer">Batal</button>
                            <button type="submit" class="bg-warna-500 hover:bg-warna-500/90 active:scale-95 transition-all text-white px-7 py-2 rounded-lg cursor-pointer">Simpan</button>
                        </div>
                    </form>
                </x-modal>
            </div>
        @endif

        @if($isDeleteModalOpen)
            <div class="fixed z-50 inset-0 flex items-center justify-center bg-warna-300/50 ">
                <x-modal class="relative bg-white flex flex-col items-center  mx-5 md:mx-0 w-max  py-10 ">
                    <i class="absolute -top-12 p-5 rounded-full bg-white fa-solid fa-circle-exclamation text-warna-800 text-6xl md:text-7xl xl:text-8xl"></i>
                    <div class="flex flex-col items-center mt-5 lg:mt-7 xl:mt-14 mb-8 lg:mb-10">
                        <h2 class="text-lg md:text-xl xl:text-2xl text-center font-bold mb-1 md:mb-2">Hapus Data Penanggung Jawab?</h2>
                        <p class="text-center w-3/4"> <span class="hidden md:inline">Data ini tidak akan bisa dikembalikan.</span> Apakah anda yakin untuk menghapusnya?</p>
                    </div>
                    <div class="flex justify-center w-[90%] ">
                        <button type="button" wire:click="closeDeleteModal" class="mr-2 bg-gray-300 hover:bg-gray-300/90 active:scale-95 transition-all text-warna-300 w-1/2 px-7 py-2 md:py-3 rounded-lg cursor-pointer">Batal</button>
                        <button type="button" wire:click="delete" class="bg-warna-800 hover:bg-warna-800/90 active:scale-95 transition-all text-white w-1/2 px-7 py-2 md:py-3 rounded-lg cursor-pointer">Hapus</button>
                    </div>
                </x-modal>
            </div>
        @endif

        @if($message = session('message'))
            <div class="fixed z-50 inset-0 flex items-center justify-center bg-warna-300/50 ">
            <x-modal class="relative bg-white flex flex-col items-center mx-5 md:mx-0 w-full md:w-1/2 lg:w-[45%] xl:w-[30%] py-7 md:py-10 ">
                <i class="absolute -top-12 {{ $message['type'] == 'success' ? 'fa-solid fa-circle-check text-warna-600' : 'fa-solid fa-triangle-exclamation text-warna-800' }} bg-white p-4 rounded-full  text-6xl md:text-7xl xl:text-8xl"></i>
                <div class="flex flex-col items-center mt-5 lg:mt-12 mb-8 lg:mb-10">
                    <h2 class="text-lg md:text-xl xl:text-2xl text-center font-bold mb-1 md:mb-2">{{ $message['title'] }}</h2>
                    <p class="text-center w-3/4">{{ $message['description'] }}</p>
                </div>
                <div class="flex justify-center w-[90%] ">
                    <button type="button" wire:click="closeDeleteModal" class="mr-2 bg-gray-300 hover:bg-gray-300/90 active:scale-95 transition-all text-warna-300 w-full px-7 py-2 md:py-3 rounded-lg cursor-pointer">OK</button>
                </div>
            </x-modal>     
        </div>
        @endif
</div>
