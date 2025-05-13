<!DOCTYPE html>
<html lang="en">
<head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <meta http-equiv="X-UA-Compatible" content="ie=edge">
      <title>Selamat Datang di Pendataan Penduduk</title>
      @vite('resources/css/app.css')
      @vite([])
</head>
<body class="bg-gray-100 w-full h-screen flex font-roboto">
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
      <div class=" w-full md:w-[50%] lg:w-[40%] h-full bg-warna-100 px-7 my-10 md:p-9 md:my-0 lg:p-12 flex flex-col justify-center items-center md:justify-between md:items-start">
            <div class="w-16 h-16 md:w-12 md:h-12 rounded-full bg-warna-400 flex justify-center items-center text-white">
                  <p>Icon</p>
            </div>
            <div class="mt-4 md:mt-20 lg:mt-10 w-full">
                  <h1 class="text-3xl xl:text-4xl font-semibold text-center md:text-left">Buat Akun Baru</h1>
                  <p class="hidden text-sm lg:text-base md:block mt-3 text-center md:text-left">Registrasi bagi Kepala Lingkungan dan warga yang memiliki tanggungan sebagai Penanggung Jawab.</p>
                  
                  <form action="{{ route('registerSubmit') }}" method="post">
                        @csrf
                        <div class="mt-3 md:mt-6 xl:mt-15">
                              <div class="relative mt-6">
                                    <input type="text" id="username" name="username" class="block w-full px-3 py-2 md:py-3 border border-gray-300 rounded-md  focus:outline-none focus:ring-warna-400 focus:border-warna-400 sm:text-sm peer" placeholder=" "  value="{{ old('username') }}"/>
                                    <label for="nama" class="absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-2 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-warna-400 peer-focus:dark:text-indigo-400 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 left-3">Username</label>
                              </div>
                              <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-6">
                                    <div class="relative">
                                          <input type="text" id="nama" name="name" class="block w-full px-3 py-2 md:py-3 border border-gray-300 rounded-md  focus:outline-none focus:ring-warna-400 focus:border-warna-400 sm:text-sm peer" placeholder=" "  value="{{ old('name') }}"/>
                                          <label for="nama" class="absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-2 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-warna-400 peer-focus:dark:text-indigo-400 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 left-3">Nama Lengkap</label>
                                    </div>
                                    <div class="relative">
                                          <input type="number" id="nik" name="nik" class="block w-full px-3 py-2 md:py-3 border border-gray-300 rounded-md  focus:outline-none focus:ring-warna-400 focus:border-warna-400 sm:text-sm peer" placeholder=" "  value="{{ old('nik') }}"/>
                                          <label for="nama" class="absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-2 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-warna-400 peer-focus:dark:text-indigo-400 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 left-3">NIK</label>
                                    </div>
      
                              </div>
   
                              <div class="relative mt-6">
                                    <input type="email" id="email" name="email" class="block w-full px-3 py-2 md:py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-warna-400 focus:border-warna-400 sm:text-sm peer" placeholder=" " value="{{ old('email') }}" />
                                    <label for="email" class="absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-2 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-warna-400 peer-focus:dark:text-indigo-400 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 left-3">Email</label>
                              </div>
                              <div class="relative mt-6">
                                    <input type="number" id="telepon" name="telepon" class="block w-full px-3 py-2 md:py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-warna-400 focus:border-warna-400 sm:text-sm peer" placeholder=" " value="{{ old('telepon') }}"/>
                                    <label for="telepon" class="absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-2 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-warna-400 peer-focus:dark:text-indigo-400 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 left-3">Nomor Telepon</label>
                              </div>
                              <div class="relative mt-6">
                                    <input type="text" id="alamat" name="alamat" class="block w-full px-3 py-2 md:py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-warna-400 focus:border-warna-400 sm:text-sm peer" placeholder=" " value="{{ old('alamat') }}"/>
                                    <label for="alamat" class="absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-2 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-warna-400 peer-focus:dark:text-indigo-400 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 left-3">Alamat</label>
                              </div>
                              <div class="relative mt-6">
                                    <select id="role" name="role" class="block w-full px-3 py-2 md:py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-warna-400 focus:border-warna-400 sm:text-sm peer">
                                          <option value="" disabled selected>Jabatan</option>
                                          <option value="kepalaLingkungan">Kepala Lingkungan</option>
                                          <option value="penanggungJawab">Penanggung Jawab</option>
                                    </select>
                              </div>
                              @if ($errors->any())
                              <div class="bg-red-100 text-red-800 px-4 py-2 rounded-md mt-4">
                                  <ul>
                                      @foreach ($errors->all() as $error)
                                          <li>{{ $error }}</li>
                                      @endforeach
                                  </ul>
                              </div>
                          @endif
                              <button class="px-3 py-2 md:py-3 rounded-md bg-warna-400 hover:bg-warna-400/90 active:scale-95 transition-all text-warna-100 w-full mt-8">Registrasi</button>
                                <p class=" text-sm mt-5 text-center md:text-left">Sudah punya akun? <a href="{{ route('login') }}" class="text-warna-400 underline">Login Sekarang!</a> </p>
                        </div>
                  </form>
                  
            </div>
      </div>

</body>
</html>