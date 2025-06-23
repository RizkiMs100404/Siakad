<?php

namespace App\Controllers\Siswa;

use App\Controllers\BaseController;
use App\Models\SiswaModel;
use App\Models\JadwalModel;
use App\Models\MapelModel;
use App\Models\GuruModel;

class Jadwal extends BaseController
{
    public function index()
    {
        $userId = session('user_id');
        if (!$userId) {
            return redirect()->to(base_url('login'))->with('errors', ['Silakan login dahulu.']);
        }

        $siswaModel = new SiswaModel();
        $jadwalModel = new JadwalModel();
        $mapelModel = new MapelModel();
        $guruModel = new GuruModel();

        $siswa = $siswaModel->where('user_id', $userId)->first();
        if (!$siswa) {
            return redirect()->back()->with('errors', ['Data siswa tidak ditemukan.']);
        }

        $jadwal = $jadwalModel->where('kelas_id', $siswa['kelas_id'])->orderBy('hari', 'ASC')->orderBy('jam_mulai', 'ASC')->findAll();

        foreach ($jadwal as &$j) {
            $j['mapel'] = $mapelModel->find($j['mapel_id'])['nama_mapel'] ?? '-';
            $j['guru'] = $guruModel->find($j['guru_id'])['nama_lengkap'] ?? '-';
        }

        return view('siswa/jadwal/index', [
            'jadwal' => $jadwal,
            'pageTitle' => 'Jadwal Pelajaran',
            'breadcrumb' => ['Akademik', 'Jadwal Pelajaran']
        ]);
    }
}
