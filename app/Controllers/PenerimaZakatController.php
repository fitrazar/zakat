<?php

namespace App\Controllers;

use Dompdf\Dompdf;
use Dompdf\Options;
use App\Models\WargaModel;
use App\Models\KasZakatModel;
use App\Models\PenerimaZakatModel;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class PenerimaZakatController extends BaseController
{
    protected $penerimaZakatModel;
    protected $wargaModel;
    protected $kasZakatModel;
    protected $helpers = ['form'];

    public function __construct()
    {
        $this->penerimaZakatModel = new PenerimaZakatModel();
        $this->wargaModel = new WargaModel();
        $this->kasZakatModel = new KasZakatModel();
    }

    public function index()
    {
        $data = [
            'warga' => $this->wargaModel->findAll(),
            'penerima_zakat' => $this->penerimaZakatModel->getPenerimaZakat(),
            'title' => 'Data Penerima Zakat'
        ];
        return view('penerima_zakat/index', $data);
    }

    public function create()
    {
        $data = [
            'validation' => \Config\Services::validation(),
            'warga' => $this->wargaModel->findAll()
        ];
        $data['title'] = 'Tambah Data Penerima Zakat';
        return view('penerima_zakat/create', $data);
    }

    public function store()
    {
        if (
            !$this->validate([
                'warga_id' => 'required|integer',
                'jenis_zakat' => 'required|in_list[uang,beras]',
                'jumlah' => 'required|numeric',
                'satuan' => 'required|max_length[50]',
                'tanggal_terima' => 'required|valid_date[Y-m-d]',
            ])
        ) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        $data = [
            'warga_id' => $this->request->getPost('warga_id'),
            'jenis_zakat' => $this->request->getPost('jenis_zakat'),
            'jumlah' => $this->request->getPost('jumlah'),
            'satuan' => $this->request->getPost('satuan'),
            'tanggal_terima' => $this->request->getPost('tanggal_terima'),
        ];
        $this->penerimaZakatModel->save($data);

        // Update saldo masuk di kas_zakat
        $this->kasZakatModel->updateSaldoMasuk($data['jenis_zakat'], $data['jumlah']);

        return redirect()->to('/penerima_zakat')->with('success', 'Data Penerima Zakat berhasil ditambahkan');
    }

    public function edit($id)
    {
        $data = [
            'validation' => \Config\Services::validation(),
            'penerima' => $this->penerimaZakatModel->getPenerimaZakat($id),
            'warga' => $this->wargaModel->findAll()
        ];
        $data['title'] = 'Edit Data Penerima Zakat';
        if (!$data['penerima']) {
            return redirect()->to('/penerima_zakat')->with('error', 'Data tidak ditemukan');
        }

        return view('penerima_zakat/edit', $data);
    }

    public function update($id)
    {
        $oldData = $this->penerimaZakatModel->find($id);
        if (!$oldData) {
            return redirect()->to('/penerima_zakat')->with('error', 'Data tidak ditemukan');
        }

        if (
            !$this->validate([
                'warga_id' => 'required|integer',
                'jenis_zakat' => 'required|in_list[uang,beras]',
                'jumlah' => 'required|numeric',
                'satuan' => 'required|max_length[50]',
                'tanggal_terima' => 'required|valid_date[Y-m-d]',
            ])
        ) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        $newData = [
            'warga_id' => $this->request->getPost('warga_id'),
            'jenis_zakat' => $this->request->getPost('jenis_zakat'),
            'jumlah' => $this->request->getPost('jumlah'),
            'satuan' => $this->request->getPost('satuan'),
            'tanggal_terima' => $this->request->getPost('tanggal_terima'),
        ];

        $this->penerimaZakatModel->update($id, $newData);

        // Perbarui saldo masuk: Kurangi saldo lama, tambahkan saldo baru
        $this->kasZakatModel->updateSaldoMasuk($oldData['jenis_zakat'], -$oldData['jumlah']);
        $this->kasZakatModel->updateSaldoMasuk($newData['jenis_zakat'], $newData['jumlah']);

        return redirect()->to('/penerima_zakat')->with('success', 'Data Penerima Zakat berhasil diperbarui');
    }

    public function delete($id)
    {
        $data = $this->penerimaZakatModel->find($id);
        if (!$data) {
            return redirect()->to('/penerima_zakat')->with('error', 'Data tidak ditemukan');
        }

        $this->penerimaZakatModel->delete($id);

        $this->kasZakatModel->updateSaldoMasuk($data['jenis_zakat'], -$data['jumlah']);

        return redirect()->to('/penerima_zakat')->with('success', 'Data Penerima Zakat berhasil dihapus');
    }

    public function cetak_pdf()
    {
        $warga_id = $this->request->getGet('warga_id');
        $tanggal_mulai = $this->request->getGet('tanggal_mulai');
        $tanggal_akhir = $this->request->getGet('tanggal_akhir');

        $data['penerima_zakat'] = $this->penerimaZakatModel->getPenerimaZakatFiltered($warga_id, $tanggal_mulai, $tanggal_akhir);

        $options = new Options();
        $options->set('defaultFont', 'Arial');
        $dompdf = new Dompdf($options);

        $html = view('penerima_zakat/pdf', $data);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $nama_file = 'Penerima_Zakat';
        if ($warga_id) {
            $nama_warga = isset($data['penerima_zakat'][0]) ? $data['penerima_zakat'][0]['nama'] : "Tidak_Ditemukan";
            $nama_file .= "_" . str_replace(' ', '_', strtolower($nama_warga));
        }
        if ($tanggal_mulai && $tanggal_akhir) {
            $nama_file .= "_" . date('d-m-Y', strtotime($tanggal_mulai)) . "_sampai_" . date('d-m-Y', strtotime($tanggal_akhir));
        }

        $dompdf->stream("$nama_file.pdf", array("Attachment" => false));
    }



    public function cetak_excel()
    {
        $warga_id = $this->request->getGet('warga_id');
        $tanggal_mulai = $this->request->getGet('tanggal_mulai');
        $tanggal_akhir = $this->request->getGet('tanggal_akhir');

        $penerima_zakat = $this->penerimaZakatModel->getPenerimaZakatFiltered($warga_id, $tanggal_mulai, $tanggal_akhir);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Header
        $sheet->setCellValue('A1', 'Nama Warga');
        $sheet->setCellValue('B1', 'Jenis Zakat');
        $sheet->setCellValue('C1', 'Jumlah');
        $sheet->setCellValue('D1', 'Satuan');
        $sheet->setCellValue('E1', 'Tanggal Terima');

        // Data
        $row = 2;
        foreach ($penerima_zakat as $p) {
            $sheet->setCellValue('A' . $row, $p['nama']);
            $sheet->setCellValue('B' . $row, ucfirst($p['jenis_zakat']));
            $sheet->setCellValue('C' . $row, $p['jumlah']);
            $sheet->setCellValue('D' . $row, $p['satuan']);
            $sheet->setCellValue('E' . $row, date('d-m-Y', strtotime($p['tanggal_terima'])));
            $row++;
        }

        $nama_file = 'Penerima_Zakat';
        if ($warga_id) {
            $nama_warga = isset($penerima_zakat[0]) ? $penerima_zakat[0]['nama'] : "Tidak_Ditemukan";
            $nama_file .= "_" . str_replace(' ', '_', strtolower($nama_warga));
        }
        if ($tanggal_mulai && $tanggal_akhir) {
            $nama_file .= "_" . date('d-m-Y', strtotime($tanggal_mulai)) . "_sampai_" . date('d-m-Y', strtotime($tanggal_akhir));
        }

        $writer = new Xlsx($spreadsheet);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $nama_file . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }



}