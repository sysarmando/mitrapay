<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;

class Auth extends Controller
{
    public function login()
    {
        if (session()->get('isLoggedIn')) {
            return redirect()->to('/mitra');
        }
        $data = [
            'title' => 'Login Pengguna'
        ];
        return view('auth/login', $data);
    }

    public function attemptLogin()
    {
        $session = session();
        $model = new UserModel();

        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        $user = $model->where('user_id', $username)->first();

        if ($user) {
            if (password_verify($password, $user['password'])) {
                $session->set([
                    'user_id' => $user['user_id'],
                    "nama_lengkap" => $user['nama_lengkap'],
                    "role_user" => $user['role_id'],
                    "tim_kerja" => $user['tim_kerja'],
                    'isLoggedIn' => true
                ]);
                return redirect()->to('/mitra');
            } else {
                return redirect()->to('/login')->with('error', 'Username atau Password salah.');
            }
        } else {
            return redirect()->to('/login')->with('error', 'Username atau Password salah.');
        }
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}
