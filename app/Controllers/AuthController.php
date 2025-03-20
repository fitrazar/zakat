<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class AuthController extends BaseController
{
    public function login()
    {
        return view('auth/login');
    }

    public function processLogin()
    {
        $session = session();
        $userModel = new UserModel();
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        $user = $userModel->getUserByUsername($username);

        if ($user && password_verify($password, $user['password'])) {
            $session->set([
                'user_id' => $user['id'],
                'username' => $user['username'],
                'name' => $user['name'],
                'role' => $user['role'],
                'rt' => $user['role'] == 'rt' ? $user['rt'] : '-',
                'isLoggedIn' => true
            ]);

            return redirect()->to('/');
        }

        return redirect()->to('/login')->with('error', 'Username atau password salah.');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }

    public function forgotPassword()
    {
        $data['title'] = 'Ganti Password';
        return view('auth/forgot_password', $data);
    }

    public function processForgotPassword()
    {
        $username = session()->get('username');
        $userModel = new UserModel();
        $user = $userModel->where('username', $username)->first();

        if (!$user) {
            return redirect()->to('/forgot-password')->with('error', 'Username tidak ditemukan.');
        }

        $userModel->update($user['id'], [
            'password' => password_hash(12345678, PASSWORD_DEFAULT)
        ]);

        return redirect()->to('/forgot-password')->with('success', 'Password berhasil direset.');
    }

    public function processResetPassword()
    {
        $username = session()->get('username');
        $password = $this->request->getPost('password');
        $confirmPassword = $this->request->getPost('confirm_password');

        if ($password !== $confirmPassword) {
            return redirect()->back()->with('error', 'Konfirmasi password tidak cocok.');
        }

        $userModel = new UserModel();
        $user = $userModel->where('username', $username)->first();

        if (!$user) {
            return redirect()->to('/forgot-password')->with('error', 'Username tidak valid.');
        }

        $userModel->update($user['id'], [
            'password' => password_hash($password, PASSWORD_DEFAULT)
        ]);

        return redirect()->to('/forgot-password')->with('success', 'Password berhasil direset.');
    }
}