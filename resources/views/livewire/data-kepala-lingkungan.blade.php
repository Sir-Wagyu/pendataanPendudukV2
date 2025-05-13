
    <div>
        <div class="w-full flex justify-between items-center py-3  mb-6">
            <h2 class="font-semibold text-xl text-warna-300 leading-tight">
                Data Kepala Lingkungan
            </h2>
    
            <button data-tooltip-target='tooltip-bottom' data-tooltip-placement="bottom" type="button" wire:click="openModal" class="w-9 md:w-11 h-9 md:h-11 bg-warna-500 rounded-lg flex justify-center items-center text-white shadow-lg hover:bg-warna-500/80 active:scale-95 transition-all cursor-pointer"><i class="fa-solid fa-user-plus md:text-lg "></i></button>

            <div id="tooltip-bottom" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-xs font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-xs opacity-0 tooltip dark:bg-gray-700">
                Tambah Data
                <div class="tooltip-arrow" data-popper-arrow></div>
            </div>
            
        </div>


        <!-- Pesan Sukses -->
        @if (session()->has('message'))
            <div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-4">
                {{ session('message') }}
            </div>
        @endif

        
        <!-- Tabel Data -->
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table
                class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400 border-collapse border border-gray-200 bg-warna-100">
                <thead class="text-xs text-warna-300 uppercase border-b-2 border-gray-200 ">
                    <tr>
                        <th scope="col" class="px-5 py-2 md:px-10 md:py-3  whitespace-nowrap  sticky left-0 bg-white  border-r border-warna-200 ">
                            No
                        </th>
                        <th scope="col"
                            class="px-10 py-4  whitespace-nowrap  md:sticky md:left-23 bg-white border-r border-warna-200">
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
                            Aksi
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $index => $user)
                        <tr class="border-t-2 bg-white border-b text-warna-300 border-gray-200">
                            <td class="px-5 py-2 md:px-10 md:py-3 sticky left-0 bg-white">{{ $index + 1 }}</td>
                            <td class="px-10 py-3">{{ $user->name }}</td>
                            <td class="px-10 py-3">{{ $user->nik }}</td>
                            <td class="px-10 py-3">{{ $user->email }}</td>
                            <td class="px-10 py-3">{{ $user->telepon }}</td>
                            <td class="px-10 py-3">{{ $user->alamat }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-4">Tidak ada data</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Modal -->
        @if ($isModalOpen === true)
            <div class="fixed z-40 inset-0 flex items-center justify-center bg-warna-300/50 ">
                <div class="bg-white  mx-5 md:mx-0 w-full md:w-3/4 lg:w-3/5 xl:w-1/2 px-10 py-8 rounded-lg shadow-lg">
                    <h2 class="text-lg lg:text-xl font-bold mb-10">{{ $selectedId ? 'Edit Data' : 'Tambah Data' }}</h2>
                    <form wire:submit.prevent="save" class="space-y-4">
                        <div class="mt-6 grid grid-cols-2 gap-4">
                            <div class="relative">
                                <input type="text" id="name" name="name" class="block w-full px-3 py-2 md:py-3 border border-gray-300 rounded-md  focus:outline-none focus:ring-warna-400 focus:border-warna-400 sm:text-sm peer" placeholder=" "  value="{{ old('name') }}"/>
                                <label for="nama" class="absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-warna-400 peer-focus:dark:text-indigo-400 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 left-3">Nama Lengkap</label>
                            </div>
                            <div class="relative ">
                                <input type="email" id="email" name="email" class="block w-full px-3 py-2 md:py-3 border border-gray-300 rounded-md  focus:outline-none focus:ring-warna-400 focus:border-warna-400 sm:text-sm peer" placeholder=" "  value="{{ old('email') }}"/>
                                <label for="nama" class="absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-warna-400 peer-focus:dark:text-indigo-400 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 left-3">Email</label>
                            </div>
                        </div>
                        <div class="relative mt-6">
                            <input type="number" id="nik" name="nik" class="block w-full px-3 py-2 md:py-3 border border-gray-300 rounded-md  focus:outline-none focus:ring-warna-400 focus:border-warna-400 sm:text-sm peer" placeholder=" "  value="{{ old('nik') }}"/>
                            <label for="nama" class="absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-warna-400 peer-focus:dark:text-indigo-400 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 left-3">NIK</label>
                        </div>
                        <div class="relative mt-6">
                            <input type="number" id="telepon" name="telepon" class="block w-full px-3 py-2 md:py-3 border border-gray-300 rounded-md  focus:outline-none focus:ring-warna-400 focus:border-warna-400 sm:text-sm peer" placeholder=" "  value="{{ old('telepon') }}"/>
                            <label for="nama" class="absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-warna-400 peer-focus:dark:text-indigo-400 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 left-3">No Telepon</label>
                        </div>
                        <div class="relative mt-6">
                            <input type="text" id="alamat" name="alamat" class="block w-full px-3 py-2 md:py-3 border border-gray-300 rounded-md  focus:outline-none focus:ring-warna-400 focus:border-warna-400 sm:text-sm peer" placeholder=" "  value="{{ old('alamat') }}"/>
                            <label for="nama" class="absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-warna-400 peer-focus:dark:text-indigo-400 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 left-3">Alamat</label>
                        </div>
                        <div class="relative mt-6">
                            <input type="text" id="username" name="username" class="block w-full px-3 py-2 md:py-3 border border-gray-300 rounded-md  focus:outline-none focus:ring-warna-400 focus:border-warna-400 sm:text-sm peer" placeholder=" "  value="{{ old('username') }}"/>
                            <label for="nama" class="absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-warna-400 peer-focus:dark:text-indigo-400 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 left-3">Username</label>
                </div> 
                        <div class="flex justify-end mt-10">
                            <button type="button" wire:click="closeModal" class="mr-2 bg-gray-300 hover:bg-gray-300/90 active:scale-95 transition-all text-warna-300 px-7 py-2 rounded-lg cursor-pointer">Batal</button>
                            <button type="submit" class="bg-warna-600 hover:bg-warna-600/90 active:scale-95 transition-all text-white px-7 py-2 rounded-lg cursor-pointer">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        @endif
    </div>
