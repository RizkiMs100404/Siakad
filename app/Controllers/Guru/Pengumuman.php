<?php

namespace App\Controllers\Guru;

use App\Controllers\BaseController;
use App\Models\PengumumanModel;
use App\Models\GuruModel;

class Pengumuman extends BaseController
{
    protected $pengumumanModel;

    public function __construct()
    {
        $this->pengumumanModel = new PengumumanModel();
    }

    protected function getGuru()
    {
        $userId = session('user_id');
        $guru = (new GuruModel())->where('user_id', $userId)->first();

        if (!$guru) {
            return redirect()->to('/logout')->with('errors', ['Data guru tidak ditemukan.']);
        }

        return $guru;
    }

    public function index()
    {
        $pengumuman = $this->pengumumanModel
            ->orderBy('created_at', 'DESC')
            ->findAll();

        return view('guru/pengumuman/index', [
            'pengumuman' => $pengumuman,
            'breadcrumb' => ['Pengumuman']
        ]);
    }

    public function create()
    {
        return view('guru/pengumuman/create', [
            'breadcrumb' => ['Pengumuman', 'Tambah']
        ]);
    }

    public function store()
    {
        $guru = $this->getGuru();
        $data = $this->request->getPost();

        $validation = \Config\Services::validation();
        $validation->setRules([
            'judul' => 'required|min_length[3]',
            'isi'   => 'required|min_length[5]',
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $this->pengumumanModel->save([
            'judul'   => $data['judul'],
            'isi'     => $data['isi'],
            'author'  => $guru['nama_lengkap'] ?? 'Guru',
            'tanggal' => date('Y-m-d'),
        ]);

        return redirect()->to(base_url('guru/pengumuman'))->with('success', 'Pengumuman berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $pengumuman = $this->pengumumanModel->find($id);

        if (!$pengumuman) {
            return redirect()->back()->with('errors', ['Data tidak ditemukan']);
        }

        return view('guru/pengumuman/edit', [
            'pengumuman' => $pengumuman,
            'breadcrumb' => ['Pengumuman', 'Edit']
        ]);
    }

    public function update($id)
    {
        $guru = $this->getGuru();
        $data = $this->request->getPost();

        $validation = \Config\Services::validation();
        $validation->setRules([
            'judul' => 'required|min_length[3]',
            'isi'   => 'required|min_length[5]',
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $this->pengumumanModel->update($id, [
            'judul'  => $data['judul'],
            'isi'    => $data['isi'],
            'author' => $guru['nama_lengkap'] ?? 'Guru'
        ]);

        return redirect()->to(base_url('guru/pengumuman'))->with('success', 'Pengumuman berhasil diupdate.');
    }

    public function delete($id)
    {
        $this->pengumumanModel->delete($id);
        return redirect()->to(base_url('guru/pengumuman'))->with('success', 'Pengumuman berhasil dihapus.');
    }
}
