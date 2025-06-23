<?php

namespace App\Controllers\Siswa;

use App\Controllers\BaseController;
use App\Models\SiswaModel;
use App\Models\NilaiModel;
use App\Models\MapelModel;
use App\Models\GuruModel;
use App\Models\KelasModel;

class Nilai extends BaseController
{
    public function index()
    {
        $userId = session('user_id');

        if (!$userId) {
            return redirect()->to(base_url('login'))->with('errors', ['Silakan login dahulu.']);
        }

        $siswaModel = new SiswaModel();
        $nilaiModel = new NilaiModel();
        $mapelModel = new MapelModel();
        $guruModel  = new GuruModel();
        $kelasModel = new KelasModel();

        $siswa = $siswaModel->where('user_id', $userId)->first();
        if (!$siswa) {
            return redirect()->back()->with('errors', ['Data siswa tidak ditemukan.']);
        }

        $nilaiList = $nilaiModel->where('siswa_id', $siswa['id'])
            ->orderBy('tahun_ajaran', 'DESC')
            ->orderBy('semester', 'DESC')
            ->findAll();

        foreach ($nilaiList as &$n) {
            $n['mapel'] = $mapelModel->find($n['mapel_id'])['nama_mapel'] ?? '-';
            $n['guru']  = $guruModel->find($n['guru_id'])['nama_lengkap'] ?? '-';
            $n['kelas'] = $kelasModel->find($n['kelas_id'])['nama_kelas'] ?? '-';
        }

        return view('siswa/nilai/index', [
            'nilaiList' => $nilaiList,
            'pageTitle' => 'Data Nilai',
            'breadcrumb' => ['Akademik', 'Nilai Siswa']
        ]);
    }
}
