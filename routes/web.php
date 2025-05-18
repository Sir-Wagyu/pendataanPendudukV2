<?php
// filepath: c:\laragon\www\pendataanPendudukV2\routes\web.php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Livewire\DataKepalaLingkungan;

Route::get('/', function () {
    return view('welcome');
})->name('welcomePage');

Route::middleware(['guest'])->group(function () {
    Route::get('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/register/submit', [AuthController::class, 'registerSubmit'])->name('registerSubmit');

    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/login/submit', [AuthController::class, 'loginSubmit'])->name('loginSubmit');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboardHome');

    Route::post('/update-password', [AuthController::class, 'updatePassword'])->name('updatePassword');

    Route::middleware(['checkRole:admin,kepalaLingkungan'])->group(function () {
        Route::get('/verifikasi-akun', [AuthController::class, 'verifikasiAkun'])->name('verifikasiAkun');
        Route::post('/verifikasi-akun/ubah-status/{id}', [AuthController::class, 'verifyUser'])->name(name: 'ubahStatus');
    });

    Route::middleware(['checkRole:admin,penanggungJawab,kepalaLingkungan'])->group(function () {
        Route::get('/data-penduduk', function () {
            return view('components.dataPenduduk');
        })->name('dataWargaTerdaftar');

        Route::get('/data-kepala-lingkungan', function () {
            return view('components.kepala-lingkungan');
        });

        Route::get('/data-penanggung-jawab', function () {
            return view('components.penanggung-jawab');
        });

        Route::get('/laporan', function () {
            return view('components.laporan');
        });
    });
});

Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
