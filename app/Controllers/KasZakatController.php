<?php

namespace App\Controllers;

use App\Models\KasZakatModel;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class KasZakatController extends BaseController
{
    public function getSaldo()
    {
        $kasModel = new KasZakatModel();

        $saldoUang = $kasModel->where('jenis', 'uang')->selectSum('saldo_akhir')->first()['saldo_akhir'] ?? 0;
        $saldoBeras = $kasModel->where('jenis', 'beras')->selectSum('saldo_akhir')->first()['saldo_akhir'] ?? 0;

        return $this->response->setJSON([
            'uang' => number_format($saldoUang, 2, ',', '.'),
            'beras' => number_format($saldoBeras, 2, ',', '.') . ' kg'
        ]);
    }

}