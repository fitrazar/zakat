<?php

namespace App\Controllers;

use App\Models\WargaModel;
use App\Models\KasZakatModel;
use App\Models\PenerimaZakatModel;
use App\Controllers\BaseController;
use App\Models\PenyaluranZakatModel;
use CodeIgniter\HTTP\ResponseInterface;

class DashboardController extends BaseController
{
    public function index()
    {
        $data['title'] = 'Dashboard';
        $kasModel = new KasZakatModel();
        $wargaModel = new WargaModel();
        $penerimaModel = new PenerimaZakatModel();
        $penyaluranModel = new PenyaluranZakatModel();

        // Ambil saldo zakat masuk & keluar berdasarkan jenisnya
        $saldoUangMasuk = $kasModel->where('jenis', 'uang')->selectSum('saldo_masuk')->first();
        $saldoUangKeluar = $kasModel->where('jenis', 'uang')->selectSum('saldo_keluar')->first();

        $saldoBerasMasuk = $kasModel->where('jenis', 'beras')->selectSum('saldo_masuk')->first();
        $saldoBerasKeluar = $kasModel->where('jenis', 'beras')->selectSum('saldo_keluar')->first();

        // Total warga dan penerima zakat
        $totalWarga = $wargaModel->countAll();
        $totalPenerima = $penerimaModel->countAll();

        // Data untuk grafik (Zakat Masuk & Keluar per bulan)
        $zakatMasuk = $penerimaModel->select("MONTH(tanggal_terima) as bulan, SUM(jumlah) as total")
            ->where('jenis_zakat', 'uang')
            ->groupBy('bulan')
            ->orderBy('bulan', 'ASC')
            ->findAll();

        $zakatKeluar = $penyaluranModel->select("MONTH(tanggal) as bulan, SUM(jumlah) as total")
            ->where('satuan', 'Rupiah')
            ->groupBy('bulan')
            ->orderBy('bulan', 'ASC')
            ->findAll();

        $zakatBerasMasuk = $penerimaModel->select("MONTH(tanggal_terima) as bulan, SUM(jumlah) as total")
            ->where('jenis_zakat', 'beras')
            ->groupBy('bulan')
            ->orderBy('bulan', 'ASC')
            ->findAll();

        $zakatBerasKeluar = $penyaluranModel->select("MONTH(tanggal) as bulan, SUM(jumlah) as total")
            ->whereNotIn("satuan", ["Rupiah"])
            ->groupBy('bulan')
            ->orderBy('bulan', 'ASC')
            ->findAll();

        $data = [
            'saldo_uang_masuk' => $saldoUangMasuk['saldo_masuk'] ?? 0,
            'saldo_uang_keluar' => $saldoUangKeluar['saldo_keluar'] ?? 0,
            'saldo_beras_masuk' => $saldoBerasMasuk['saldo_masuk'] ?? 0,
            'saldo_beras_keluar' => $saldoBerasKeluar['saldo_keluar'] ?? 0,
            'total_warga' => $totalWarga,
            'total_penerima' => $totalPenerima,
            'zakat_masuk' => json_encode($zakatMasuk),
            'zakat_keluar' => json_encode($zakatKeluar),
            'zakat_beras_masuk' => json_encode($zakatBerasMasuk),
            'zakat_beras_keluar' => json_encode($zakatBerasKeluar),
        ];

        return view('dashboard/index', $data);
    }
}