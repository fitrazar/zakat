<?php

namespace App\Models;

use CodeIgniter\Model;

class PenyaluranZakatModel extends Model
{
    protected $table = 'penyaluran_zakat';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = ['kategori', 'jumlah', 'satuan', 'tanggal', 'keterangan', 'created_at', 'updated_at'];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = true;
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
     * Tambah penyaluran zakat & update saldo di KasZakatModel
     */
    public function tambahPenyaluran($data)
    {
        $kasModel = new \App\Models\KasZakatModel();

        $jenis = in_array($data['satuan'], ['Kilogram', 'Liter']) ? 'beras' : 'uang';

        $saldo = $kasModel->getSaldoByJenis($jenis);
        if (!$saldo || $saldo['saldo_akhir'] < $data['jumlah']) {
            throw new \Exception('Saldo tidak mencukupi untuk penyaluran zakat.');
        }

        // Insert data penyaluran tanpa mengubah satuan aslinya
        $this->insert($data);

        // Update saldo keluar
        $kasModel->updateSaldoKeluar($jenis, $data['jumlah']);
    }



    /**
     * Edit data penyaluran zakat & sesuaikan saldo
     */
    public function editPenyaluran($id, $data)
    {
        $kasModel = new \App\Models\KasZakatModel();
        $penyaluranLama = $this->find($id);

        if (!$penyaluranLama) {
            throw new \Exception('Data penyaluran tidak ditemukan.');
        }

        $jenisLama = in_array($penyaluranLama['satuan'], ['Kilogram', 'Liter']) ? 'beras' : 'uang';
        $jenisBaru = in_array($data['satuan'], ['Kilogram', 'Liter']) ? 'beras' : 'uang';

        // Sesuaikan saldo keluar dengan jumlah lama
        $kasModel->adjustSaldoKeluar($jenisLama, $penyaluranLama['jumlah']);

        // Update saldo keluar dengan jumlah baru
        $kasModel->updateSaldoKeluar($jenisBaru, $data['jumlah']);

        // Update data penyaluran tanpa mengubah satuan aslinya
        $this->update($id, $data);
    }

    /**
     * Hapus penyaluran zakat & kembalikan saldo
     */
    public function hapusPenyaluran($id)
    {
        $kasModel = new \App\Models\KasZakatModel();
        $penyaluran = $this->find($id);

        if (!$penyaluran) {
            throw new \Exception('Data penyaluran tidak ditemukan.');
        }

        $jenis = in_array($penyaluran['satuan'], ['Kilogram', 'Liter']) ? 'beras' : 'uang';

        // Kembalikan saldo keluar
        $kasModel->adjustSaldoKeluar($jenis, $penyaluran['jumlah']);

        // Hapus data penyaluran
        $this->delete($id);
    }


}