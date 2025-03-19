<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class RtController extends BaseController
{
    protected $userModel;
    protected $helpers = ['form'];

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    // Menampilkan daftar RT
    public function index()
    {
        $data['rt_list'] = $this->userModel->where('role', 'rt')->findAll();
        $data['title'] = 'Data RT';
        return view('rt/index', $data);
    }

    public function create()
    {
        $data['title'] = 'Tambah Data RT';
        return view('rt/create', $data);
    }

    // Menyimpan data RT baru
    public function store()
    {
        $validation = \Config\Services::validation();
        $validation->setRules([
            'name' => 'required|min_length[3]|max_length[255]',
            'username' => 'required|is_unique[users.username]|min_length[3]|max_length[20]',
            'password' => 'required|min_length[6]',
            'rt' => 'required|integer|min_length[1]|max_length[2]'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $rt = str_pad($this->request->getPost('rt'), 2, '0', STR_PAD_LEFT);

        $this->userModel->save([
            'name' => $this->request->getPost('name'),
            'username' => $this->request->getPost('username'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'role' => 'rt',
            'rt' => $rt
        ]);

        return redirect()->to('/rt')->with('success', 'RT berhasil ditambahkan');
    }

    // Menampilkan form edit RT
    public function edit($id)
    {
        $data['rt'] = $this->userModel->find($id);
        $data['title'] = 'Edit Data RT';
        if (!$data['rt'] || $data['rt']['role'] !== 'rt') {
            return redirect()->to('/rt')->with('error', 'Data tidak ditemukan');
        }

        return view('rt/edit', $data);
    }

    // Update data RT
    public function update($id)
    {
        $validation = \Config\Services::validation();
        $validation->setRules([
            'name' => 'required|min_length[3]|max_length[255]',
            'username' => "required|min_length[3]|max_length[20]|is_unique[users.username,id,{$id}]",
            'rt' => 'required|integer|min_length[1]|max_length[2]'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $rt = str_pad($this->request->getPost('rt'), 2, '0', STR_PAD_LEFT);

        $updateData = [
            'name' => $this->request->getPost('name'),
            'username' => $this->request->getPost('username'),
            'rt' => $rt
        ];

        if ($this->request->getPost('password')) {
            $updateData['password'] = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);
        }

        $this->userModel->update($id, $updateData);

        return redirect()->to('/rt')->with('success', 'Data RT berhasil diperbarui');
    }

    // Hapus data RT
    public function delete($id)
    {
        $rt = $this->userModel->find($id);

        if (!$rt || $rt['role'] !== 'rt') {
            return redirect()->to('/rt')->with('error', 'Data tidak ditemukan');
        }

        $this->userModel->delete($id);

        return redirect()->to('/rt')->with('success', 'RT berhasil dihapus');
    }
}