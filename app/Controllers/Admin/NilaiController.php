<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\NilaiModel;
use App\Models\SiswaModel;
use App\Models\KelasModel;
use App\Models\MapelModel;
use App\Models\GuruModel;

class NilaiController extends BaseController
{
    protected $nilaiModel;

    public function __construct()
    {
        $this->nilaiModel = new NilaiModel();
    }

    public function index()
    {
        $nilaiModel = $this->nilaiModel;
        $search = $this->request->getGet('search');
        $perPage = 10;

        // JOIN relasi ke siswa, mapel, guru, kelas
        $nilaiModel->select('nilai.*, 
            siswa.nama_lengkap as siswa_nama, 
            mapel.nama_mapel, 
            guru.nama_lengkap as guru_nama, 
            kelas.nama_kelas
        ')
        ->join('siswa', 'siswa.id = nilai.siswa_id', 'left')
        ->join('mapel', 'mapel.id = nilai.mapel_id', 'left')
        ->join('guru', 'guru.id = nilai.guru_id', 'left')
        ->join('kelas', 'kelas.id = nilai.kelas_id', 'left');

        if ($search) {
            $nilaiModel->groupStart()
                ->like('siswa.nama_lengkap', $search)
                ->orLike('mapel.nama_mapel', $search)
                ->orLike('guru.nama_lengkap', $search)
                ->orLike('kelas.nama_kelas', $search)
                ->orLike('nilai_angka', $search)
                ->orLike('nilai_huruf', $search)
                ->orLike('semester', $search)
                ->orLike('tahun_ajaran', $search)
                ->groupEnd();
        }

        $data = [
            'nilai'      => $nilaiModel->orderBy('tahun_ajaran','desc')->paginate($perPage),
            'pager'      => $nilaiModel->pager,
            'pageTitle'  => 'Data Nilai',
            'breadcrumb' => ['Data Master', 'Nilai'],
            'search'     => $search,
        ];
        return view('admin/nilai/index', $data);
    }

    public function create()
    {
        $kelasModel = new KelasModel();
        $siswaModel = new SiswaModel();
        $mapelModel = new MapelModel();
        $guruModel  = new GuruModel();
        $data = [
            'kelasList'  => $kelasModel->orderBy('nama_kelas')->findAll(),
            'siswaList'  => $siswaModel->orderBy('nama_lengkap')->findAll(),
            'mapelList'  => $mapelModel->orderBy('nama_mapel')->findAll(),
            'guruList'   => $guruModel->orderBy('nama_lengkap')->findAll(),
            'pageTitle'  => 'Tambah Nilai',
            'breadcrumb' => ['Data Master', 'Nilai', 'Tambah'],
        ];
        return view('admin/nilai/create', $data);
    }

    public function store()
    {
        $validation = \Config\Services::validation();
        if (!$this->validate([
            'siswa_id'     => 'required',
            'mapel_id'     => 'required',
            'guru_id'      => 'required',
            'kelas_id'     => 'required',
            'nilai_angka'  => 'required|numeric',
            'nilai_huruf'  => 'required',
            'semester'     => 'required',
            'tahun_ajaran' => 'required',
        ])) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $this->nilaiModel->save([
            'siswa_id'     => $this->request->getPost('siswa_id'),
            'mapel_id'     => $this->request->getPost('mapel_id'),
            'guru_id'      => $this->request->getPost('guru_id'),
            'kelas_id'     => $this->request->getPost('kelas_id'),
            'nilai_angka'  => $this->request->getPost('nilai_angka'),
            'nilai_huruf'  => $this->request->getPost('nilai_huruf'),
            'semester'     => $this->request->getPost('semester'),
            'tahun_ajaran' => $this->request->getPost('tahun_ajaran'),
        ]);

        return redirect()->to('/admin/nilai')->with('success', 'Data nilai berhasil ditambahkan');
    }

    public function edit($id)
    {
        $nilai = $this->nilaiModel->find($id);
        if (!$nilai) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Data nilai tidak ditemukan');
        }

        $kelasModel = new KelasModel();
        $siswaModel = new SiswaModel();
        $mapelModel = new MapelModel();
        $guruModel  = new GuruModel();

        $data = [
            'nilai'      => $nilai,
            'kelasList'  => $kelasModel->orderBy('nama_kelas')->findAll(),
            'siswaList'  => $siswaModel->orderBy('nama_lengkap')->findAll(),
            'mapelList'  => $mapelModel->orderBy('nama_mapel')->findAll(),
            'guruList'   => $guruModel->orderBy('nama_lengkap')->findAll(),
            'pageTitle'  => 'Edit Nilai',
            'breadcrumb' => ['Data Master', 'Nilai', 'Edit'],
        ];

        return view('admin/nilai/edit', $data);
    }

    public function update($id)
    {
        $nilai = $this->nilaiModel->find($id);
        if (!$nilai) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Data nilai tidak ditemukan');
        }

        $validation = \Config\Services::validation();
        $rules = [
            'siswa_id'     => 'required',
            'mapel_id'     => 'required',
            'guru_id'      => 'required',
            'kelas_id'     => 'required',
            'nilai_angka'  => 'required|numeric',
            'nilai_huruf'  => 'required',
            'semester'     => 'required',
            'tahun_ajaran' => 'required',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $this->nilaiModel->update($id, [
            'siswa_id'     => $this->request->getPost('siswa_id'),
            'mapel_id'     => $this->request->getPost('mapel_id'),
            'guru_id'      => $this->request->getPost('guru_id'),
            'kelas_id'     => $this->request->getPost('kelas_id'),
            'nilai_angka'  => $this->request->getPost('nilai_angka'),
            'nilai_huruf'  => $this->request->getPost('nilai_huruf'),
            'semester'     => $this->request->getPost('semester'),
            'tahun_ajaran' => $this->request->getPost('tahun_ajaran'),
        ]);

        return redirect()->to('/admin/nilai')->with('success', 'Data nilai berhasil diupdate');
    }

    public function delete($id)
    {
        $nilai = $this->nilaiModel->find($id);
        if (!$nilai) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Data nilai tidak ditemukan');
        }
        $this->nilaiModel->delete($id);

        return redirect()->to('/admin/nilai')->with('success', 'Data nilai berhasil dihapus');
    }
}
