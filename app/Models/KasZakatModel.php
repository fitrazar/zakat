<?php

namespace App\Models;

use CodeIgniter\Model;

class KasZakatModel extends Model
{
    protected $table = 'kas_zakat';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = ['jenis', 'saldo_masuk', 'saldo_keluar', 'saldo_akhir', 'updated_at'];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

    // Validation
    protected $validationRules = [];
    protected $validationMessages = [];
    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert = [];
    protected $afterInsert = [];
    protected $beforeUpdate = [];
    protected $afterUpdate = [];
    protected $beforeFind = [];
    protected $afterFind = [];
    protected $beforeDelete = [];
    protected $afterDelete = [];

    /**
     * Ambil saldo berdasarkan jenis zakat (uang/beras)
     */
    public function getSaldoByJenis($jenis)
    {
        return $this->where('jenis', $jenis)->first();
    }

    /**
     * Tambah saldo masuk saat penerimaan zakat
     */
    public function updateSaldoMasuk($jenis, $jumlah)
    {
        $saldo = $this->getSaldoByJenis($jenis);
        if ($saldo) {
            $newSaldoMasuk = $saldo['saldo_masuk'] + $jumlah;
            $newSaldoAkhir = $newSaldoMasuk - $saldo['saldo_keluar'];

            $this->update($saldo['id'], [
                'saldo_masuk' => $newSaldoMasuk,
                'saldo_akhir' => $newSaldoAkhir,
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        } else {
            // Jika belum ada data, tambahkan baru
            $this->insert([
                'jenis' => $jenis,
                'saldo_masuk' => $jumlah,
                'saldo_keluar' => 0,
                'saldo_akhir' => $jumlah,
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        }
    }

    /**
     * Kurangi saldo saat penyaluran zakat
     */
    public function updateSaldoKeluar($jenis, $jumlah)
    {
        $saldo = $this->getSaldoByJenis($jenis);
        if ($saldo && $saldo['saldo_akhir'] >= $jumlah) {
            $newSaldoKeluar = $saldo['saldo_keluar'] + $jumlah;
            $newSaldoAkhir = $saldo['saldo_masuk'] - $newSaldoKeluar;

            $this->update($saldo['id'], [
                'saldo_keluar' => $newSaldoKeluar,
                'saldo_akhir' => $newSaldoAkhir,
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        } else {
            throw new \Exception('Saldo tidak mencukupi untuk penyaluran zakat.');
        }
    }

    /**
     * Koreksi saldo saat penerimaan zakat diedit
     */
    public function adjustSaldoMasuk($jenis, $jumlahLama, $jumlahBaru)
    {
        $saldo = $this->getSaldoByJenis($jenis);
        if ($saldo) {
            $newSaldoMasuk = $saldo['saldo_masuk'] - $jumlahLama + $jumlahBaru;
            $newSaldoAkhir = $newSaldoMasuk - $saldo['saldo_keluar'];

            if ($newSaldoAkhir < 0) {
                throw new \Exception('Saldo tidak boleh negatif setelah pembaruan.');
            }

            $this->update($saldo['id'], [
                'saldo_masuk' => $newSaldoMasuk,
                'saldo_akhir' => $newSaldoAkhir,
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        }
    }

    /**
     * Koreksi saldo saat penyaluran zakat dihapus
     */
    public function adjustSaldoKeluar($jenis, $jumlah)
    {
        $saldo = $this->getSaldoByJenis($jenis);
        if ($saldo) {
            $newSaldoKeluar = $saldo['saldo_keluar'] - $jumlah;
            if ($newSaldoKeluar < 0) {
                $newSaldoKeluar = 0; // Pastikan saldo keluar tidak negatif
            }
            $newSaldoAkhir = $saldo['saldo_masuk'] - $newSaldoKeluar;

            $this->update($saldo['id'], [
                'saldo_keluar' => $newSaldoKeluar,
                'saldo_akhir' => $newSaldoAkhir,
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        } else {
            throw new \Exception('Saldo tidak mencukupi untuk penyaluran zakat.');
        }
    }
}