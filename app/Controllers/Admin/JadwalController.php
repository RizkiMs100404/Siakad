<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\JadwalModel;
use App\Models\KelasModel;
use App\Models\MapelModel;
use App\Models\GuruModel;

class JadwalController extends BaseController
{
    protected $jadwalModel;

    public function __construct()
    {
        $this->jadwalModel = new JadwalModel();
    }

    public function index()
    {
        $search   = $this->request->getGet('search');
        $perPage  = 10;

        // JOIN ke tabel relasi
        $this->jadwalModel
            ->select('jadwal.*, kelas.nama_kelas, mapel.nama_mapel, guru.nama_lengkap AS nama_guru')
            ->join('kelas', 'kelas.id = jadwal.kelas_id', 'left')
            ->join('mapel', 'mapel.id = jadwal.mapel_id', 'left')
            ->join('guru', 'guru.id = jadwal.guru_id', 'left');

        if ($search) {
            $this->jadwalModel->groupStart()
                ->like('kelas.nama_kelas', $search)
                ->orLike('mapel.nama_mapel', $search)
                ->orLike('guru.nama_lengkap', $search)
                ->orLike('hari', $search)
                ->groupEnd();
        }

        $data = [
            'jadwal'    => $this->jadwalModel->orderBy('hari', 'asc')->paginate($perPage, 'default'),
            'pager'     => $this->jadwalModel->pager,
            'pageTitle' => 'Data Jadwal',
            'breadcrumb'=> ['Data Master', 'Jadwal'],
            'search'    => $search,
        ];
        return view('admin/jadwal/index', $data);
    }

    public function create()
{
    $kelasModel = new \App\Models\KelasModel();
    $mapelModel = new \App\Models\MapelModel();
    $guruModel  = new \App\Models\GuruModel();

    $data = [
        'kelasList' => $kelasModel->orderBy('nama_kelas')->findAll(),
        'mapelList' => $mapelModel->orderBy('nama_mapel')->findAll(),
        'guruList'  => $guruModel->orderBy('nama_lengkap')->findAll(),
        'pageTitle'  => 'Tambah Jadwal',
        'breadcrumb' => ['Data Master', 'Jadwal', 'Tambah'],
    ];
    return view('admin/jadwal/create', $data);
}


    public function store()
    {
        $validation = \Config\Services::validation();
        if (!$this->validate([
            'kelas_id'   => 'required',
            'mapel_id'   => 'required',
            'guru_id'    => 'required',
            'hari'       => 'required',
            'jam_mulai'  => 'required',
            'jam_selesai'=> 'required',
        ])) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $this->jadwalModel->save([
            'kelas_id'   => $this->request->getPost('kelas_id'),
            'mapel_id'   => $this->request->getPost('mapel_id'),
            'guru_id'    => $this->request->getPost('guru_id'),
            'hari'       => $this->request->getPost('hari'),
            'jam_mulai'  => $this->request->getPost('jam_mulai'),
            'jam_selesai'=> $this->request->getPost('jam_selesai'),
        ]);

        return redirect()->to('/admin/jadwal')->with('success', 'Data jadwal berhasil ditambahkan');
    }

    public function edit($id)
{
    $jadwal = $this->jadwalModel->find($id);
    if (!$jadwal) {
        throw new \CodeIgniter\Exceptions\PageNotFoundException('Data jadwal tidak ditemukan');
    }
    $kelasModel = new \App\Models\KelasModel();
    $mapelModel = new \App\Models\MapelModel();
    $guruModel  = new \App\Models\GuruModel();
    $data = [
        'jadwal'    => $jadwal,
        'kelasList' => $kelasModel->orderBy('nama_kelas')->findAll(),
        'mapelList' => $mapelModel->orderBy('nama_mapel')->findAll(),
        'guruList'  => $guruModel->orderBy('nama_lengkap')->findAll(),
        'pageTitle' => 'Edit Jadwal',
        'breadcrumb'=> ['Data Master', 'Jadwal', 'Edit'],
    ];
    return view('admin/jadwal/edit', $data);
}


    public function update($id)
    {
        $jadwal = $this->jadwalModel->find($id);
        if (!$jadwal) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Data jadwal tidak ditemukan');
        }

        $validation = \Config\Services::validation();
        $rules = [
            'kelas_id'   => 'required',
            'mapel_id'   => 'required',
            'guru_id'    => 'required',
            'hari'       => 'required',
            'jam_mulai'  => 'required',
            'jam_selesai'=> 'required',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $this->jadwalModel->update($id, [
            'kelas_id'   => $this->request->getPost('kelas_id'),
            'mapel_id'   => $this->request->getPost('mapel_id'),
            'guru_id'    => $this->request->getPost('guru_id'),
            'hari'       => $this->request->getPost('hari'),
            'jam_mulai'  => $this->request->getPost('jam_mulai'),
            'jam_selesai'=> $this->request->getPost('jam_selesai'),
        ]);

        return redirect()->to('/admin/jadwal')->with('success', 'Data jadwal berhasil diupdate');
    }

    public function delete($id)
    {
        $jadwal = $this->jadwalModel->find($id);
        if (!$jadwal) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Data jadwal tidak ditemukan');
        }
        $this->jadwalModel->delete($id);

        return redirect()->to('/admin/jadwal')->with('success', 'Data jadwal berhasil dihapus');
    }
}
