<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Dashboard Pendataan Penduduk</title>
    @vite('resources/css/app.css')
    @vite([])
    @livewireStyles
</head>

<body class="font-roboto">
    <div class="min-h-screen bg-gray-100">
        <nav class="fixed top-0 z-50 w-full bg-white border-b border-gray-200">
            <div class="px-3 py-4 lg:px-5 lg:pl-3">
                <div class="flex items-center justify-between md:mx-3">
                    <div class="flex items-center justify-start md:hidden  rtl:justify-end">
                        <button data-drawer-target="logo-sidebar" data-drawer-toggle="logo-sidebar"
                            aria-controls="logo-sidebar" type="button"
                            class="inline-flex items-center p-2 text-sm text-gray-500 rounded-lg sm:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200">
                            <span class="sr-only">Open sidebar</span>
                            <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path clip-rule="evenodd" fill-rule="evenodd"
                                    d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z">
                                </path>
                            </svg>
                        </button>
                        
                    </div>
                    <p class="hidden md:block text-xl font-semibold sm:text-xl whitespace-nowrap text-warna-300">SIDUKTANG Desa X</p>
                    <p class="text-xl font-semibold sm:text-lg whitespace-nowrap text-warna-300">{{ Auth::user()->name }}</p>
                </div>
            </div>
        </nav>

        <aside id="logo-sidebar"
            class="fixed top-0 left-0 z-40 w-64 h-screen pt-20 transition-transform -translate-x-full bg-warna-100 border-r border-gray-200 sm:translate-x-0"
            aria-label="Sidebar">
            <div class="h-full px-3 pb-4 overflow-y-auto bg-warna-100">
                <ul class="space-y-2 font-medium">
                    
                    <li>
                        <a href="/dashboard"
                        class="{{ request()->is('dashboard') ? 'bg-warna-400/30 text-warna-300' : '' }} flex items-center px-2 py-4 text-warna-300 hover:bg-warna-400/35 hover:text-warna-300 group rounded-lg ">
                        <svg class="w-5 h-5 text-warna-300 transition duration-75 " aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 21">
                                <path
                                    d="M16.975 11H10V4.025a1 1 0 0 0-1.066-.998 8.5 8.5 0 1 0 9.039 9.039.999.999 0 0 0-1-1.066h.002Z" />
                                <path
                                    d="M12.5 0c-.157 0-.311.01-.565.027A1 1 0 0 0 11 1.02V10h8.975a1 1 0 0 0 1-.935c.013-.188.028-.374.028-.565A8.51 8.51 0 0 0 12.5 0Z" />
                            </svg>
                            <span class="ms-3">Dashboard</span>
                        </a>
                    </li>
                    @if (Auth::user()->role == 'admin')     
                        <li>
                            <a href="{{ route('verifikasiAkun') }}"
                                class="{{ request()->is('verifikasi-akun') ? 'bg-warna-400/30 text-warna-300' : '' }} flex items-center px-2 py-4 text-warna-300 hover:bg-warna-400/35 hover:text-warna-300 group rounded-lg ">
                                <svg class=" w-5 h-5 text-warna-300 transition duration-75 " aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                    <path fill-rule="evenodd" d="M12 2c-.791 0-1.55.314-2.11.874l-.893.893a.985.985 0 0 1-.696.288H7.04A2.984 2.984 0 0 0 4.055 7.04v1.262a.986.986 0 0 1-.288.696l-.893.893a2.984 2.984 0 0 0 0 4.22l.893.893a.985.985 0 0 1 .288.696v1.262a2.984 2.984 0 0 0 2.984 2.984h1.262c.261 0 .512.104.696.288l.893.893a2.984 2.984 0 0 0 4.22 0l.893-.893a.985.985 0 0 1 .696-.288h1.262a2.984 2.984 0 0 0 2.984-2.984V15.7c0-.261.104-.512.288-.696l.893-.893a2.984 2.984 0 0 0 0-4.22l-.893-.893a.985.985 0 0 1-.288-.696V7.04a2.984 2.984 0 0 0-2.984-2.984h-1.262a.985.985 0 0 1-.696-.288l-.893-.893A2.984 2.984 0 0 0 12 2Zm3.683 7.73a1 1 0 1 0-1.414-1.413l-4.253 4.253-1.277-1.277a1 1 0 0 0-1.415 1.414l1.985 1.984a1 1 0 0 0 1.414 0l4.96-4.96Z" clip-rule="evenodd"/>
                                </svg>
                                
                            <span class="flex-1 ms-3 whitespace-nowrap">
                                Verifikasi Akun
                            </a>
                        </li>
                        <li>
                            <button id="dropDownButton" class="w-full flex justify-between items-center px-2 py-4  text-warna-300 hover:bg-warna-400/35 hover:text-warna-300 group rounded-lg">
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 text-warna-300 transition duration-75" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10 3a7 7 0 1 0 0 14 7 7 0 0 0 0-14Zm0 12a5 5 0 1 1 0-10 5 5 0 0 1 0 10Z" />
                                        <path d="M10 5a5 5 0 0 0-5 5h10a5 5 0 0 0-5-5Z" />
                                    </svg>
                                    <span class="flex-1 ms-3 whitespace-nowrap">Master Data</span>
                                </div>
                                <svg class="w-4 h-4 ml-auto" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                            <ul id="dropDownContent" class="hidden space-y-2 pl-2 mt-2">
                                <li>
                                    <a href="/data-kepala-lingkungan" class="{{ request()->is('data-kepala-lingkungan') ? 'bg-warna-200 text-warna-300' : '' }} flex items-center p-2 text-warna-300 hover:bg-warna-200 hover:text-warna-300 group rounded-lg ">
                                        <svg class="w-5 h-5 text-warna-300 transition duration-75" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M10 3a7 7 0 1 0 0 14 7 7 0 0 0 0-14Zm0 12a5 5 0 1 1 0-10 5 5 0 0 1 0 10Z" />
                                            <path d="M10 5a5 5 0 0 0-5 5h10a5 5 0 0 0-5-5Z" />
                                        </svg>
                                        <span class="ms-3">Data Kepala Lingkungan</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="/data-penanggung-jawab" class="flex items-center p-2 text-warna-300 hover:bg-warna-200 hover:text-warna-300 group rounded-lg">
                                        <svg class="w-5 h-5 text-warna-300 transition duration-75" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M10 3a7 7 0 1 0 0 14 7 7 0 0 0 0-14Zm0 12a5 5 0 1 1 0-10 5 5 0 0 1 0 10Z" />
                                            <path d="M10 5a5 5 0 0 0-5 5h10a5 5 0 0 0-5-5Z" />
                                        </svg>
                                        <span class="ms-3">Data Penanggung Jawab</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="/data-penduduk"
                                class="{{ request()->is('data-penduduk') ? 'bg-warna-200 text-warna-300' : '' }} flex items-center px-2 py-4  text-warna-300 hover:bg-warna-200 hover:text-warna-300 group rounded-lg ">
                                <svg class="flex-shrink-0 w-5 h-5 text-warna-300 transition duration-75 " aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 18">
                                    <path
                                        d="M14 2a3.963 3.963 0 0 0-1.4.267 6.439 6.439 0 0 1-1.331 6.638A4 4 0 1 0 14 2Zm1 9h-1.264A6.957 6.957 0 0 1 15 15v2a2.97 2.97 0 0 1-.184 1H19a1 1 0 0 0 1-1v-1a5.006 5.006 0 0 0-5-5ZM6.5 9a4.5 4.5 0 1 0 0-9 4.5 4.5 0 0 0 0 9ZM8 10H5a5.006 5.006 0 0 0-5 5v2a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-2a5.006 5.006 0 0 0-5-5Z" />
                                </svg>
                                <span class="flex-1 ms-3 whitespace-nowrap">
                                    Data Penduduk
                                </span>
                            </a>
                        </li>
                        <li>
                            <a href="/laporan"
                                class="{{ request()->is('laporan') ? 'bg-warna-200 text-warna-300' : '' }} flex items-center px-2 py-4 text-warna-300 hover:bg-warna-200 hover:text-warna-300 group rounded-lg">
                                <svg class="flex-shrink-0 w-5 h-5 text-warna-300 transition duration-75 group-hover:text-warna-300"
                                    aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    fill="currentColor" viewBox="0 0 24 24">
                                    <path fill-rule="evenodd"
                                        d="M9 2.221V7H4.221a2 2 0 0 1 .365-.5L8.5 2.586A2 2 0 0 1 9 2.22ZM11 2v5a2 2 0 0 1-2 2H4v11a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2h-7Z"
                                        clip-rule="evenodd" />
                                </svg>
                                <span class="flex-1 ms-3 whitespace-nowrap">Laporan</span>
                            </a>
                        </li>
                    {{-- <x-nav-dashboard icon='user' title='Profil' href='/profil'/> --}}
                    @endif

                    @if(Auth::user()->role == 'penduduk')
                    
                    @endif               
                    <li>
                        <button
                            type="button"
                            x-data
                            @click="$dispatch('show-logout-modal')"
                            class="w-full flex items-center px-2 py-4 text-warna-800 rounded-lg group hover:bg-warna-200"
                        >
                            <!-- ...icon dan label... -->
                            <i class="fa-solid fa-right-from-bracket text-lg"></i>
                            <span class="w-max ms-3 whitespace-nowrap">Log Out</span>
                        </button>
                    </li>
                </ul>
            </div>
        </aside>

        <!-- konten -->
        <main class="p-4 sm:ml-64">

            <div class="p-4 border-2 border-gray-200 border-dashed rounded-lg mt-14">
                {{-- <div id="popup-modal" tabindex="-1"
                    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0  max-h-full ">
                    <div class="relative p-4 w-full max-w-md max-h-full">
                        <div class="relative bg-white rounded-lg shadow">
                            <button type="button"
                                class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
                                data-modal-hide="popup-modal">
                                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 14 14">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                </svg>
                                <span class="sr-only">Close modal</span>
                            </button>
                            <div class="relative p-4 md:p-5 text-center">
                                <i class="absolute fa-solid fa-circle-exclamation text-gray-500/80 text-7xl mb-5"></i>
                                <h3 class="mb-5 text-lg font-normal text-gray-500">Apakah anda yakin ingin logout?</h3>
                                <a href="{{ route('logout') }}" data-modal-hide="popup-modal" type="button"
                                    class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                                    Iya
                                </a>
                                <button data-modal-hide="popup-modal" type="button"
                                    class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100">Tidak</button>
                            </div>
                        </div>
                    </div>
                </div> --}}

                <div 
                    x-data="{ open: false }"
                    x-on:show-logout-modal.window="open = true"
                    x-show="open"
                    class="fixed inset-0 z-50 flex items-center justify-center bg-black/40"
                    style="display: none;"
                >
                    <x-modal class="relative bg-white flex flex-col items-center mx-5 md:mx-0 w-full md:w-1/2 lg:w-[45%] xl:w-[30%] py-7 md:py-10 ">
                        <i class="absolute -top-12 fa-solid fa-circle-exclamation text-warna-300/50 bg-white p-4 rounded-full  text-6xl md:text-7xl xl:text-8xl"></i>
                        <div class="flex flex-col items-center mt-5 lg:mt-12 mb-8 lg:mb-10">
                            <h2 class="text-lg md:text-xl xl:text-2xl text-center font-semibold mb-1 md:mb-2">Apakah anda yakin ingin logout?</h2>

                        </div>
                        <div class="flex justify-center w-[90%] ">
                            <button type="button"  @click="open = false" class="mr-2 bg-gray-300 hover:bg-gray-300/90 active:scale-95 transition-all text-warna-300 w-1/2 px-7 py-2 md:py-3 rounded-lg cursor-pointer">Tidak</button>
                            <a href="{{ route('logout') }}" @click="open = false" class="mr-2 text-white bg-warna-800 hover:bg-warna-800/90 active:scale-95 transition-all w-1/2 px-7 py-2 md:py-3 rounded-lg cursor-pointer text-center">Iya</a>
                        </div>
                    </x-modal>
                </div>

                @if(Auth::user()->must_change_password == true)
                <div id="change-password-modal" tabindex="-1"
                    class="fixed inset-0 z-50 flex items-center justify-center w-full h-full bg-black/60 bg-opacity-50">
                    <div class="relative p-4 w-full max-w-xl max-h-full">
                        <div class="relative bg-white rounded-lg shadow">
                            <div class="p-4 md:px-10 md:py-12 text-center">
                                <svg class="mx-auto mb-4 text-gray-400 w-12 md:w-14 h-12 md:h-14" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                </svg>
                                <h3 class=" text-xl text-warna-300 hidden md:block">Ini adalah login pertama Anda. </h3>
                                <h3 class="md:hidden text-lg text-warna-300">Silahkan ubah password Anda untuk keamanan</h3>
                                <p class="text-gray-500 hidden md:block">Silakan ganti password terlebih dahulu untuk keamanan.</p>
                                <form action="{{ route('updatePassword') }}" method="POST">
                                    @csrf
                                    <div class="relative mt-6 md:mt-10">
                                        <input type="password" id="newPassword" name="newPassword" class="block w-full px-3 py-2 md:py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-warna-400 focus:border-warna-400 sm:text-sm peer" placeholder=" " required/>
                                        <label for="newPassword" class="absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-2 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-warna-400 peer-focus:dark:text-indigo-400 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 left-3">Password Baru</label>
                                        <button type="button" onclick="togglePassword('newPassword', 'eyeIcon1')" class="absolute inset-y-0 right-0 px-3 py-2 text-gray-500 focus:outline-none">
                                            <span id="eyeIcon1"><i class="fa-solid fa-eye"></i></span>
                                        </button>
                                    </div>
                                    <div class="relative mt-6">
                                        <input type="password" id="confirmPassword" name="confirmPassword" class="block w-full px-3 py-2 md:py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-warna-400 focus:border-warna-400 sm:text-sm peer" placeholder=" " required/>
                                        <label for="confirmPassword" class="absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-2 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-warna-400 peer-focus:dark:text-indigo-400 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 left-3">Konfirmasi Password</label>
                                        <button type="button" onclick="togglePassword( 'confirmPassword', 'eyeIcon2')" class="absolute inset-y-0 right-0 px-3 py-2 text-gray-500 focus:outline-none">
                                            <span id="eyeIcon2"><i class="fa-solid fa-eye"></i></span>
                                        </button>
                                    </div>
                                    <button class="mt-8 md:mt-9 px-3 py-2 md:py-3 rounded-md bg-warna-400 hover:bg-warna-400/90 active:scale-95 transition-all text-warna-100 w-full ">Ubah Password</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                    {{ $slot }}

            </div>
        </main>
    </div>


    <script>
        function togglePassword(inputId, iconId) {
            const passwordInput = document.getElementById(inputId);
            const eyeIcon = document.getElementById(iconId);
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.innerHTML = '<i class="fa-solid fa-eye-slash"></i>';
            } else {
                passwordInput.type = 'password';
                eyeIcon.innerHTML = '<i class="fa-solid fa-eye"></i>';
            }
        }

        function toggleDropdown(id) {
            const dropdown = document.getElementById(id);
            if (dropdown.classList.contains('hidden')) {
                dropdown.classList.remove('hidden');
            } else {
                dropdown.classList.add('hidden');
            }
        }

        document.getElementById('dropDownButton').addEventListener('click', function(event) {
            const dropdownContent = document.getElementById('dropDownContent');
            if (dropdownContent.classList.contains('hidden')) {
            dropdownContent.classList.remove('hidden');
            dropdownContent.style.overflow = 'hidden';
            dropdownContent.style.maxHeight = '0';
            dropdownContent.style.transition = 'max-height 0.3s ease-in-out';
            setTimeout(() => {
                dropdownContent.style.maxHeight = dropdownContent.scrollHeight + 'px';
            }, 10);
            } else {
            dropdownContent.style.maxHeight = '0';
            dropdownContent.style.transition = 'max-height 0.3s ease-in-out';
            setTimeout(() => {
                dropdownContent.classList.add('hidden');
                dropdownContent.style.overflow = '';
            }, 300);
            }
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>
    @livewireScripts
</body>

</html>