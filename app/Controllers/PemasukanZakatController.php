<?php

namespace App\Controllers;

use Dompdf\Dompdf;
use Dompdf\Options;
use App\Models\KasZakatModel;
use App\Controllers\BaseController;
use App\Models\PemasukanZakatModel;
use CodeIgniter\HTTP\ResponseInterface;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class PemasukanZakatController extends BaseController
{
    protected $pemasukanZakatModel;
    protected $kasZakatModel;
    protected $helpers = ['form'];

    public function __construct()
    {
        $this->pemasukanZakatModel = new PemasukanZakatModel();
        $this->kasZakatModel = new KasZakatModel();
    }

    public function index()
    {
        $data = [
            'pemasukan_zakat' => $this->pemasukanZakatModel->findAll(),
            'title' => 'Data Pemasukan Zakat',
        ];
        return view('pemasukan_zakat/index', $data);
    }

    public function create()
    {
        $data = [
            'validation' => \Config\Services::validation(),
        ];
        $data['title'] = 'Tambah Data Pemasukan Zakat';
        return view('pemasukan_zakat/create', $data);
    }

    public function store()
    {
        if (
            !$this->validate([
                'nama' => 'required|string|max_length[100]',
                'jumlah_keluarga' => 'required|integer',
                'jenis' => 'required|in_list[uang,beras]',
                'jenis_zakat' => 'required|in_list[Zakat Fitrah,Zakat Maal]',
                'infaq' => 'permit_empty|numeric',
                'jumlah' => 'required|numeric',
                'tanggal_masuk' => 'required|valid_date[Y-m-d]',
            ])
        ) {
            return redirect()->back()->withInput()->with('error', $this->validator);
        }


        $data = [
            'nama' => $this->request->getPost('nama'),
            'jumlah_keluarga' => $this->request->getPost('jumlah_keluarga'),
            'jenis' => $this->request->getPost('jenis'),
            'jenis_zakat' => $this->request->getPost('jenis_zakat'),
            'infaq' => $this->request->getPost('infaq'),
            'jumlah' => $this->request->getPost('jumlah'),
            'tanggal_masuk' => $this->request->getPost('tanggal_masuk'),
        ];

        $this->pemasukanZakatModel->save($data);

        // Update saldo masuk di kas_zakat
        $this->kasZakatModel->updateSaldoMasuk($data['jenis'], $data['jumlah']);
        if ($data['infaq'] > 0) {
            $this->kasZakatModel->updateSaldoMasuk($data['jenis'], $data['infaq']);
        }

        return redirect()->to('/pemasukan_zakat')->with('success', 'Data Pemasukan Zakat berhasil ditambahkan');
    }

    public function edit($id)
    {
        $data = [
            'validation' => \Config\Services::validation(),
            'pemasukan' => $this->pemasukanZakatModel->find($id),
        ];
        $data['title'] = 'Edit Data Pemasukan Zakat';
        if (!$data['pemasukan']) {
            return redirect()->to('/pemasukan_zakat')->with('error', 'Data tidak ditemukan');
        }

        return view('pemasukan_zakat/edit', $data);
    }

    public function update($id)
    {
        $oldData = $this->pemasukanZakatModel->find($id);
        if (!$oldData) {
            return redirect()->to('/pemasukan_zakat')->with('error', 'Data tidak ditemukan');
        }

        if (
            !$this->validate([
                'nama' => 'required|string|max_length[100]',
                'jumlah_keluarga' => 'required|integer',
                'jenis' => 'required|in_list[uang,beras]',
                'jenis_zakat' => 'required|in_list[Zakat Fitrah,Zakat Maal]',
                'infaq' => 'permit_empty|numeric',
                'jumlah' => 'required|numeric',
                'tanggal_masuk' => 'required|valid_date[Y-m-d]',
            ])
        ) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }



        $newData = [
            'nama' => $this->request->getPost('nama'),
            'jumlah_keluarga' => $this->request->getPost('jumlah_keluarga'),
            'jenis' => $this->request->getPost('jenis'),
            'jenis_zakat' => $this->request->getPost('jenis_zakat'),
            'infaq' => $this->request->getPost('infaq'),
            'jumlah' => $this->request->getPost('jumlah'),
            'tanggal_masuk' => $this->request->getPost('tanggal_masuk'),
        ];

        $this->pemasukanZakatModel->update($id, $newData);

        // Perbarui saldo masuk: Kurangi saldo lama, tambahkan saldo baru
        $this->kasZakatModel->updateSaldoMasuk($oldData['jenis'], -$oldData['jumlah']);
        $this->kasZakatModel->updateSaldoMasuk($newData['jenis'], $newData['jumlah']);

        if ($newData['infaq'] > 0) {
            $this->kasZakatModel->updateSaldoMasuk($newData['jenis'], $newData['infaq']);
        }

        if ($oldData['infaq'] > 0) {
            $this->kasZakatModel->updateSaldoMasuk($oldData['jenis'], -$oldData['infaq']);
        }

        return redirect()->to('/pemasukan_zakat')->with('success', 'Data Pemasukan Zakat berhasil diperbarui');
    }

    public function delete($id)
    {
        $data = $this->pemasukanZakatModel->find($id);
        if (!$data) {
            return redirect()->to('/pemasukan_zakat')->with('error', 'Data tidak ditemukan');
        }

        $this->pemasukanZakatModel->delete($id);

        // Kurangi saldo masuk di kas_zakat
        $this->kasZakatModel->updateSaldoMasuk($data['jenis'], -$data['jumlah']);

        return redirect()->to('/pemasukan_zakat')->with('success', 'Data Pemasukan Zakat berhasil dihapus');
    }

    public function cetak_pdf()
    {
        $nama = $this->request->getGet('nama');
        $tanggal_mulai = $this->request->getGet('tanggal_mulai');
        $tanggal_akhir = $this->request->getGet('tanggal_akhir');

        $zakatModel = new PemasukanZakatModel();
        $query = $zakatModel->select('*');

        if (!empty($nama)) {
            $query->like('nama', $nama);
        }
        if (!empty($tanggal_mulai) && !empty($tanggal_akhir)) {
            $query->where('tanggal_masuk >=', $tanggal_mulai)
                ->where('tanggal_masuk <=', $tanggal_akhir);
        }

        $data['pemasukan_zakat'] = $query->findAll();

        $options = new Options();
        $options->set('defaultFont', 'Arial');
        $dompdf = new Dompdf($options);

        $html = view('pemasukan_zakat/pdf', $data);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $nama_file = 'Bukti Pembayaran Zakat';
        if ($nama) {
            $nama_warga = isset($data['pemasukan_zakat'][0]) ? $data['pemasukan_zakat'][0]['nama'] : "Tidak_Ditemukan";
            $nama_file .= " " . $nama_warga;
        }
        if ($tanggal_mulai && $tanggal_akhir) {
            $nama_file .= " " . date('d-m-Y', strtotime($tanggal_mulai)) . " sampai " . date('d-m-Y', strtotime($tanggal_akhir));
        }

        $dompdf->stream("$nama_file.pdf", array("Attachment" => false));
    }



    // public function cetak_excel()
    // {
    //     $warga_id = $this->request->getGet('warga_id');
    //     $tanggal_mulai = $this->request->getGet('tanggal_mulai');
    //     $tanggal_akhir = $this->request->getGet('tanggal_akhir');

    //     $pemasukan_zakat = $this->pemasukanZakatModel->getPenerimaZakatFiltered($warga_id, $tanggal_mulai, $tanggal_akhir);

    //     $spreadsheet = new Spreadsheet();
    //     $sheet = $spreadsheet->getActiveSheet();

    //     // Header
    //     $sheet->setCellValue('A1', 'Nama Warga');
    //     $sheet->setCellValue('B1', 'Jenis Zakat');
    //     $sheet->setCellValue('C1', 'Jumlah');
    //     $sheet->setCellValue('D1', 'Satuan');
    //     $sheet->setCellValue('E1', 'Tanggal Terima');

    //     // Data
    //     $row = 2;
    //     foreach ($pemasukan_zakat as $p) {
    //         $sheet->setCellValue('A' . $row, $p['nama']);
    //         $sheet->setCellValue('B' . $row, ucfirst($p['jenis_zakat']));
    //         $sheet->setCellValue('C' . $row, $p['jumlah']);
    //         $sheet->setCellValue('D' . $row, $p['satuan']);
    //         $sheet->setCellValue('E' . $row, date('d-m-Y', strtotime($p['tanggal_masuk'])));
    //         $row++;
    //     }

    //     $nama_file = 'pemasukan_zakat';
    //     if ($warga_id) {
    //         $nama_warga = isset($pemasukan_zakat[0]) ? $pemasukan_zakat[0]['nama'] : "Tidak_Ditemukan";
    //         $nama_file .= "_" . str_replace(' ', '_', strtolower($nama_warga));
    //     }
    //     if ($tanggal_mulai && $tanggal_akhir) {
    //         $nama_file .= "_" . date('d-m-Y', strtotime($tanggal_mulai)) . "_sampai_" . date('d-m-Y', strtotime($tanggal_akhir));
    //     }

    //     $writer = new Xlsx($spreadsheet);
    //     header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    //     header('Content-Disposition: attachment;filename="' . $nama_file . '.xlsx"');
    //     header('Cache-Control: max-age=0');

    //     $writer->save('php://output');
    // }
}