<?php
// filepath: c:\laragon\www\pendataanPendudukV2\routes\web.php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\cetak_surat;
use App\Http\Controllers\ExportController;

Route::get('/', function () {
    return view('welcome');
})->name('welcomePage');


Route::middleware(['guest'])->group(function () {
    Route::get('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/register/submit', [AuthController::class, 'registerSubmit'])->name('registerSubmit');

    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/login/submit', [AuthController::class, 'loginSubmit'])->name('loginSubmit');

    Route::post('/forgot-password', [AuthController::class, 'forgotPassword'])->name('forgotPassword');
});


Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboardHome');
    Route::post('/update-password', [AuthController::class, 'updatePassword'])->name('updatePassword');
    Route::post('/update-location', [AuthController::class, 'updateLocation'])->name('updateLocation');

    // Route untuk export
    Route::get('/export/csv', [ExportController::class, 'exportCsv'])->name('export.csv');
    Route::get('/export/excel', [ExportController::class, 'exportExcel'])->name('export.excel');
    Route::get('/export/summary', [ExportController::class, 'exportSummary'])->name('export.summary');

    // Route untuk layanan surat
    Route::get('/export/surat/csv', [ExportController::class, 'exportSuratCsv'])->name('export.surat.csv');
    Route::get('/export/surat/excel', [ExportController::class, 'exportSuratExcel'])->name('export.surat.excel');
    Route::get('/download/surat/{id}', [ExportController::class, 'downloadSurat'])->name('download.surat');


    Route::middleware(['checkRole:admin'])->group(function () {
        Route::get('/verifikasi-akun', [AuthController::class, 'verifikasiAkun'])->name('verifikasiAkun');
        Route::post('/verifikasi-akun/ubah-status/{id}', [AuthController::class, 'verifyUser'])->name(name: 'ubahStatus');
    });


    Route::middleware(['checkRole:admin,penanggungJawab,kepalaLingkungan'])->group(function () {
        Route::get('/user-profile', function () {
            return view('components.user-profile');
        })->name('userProfile');
        Route::get('/user-profile/ganti-password', function () {
            return view('components.user-profile');
        })->name('gantiPassword');


        Route::get('/master-data/data-kepala-lingkungan', function () {
            return view('components.kepala-lingkungan');
        });
        Route::get('/master-data/data-penanggung-jawab', function () {
            return view('components.penanggung-jawab');
        });

        Route::get('/data-penduduk', function () {
            return view('components.dataPenduduk');
        })->name('dataWargaTerdaftar');


        Route::get('/layanan-surat', function () {
            return view('components.layanan-surat');
        });
        Route::get('/download-surat/{id}', [\App\Http\Controllers\cetak_surat::class, 'downloadSurat'])->name('download.surat');
        Route::get('/cetak-surat/{id}', [cetak_surat::class, 'downloadSurat'])->name('cetak.surat');
        Route::get('/preview-surat/{id}', [cetak_surat::class, 'previewSurat'])->name('preview.surat');

        Route::get('/laporan/penduduk', function () {
            return view('components.laporan-penduduk');
        });
        Route::get('/laporan/layanan-surat', function () {
            return view('components.laporan-layanan-surat');
        });
    });


    Route::middleware(['checkRole:kepalaLingkungan'])->group(function () {
        Route::get('/verifikasi-penduduk', function () {
            return view('components.verifikasi-penduduk');
        })->name('verifikasiPenduduk');
    });
});

Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
