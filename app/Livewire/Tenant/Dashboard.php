<?php

namespace App\Livewire\Tenant;

use Livewire\Component;
use App\Models\Warga;
use App\Models\Rumah;
use App\Models\PembayaranIuran;
use App\Models\Keluhan;
use App\Models\GlobalAnnouncement;

class Dashboard extends Component
{
    public function render()
    {
        // Statistik Utama (Transparan untuk semua: RT & Warga)
        $totalWarga = Warga::count();
        $totalRumah = Rumah::count();
        $kasMasuk = PembayaranIuran::where('status', 'Lunas')->sum('nominal');
        $tunggakan = PembayaranIuran::where('status', '!=', 'Lunas')->count();

        $announcement = GlobalAnnouncement::where('is_active', true)->latest()->first();

        // Data Grafik 1: Status Iuran (Pie Chart)
        $iuranLunas = PembayaranIuran::where('status', 'Lunas')->count();
        $iuranNunggak = $tunggakan;
        
        // Menghindari array kosong jika belum ada data sama sekali
        if ($iuranLunas == 0 && $iuranNunggak == 0) {
            $iuranLunas = 1; 
            $iuranNunggak = 0; // dummy data sementara
        }

        $chartIuranData = [$iuranLunas, $iuranNunggak];

        // Data Grafik 2: Tren Keluhan 6 Bulan Terakhir (Bar Chart)
        $chartKeluhanCategories = [];
        $chartKeluhanData = [];

        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $chartKeluhanCategories[] = $date->translatedFormat('M Y');
            $count = Keluhan::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();
            $chartKeluhanData[] = $count;
        }

        return view('livewire.tenant.dashboard', compact(
            'totalWarga', 
            'totalRumah', 
            'kasMasuk', 
            'tunggakan',
            'announcement',
            'chartIuranData',
            'chartKeluhanCategories',
            'chartKeluhanData'
        ));
    }
}
