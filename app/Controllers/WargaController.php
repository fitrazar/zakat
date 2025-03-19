<?php

namespace App\Controllers;

use App\Models\WargaModel;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class WargaController extends BaseController
{
    protected $wargaModel;

    public function __construct()
    {
        $this->wargaModel = new WargaModel();
    }

    public function index()
    {
        $data['title'] = 'Data Warga';
        if (is_admin()) {
            $data['warga'] = $this->wargaModel->findAll();
        } elseif (is_rt()) {
            $data['warga'] = $this->wargaModel->where('rt', session()->get('rt'))->findAll();
        }

        return view('warga/index', $data);
    }

    public function create()
    {
        $data['title'] = 'Tambah Data Warga';
        return view('warga/create', $data);
    }

    public function store()
    {
        $validationRules = [
            'nama' => 'required|min_length[3]|max_length[100]',
            'alamat' => 'required|max_length[255]',
            'jumlah_keluarga' => 'required|integer',
            'rt' => 'required|integer',
            'rw' => 'required|integer',
            'status' => 'required|in_list[Mampu,Tidak Mampu]',
            'jenis_kelamin' => 'required|in_list[Laki - Laki,Perempuan]',
            'pekerjaan' => 'required|max_length[100]',
        ];

        if (!$this->validate($validationRules)) {
            return redirect()->back()->withInput()->with('error', $this->validator->listErrors());
        }

        $pekerjaan = $this->request->getPost('pekerjaan');
        if ($pekerjaan == 'Lainnya') {
            $pekerjaan = $this->request->getPost('pekerjaan_lain');
        }

        $rt = str_pad($this->request->getPost('rt'), 2, '0', STR_PAD_LEFT);
        $rw = str_pad($this->request->getPost('rw'), 2, '0', STR_PAD_LEFT);

        $this->wargaModel->save([
            'nama' => $this->request->getPost('nama'),
            'alamat' => $this->request->getPost('alamat'),
            'jumlah_keluarga' => $this->request->getPost('jumlah_keluarga'),
            'rt' => $rt,
            'rw' => $rw,
            'status' => $this->request->getPost('status'),
            'jenis_kelamin' => $this->request->getPost('jenis_kelamin'),
            'pekerjaan' => $pekerjaan
        ]);

        return redirect()->to('/warga')->with('success', 'Data warga berhasil ditambahkan');
    }


    public function edit($id)
    {
        $data['warga'] = $this->wargaModel->find($id);
        $data['title'] = 'Edit Data Warga';
        return view('warga/edit', $data);
    }

    public function update($id)
    {
        $rules = [
            'nama' => 'required|min_length[3]',
            'alamat' => 'required',
            'jumlah_keluarga' => 'required|integer',
            'rt' => 'required|integer',
            'rw' => 'required|integer',
            'status' => 'required',
            'jenis_kelamin' => 'required',
            'pekerjaan' => 'required'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', $this->validator->listErrors());
        }


        $pekerjaan = $this->request->getPost('pekerjaan');
        if ($pekerjaan == 'Lainnya') {
            $pekerjaan = $this->request->getPost('pekerjaan_lain');
        }

        $this->wargaModel->update($id, [
            'nama' => $this->request->getPost('nama'),
            'alamat' => $this->request->getPost('alamat'),
            'jumlah_keluarga' => $this->request->getPost('jumlah_keluarga'),
            'rt' => str_pad($this->request->getPost('rt'), 2, '0', STR_PAD_LEFT),
            'rw' => str_pad($this->request->getPost('rw'), 2, '0', STR_PAD_LEFT),
            'status' => $this->request->getPost('status'),
            'jenis_kelamin' => $this->request->getPost('jenis_kelamin'),
            'pekerjaan' => $pekerjaan
        ]);

        return redirect()->to('/warga')->with('success', 'Data warga berhasil diperbarui');
    }

    public function delete($id)
    {
        $this->wargaModel->delete($id);
        return redirect()->to('/warga')->with('success', 'Data warga berhasil dihapus');
    }
}