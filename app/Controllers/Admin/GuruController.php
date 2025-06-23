<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\GuruModel;
use App\Models\UserModel;

class GuruController extends BaseController
{
    protected $guruModel;

    public function __construct()
    {
        $this->guruModel = new GuruModel();
    }

    public function index()
{
    $guruModel = $this->guruModel;
    $search = $this->request->getGet('search');
    $perPage = 10; // jumlah data per halaman

    if ($search) {
        $guruModel = $guruModel->like('nama_lengkap', $search)
            ->orLike('nip', $search)
            ->orLike('mapel', $search);
    }

    // Data guru (dapatkan semua user_id yang digunakan)
    $guru = $guruModel->orderBy('nama_lengkap','asc')->paginate($perPage);
    $userIds = array_column($guru, 'user_id');
    $users = [];
    if ($userIds) {
        // Ambil data user terkait
        $userModel = new \App\Models\UserModel();
        $userRows = $userModel->whereIn('id', $userIds)->findAll();
        foreach($userRows as $u){
            $users[$u['id']] = $u;
        }
    }

    $data = [
        'guru'      => $guru,
        'users'     => $users, // untuk mapping user_id => nama
        'pager'     => $guruModel->pager,
        'pageTitle' => 'Data Guru',
        'breadcrumb'=> ['Data Master', 'Guru'],
        'search'    => $search
    ];
    return view('admin/guru/index', $data);
}


    public function create()
{
    // Ambil user role guru yang belum dipakai di tabel guru
    $userModel = new UserModel();
    $usedUserIds = $this->guruModel->select('user_id')->findColumn('user_id') ?? [];
    $users = $userModel->where('role', 'guru');
    if ($usedUserIds) {
        $users = $users->whereNotIn('id', $usedUserIds);
    }
    $users = $users->findAll();

    $data = [
        'users' => $users,
        'pageTitle' => 'Tambah Guru',
        'breadcrumb' => ['Data Master', 'Guru', 'Tambah'],
    ];
    return view('admin/guru/create', $data);
}


    public function store()
    {
        $validation = \Config\Services::validation();

        if (!$this->validate([
            'user_id'      => 'required|is_unique[guru.user_id]',
            'nama_lengkap' => 'required',
            'nip'          => 'required|is_unique[guru.nip]',
            'mapel'        => 'required',
            'no_hp'        => 'required',
            'alamat'       => 'required',
        ])) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $this->guruModel->save([
            'user_id'      => $this->request->getPost('user_id'),
            'nama_lengkap' => $this->request->getPost('nama_lengkap'),
            'nip'          => $this->request->getPost('nip'),
            'mapel'        => $this->request->getPost('mapel'),
            'no_hp'        => $this->request->getPost('no_hp'),
            'alamat'       => $this->request->getPost('alamat'),
        ]);

        return redirect()->to('/admin/guru')->with('success', 'Data guru berhasil ditambahkan');
    }

    public function edit($id)
{
    $guru = $this->guruModel->find($id);
    if (!$guru) {
        throw new \CodeIgniter\Exceptions\PageNotFoundException('Data guru tidak ditemukan');
    }
    $userModel = new UserModel();

    // Ambil semua user role guru yang belum dipakai, + user yang sedang digunakan di data ini (agar bisa tetap dipilih)
    $usedUserIds = $this->guruModel->select('user_id')->where('id !=', $id)->findColumn('user_id') ?? [];
    $users = $userModel->where('role', 'guru');
    if ($usedUserIds) {
        $users = $users->whereNotIn('id', $usedUserIds);
    }
    // Tambahkan user yang sekarang (biar tetap ada di dropdown)
    if ($guru['user_id']) {
        $users = $users->orWhere('id', $guru['user_id']);
    }
    $users = $users->findAll();

    $data = [
        'guru' => $guru,
        'users' => $users,
        'pageTitle' => 'Edit Guru',
        'breadcrumb' => ['Data Master', 'Guru', 'Edit'],
    ];

    return view('admin/guru/edit', $data);
}


    public function update($id)
    {
        $guru = $this->guruModel->find($id);
        if (!$guru) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Data guru tidak ditemukan');
        }

        $validation = \Config\Services::validation();

        // user_id tidak boleh dobel di table guru kecuali di data ini sendiri
        $rules = [
            'user_id'      => "required|is_unique[guru.user_id,id,$id]",
            'nama_lengkap' => 'required',
            'nip'          => "required|is_unique[guru.nip,id,$id]",
            'mapel'        => 'required',
            'no_hp'        => 'required',
            'alamat'       => 'required',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $this->guruModel->update($id, [
            'user_id'      => $this->request->getPost('user_id'),
            'nama_lengkap' => $this->request->getPost('nama_lengkap'),
            'nip'          => $this->request->getPost('nip'),
            'mapel'        => $this->request->getPost('mapel'),
            'no_hp'        => $this->request->getPost('no_hp'),
            'alamat'       => $this->request->getPost('alamat'),
        ]);

        return redirect()->to('/admin/guru')->with('success', 'Data guru berhasil diupdate');
    }

    public function delete($id)
    {
        $guru = $this->guruModel->find($id);
        if (!$guru) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Data guru tidak ditemukan');
        }

        $this->guruModel->delete($id);

        return redirect()->to('/admin/guru')->with('success', 'Data guru berhasil dihapus');
    }
} 