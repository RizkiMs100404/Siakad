<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\SiswaModel;
use App\Models\UserModel;
use App\Models\KelasModel;

class SiswaController extends BaseController
{
    protected $siswaModel;

    public function __construct()
    {
        $this->siswaModel = new SiswaModel();
    }

    public function index()
{
    $siswaModel = $this->siswaModel;
    $search = $this->request->getGet('search');
    $perPage = 10;

    $siswa = $siswaModel
        ->select('siswa.*, kelas.nama_kelas')
        ->join('kelas', 'kelas.id = siswa.kelas_id', 'left');

    if ($search) {
        $siswa->groupStart()
            ->like('siswa.nama_lengkap', $search)
            ->orLike('siswa.nis', $search)
            ->orLike('siswa.nisn', $search)
            ->orLike('kelas.nama_kelas', $search)
            ->groupEnd();
    }

    $siswaData = $siswa->orderBy('siswa.nama_lengkap','asc')->paginate($perPage);
    // Dapatkan user_id siswa
    $userIds = array_column($siswaData, 'user_id');
    $users = [];
    if ($userIds) {
        $userModel = new \App\Models\UserModel();
        $userRows = $userModel->whereIn('id', $userIds)->findAll();
        foreach($userRows as $u){
            $users[$u['id']] = $u;
        }
    }

    $data = [
        'siswa'     => $siswaData,
        'users'     => $users,
        'pager'     => $siswaModel->pager,
        'pageTitle' => 'Data Siswa',
        'breadcrumb'=> ['Data Master', 'Siswa'],
        'search'    => $search
    ];
    return view('admin/siswa/index', $data);
}


    public function create()
{
    $kelasModel = new KelasModel();
    $userModel  = new UserModel();

    // Ambil user_id yang sudah dipakai di siswa dan filter null
    $usedUserIds = $this->siswaModel->select('user_id')->findColumn('user_id') ?? [];
    $usedUserIds = array_filter($usedUserIds, function($v) { return !is_null($v) && $v !== ''; });

    // Ambil user role siswa yang belum dipakai
    $users = $userModel->where('role', 'siswa');
    if ($usedUserIds) {
        $users = $users->whereNotIn('id', $usedUserIds);
    }
    $users = $users->findAll();

    $data = [
        'users'      => $users,
        'kelas'      => $kelasModel->orderBy('nama_kelas')->findAll(),
        'pageTitle'  => 'Tambah Siswa',
        'breadcrumb' => ['Data Master', 'Siswa', 'Tambah'],
    ];
    return view('admin/siswa/create', $data);
}



    public function store()
    {
        $validation = \Config\Services::validation();

        if (!$this->validate([
            'user_id'      => 'required|is_unique[siswa.user_id]',
            'nama_lengkap' => 'required',
            'nis'          => 'required|is_unique[siswa.nis]',
            'nisn'         => 'required|is_unique[siswa.nisn]',
            'kelas_id'     => 'required',
            'jurusan'      => 'required',
            'no_hp'        => 'required',
            'alamat'       => 'required',
        ])) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $this->siswaModel->save([
            'user_id'      => $this->request->getPost('user_id'),
            'nama_lengkap' => $this->request->getPost('nama_lengkap'),
            'nis'          => $this->request->getPost('nis'),
            'nisn'         => $this->request->getPost('nisn'),
            'kelas_id'     => $this->request->getPost('kelas_id'),
            'jurusan'      => $this->request->getPost('jurusan'),
            'no_hp'        => $this->request->getPost('no_hp'),
            'alamat'       => $this->request->getPost('alamat'),
        ]);

        return redirect()->to('/admin/siswa')->with('success', 'Data siswa berhasil ditambahkan');
    }

    public function edit($id)
    {
        $siswa = $this->siswaModel->find($id);
        if (!$siswa) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Data siswa tidak ditemukan');
        }

        $kelasModel = new KelasModel();
        $userModel = new UserModel();
        // Ambil user role siswa yg belum pernah dipakai, plus yang sedang dipakai oleh data ini
        $usedUserIds = $this->siswaModel->select('user_id')->where('id !=', $id)->findColumn('user_id') ?? [];
        $users = $userModel->where('role', 'siswa');
        if ($usedUserIds) {
            $users = $users->whereNotIn('id', $usedUserIds);
        }
        if ($siswa['user_id']) {
            $users = $users->orWhere('id', $siswa['user_id']);
        }
        $users = $users->findAll();

        $data = [
            'siswa'      => $siswa,
            'users'      => $users,
            'kelas'      => $kelasModel->orderBy('nama_kelas')->findAll(),
            'pageTitle'  => 'Edit Siswa',
            'breadcrumb' => ['Data Master', 'Siswa', 'Edit'],
        ];
        return view('admin/siswa/edit', $data);
    }

    public function update($id)
    {
        $siswa = $this->siswaModel->find($id);
        if (!$siswa) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Data siswa tidak ditemukan');
        }

        $validation = \Config\Services::validation();

        $rules = [
            'user_id'      => "required|is_unique[siswa.user_id,id,$id]",
            'nama_lengkap' => 'required',
            'nis'          => "required|is_unique[siswa.nis,id,$id]",
            'nisn'         => "required|is_unique[siswa.nisn,id,$id]",
            'kelas_id'     => 'required',
            'jurusan'      => 'required',
            'no_hp'        => 'required',
            'alamat'       => 'required',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $this->siswaModel->update($id, [
            'user_id'      => $this->request->getPost('user_id'),
            'nama_lengkap' => $this->request->getPost('nama_lengkap'),
            'nis'          => $this->request->getPost('nis'),
            'nisn'         => $this->request->getPost('nisn'),
            'kelas_id'     => $this->request->getPost('kelas_id'),
            'jurusan'      => $this->request->getPost('jurusan'),
            'no_hp'        => $this->request->getPost('no_hp'),
            'alamat'       => $this->request->getPost('alamat'),
        ]);

        return redirect()->to('/admin/siswa')->with('success', 'Data siswa berhasil diupdate');
    }

    public function delete($id)
    {
        $siswa = $this->siswaModel->find($id);
        if (!$siswa) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Data siswa tidak ditemukan');
        }

        $this->siswaModel->delete($id);

        return redirect()->to('/admin/siswa')->with('success', 'Data siswa berhasil dihapus');
    }
}
