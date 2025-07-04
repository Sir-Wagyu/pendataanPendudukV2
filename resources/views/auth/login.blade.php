<!DOCTYPE html>
<html lang="en">
<head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <meta http-equiv="X-UA-Compatible" content="ie=edge">
      <title>Selamat Datang di Pendataan Penduduk</title>
      @vite('resources/css/app.css')
      @vite([])
      <script src="//unpkg.com/alpinejs" defer></script>
</head>
<body x-data="{ showModal: false }" class="bg-gray-100 w-full h-screen flex items-center justify-center font-roboto">


      <div class=" w-full md:w-[50%] lg:w-[40%] h-full bg-warna-100 p-7 md:p-9 lg:p-12 flex flex-col justify-center items-center md:justify-between md:items-start">
            <div class="w-16 h-16 md:w-12 md:h-12 rounded-full bg-warna-400 flex justify-center items-center text-white">
                  <p>Icon</p>
            </div>
            <div class="mt-4 md:mt-20 lg:mt-20 w-full ">
                  
                  <h1 class="text-3xl xl:text-4xl font-semibold text-center md:text-left">Selamat Datang Kembali!</h1>
                  <p class="hidden text-sm lg:text-base md:block mt-3 text-center md:text-left">Masuk untuk mendapatkan akses data dan informasi kependudukan pendatang.</p>
                  <form action="{{ route('loginSubmit') }}" method="post">
                        @csrf
                        <div class="mt-15">
                              @if(session('success'))
                                    <div class="bg-green-100 text-green-500 px-4 py-2 rounded-md mt-4 text-center">
                                          <p>{{ session('success') }}</p>
                                    </div>
                              @endif
                              <div class="relative mt-6">
                                    <input type="text" id="username" name="username" class="block w-full px-3 py-2 md:py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-warna-400 focus:border-warna-400 sm:text-sm peer" placeholder=" " required/>
                                    <label for="username" class="absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-2 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-warna-400 peer-focus:dark:text-indigo-400 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 left-3">Username</label>
                              </div>
                                <div class="relative mt-6">
                                          <input type="password" id="password" name="password" class="block w-full px-3 py-2 md:py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-warna-400 focus:border-warna-400 sm:text-sm peer" placeholder=" " required/>
                                          <label for="password" class="absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-2 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-warna-400 peer-focus:dark:text-indigo-400 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 left-3">Password</label>
                                          <button type="button" onclick="togglePassword()" class="absolute inset-y-0 right-0 px-3 py-2 text-gray-500 focus:outline-none">
                                                <span id="eyeIcon"><i class="fa-solid fa-eye"></i></span>
                                          </button>
                                </div>
                              <div class="mt-8 md:mt-9">

                                    @if(session('error'))
                                    <p class=" mb-2 text-warna-800">{{ session('error') }}</p>
                                    @endif
                                    <button class="px-3 py-2 md:py-3 rounded-md bg-warna-400 hover:bg-warna-400/90 active:scale-95 transition-all text-warna-100 w-full ">Login</button>
                              </div>
                              <div class="flex flex-col md:flex-row justify-between mt-5 md:mt-6 gap-3 text-center md:text-left">
                                    <a @click="showModal = true" class="text-sm text-warna-400 underline md:order-2 cursor-pointer">Lupa akun saya? </a>
                                    <p class="text-sm mt-3 md:mt-0 md:order-1">Pemilik kos baru? <a href="{{ route('register') }}" class="text-warna-400 underline">Daftar Akun</a> </p>
                              </div>
                        </div>
                  </form>
            </div>
            <div></div>
      </div>
      <div x-show="showModal" x-cloak>
      <!-- Backdrop -->
            <div x-show="showModal" 
                  x-transition:enter="transition ease-out duration-300" 
                  x-transition:enter-start="opacity-0" 
                  x-transition:enter-end="opacity-100"
                  x-transition:leave="transition ease-in duration-200" 
                  x-transition:leave-start="opacity-100" 
                  x-transition:leave-end="opacity-0"
                  class="fixed inset-0 bg-black/60 bg-opacity-50 z-40"
                  @click="showModal = false">
            </div>

            <!-- Modal -->
            <div x-show="showModal" 
                  x-transition:enter="transition ease-out duration-300" 
                  x-transition:enter-start="opacity-0 transform scale-95" 
                  x-transition:enter-end="opacity-100 transform scale-100"
                  x-transition:leave="transition ease-in duration-200" 
                  x-transition:leave-start="opacity-100 transform scale-100" 
                  x-transition:leave-end="opacity-0 transform scale-95"
                  class="fixed inset-0 flex items-center justify-center z-50 p-4">
                  
                  <div class="bg-white rounded-lg shadow-lg w-full max-w-md" @click.stop>
                        <!-- Modal Header -->
                        <div class="flex flex-col items-center justify-between px-6 pt-6 pb-4">
                              <i class="fa-solid fa-circle-question text-gray-400 text-5xl mb-2"></i>
                              <h3 class="text-lg font-semibold text-center text-gray-900">Lupa Password?</h3>
                        </div>

                        <!-- Modal Body -->
                        <div class="px-6 pb-6">
                              <p class="text-sm text-gray-600 mb-6 text-center">Masukkan email Anda untuk mendapatkan kode reset</p>

                              <form action="{{ route('forgotPassword') }}" method="POST">
                                    @csrf
                                    <div class="relative">
                                          <input type="text" 
                                                id="forgot_email" 
                                                name="email" 
                                                class="block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-warna-400 focus:border-warna-400 sm:text-sm peer" 
                                                placeholder=" " 
                                                required/>
                                          <label for="forgot_email" 
                                                class="absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-2 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-warna-400 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 left-3">
                                                Email
                                          </label>
                                          @error('email')
                                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p> 
                                          @enderror
                                    </div>

                                    <!-- Modal Footer -->
                                    <div class="flex gap-3 mt-6">
                                          <button type="button" 
                                                      @click="showModal = false"
                                                      class="flex-1 px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 border border-gray-300 rounded-md hover:bg-gray-200 focus:outline-none transition-colors">
                                                Batal
                                          </button>
                                          <button type="submit" 
                                                      class="flex-1 px-4 py-2 text-sm font-medium text-white bg-warna-400 border border-transparent rounded-md hover:bg-warna-400/90 focus:outline-none transition-colors">
                                                Kirim
                                          </button>
                                    </div>
                              </form>
                        </div>
                  </div>
            </div>
      </div>
      <div class="hidden md:block md:w-[50%] lg:w-[60%] h-full bg-warna-400 relative">
            <img src="/ulunDanu.jpg" alt="Pura Ulun Danu" class="w-full h-full object-cover">
            <div class="w-full h-full absolute top-0 left-0 text-white z-12">
                  <div class="w-full h-full flex flex-col justify-center items-center text-center px-4 xl:w-[70%] mx-auto">
                        <h1 class="text-3xl lg:text-4xl xl:text-5xl font-bold tracking-wide text-pretty">SIDUKTANG</h1>
                        <h2 class="text-xl lg:text-2xl xl:text-3xl  font-semibold tracking-wide text-pretty">Sistem Data Kependudukan Pendatang

                        </h2>
                        <p class="mt-3 lg:mt-6 xl:text-lg text-center">Tertib Administrasi, Kemudahan Pendataan, dan Legalitas Tinggal dalam Satu Sistem</p>
                  </div>
            </div>
            <div class="w-full h-full absolute top-0 left-0 bg-warna-400/70 z-10"></div>
      </div>


      <script>
            function togglePassword() {
                    const passwordInput = document.getElementById('password');
                    const eyeIcon = document.getElementById('eyeIcon');
                    if (passwordInput.type === 'password') {
                              passwordInput.type = 'text';
                              eyeIcon.innerHTML = '<i class="fa-solid fa-eye-slash"></i>';
                    } else {
                              passwordInput.type = 'password';
                              eyeIcon.innerHTML = '<i class="fa-solid fa-eye"></i>';
                    }
            }
      </script>
</body>
</html>


