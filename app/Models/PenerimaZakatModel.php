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

        // Pastikan minimal ada salah satu jenis zakat yang diberikan
        if (empty($data['jumlah_uang']) && empty($data['jumlah_beras'])) {
            throw new \Exception('Harap masukkan jumlah zakat yang akan disalurkan.');
        }

        // Jika ada zakat uang, proses saldo dan insert transaksi
        if (!empty($data['jumlah_uang'])) {
            $saldoUang = $kasModel->getSaldoByJenis('uang');
            if (!$saldoUang || $saldoUang['saldo_akhir'] < $data['jumlah_uang']) {
                throw new \Exception('Saldo uang tidak mencukupi untuk penyaluran zakat.');
            }

            // Simpan transaksi untuk zakat uang
            $this->insert([
                'warga_id' => $data['warga_id'],
                'jenis' => 'uang',
                'jumlah' => $data['jumlah_uang'],
                'tanggal_terima' => $data['tanggal_terima'],
                'foto' => $data['foto']
            ]);

            // Kurangi saldo kas uang
            $kasModel->updateSaldoKeluar('uang', $data['jumlah_uang']);
        }

        // Jika ada zakat beras, proses saldo dan insert transaksi
        if (!empty($data['jumlah_beras'])) {
            $saldoBeras = $kasModel->getSaldoByJenis('beras');
            if (!$saldoBeras || $saldoBeras['saldo_akhir'] < $data['jumlah_beras']) {
                throw new \Exception('Saldo beras tidak mencukupi untuk penyaluran zakat.');
            }

            // Simpan transaksi untuk zakat beras
            $this->insert([
                'warga_id' => $data['warga_id'],
                'jenis' => 'beras',
                'jumlah' => $data['jumlah_beras'],
                'tanggal_terima' => $data['tanggal_terima'],
                'foto' => $data['foto']
            ]);

            // Kurangi saldo kas beras
            $kasModel->updateSaldoKeluar('beras', $data['jumlah_beras']);
        }
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