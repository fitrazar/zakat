<?php

namespace App\Controllers;

use App\Models\WargaModel;
use App\Models\KasZakatModel;
use App\Controllers\BaseController;
use App\Models\PenyaluranZakatModel;
use CodeIgniter\HTTP\ResponseInterface;

class PenyaluranZakatController extends BaseController
{
    protected $penyaluranZakatModel;
    protected $kasZakatModel;
    protected $helpers = ['form'];

    public function __construct()
    {
        $this->penyaluranZakatModel = new PenyaluranZakatModel();
        $this->kasZakatModel = new KasZakatModel();
    }

    /**
     * Menampilkan daftar penyaluran zakat
     */
    public function index()
    {
        $data = [
            'title' => 'Data Penyaluran Zakat',
            'penyaluran' => $this->penyaluranZakatModel->findAll()
        ];
        return view('penyaluran_zakat/index', $data);
    }

    /**
     * Form tambah penyaluran zakat
     */
    public function create()
    {
        $data = [
            'title' => 'Tambah Penyaluran Zakat',
            'validation' => \Config\Services::validation()
        ];
        return view('penyaluran_zakat/create', $data);
    }

    /**
     * Proses tambah penyaluran zakat
     */
    public function store()
    {
        if (
            !$this->validate([
                'kategori' => 'required|in_list[Fakir Miskin,Mualaf,Amil,Gharimin,Fisabilillah,Ibnu Sabil,Yatim Piatu]',
                'jumlah' => 'required|numeric',
                'satuan' => 'required|max_length[20]',
                'tanggal' => 'required|valid_date[Y-m-d]',
                'keterangan' => 'permit_empty|string'
            ])
        ) {
            return redirect()->back()->withInput()->with('error', $this->validator);
        }

        $data = [
            'kategori' => $this->request->getPost('kategori'),
            'jumlah' => $this->request->getPost('jumlah'),
            'satuan' => $this->request->getPost('satuan'),
            'tanggal' => $this->request->getPost('tanggal'),
            'keterangan' => $this->request->getPost('keterangan'),
        ];

        try {
            $this->penyaluranZakatModel->tambahPenyaluran($data);
            return redirect()->to('/penyaluran_zakat')->with('success', 'Penyaluran Zakat berhasil ditambahkan.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }
    }

    /**
     * Form edit penyaluran zakat
     */
    public function edit($id)
    {
        $penyaluran = $this->penyaluranZakatModel->find($id);
        if (!$penyaluran) {
            return redirect()->to('/penyaluran_zakat')->with('error', 'Data tidak ditemukan.');
        }

        $data = [
            'title' => 'Edit Penyaluran Zakat',
            'validation' => \Config\Services::validation(),
            'penyaluran' => $penyaluran
        ];
        return view('penyaluran_zakat/edit', $data);
    }

    /**
     * Proses edit penyaluran zakat
     */
    public function update($id)
    {
        if (
            !$this->validate([
                'kategori' => 'required|in_list[Fakir Miskin,Mualaf,Amil,Gharimin,Fisabilillah,Ibnu Sabil,Yatim Piatu]',
                'jumlah' => 'required|numeric',
                'satuan' => 'required|max_length[20]',
                'tanggal' => 'required|valid_date[Y-m-d]',
                'keterangan' => 'permit_empty|string'
            ])
        ) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        $data = [
            'kategori' => $this->request->getPost('kategori'),
            'jumlah' => $this->request->getPost('jumlah'),
            'satuan' => $this->request->getPost('satuan'),
            'tanggal' => $this->request->getPost('tanggal'),
            'keterangan' => $this->request->getPost('keterangan'),
        ];

        try {
            $this->penyaluranZakatModel->editPenyaluran($id, $data);
            return redirect()->to('/penyaluran_zakat')->with('success', 'Penyaluran Zakat berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }
    }

    /**
     * Hapus penyaluran zakat
     */
    public function delete($id)
    {
        try {
            $this->penyaluranZakatModel->hapusPenyaluran($id);
            return redirect()->to('/penyaluran_zakat')->with('success', 'Penyaluran Zakat berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->to('/penyaluran_zakat')->with('error', $e->getMessage());
        }
    }

    /**
     * Cetak laporan penyaluran zakat (PDF)
     */
    public function cetak_pdf()
    {
        $data['penyaluran'] = $this->penyaluranZakatModel->findAll();

        $options = new \Dompdf\Options();
        $options->set('defaultFont', 'Arial');
        $dompdf = new \Dompdf\Dompdf($options);

        $html = view('penyaluran_zakat/pdf', $data);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $dompdf->stream("Laporan_Penyaluran_Zakat.pdf", ["Attachment" => false]);
    }

    /**
     * Export laporan penyaluran zakat (Excel)
     */
    public function cetak_excel()
    {
        $penyaluran = $this->penyaluranZakatModel->findAll();

        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Header
        $sheet->setCellValue('A1', 'Kategori');
        $sheet->setCellValue('B1', 'Jumlah');
        $sheet->setCellValue('C1', 'Satuan');
        $sheet->setCellValue('D1', 'Tanggal');
        $sheet->setCellValue('E1', 'Keterangan');

        // Data
        $row = 2;
        foreach ($penyaluran as $p) {
            $sheet->setCellValue('A' . $row, $p['kategori']);
            $sheet->setCellValue('B' . $row, $p['jumlah']);
            $sheet->setCellValue('C' . $row, $p['satuan']);
            $sheet->setCellValue('D' . $row, date('d-m-Y', strtotime($p['tanggal'])));
            $sheet->setCellValue('E' . $row, $p['keterangan']);
            $row++;
        }

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Laporan_Penyaluran_Zakat.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }
}