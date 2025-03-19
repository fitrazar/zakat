<?php

namespace App\Models;

use CodeIgniter\Model;

class PenerimaZakatModel extends Model
{
    protected $table = 'penerima_zakat';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = ['warga_id', 'jenis', 'jumlah', 'tanggal_terima', 'foto', 'created_at', 'updated_at'];

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

    public function getPenerimaZakat($id = null, $warga_id = null)
    {
        $query = $this->select('penerima_zakat.*, warga.nama, warga.alamat, warga.rt, warga.rw, warga.jenis_kelamin, warga.status')
            ->join('warga', 'warga.id = penerima_zakat.warga_id');

        if ($warga_id !== null) {
            $query->where('penerima_zakat.warga_id', $warga_id);
        }

        if ($id !== null) {
            return $query->where('penerima_zakat.id', $id)->first();
        }

        return $query->findAll();
    }

    public function getPenerimaZakatFiltered($warga_id = null, $tanggal_mulai = null, $tanggal_akhir = null)
    {
        $builder = $this->select('penerima_zakat.*, warga.nama, warga.alamat, warga.rt, warga.rw, warga.jenis_kelamin, warga.status')
            ->join('warga', 'warga.id = penerima_zakat.warga_id');

        if ($warga_id) {
            $builder->where('penerima_zakat.warga_id', $warga_id);
        }

        if ($tanggal_mulai && $tanggal_akhir) {
            $builder->where('penerima_zakat.tanggal_terima >=', $tanggal_mulai)
                ->where('penerima_zakat.tanggal_terima <=', $tanggal_akhir);
        }

        return $builder->findAll();
    }


    /**
     * Tambah penyaluran zakat & update saldo di KasZakatModel
     */
    public function tambahPenyaluran($data)
    {
        $kasModel = new \App\Models\KasZakatModel();

        $saldo = $kasModel->getSaldoByJenis($data['jenis']);
        if (!$saldo || $saldo['saldo_akhir'] < $data['jumlah']) {
            throw new \Exception('Saldo tidak mencukupi untuk penyaluran zakat.');
        }

        // Insert data penyaluran tanpa mengubah satuan aslinya
        $this->insert($data);

        // Update saldo keluar
        $kasModel->updateSaldoKeluar($data['jenis'], $data['jumlah']);
    }



    /**
     * Edit data penyaluran zakat & sesuaikan saldo
     */
    public function editPenyaluran($id, $data)
    {
        $kasModel = new \App\Models\KasZakatModel();
        $penerimaOld = $this->find($id);

        if (!$penerimaOld) {
            throw new \Exception('Data penerima tidak ditemukan.');
        }

        // Sesuaikan saldo keluar dengan jumlah lama
        $kasModel->adjustSaldoKeluar($penerimaOld['jenis'], $penerimaOld['jumlah']);

        // Update saldo keluar dengan jumlah baru
        $kasModel->updateSaldoKeluar($data['jenis'], $data['jumlah']);

        // Update data penyaluran tanpa mengubah satuan aslinya
        $this->update($id, $data);
    }

    /**
     * Hapus penyaluran zakat & kembalikan saldo
     */
    public function hapusPenyaluran($id)
    {
        $kasModel = new \App\Models\KasZakatModel();
        $penerimaan = $this->find($id);

        if (!$penerimaan) {
            throw new \Exception('Data Penerima tidak ditemukan.');
        }

        // Kembalikan saldo keluar
        $kasModel->adjustSaldoKeluar($penerimaan['jenis'], $penerimaan['jumlah']);

        // Hapus data penyaluran
        $this->delete($id);
    }


}