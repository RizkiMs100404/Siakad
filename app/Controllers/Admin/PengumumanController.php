<?php

namespace App\Controllers\Admin;
use App\Controllers\BaseController;
use App\Models\PengumumanModel;

class PengumumanController extends BaseController
{
    protected $pengumumanModel;

    public function __construct()
    {
        $this->pengumumanModel = new PengumumanModel();
    }

    public function index()
{
    $search = $this->request->getGet('search');
    $perPage = 5; // jumlah data per halaman

    $model = $this->pengumumanModel;

    if ($search) {
        $model = $model
            ->groupStart()
            ->like('judul', $search)
            ->orLike('isi', $search)
            ->orLike('author', $search)
            ->groupEnd();
    }

    $pengumuman = $model->orderBy('tanggal', 'desc')->paginate($perPage, 'pengumuman');
    $pager = $model->pager;

    $data = [
        'pengumuman' => $pengumuman,
        'pager'      => $pager,
        'pageTitle'  => 'Pengumuman',
        'breadcrumb' => ['Pengumuman'],
        'search'     => $search, // untuk di view
    ];
    return view('admin/pengumuman/index', $data);
}


    public function create()
    {
        $data = [
            'pageTitle' => 'Tambah Pengumuman',
            'breadcrumb' => ['Pengumuman', 'Tambah']
        ];
        return view('admin/pengumuman/create', $data);
    }

    public function store()
    {
        $validation = \Config\Services::validation();
        $rules = [
            'judul' => 'required',
            'isi' => 'required',
            'tanggal' => 'required|valid_date[Y-m-d]',
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $this->pengumumanModel->insert([
            'judul' => $this->request->getPost('judul'),
            'isi'   => $this->request->getPost('isi'),
            'author'=> session('username') ?? 'Admin',
            'tanggal'=> $this->request->getPost('tanggal')
        ]);

        return redirect()->to('/admin/pengumuman')->with('success', 'Pengumuman berhasil ditambahkan');
    }

    public function edit($id)
    {
        $p = $this->pengumumanModel->find($id);
        if (!$p) throw new \CodeIgniter\Exceptions\PageNotFoundException('Pengumuman tidak ditemukan');

        $data = [
            'pengumuman' => $p,
            'pageTitle' => 'Edit Pengumuman',
            'breadcrumb' => ['Pengumuman', 'Edit']
        ];
        return view('admin/pengumuman/edit', $data);
    }

    public function update($id)
    {
        $p = $this->pengumumanModel->find($id);
        if (!$p) throw new \CodeIgniter\Exceptions\PageNotFoundException('Pengumuman tidak ditemukan');

        $validation = \Config\Services::validation();
        $rules = [
            'judul' => 'required',
            'isi' => 'required',
            'tanggal' => 'required|valid_date[Y-m-d]',
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $this->pengumumanModel->update($id, [
            'judul' => $this->request->getPost('judul'),
            'isi'   => $this->request->getPost('isi'),
            'tanggal'=> $this->request->getPost('tanggal')
        ]);

        return redirect()->to('/admin/pengumuman')->with('success', 'Pengumuman berhasil diupdate');
    }

    public function delete($id)
    {
        $p = $this->pengumumanModel->find($id);
        if (!$p) throw new \CodeIgniter\Exceptions\PageNotFoundException('Pengumuman tidak ditemukan');
        $this->pengumumanModel->delete($id);

        return redirect()->to('/admin/pengumuman')->with('success', 'Pengumuman berhasil dihapus');
    }
}
