<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\SiswaModel;
use App\Models\GuruModel;
use App\Models\KelasModel;
use App\Models\MapelModel;

class Dashboard extends BaseController
{
    public function index()
    {
        $siswaModel = new SiswaModel();
        $guruModel  = new GuruModel();
        $kelasModel = new KelasModel();
        $mapelModel = new MapelModel();

        // Total
        $totalSiswa = $siswaModel->countAllResults();
        $totalGuru  = $guruModel->countAllResults();
        $totalKelas = $kelasModel->countAllResults();
        $totalMapel = $mapelModel->countAllResults();

        // Data siswa per kelas untuk grafik
        $kelasData = $kelasModel
            ->select('kelas.nama_kelas, COUNT(siswa.id) as jumlah_siswa')
            ->join('siswa', 'siswa.kelas_id = kelas.id', 'left')
            ->groupBy('kelas.id')
            ->orderBy('kelas.nama_kelas', 'asc')
            ->findAll();

        return view('admin/dashboard', [
            'pageTitle'   => 'Dashboard',
            'breadcrumb'  => ['Dashboard'],
            'totalSiswa'  => $totalSiswa,
            'totalGuru'   => $totalGuru,
            'totalKelas'  => $totalKelas,
            'totalMapel'  => $totalMapel,
            'kelasData'   => $kelasData,
        ]);
    }
}

