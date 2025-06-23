<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\MapelModel;
use App\Models\GuruModel;

class MapelController extends BaseController
{
    protected $mapelModel;

    public function __construct()
    {
        $this->mapelModel = new MapelModel();
    }

    public function index()
    {
        $mapelModel = $this->mapelModel;
        $search = $this->request->getGet('search');
        $perPage = 10;

        // Join ke guru untuk dapat nama
        $mapelModel->select('mapel.*, guru.nama_lengkap as nama_guru');
        $mapelModel->join('guru', 'guru.id = mapel.guru_id', 'left');

        if ($search) {
            $mapelModel->groupStart()
                ->like('mapel.nama_mapel', $search)
                ->orLike('guru.nama_lengkap', $search)
                ->groupEnd();
        }

        $data = [
            'mapel'    => $mapelModel->orderBy('mapel.nama_mapel','asc')->paginate($perPage),
            'pager'    => $mapelModel->pager,
            'pageTitle'=> 'Data Mapel',
            'breadcrumb'=> ['Data Master', 'Mapel'],
            'search'   => $search,
        ];
        return view('admin/mapel/index', $data);
    }

    public function create()
    {
        $guruModel = new GuruModel();
        $data = [
            'guruList'   => $guruModel->orderBy('nama_lengkap')->findAll(),
            'pageTitle'  => 'Tambah Mapel',
            'breadcrumb' => ['Data Master', 'Mapel', 'Tambah'],
        ];
        return view('admin/mapel/create', $data);
    }

    public function store()
    {
        $validation = \Config\Services::validation();
        if (!$this->validate([
            'nama_mapel' => 'required|is_unique[mapel.nama_mapel]',
            'guru_id'    => 'required'
        ])) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $this->mapelModel->save([
            'nama_mapel' => $this->request->getPost('nama_mapel'),
            'guru_id'    => $this->request->getPost('guru_id'),
        ]);

        return redirect()->to('/admin/mapel')->with('success', 'Data mapel berhasil ditambahkan');
    }

    public function edit($id)
    {
        $mapel = $this->mapelModel->find($id);
        if (!$mapel) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Data mapel tidak ditemukan');
        }
        $guruModel = new GuruModel();
        $data = [
            'mapel'     => $mapel,
            'guruList'  => $guruModel->orderBy('nama_lengkap')->findAll(),
            'pageTitle' => 'Edit Mapel',
            'breadcrumb' => ['Data Master', 'Mapel', 'Edit'],
        ];

        return view('admin/mapel/edit', $data);
    }

    public function update($id)
    {
        $mapel = $this->mapelModel->find($id);
        if (!$mapel) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Data mapel tidak ditemukan');
        }

        $validation = \Config\Services::validation();
        $rules = [
            'nama_mapel' => "required|is_unique[mapel.nama_mapel,id,$id]",
            'guru_id'    => 'required'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $this->mapelModel->update($id, [
            'nama_mapel' => $this->request->getPost('nama_mapel'),
            'guru_id'    => $this->request->getPost('guru_id'),
        ]);

        return redirect()->to('/admin/mapel')->with('success', 'Data mapel berhasil diupdate');
    }

    public function delete($id)
    {
        $mapel = $this->mapelModel->find($id);
        if (!$mapel) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Data mapel tidak ditemukan');
        }
        $this->mapelModel->delete($id);

        return redirect()->to('/admin/mapel')->with('success', 'Data mapel berhasil dihapus');
    }
}
