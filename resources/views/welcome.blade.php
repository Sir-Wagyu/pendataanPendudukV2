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
    <div>
        <div class="w-22 h-22 mx-auto bg-indigo-500 rounded-full mb-5"></div>
        <h1 class="text-3xl font-semibold">Selamat Datang Di Web Pendataan Penduduk</h1>
        <p></p>
        <div class="flex  items-center justify-center text-lg font-medium mt-10">
            <a href="{{ route('register') }}" class="px-20 py-3 bg-warna-400 rounded-lg text-warna-100">Register</a>
            <p class="my-8 mx-8 text-base">atau</p>
            <a href="{{ route('login') }}" class="px-20 py-3 bg-warna-100 border-2 border-warna-400 rounded-lg text-warna-400">Login</a>
        </div>
    </div>
</body>
</html>