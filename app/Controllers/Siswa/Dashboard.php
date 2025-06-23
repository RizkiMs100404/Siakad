<?php

namespace App\Controllers\Siswa;

use App\Controllers\BaseController;
use App\Models\SiswaModel;
use App\Models\JadwalModel;
use App\Models\MapelModel;
use App\Models\KelasModel;
use App\Models\NilaiModel;
use App\Models\PengumumanModel;
use App\Models\PresensiModel;

class Dashboard extends BaseController
{
    public function index()
    {
        $userId = session('user_id');

        // Ambil data siswa login
        $siswaModel = new SiswaModel();
        $siswa = $siswaModel->where('user_id', $userId)->first();

        if (!$siswa) {
            return redirect()->to('/logout')->with('errors', ['Data siswa tidak ditemukan.']);
        }

        $siswaId  = $siswa['id'];
        $kelasId  = $siswa['kelas_id'];

        // Jadwal
        $jadwalModel = new JadwalModel();
        $mapelModel  = new MapelModel();
        $kelasModel  = new KelasModel();

        $jadwalRaw = $jadwalModel
            ->where('kelas_id', $kelasId)
            ->orderBy('hari', 'ASC')
            ->orderBy('jam_mulai', 'ASC')
            ->findAll();

        $jadwalList = [];
        foreach ($jadwalRaw as $j) {
            $mapel = $mapelModel->find($j['mapel_id']);
            $kelas = $kelasModel->find($j['kelas_id']);

            $jadwalList[] = [
                'hari'        => ucfirst(strtolower($j['hari'])),
                'jam_mulai'   => $j['jam_mulai'],
                'jam_selesai' => $j['jam_selesai'],
                'mapel'       => $mapel['nama_mapel'] ?? '-',
                'kelas'       => $kelas['nama_kelas'] ?? '-',
            ];
        }

        // Nilai terakhir
        $nilaiModel = new NilaiModel();
        $nilaiTerakhir = $nilaiModel
            ->where('siswa_id', $siswaId)
            ->orderBy('created_at', 'DESC')
            ->findAll(5);

        // Pengumuman
        $pengumumanModel = new PengumumanModel();
        $pengumuman = $pengumumanModel
            ->orderBy('created_at', 'DESC')
            ->findAll(5);

        // Presensi
        $presensiModel = new PresensiModel();

        $presensi = $presensiModel
            ->where('siswa_id', $siswaId)
            ->orderBy('tanggal', 'DESC')
            ->first();

        // Statistik Presensi
        $countHadir = $presensiModel->where(['siswa_id' => $siswaId, 'keterangan' => 'Hadir'])->countAllResults();
        $countIzin  = $presensiModel->where(['siswa_id' => $siswaId, 'keterangan' => 'Izin'])->countAllResults();
        $countSakit = $presensiModel->where(['siswa_id' => $siswaId, 'keterangan' => 'Sakit'])->countAllResults();
        $countAlpa  = $presensiModel->where(['siswa_id' => $siswaId, 'keterangan' => 'Alpa'])->countAllResults();

        return view('siswa/dashboard', [
            'jadwal'         => $jadwalList,
            'nilai_terakhir' => $nilaiTerakhir,
            'pengumuman'     => $pengumuman,
            'presensi'       => $presensi,
            'siswa'          => $siswa,
            'breadcrumb'     => ['Dashboard'],
            'countHadir'     => $countHadir,
            'countIzin'      => $countIzin,
            'countSakit'     => $countSakit,
            'countAlpa'      => $countAlpa,
        ]);
    }
}
