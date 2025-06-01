<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Pendataan Penduduk Desa X</title>
    @vite('resources/css/app.css')
    @vite([])
</head>
<body class="h-full w-full flex items-center justify-center py-20 font-urbanist">
    <div class="max-w-4xl mx-auto text-center px-6">
        <!-- Hero Icon -->
        <div class="relative mb-8">
            <div class="w-24 h-24 mx-auto bg-gradient-to-r from-[#3a6ea5] to-[#2d5a8a] rounded-full flex items-center justify-center shadow-lg">
                <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
            </div>
            <div class="absolute -top-2 -right-2 w-6 h-6 bg-yellow-400 rounded-full animate-pulse"></div>
        </div>

        <!-- Main Heading -->
        <h1 class="text-4xl md:text-5xl font-bold text-gray-800 mb-4 leading-tight">
            Selamat Datang Di
            <span class="bg-gradient-to-r from-[#2d5a8a] to-[#1e3a5f] bg-clip-text text-transparent">
                SIDUKTANG
            </span>
        </h1>

        <!-- Subtitle -->
        <p class="text-lg text-gray-600 mb-12 max-w-2xl mx-auto leading-relaxed">
            Sistem Informasi Manajemen Penduduk Pendatang yang modern dan efisien untuk Balai Kencana Resort. 
            Mulai kelola data penduduk dengan mudah dan aman.
        </p>

        <!-- CTA Buttons -->
        <div class="flex flex-col sm:flex-row items-center justify-center gap-4 text-lg font-medium">
            <a href="{{ route('register') }}" 
               class="group px-8 py-4 bg-gradient-to-r from-[#3a6ea5] to-[#2d5a8a] hover:from-[#4a7eb5] hover:to-[#3d6a9a] rounded-xl text-white transform transition-all duration-200 hover:scale-105 shadow-lg hover:shadow-xl">
                <span class="flex items-center gap-2">
                    Daftar Sekarang
                    <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                    </svg>
                </span>
            </a>

            <div class="flex items-center gap-4">
                <div class="hidden sm:block w-px h-8 bg-gray-300"></div>
                <span class="text-gray-500 text-sm">atau</span>
                <div class="hidden sm:block w-px h-8 bg-gray-300"></div>
            </div>

            <a href="{{ route('login') }}" 
               class="px-8 py-4 bg-white border-2 border-[#3a6ea5] hover:bg-[#f0f5fa] rounded-xl text-[#2d5a8a] transform transition-all duration-200 hover:scale-105 shadow-md hover:shadow-lg">
                Masuk
            </a>
        </div>

        <!-- Features Preview -->
        <div class="mt-16 grid grid-cols-1 md:grid-cols-3 gap-6 text-center">
            <div class="p-6 bg-white rounded-xl shadow-md hover:shadow-lg transition-shadow">
                <div class="w-12 h-12 mx-auto mb-4 bg-[#e8f1fa] rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h3 class="font-semibold text-gray-800 mb-2">Aman & Terpercaya</h3>
                <p class="text-sm text-gray-600">Data tersimpan dengan sistem keamanan tinggi</p>
            </div>

            <div class="p-6 bg-white rounded-xl shadow-md hover:shadow-lg transition-shadow">
                <div class="w-12 h-12 mx-auto mb-4 bg-green-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                </div>
                <h3 class="font-semibold text-gray-800 mb-2">Cepat & Efisien</h3>
                <p class="text-sm text-gray-600">Proses data penduduk dengan cepat dan mudah</p>
            </div>

            <div class="p-6 bg-white rounded-xl shadow-md hover:shadow-lg transition-shadow">
                <div class="w-12 h-12 mx-auto mb-4 bg-purple-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H9a2 2 0 01-2-2z"></path>
                    </svg>
                </div>
                <h3 class="font-semibold text-gray-800 mb-2">Laporan Lengkap</h3>
                <p class="text-sm text-gray-600">Generate laporan data yang komprehensif</p>
            </div>
        </div>
    </div>
</body>
</html>