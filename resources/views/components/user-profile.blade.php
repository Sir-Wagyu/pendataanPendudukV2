<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>SIDUKTANG</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite('resources/css/app.css')
    @vite([])
    @livewireStyles

     <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
     integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
     crossorigin=""/>

     <script src="https://unpkg.com/@popperjs/core@2"></script>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
     integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
     crossorigin=""></script>
     <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
                    <p class="hidden md:block text-xl font-semibold sm:text-xl whitespace-nowrap text-warna-300">SIDUKTANG BKR</p>
                    
                    <i id="avatarButton" data-dropdown-toggle="userDropdown" class="mr-4 fa-solid fa-circle-user text-4xl cursor-pointer text-warna-300 active:scale-95 transition-all hover:text-warna-400"></i>

                    

                    <!-- Dropdown menu -->
                    <div id="userDropdown" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow-lg w-44 ">
                        <div class="px-4 py-3 text-sm text-gray-900 ">
                        <div>{{ Auth::user()->name }}</div>
                        <p class="text-xs text-gray-400" class="font-medium truncate">
                            @if(Auth::user()->role == 'admin')
                                Admin
                            @elseif(Auth::user()->role == 'kepalaLingkungan')
                                Kepala Lingkungan
                            @elseif(Auth::user()->role == 'penanggungJawab')
                                Penanggung Jawab
                            @else
                                Penduduk
                            @endif
                        </p>
                        </div>
                        <ul class="py-2 text-sm text-gray-700 " aria-labelledby="avatarButton">
                            <li>
                                <a href="/user-profile" class="block px-4 py-2 hover:bg-warna-400/30 ">Settings</a>
                            </li>
                        </ul>

                    </div>

                </div>
            </div>
        </nav>
        <aside id="logo-sidebar"
            class="md:hidden fixed top-0 left-0 z-40 w-64 h-screen pt-20 transition-transform -translate-x-full bg-warna-100 border-r border-gray-200 sm:translate-x-0"
            aria-label="Sidebar">
            <div class="h-full px-3 pb-4 overflow-y-auto bg-warna-100">
                <ul class="space-y-5 font-medium">
                    <li>
                        <a href="/dashboard"
                            class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-warna-400/30 group">
                            <i class="fa-solid fa-house mr-3 text-warna-300 group-hover:text-warna-400"></i>
                            <span class="ml-3">Dashboard</span>
                        </a>
                    </li>
                    <li>
                        <a href="/user-profile"
                            class="{{ request()->is('user-profile') ? 'bg-warna-400/30 text-warna-300' : '' }} flex items-center p-2 text-gray-900 rounded-lg hover:bg-warna-400/30 group">
                            <i class="fa-solid fa-user-gear mr-3 text-warna-300 group-hover:text-warna-400"></i>
                            <span class="ml-3">User Profile</span>
                        </a>
                    </li>
                    <li>
                        <a href="/user-profile/ganti-password"
                            class="{{ request()->is('user-profile/ganti-password') ? 'bg-warna-400/30 text-warna-300' : '' }} flex items-center p-2 text-gray-900 rounded-lg hover:bg-warna-400/30 group">
                            <i class="fa-solid fa-unlock mr-3 text-warna-300 group-hover:text-warna-400"></i>
                            <span class="ml-3">Ganti Password</span>
                        </a>
                    </li>
                    <li>
                        <button
                            type="button"
                            x-data
                            @click="$dispatch('show-logout-modal')"
                            class="w-full flex items-center p-2 text-warna-800 rounded-lg hover:bg-warna-800/30 group">
                            <i class="fa-solid fa-right-from-bracket mr-3 text-warna-800 group-hover:text-warna-800"></i>
                            <span class="ml-3">User Profile</span>
                        </button>
                    </li>
                    
            </div>
        </aside>
        <main class="p-4 max-w-5xl md:flex mx-auto bg-gray-100 overflow-hidden">
            <div class="w-[30%] hidden md:block">
                <div class="mt-20 bg-white shadow-md rounded-lg p-6 mr-4">
                    <p class="text-lg font-semibold mb-10">Profile</p>
                    <div class="flex flex-col border-warna-300 mb-6 gap-5">
                        <a href="/dashboard" class="flex items-center gap-2 text-gray-700 hover:text-warna-400 transition-colors group"> 
                            <i class="fa-solid fa-house mr-2 text-warna-300 group-hover:text-warna-400"></i>
                            Kembali
                        </a>
                        <a href="/user-profile" class="flex items-center gap-2 text-gray-700 hover:text-warna-400 transition-colors group {{ request()->is('user-profile') ? 'text-warna-400 font-medium' : '' }}">
                            <i class="fa-solid fa-user-gear mr-2 text-warna-300 group-hover:text-warna-400 {{ request()->is('user-profile') ? 'text-warna-400' : '' }}"></i>
                            Detail User
                        </a>
                        <a href="/user-profile/ganti-password" class="flex items-center gap-2 text-gray-700 hover:text-warna-400 transition-colors group {{ request()->is('user-profile/ganti-password') ? 'text-warna-400 font-medium' : '' }}">
                            <i class="fa-solid fa-unlock mr-2 text-warna-300 group-hover:text-warna-400 {{ request()->is('user-profile/ganti-password') ? 'text-warna-400' : '' }}"></i>
                            Ganti Password
                        </a>
                        <button 
                            type="button"
                            x-data
                            @click="$dispatch('show-logout-modal')"
                            class="flex items-center gap-2 text-gray-700 hover:text-warna-800 transition-colors group">
                            <i class="fa-solid fa-right-from-bracket mr-2 text-warna-300 group-hover:text-warna-800"></i>
                            Logout
                        </button>
                    </div>
                </div>
            </div>
            <div class="w-full md:w-[70%] ">
                

                @livewire('user-profile')
            </div>

            <!-- Modal for Logout Confirmation -->
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
        </main>
    </div>

    @livewireScripts
    <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>
</body>
</html>
