<?php

namespace App\Controllers\Siswa;

use App\Controllers\BaseController;
use App\Models\UserModel;
use Config\Services;

class Profile extends BaseController
{
    public function index()
    {
        $userId = session('user_id');

        if (!$userId) {
            return redirect()->to(base_url('login'))->with('errors', ['Silakan login dahulu.']);
        }

        $userModel = new UserModel();
        $user = $userModel->find($userId) ?? [];

        return view('siswa/profile/index', [
            'user' => $user,
            'pageTitle' => 'Profil Saya',
            'breadcrumb' => ['Pengaturan', 'Profil']
        ]);
    }

    public function update()
    {
        $userId = session('user_id');

        if (!$userId) {
            return redirect()->to(base_url('login'))->with('errors', ['Silakan login dahulu.']);
        }

        $userModel = new UserModel();
        $hasUsername = $this->request->getPost('username');
        $hasEmail    = $this->request->getPost('email');
        $file        = $this->request->getFile('foto');

        if ((!$hasUsername && !$hasEmail) && ($file && $file->isValid() && !$file->hasMoved())) {
            $validation = Services::validation();
            $validation->setRules([
                'foto' => 'uploaded[foto]|is_image[foto]|mime_in[foto,image/jpg,image/jpeg,image/png]|max_size[foto,2048]',
            ]);

            if (!$validation->withRequest($this->request)->run()) {
                return redirect()->back()->withInput()->with('errors', $validation->getErrors());
            }

            $newName = uniqid() . '.' . $file->getClientExtension();
            $file->move('uploads/user/', $newName);

            $user = $userModel->find($userId);
            if ($user && !empty($user['foto']) && $user['foto'] != 'default.png' && file_exists('uploads/user/' . $user['foto'])) {
                @unlink('uploads/user/' . $user['foto']);
            }

            $userModel->update($userId, ['foto' => $newName]);
            session()->set('user_foto', $newName);

            return redirect()->back()->with('success', 'Foto profil berhasil diperbarui.');
        }

        $validation = Services::validation();
        $validation->setRules([
            'username' => 'required|min_length[3]',
            'email'    => 'required|valid_email',
            'foto'     => 'permit_empty|is_image[foto]|mime_in[foto,image/jpg,image/jpeg,image/png]|max_size[foto,2048]',
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $data = [
            'username' => $this->request->getPost('username'),
            'email'    => $this->request->getPost('email'),
        ];

        if ($file && $file->isValid() && !$file->hasMoved()) {
            $newName = uniqid() . '.' . $file->getClientExtension();
            $file->move('uploads/user/', $newName);
            $data['foto'] = $newName;

            $user = $userModel->find($userId);
            if ($user && !empty($user['foto']) && $user['foto'] != 'default.png' && file_exists('uploads/user/' . $user['foto'])) {
                @unlink('uploads/user/' . $user['foto']);
            }

            session()->set('user_foto', $newName);
        }

        $userModel->update($userId, $data);
        session()->set('user_name', $data['username']);

        return redirect()->back()->with('success', 'Profil berhasil diperbarui.');
    }

    public function password()
    {
        $userId = session('user_id');

        if (!$userId) {
            return redirect()->to(base_url('login'))->with('errors', ['Silakan login dahulu.']);
        }

        $userModel = new UserModel();

        $validation = Services::validation();
        $validation->setRules([
            'current_password' => 'required',
            'new_password'     => 'required|min_length[6]',
            'confirm_password' => 'required|matches[new_password]',
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors())->with('tab', 'password');
        }

        $user = $userModel->find($userId);
        if (!$user) {
            return redirect()->back()->with('errors', ['User tidak ditemukan'])->with('tab', 'password');
        }

        if (!password_verify($this->request->getPost('current_password'), $user['password'])) {
            return redirect()->back()->with('errors', ['current_password' => 'Password lama salah'])->with('tab', 'password');
        }

        $userModel->update($userId, [
            'password' => password_hash($this->request->getPost('new_password'), PASSWORD_DEFAULT)
        ]);

        return redirect()->back()->with('success', 'Password berhasil diganti.')->with('tab', 'password');
    }
}
