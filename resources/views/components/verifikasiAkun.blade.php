<x-Layout>
    <div class="bg-white p-6 rounded-lg shadow-md mt-7">
        <h2 class="font-semibold text-xl text-warna-300 leading-tight mb-6">
            Verifikasi Akun
        </h2>
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table
                class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400 border-collapse border border-gray-200 bg-warna-100">
                <thead class="text-xs text-warna-300 uppercase border-b-2 border-gray-200 ">
                    <tr>
                        <th scope="col" class="px-10 py-3  whitespace-nowrap   border-r border-warna-200 ">
                            No
                        </th>
                        <th scope="col"
                            class="px-10 py-4  whitespace-nowrap   border-r border-warna-200">
                            Nama Lengkap
                        </th>
                        <th scope="col" class="px-10 py-4  whitespace-nowrap  ">
                            NIK
                        </th>
                        <th scope="col"
                            class="px-10 py-4  whitespace-nowrap   border-r border-warna-200">
                            Username
                        </th>
                        <th scope="col" class="px-10 py-4  whitespace-nowrap ">
                            Email
                        </th>
                        <th scope="col" class="px-10 py-4  whitespace-nowrap ">
                            Aksi
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                    <tr class="bg-white border-b text-warna-300 border-gray-200">
                            <td class="px-10 py-3 whitespace-nowrap  font-medium">
                                {{ $loop->iteration }}
                            </td>
                            <td class="px-10 py-3 whitespace-nowrap font-medium">
                                {{ $user->name }}
                            </td>
                            <td class="px-10 py-3 whitespace-nowrap">
                                {{ $user->nik }}
                            </td>
                            <td class="px-10 py-3 whitespace-nowrap font-medium">
                                {{ $user->username }}
                            </td>
                            <td class="px-10 py-3 whitespace-nowrap">
                                {{ $user->email }}
                            </td>
                            <td class="px-10 py-3 whitespace-nowrap flex flex-col gap-1">
                                <form
                                id="verifikasiForm"
                                class="flex items-center gap-1"
                                x-data="{ loading: true }"
                                @submit="loading = true"
                                action="{{ route('ubahStatus', $user->id) }}" method="POST">
                                    @csrf
                                    <div data-tooltip-target="tooltip-approve-{{ $user->id }}" data-tooltip-placement="top">
                                        <button type="submit" name="status" value="approved" class="bg-warna-500 hover:bg-warna-500/80 active:scale-95 transition-all text-white px-4 py-2 rounded-lg cursor-pointer">
                                            <i class="fa-solid fa-check"></i>
                                        </button>
                                    </div>
                                    <div id="tooltip-approve-{{ $user->id }}" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-xs font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                                        Setujui Akun
                                        <div class="tooltip-arrow" data-popper-arrow></div>
                                    </div>

                                    <div data-tooltip-target="tooltip-reject-{{ $user->id }}" data-tooltip-placement="top">
                                        <button type="submit" name="status" value="rejected" class="bg-warna-800 hover:bg-warna-800/80 active:scale-95 transition-all text-white px-4 py-2 rounded-lg cursor-pointer">
                                            <i class="fa-solid fa-times"></i>
                                        </button>
                                    </div>
                                    <div id="tooltip-reject-{{ $user->id }}" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-xs font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                                        Tolak Akun
                                        <div class="tooltip-arrow" data-popper-arrow></div>
                                    </div>

                                    
                                </form>
                            </td>
                        @empty
                            <td colspan="6" class="px-10 py-3 text-base text-center text-gray-500">
                                Tidak ada data akun yang perlu diverifikasi
                            </td>
                        </tr>
                        @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="bg-white p-6 rounded-lg shadow-md mt-7">
        <h2 class="font-semibold text-xl text-warna-300 leading-tight mb-6">
            Akun Terdaftar
        </h2>
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table
                class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400 border-collapse border border-gray-200 bg-warna-100">
                <thead class="text-xs text-warna-300 uppercase border-b-2 border-gray-200 ">
                    <tr>
                        <th scope="col" class="px-10 py-3  whitespace-nowrap   border-r border-warna-200 ">
                            No
                        </th>
                        <th scope="col"
                            class="px-10 py-4  whitespace-nowrap   border-r border-warna-200">
                            Nama Lengkap
                        </th>
                        <th scope="col" class="px-10 py-4  whitespace-nowrap  ">
                            NIK
                        </th>
                        <th scope="col"
                            class="px-10 py-4  whitespace-nowrap   border-r border-warna-200">
                            Username
                        </th>
                        <th scope="col" class="px-10 py-4  whitespace-nowrap ">
                            Email
                        </th>
                        <th scope="col" class="px-10 py-4  whitespace-nowrap ">
                            Role
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($accounts as $account)
                    <tr class="bg-white border-b text-warna-300 border-gray-200">
                            <td class="px-10 py-3 whitespace-nowrap  font-medium">
                                {{ $loop->iteration }}
                            </td>
                            <td class="px-10 py-3 whitespace-nowrap font-medium">
                                {{ $account->name }}
                            </td>
                            <td class="px-10 py-3 whitespace-nowrap">
                                {{ $account->nik }}
                            </td>
                            <td class="px-10 py-3 whitespace-nowrap font-medium">
                                {{ $account->username }}
                            </td>
                            <td class="px-10 py-3 whitespace-nowrap">
                                {{ $account->email }}
                            </td>
                            <td class="px-10 py-3 whitespace-nowrap flex flex-col gap-1">
                                @if ($account->role == 'kepalaLingkungan')
                                    <p>Kepala Lingkungan</p>
                                @elseif ($account->role == 'penanggungJawab')
                                    <p>Penanggung Jawab</p>
                                @else
                                    <p>Unknown</p>
                                @endif
                            </td>
                        @empty
                            <td colspan="6" class="px-10 py-3 text-base text-center text-gray-500">
                                Tidak ada data akun yang perlu diverifikasi
                            </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
        

        
        
       


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

        <script>
            const form = document.getElementById('verifikasiForm');
            const loadingModal = document.getElementById('loadingModal');

            form.addEventListener('submit', function () {
                loadingModal.classList.remove('hidden');
                loadingModal.classList.add('flex');
            });
        </script>


</x-Layout>