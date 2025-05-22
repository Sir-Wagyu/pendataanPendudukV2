<div>
    <h2 class="font-semibold text-xl text-warna-300 leading-tight mt-10 mb-6">
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
                                <button type="submit"  name="status_akun" value="diterima" class="bg-warna-500 hover:bg-warna-500/80 active:scale-95 transition-all text-white px-4 py-2 rounded-lg cursor-pointer">
                                    <i class="fa-solid fa-check"></i>
                                </button>
                                <button type="submit" wire:click="showAlasanModal({{ $data->id }})" name="status_akun" value="ditolak" class="bg-warna-800 hover:bg-warna-800/80 active:scale-95 transition-all text-white px-4 py-2 rounded-lg cursor-pointer">
                                    <i class="fa-solid fa-times"></i>
                                </button>
                            </td>
                    </tr>
                @endforeach
                
            </tbody>
        </table>
        </div>
        

        @if($isAlasanModal)
            <div class="fixed z-50 inset-0 flex items-center justify-center bg-warna-300/50 ">
                <x-modal class="relative bg-white flex flex-col items-center  mx-5 md:mx-0 w-max md:w-[60%] lg:w-[50%] xl:w-[40%] py-10 ">
                    <i class="absolute -top-12 p-5 rounded-full bg-white fa-solid fa-circle-exclamation text-warna-800 text-6xl md:text-7xl xl:text-8xl"></i>
                    <div class="flex flex-col items-center mt-5 lg:mt-7 xl:mt-14 mb-8 lg:mb-10">
                        <h2 class="text-lg md:text-xl xl:text-2xl text-center font-bold mb-1 md:mb-2">Verifikasi Penolakan Status Penduduk</h2>
                        <p class="text-center w-3/4 hidden md:block">Berikan alasan penolakan yang objektif untuk menolak penduduk ini.</p>

                        <textarea wire:model="alasan_penolakan" class="w-[85%] lg:w-[90%] xl:w-full mt-5 rounded-md" rows="3" placeholder="Masukkan alasan penolakan..."></textarea>
                        @error('alasan')
                            <span class="text-red-500 text-sm mt-2">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="flex justify-center w-[90%] ">
                        <button type="button" wire:click="closeAlasanModal" class="mr-2 bg-gray-300 hover:bg-gray-300/90 active:scale-95 transition-all text-warna-300 w-1/2 px-7 py-2 md:py-3 rounded-lg cursor-pointer">Batal</button>
                        <button type="button" wire:click="tolakPenduduk" class="bg-warna-800 hover:bg-warna-800/90 active:scale-95 transition-all text-white w-1/2 px-7 py-2 md:py-3 rounded-lg cursor-pointer">Tolak</button>
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
                        <button type="button" wire:click="closeDeleteModal" class="mr-2 bg-gray-300 hover:bg-gray-300/90 active:scale-95 transition-all text-warna-300 w-full px-7 py-2 md:py-3 rounded-lg cursor-pointer">OK</button>
                    </div>
                </x-modal>     
            </div>
        @endif

        <div
            id="loadingModal"
            class="hidden fixed inset-0 z-50 items-center justify-center bg-black/40"
        >
            <div class="bg-white p-6 rounded shadow text-center">
                <span class="animate-spin inline-block text-2xl">&#9696;</span>
                <div class="mt-2">Loading...</div>
            </div>
        </div>

        @if(session('message'))
            <div 
            x-data="{ open: true }"
            x-show="open"
            class="fixed z-50 inset-0 flex items-center justify-center bg-warna-300/50"
            style="display: none;">
                <x-modal class="relative bg-white flex flex-col items-center mx-5 md:mx-0 w-full md:w-1/2 lg:w-[45%] xl:w-[30%] py-7 md:py-10 ">
                    <i class="absolute -top-12 {{ session('message.type') == 'success' ? 'fa-solid fa-circle-check text-warna-600' : 'fa-solid fa-triangle-exclamation text-warna-800' }} bg-white p-4 rounded-full  text-6xl md:text-7xl xl:text-8xl"></i>
                    <div class="flex flex-col items-center mt-5 lg:mt-12 mb-8 lg:mb-10">
                        <h2 class="text-lg md:text-xl xl:text-2xl text-center font-bold mb-1 md:mb-2">{{ session('message.title') }}</h2>
                        <p class="text-center w-3/4">{{ session('message.description') }}</p>
                    </div>
                    <div class="flex justify-center w-[90%] ">
                        <button 
                            type="button" 
                            @click="open = false"
                            class="mr-2 bg-gray-300 hover:bg-gray-300/90 active:scale-95 transition-all text-warna-300 w-full px-7 py-2 md:py-3 rounded-lg cursor-pointer"
                        >OK</button>
                    </div>
                </x-modal>
            </div>
        @endif
        <h2 class="font-semibold text-xl text-warna-300 leading-tight mt-10 mb-6">
            Akun Terdaftar
        </h2>

        <script>
            const form = document.getElementById('verifikasiForm');
            const loadingModal = document.getElementById('loadingModal');

            form.addEventListener('submit', function () {
                loadingModal.classList.remove('hidden');
                loadingModal.classList.add('flex');
            });
        </script>

</div>
