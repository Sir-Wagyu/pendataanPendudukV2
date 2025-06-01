{{-- filepath: c:\laragon\www\pendataanPendudukV2\resources\views\livewire\user-profile.blade.php --}}

<div class="mt-20 bg-white shadow-md rounded-lg p-6">
    {{-- GANTI request()->is() DENGAN $currentView --}}
    @if($currentView === 'profile')
        <div class="flex items-center justify-between border-warna-300 mb-10">
            <div></div>
            <div>
                <p class="text-xl font-semibold">Detail User</p>
            </div>
            <div></div>
        </div>
        <div class="max-h-[60dvh] md:max-h-[65dvh] overflow-y-auto pr-2 w-full">
            <x-g-input 
                type="text"
                label="Nama Lengkap"
                name="name"
                wireModel="name"
                class="mt-5 mb-4 md:mb-6"
            />
            <x-g-input
                type="text"
                label="Email"
                name="email"
                wireModel="email"
                class="mb-4 md:mb-6"
            />
            <x-g-input
                type="text"
                label="Nomor Telepon"
                name="telepon"
                wireModel="telepon"
                class="mb-4 md:mb-6"
            />

            <p class="text-sm mb-2"><i class="fa-solid fa-location-dot"></i> Alamat</p>
            <div 
                id="mapProfile"
                class="w-full h-96 mb-4 md:mb-6 rounded-lg z-0"
                wire:ignore
                x-data
                x-init="
                const map = L.map('mapProfile').setView([{{ $latitude }}, {{ $longitude }}], 15);
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    maxZoom: 19,
                }).addTo(map);
                L.marker([{{ $latitude }}, {{ $longitude }}]).addTo(map);
                "
            ></div>

            <div class="w-full flex mb-4 md:mb-6 gap-3">
                <x-g-input
                    type="text"
                    label="Latitude"
                    name="latitude"
                    wireModel="latitude"
                    class="w-full disabled:opacity-50"
                    disabled
                />
                <x-g-input
                    type="text"
                    label="Longitude"
                    name="longitude"
                    wireModel="longitude"
                    class="w-full disabled:opacity-50"
                    disabled
                />
            </div>

            <x-g-input
                type="text"
                label="Alamat"
                name="alamat"
                wireModel="alamat"
                class="mb-4 md:mb-6"
            />

        </div>

        <div class="mt-6">
            <button 
                wire:click="updateProfile" 
                wire:loading.attr="disabled"
                wire:target="updateProfile"
                class="w-full bg-warna-400 hover:bg-warna-400/80 text-white font-medium py-2 md:py-3 rounded-lg transition-all active:scale-95 disabled:opacity-50 disabled:cursor-not-allowed relative">
                
                <span wire:loading.remove wire:target="updateProfile">
                    <i class="fa-solid fa-save mr-2"></i>
                    Simpan Perubahan
                </span>
                <span wire:loading wire:target="updateProfile" class="flex items-center  justify-center">
                    <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Menyimpan...
                </span>
            </button>
        </div>
    @endif

    @if($currentView === 'change-password')
        <div class="flex items-center justify-between border-warna-300 mb-10">
            <div></div>
            <div>
                <p class="text-xl font-semibold">Ganti Password</p>
            </div>
            <div></div>
        </div>
        <div class="max-h-[60dvh] md:max-h-[65dvh] xl:max-h-[70dvh] overflow-y-auto pr-2 w-full">

            <div class="relative mb-4 md:mb-6 mt-6">
                <input 
                    type="password" 
                    id="passwordLama" 
                    name="passwordLama" 
                    class="block w-full px-3 py-2 md:py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-warna-400 focus:border-warna-400 sm:text-sm peer" 
                    wire:model="passwordLama"
                    placeholder=" "
                />
                <label for="passwordLama" class="absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-2 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-warna-400 peer-focus:dark:text-indigo-400 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 left-3">Password Lama</label>
                <button type="button" onclick="togglePassword('passwordLama', 'eyeIcon1')" class="absolute inset-y-0 right-0 px-3 py-2 text-gray-500 focus:outline-none">
                    <span id="eyeIcon1"><i class="fa-solid fa-eye"></i></span>
                </button>
            </div>
            
            <div class="relative mb-4 md:mb-6 mt-6">
                <input 
                    type="password" 
                    id="passwordBaru" 
                    name="passwordBaru" 
                    class="block w-full px-3 py-2 md:py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-warna-400 focus:border-warna-400 sm:text-sm peer" 
                    wire:model="passwordBaru"
                    placeholder=" " 
                    required
                />
                <label for="passwordBaru" class="absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-2 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-warna-400 peer-focus:dark:text-indigo-400 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 left-3">Password Baru</label>
                <button type="button" onclick="togglePassword('passwordBaru', 'eyeIcon2')" class="absolute inset-y-0 right-0 px-3 py-2 text-gray-500 focus:outline-none">
                    <span id="eyeIcon2"><i class="fa-solid fa-eye"></i></span>
                </button>
            </div>
            
            <div class="relative mb-4 md:mb-6 mt-6">
                <input 
                    type="password" 
                    id="password_confirmation" 
                    name="password_confirmation" 
                    class="block w-full px-3 py-2 md:py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-warna-400 focus:border-warna-400 sm:text-sm peer" 
                    wire:model="password_confirmation"
                    placeholder=" " 
                    required
                />
                <label for="password_confirmation" class="absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-2 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-warna-400 peer-focus:dark:text-indigo-400 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 left-3">Konfirmasi Password</label>
                <button type="button" onclick="togglePassword('password_confirmation', 'eyeIcon3')" class="absolute inset-y-0 right-0 px-3 py-2 text-gray-500 focus:outline-none">
                    <span id="eyeIcon3"><i class="fa-solid fa-eye"></i></span>
                </button>
            </div>

            <div class="mt-6">
                <button 
                    wire:click="changePassword" 
                    wire:loading.attr="disabled"
                    wire:target="changePassword"
                    class="w-full bg-warna-400 hover:bg-warna-400/80 text-white font-medium py-2 md:py-3 rounded-lg transition-all active:scale-95 disabled:opacity-50 disabled:cursor-not-allowed relative">
                    
                    <span wire:loading.remove wire:target="changePassword">
                        <i class="fa-solid fa-key mr-2"></i>
                        Ganti Password
                    </span>
                    <span wire:loading wire:target="changePassword" class="flex items-center justify-center">
                        <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <p>
                            Memproses...
                        </p>
                    </span>
                </button>
            </div>
        </div>
    @endif

    @if(session()->has('message'))
        <div class="fixed z-50 inset-0 flex items-center justify-center bg-warna-300/50 ">
            <x-modal class="relative bg-white flex flex-col items-center mx-5 md:mx-0 w-full md:w-1/2 lg:w-[45%] xl:w-[30%] py-7 md:py-10 ">
                <i class="absolute -top-12 {{ session('message.type') == 'success' ? 'fa-solid fa-circle-check text-warna-600' : 'fa-solid fa-triangle-exclamation text-warna-800' }} bg-white p-4 rounded-full  text-6xl md:text-7xl xl:text-8xl"></i>
                <div class="flex flex-col items-center mt-5 lg:mt-12 mb-8 lg:mb-10">
                    <h2 class="text-lg md:text-xl xl:text-2xl text-center font-bold mb-1 md:mb-2">{{ session('message.title') }}</h2>
                    <p class="text-center w-3/4">{{ session('message.description') }}</p>
                </div>
                <div></div>
                <div class="flex justify-center w-[90%] ">
                    <button type="button" wire:click="clearMessage" class="mr-2 bg-gray-300 hover:bg-gray-300/90 active:scale-95 transition-all text-warna-300 w-full px-7 py-2 md:py-3 rounded-lg cursor-pointer">OK</button>
                </div>
            </x-modal>     
        </div>
    @endif
    

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
    </script>
</div>