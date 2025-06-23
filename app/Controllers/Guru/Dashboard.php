<?php

namespace App\Controllers\Guru;

use App\Controllers\BaseController;
use App\Models\SiswaModel;
use App\Models\KelasModel;
use App\Models\MapelModel;
use App\Models\JadwalModel;
use App\Models\NilaiModel;
use App\Models\PengumumanModel;
use App\Models\PresensiModel;
use App\Models\GuruModel;

class Dashboard extends BaseController
{
    public function index()
    {
        $userId = session('user_id');
        $guruModel = new GuruModel();
        $guru = $guruModel->where('user_id', $userId)->first();

        if (!$guru) {
            return redirect()->to('/logout')->with('errors', ['Data guru tidak ditemukan.']);
        }

        $guruId = $guru['id'];

        // Kelas yang diampu
        $kelasModel = new KelasModel();
        $kelasList = $kelasModel->where('guru_id', $guruId)->findAll();
        $kelasIds = array_column($kelasList, 'id');

        // Jumlah siswa
        $jumlahSiswa = 0;
        if (!empty($kelasIds)) {
            $siswaModel = new SiswaModel();
            $jumlahSiswa = $siswaModel->whereIn('kelas_id', $kelasIds)->countAllResults();
        }

        // Jadwal Mengajar
        $jadwalModel = new JadwalModel();
        $mapelModel  = new MapelModel();
        $jadwalRaw = $jadwalModel
            ->where('guru_id', $guruId)
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
            ->where('guru_id', $guruId)
            ->orderBy('created_at', 'DESC')
            ->findAll(5);

        // Pengumuman terbaru
        $pengumumanModel = new PengumumanModel();
        $pengumuman = $pengumumanModel
            ->orderBy('created_at', 'DESC')
            ->findAll(5);

        // Presensi Statistik berdasarkan tanggal terakhir
        $presensiModel = new PresensiModel();
        $latestPresensi = $presensiModel
            ->where('guru_id', $guruId)
            ->orderBy('tanggal', 'DESC')
            ->first();

        $statistikPresensi = [
            'Hadir' => 0,
            'Izin'  => 0,
            'Sakit' => 0,
            'Alpa'  => 0
        ];

        $tanggalPresensiTerakhir = null;

        if ($latestPresensi) {
            $tanggalPresensiTerakhir = $latestPresensi['tanggal'];

            $presensiHariIni = $presensiModel
                ->select('keterangan, COUNT(*) as total')
                ->where('guru_id', $guruId)
                ->where('tanggal', $tanggalPresensiTerakhir)
                ->groupBy('keterangan')
                ->findAll();

            foreach ($presensiHariIni as $row) {
                $status = ucfirst(strtolower($row['keterangan']));
                if (isset($statistikPresensi[$status])) {
                    $statistikPresensi[$status] = (int)$row['total'];
                }
            }
        }

        return view('guru/dashboard', [
            'jumlah_siswa'           => $jumlahSiswa,
            'jadwal'                 => $jadwalList,
            'nilai_terakhir'         => $nilaiTerakhir,
            'pengumuman'             => $pengumuman,
            'statistikPresensi'      => $statistikPresensi,
            'tanggalPresensiTerakhir'=> $tanggalPresensiTerakhir
        ]);
    }

    public function search()
{
    $query = $this->request->getGet('q');
    if (!$query) {
        return $this->response->setJSON([]);
    }

    // Contoh pencarian: Siswa, Jadwal, Nilai
    $siswaModel = new \App\Models\SiswaModel();
    $hasilSiswa = $siswaModel->like('nama_lengkap', $query)->findAll(5);

    $result = [];

    foreach ($hasilSiswa as $siswa) {
        $result[] = [
            'label' => $siswa['nama_lengkap'],
            'url' => base_url('guru/chat?siswa=' . $siswa['id']),
            'icon' => 'fa-user-graduate'
        ];
    }

    // Kamu bisa tambah pencarian ke jadwal, nilai, dsb di sini

    return $this->response->setJSON($result);
}

}
