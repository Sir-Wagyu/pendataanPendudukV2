<?php
// filepath: c:\laragon\www\pendataanPendudukV2\app\Livewire\Dashboard.php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\penduduk_pendatang;
use App\Models\layanan_surat;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class Dashboard extends Component
{
    // Chart Akun
    public $filterWaktu = 'mingguan';
    public $chartData = [];
    public $chartLabels = [];

    // Chart Penduduk
    public $filterWaktuPenduduk = 'mingguan';
    public $chartDataPenduduk = [];
    public $chartLabelsPenduduk = [];

    public $mapData = [];

    public function mount()
    {
        $this->loadChartData();
        $this->loadChartDataPenduduk();
        $this->mapData = $this->getMapData();
    }

    public function updatedFilterWaktu()
    {
        $this->loadChartData();
    }

    public function updatedFilterWaktuPenduduk()
    {
        $this->loadChartDataPenduduk();
    }

    public function loadChartData()
    {
        switch ($this->filterWaktu) {
            case 'mingguan':
                $this->getWeeklyData();
                break;
            case 'bulanan':
                $this->getMonthlyData();
                break;
            case 'tahunan':
                $this->getYearlyData();
                break;
        }
    }

    public function loadChartDataPenduduk()
    {
        switch ($this->filterWaktuPenduduk) {
            case 'mingguan':
                $this->getWeeklyDataPenduduk();
                break;
            case 'bulanan':
                $this->getMonthlyDataPenduduk();
                break;
            case 'tahunan':
                $this->getYearlyDataPenduduk();
                break;
        }
    }

    public function getMapData()
    {
        $pendudukData = $this->getPendudukQuery()
            ->select('id', 'nama_lengkap', 'alamat_sekarang', 'latitude', 'longitude', 'created_at')
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->get()
            ->map(function ($penduduk) {
                return [
                    'id' => $penduduk->id,
                    'nama' => $penduduk->nama_lengkap,
                    'latitude' => (float) $penduduk->latitude,
                    'longitude' => (float) $penduduk->longitude,
                    'alamat' => $penduduk->alamat_sekarang ?? 'Alamat tidak tersedia',
                    'tanggal_daftar' => $penduduk->created_at->format('d M Y'),
                    'popup_content' => "
                    <div class='p-2'>
                        <h4 class='font-bold text-sm'>{$penduduk->nama}</h4>
                        <p class='text-xs text-gray-600'>{$penduduk->alamat}</p>
                        <p class='text-xs text-blue-600'>Terdaftar: {$penduduk->created_at->format('d M Y')}</p>
                    </div>
                "
                ];
            });

        return $pendudukData;
    }

    private function getWeeklyData()
    {
        $this->chartLabels = [];
        $this->chartData = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $this->chartLabels[] = $date->format('d M');

            $count = User::whereDate('created_at', $date->format('Y-m-d'))->count();
            $this->chartData[] = $count;
        }
    }

    private function getMonthlyData()
    {
        $this->chartLabels = [];
        $this->chartData = [];

        for ($i = 29; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $this->chartLabels[] = $date->format('d M');

            $count = User::whereDate('created_at', $date->format('Y-m-d'))->count();
            $this->chartData[] = $count;
        }
    }

    private function getYearlyData()
    {
        $this->chartLabels = [];
        $this->chartData = [];

        for ($i = 11; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $this->chartLabels[] = $date->format('M Y');

            $count = User::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();
            $this->chartData[] = $count;
        }
    }

    private function getWeeklyDataPenduduk()
    {
        $this->chartLabelsPenduduk = [];
        $this->chartDataPenduduk = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $this->chartLabelsPenduduk[] = $date->format('d M');

            $count = $this->getPendudukQuery()
                ->whereDate('created_at', $date->format('Y-m-d'))
                ->count();
            $this->chartDataPenduduk[] = $count;
        }
    }

    private function getMonthlyDataPenduduk()
    {
        $this->chartLabelsPenduduk = [];
        $this->chartDataPenduduk = [];

        for ($i = 29; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $this->chartLabelsPenduduk[] = $date->format('d M');

            $count = $this->getPendudukQuery()
                ->whereDate('created_at', $date->format('Y-m-d'))
                ->count();
            $this->chartDataPenduduk[] = $count;
        }
    }

    private function getYearlyDataPenduduk()
    {
        $this->chartLabelsPenduduk = [];
        $this->chartDataPenduduk = [];

        for ($i = 11; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $this->chartLabelsPenduduk[] = $date->format('M Y');

            $count = $this->getPendudukQuery()
                ->whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();
            $this->chartDataPenduduk[] = $count;
        }
    }

    private function getPendudukQuery()
    {
        $user = Auth::user();
        $query = penduduk_pendatang::query();

        switch ($user->role) {
            case 'admin':
                break;

            case 'kepalaLingkungan':
                $query->where('id_kepalaLingkungan', $user->id);
                break;

            case 'penanggungJawab':
                $query->where('id_penanggungJawab', $user->id);
                break;

            default:
                $query->whereRaw('1 = 0');
                break;
        }

        return $query;
    }

    private function getLayananSuratQuery()
    {
        $user = Auth::user();
        $query = layanan_surat::query();

        switch ($user->role) {
            case 'admin':
                // Admin bisa lihat semua data
                break;

            case 'kepalaLingkungan':
                // Kepala lingkungan hanya data surat dari penduduk yang di bawah mereka
                $query->whereHas('penduduk', function ($q) use ($user) {
                    $q->where('id_kepalaLingkungan', $user->id);
                });
                break;

            case 'penanggungJawab':

                $query->whereHas('penduduk', function ($q) use ($user) {
                    $q->where('id_penanggungJawab', $user->id);
                });
                break;

            default:
                // Role lain tidak bisa lihat data apapun
                $query->whereRaw('1 = 0');
                break;
        }

        return $query;
    }


    public function render()
    {
        $user = Auth::user();

        // Data untuk card statistik
        $totalAkunPending = User::where('status', 'pending')->count();
        $totalAkun = User::where('role', '!=', 'admin')->count();

        // Total penduduk berdasarkan role
        $totalPendudukDatang = $this->getPendudukQuery()->count();
        $totalPendudukPending = $this->getPendudukQuery()->where('status_akun', 'pending')->count();

        // Total Laporan Penduduk
        $totalSuratPenduduk = $this->getLayananSuratQuery()->count();
        $totalSuratPendudukPending = $this->getLayananSuratQuery()->where('status_pengajuan', 'diajukan')->count();

        return view('livewire.dashboard', [
            'totalAkunPending' => $totalAkunPending,
            'totalAkun' => $totalAkun,
            'totalPendudukDatang' => $totalPendudukDatang,
            'totalPendudukPending' => $totalPendudukPending,
            'totalSuratPenduduk' => $totalSuratPenduduk,
            'totalSuratPendudukPending' => $totalSuratPendudukPending,
        ]);
    }
}
