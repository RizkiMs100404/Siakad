<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;

class UserController extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function index()
{
    $userModel = $this->userModel;
    $search = $this->request->getGet('search');
    $role   = $this->request->getGet('role');
    $perPage = 10;

    if ($search) {
        $userModel = $userModel
            ->like('username', $search)
            ->orLike('email', $search)
            ->orLike('role', $search);
    }
    if ($role) {
        $userModel = $userModel->where('role', $role);
    }

    $data = [
        'users'      => $userModel->orderBy('role','asc')->orderBy('username','asc')->paginate($perPage),
        'pager'      => $userModel->pager,
        'pageTitle'  => 'Manajemen Akun',
        'breadcrumb' => ['Manajemen Akun'],
        'search'     => $search,
        'role'       => $role
    ];
    return view('admin/user/index', $data);
}


    public function create()
    {
        return view('admin/user/create', [
            'pageTitle' => 'Tambah User',
            'breadcrumb' => ['Manajemen Akun', 'Tambah']
        ]);
    }

    public function store()
    {
        $validation = \Config\Services::validation();
        if (!$this->validate([
            'username' => 'required|min_length[3]',
            'email'    => 'required|valid_email|is_unique[users.email]',
            'password' => 'required|min_length[6]',
            'role'     => 'required|in_list[admin,guru,siswa]',
            'foto'     => 'permit_empty|is_image[foto]|mime_in[foto,image/jpg,image/jpeg,image/png]|max_size[foto,2048]',
        ], [
            'email' => ['is_unique' => 'Email sudah digunakan.'],
            'role'  => ['in_list' => 'Role tidak valid.'],
        ])) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $data = [
            'username' => $this->request->getPost('username'),
            'email'    => $this->request->getPost('email'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'role'     => $this->request->getPost('role'),
        ];

        // Upload Foto
        $file = $this->request->getFile('foto');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $newName = uniqid() . '.' . $file->getClientExtension();
            $file->move('uploads/user/', $newName);
            $data['foto'] = $newName;
        }

        $this->userModel->save($data);

        return redirect()->to('/admin/manajemen-akun')->with('success', 'User berhasil ditambahkan');
    }

    public function edit($id)
    {
        $user = $this->userModel->find($id);
        if (!$user) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('User tidak ditemukan');
        }

        return view('admin/user/edit', [
            'user'      => $user,
            'pageTitle' => 'Edit User',
            'breadcrumb' => ['Manajemen Akun', 'Edit']
        ]);
    }

    public function update($id)
    {
        $user = $this->userModel->find($id);
        if (!$user) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('User tidak ditemukan');
        }

        $validation = \Config\Services::validation();
        $rules = [
            'username' => 'required|min_length[3]',
            'email'    => "required|valid_email|is_unique[users.email,id,$id]",
            'role'     => 'required|in_list[admin,guru,siswa]',
            'foto'     => 'permit_empty|is_image[foto]|mime_in[foto,image/jpg,image/jpeg,image/png]|max_size[foto,2048]',
        ];
        if ($this->request->getPost('password')) {
            $rules['password'] = 'min_length[6]';
        }
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $data = [
            'username' => $this->request->getPost('username'),
            'email'    => $this->request->getPost('email'),
            'role'     => $this->request->getPost('role'),
        ];

        if ($this->request->getPost('password')) {
            $data['password'] = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);
        }

        // Upload Foto
        $file = $this->request->getFile('foto');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $newName = uniqid() . '.' . $file->getClientExtension();
            $file->move('uploads/user/', $newName);
            $data['foto'] = $newName;
            // Hapus foto lama (bukan default)
            if ($user['foto'] && $user['foto'] != 'default.png' && file_exists('uploads/user/'.$user['foto'])) {
                @unlink('uploads/user/'.$user['foto']);
            }
        }

        $this->userModel->update($id, $data);

        return redirect()->to('/admin/manajemen-akun')->with('success', 'User berhasil diupdate');
    }

    public function delete($id)
    {
        $user = $this->userModel->find($id);
        if (!$user) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('User tidak ditemukan');
        }
        // Hapus foto
        if ($user['foto'] && $user['foto'] != 'default.png' && file_exists('uploads/user/'.$user['foto'])) {
            @unlink('uploads/user/'.$user['foto']);
        }
        $this->userModel->delete($id);

        return redirect()->to('/admin/manajemen-akun')->with('success', 'User berhasil dihapus');
    }
}
