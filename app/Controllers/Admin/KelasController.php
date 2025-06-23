<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\KelasModel;
use App\Models\GuruModel;

class KelasController extends BaseController
{
    protected $kelasModel;

    public function __construct()
    {
        $this->kelasModel = new KelasModel();
    }

    public function index()
{
    $kelasModel = $this->kelasModel;
    $search     = $this->request->getGet('search');
    $perPage    = 10;

    // JOIN ke tabel guru, alias wali_nama
    $kelasModel->select('kelas.*, guru.nama_lengkap as wali_nama');
    $kelasModel->join('guru', 'guru.id = kelas.guru_id', 'left');

    if ($search) {
        $kelasModel->groupStart()
            ->like('kelas.nama_kelas', $search)
            ->orLike('guru.nama_lengkap', $search)
            ->groupEnd();
    }

    $data = [
        'kelas'     => $kelasModel->orderBy('kelas.nama_kelas', 'asc')->paginate($perPage, 'default'),
        'pager'     => $kelasModel->pager,
        'pageTitle' => 'Data Kelas',
        'breadcrumb'=> ['Data Master', 'Kelas'],
        'search'    => $search,
    ];
    return view('admin/kelas/index', $data);
}


    public function create()
    {
        $guruModel = new GuruModel();
        $data = [
            'guruList' => $guruModel->orderBy('nama_lengkap')->findAll(),
            'pageTitle' => 'Tambah Kelas',
            'breadcrumb' => ['Data Master', 'Kelas', 'Tambah'],
        ];
        return view('admin/kelas/create', $data);
    }

    public function store()
    {
        $validation = \Config\Services::validation();
        if (!$this->validate([
            'nama_kelas' => 'required|is_unique[kelas.nama_kelas]',
        ])) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $this->kelasModel->save([
            'nama_kelas' => $this->request->getPost('nama_kelas'),
            'guru_id'    => $this->request->getPost('guru_id'),
        ]);

        return redirect()->to('/admin/kelas')->with('success', 'Data kelas berhasil ditambahkan');
    }

    public function edit($id)
    {
        $kelas = $this->kelasModel->find($id);
        if (!$kelas) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Data kelas tidak ditemukan');
        }
        $guruModel = new GuruModel();
        $data = [
            'kelas' => $kelas,
            'guruList' => $guruModel->orderBy('nama_lengkap')->findAll(),
            'pageTitle' => 'Edit Kelas',
            'breadcrumb' => ['Data Master', 'Kelas', 'Edit'],
        ];

        return view('admin/kelas/edit', $data);
    }

    public function update($id)
    {
        $kelas = $this->kelasModel->find($id);
        if (!$kelas) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Data kelas tidak ditemukan');
        }

        $validation = \Config\Services::validation();
        $rules = [
            'nama_kelas' => "required|is_unique[kelas.nama_kelas,id,$id]",
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $this->kelasModel->update($id, [
            'nama_kelas' => $this->request->getPost('nama_kelas'),
            'guru_id'    => $this->request->getPost('guru_id'),
        ]);

        return redirect()->to('/admin/kelas')->with('success', 'Data kelas berhasil diupdate');
    }

    public function delete($id)
    {
        $kelas = $this->kelasModel->find($id);
        if (!$kelas) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Data kelas tidak ditemukan');
        }
        $this->kelasModel->delete($id);

        return redirect()->to('/admin/kelas')->with('success', 'Data kelas berhasil dihapus');
    }
}
