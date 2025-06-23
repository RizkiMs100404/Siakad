<?php

namespace App\Controllers\Siswa;

use App\Controllers\BaseController;
use App\Models\SiswaModel;
use App\Models\PresensiModel;
use App\Models\MapelModel;
use App\Models\GuruModel;
use App\Models\KelasModel;

class Absensi extends BaseController
{
    public function index()
    {
        $userId = session('user_id');

        if (!$userId) {
            return redirect()->to(base_url('login'))->with('errors', ['Silakan login dahulu.']);
        }

        $siswaModel = new SiswaModel();
        $presensiModel = new PresensiModel();
        $mapelModel = new MapelModel();
        $guruModel  = new GuruModel();
        $kelasModel = new KelasModel();

        $siswa = $siswaModel->where('user_id', $userId)->first();
        if (!$siswa) {
            return redirect()->back()->with('errors', ['Data siswa tidak ditemukan.']);
        }

        $presensiList = $presensiModel->where('siswa_id', $siswa['id'])
            ->orderBy('tanggal', 'DESC')
            ->findAll();

        foreach ($presensiList as &$p) {
            $p['mapel'] = $mapelModel->find($p['mapel_id'])['nama_mapel'] ?? '-';
            $p['guru']  = $guruModel->find($p['guru_id'])['nama_lengkap'] ?? '-';
            $p['kelas'] = $kelasModel->find($p['kelas_id'])['nama_kelas'] ?? '-';
        }

        return view('siswa/absensi/index', [
            'presensiList' => $presensiList,
            'pageTitle' => 'Riwayat Absensi',
            'breadcrumb' => ['Akademik', 'Absensi']
        ]);
    }
}
