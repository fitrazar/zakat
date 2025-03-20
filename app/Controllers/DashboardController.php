<?php

namespace App\Controllers;

use App\Models\WargaModel;
use App\Models\KasZakatModel;
use App\Models\PenerimaZakatModel;
use App\Controllers\BaseController;
use App\Models\PemasukanZakatModel;
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
        $pemasukanModel = new PemasukanZakatModel();

        // Ambil saldo zakat masuk & keluar berdasarkan jenisnya
        $saldoUangMasuk = $kasModel->where('jenis', 'uang')->selectSum('saldo_masuk')->first();
        $saldoUangKeluar = $kasModel->where('jenis', 'uang')->selectSum('saldo_keluar')->first();
        $saldoUangAkhir = $kasModel->where('jenis', 'uang')->selectSum('saldo_akhir')->first();

        $saldoBerasMasuk = $kasModel->where('jenis', 'beras')->selectSum('saldo_masuk')->first();
        $saldoBerasKeluar = $kasModel->where('jenis', 'beras')->selectSum('saldo_keluar')->first();
        $saldoBerasAkhir = $kasModel->where('jenis', 'beras')->selectSum('saldo_akhir')->first();

        // Total warga dan penerima zakat
        $totalWarga = $wargaModel->countAll();
        $totalPenerima = $penerimaModel->countAll();

        // Data untuk grafik (Zakat Masuk & Keluar per bulan)
        $zakatMasuk = $pemasukanModel->select("MONTH(tanggal_masuk) as bulan, SUM(jumlah) as total")
            ->where('jenis', 'uang')
            ->groupBy('bulan')
            ->orderBy('bulan', 'ASC')
            ->findAll();

        $zakatKeluar = $penerimaModel->select("MONTH(tanggal_terima) as bulan, SUM(jumlah) as total")
            ->where('jenis', 'uang')
            ->groupBy('bulan')
            ->orderBy('bulan', 'ASC')
            ->findAll();

        $zakatBerasMasuk = $pemasukanModel->select("MONTH(tanggal_masuk) as bulan, SUM(jumlah) as total")
            ->where('jenis', 'beras')
            ->groupBy('bulan')
            ->orderBy('bulan', 'ASC')
            ->findAll();

        $zakatBerasKeluar = $penerimaModel->select("MONTH(tanggal_terima) as bulan, SUM(jumlah) as total")
            ->where("jenis", "beras")
            ->groupBy('bulan')
            ->orderBy('bulan', 'ASC')
            ->findAll();

        $data = [
            'saldo_uang_masuk' => $saldoUangMasuk['saldo_masuk'] ?? 0,
            'saldo_uang_keluar' => $saldoUangKeluar['saldo_keluar'] ?? 0,
            'saldo_uang_akhir' => $saldoUangAkhir['saldo_akhir'] ?? 0,
            'saldo_beras_masuk' => $saldoBerasMasuk['saldo_masuk'] ?? 0,
            'saldo_beras_keluar' => $saldoBerasKeluar['saldo_keluar'] ?? 0,
            'saldo_beras_akhir' => $saldoBerasKeluar['saldo_akhir'] ?? 0,
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