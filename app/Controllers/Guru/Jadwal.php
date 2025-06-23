<?php

namespace App\Controllers\Guru;

use App\Controllers\BaseController;
use App\Models\JadwalModel;
use App\Models\MapelModel;
use App\Models\KelasModel;
use App\Models\GuruModel;

class Jadwal extends BaseController
{
    public function index()
    {
        $userId = session('user_id'); // ✅ pakai session user_id
        $guruModel = new GuruModel();
        $guru = $guruModel->where('user_id', $userId)->first();

        if (!$guru) {
            return redirect()->to('/logout')->with('errors', ['Data guru tidak ditemukan.']);
        }

        $guruId = $guru['id'];

        $jadwalModel = new JadwalModel();
        $mapelModel  = new MapelModel();
        $kelasModel  = new KelasModel();

        // Ambil semua jadwal berdasarkan guru_id
        $jadwalList = $jadwalModel
            ->where('guru_id', $guruId)
            ->orderBy('hari', 'ASC')
            ->orderBy('jam_mulai', 'ASC')
            ->findAll();

        $jadwal = [];

        foreach ($jadwalList as $item) {
            $mapel = $mapelModel->find($item['mapel_id']);
            $kelas = $kelasModel->find($item['kelas_id']);

            $jadwal[] = [
                'hari'      => ucfirst($item['hari']),
                'jam'       => date('H:i', strtotime($item['jam_mulai'])) . ' - ' . date('H:i', strtotime($item['jam_selesai'])),
                'mapel'     => $mapel['nama_mapel'] ?? '-',
                'mapel_id'  => $item['mapel_id'],
                'kelas'     => $kelas['nama_kelas'] ?? '-',
            ];
        }

        return view('guru/jadwal/index', [
            'jadwal'     => $jadwal,
            'breadcrumb' => ['Jadwal'], // ✅ untuk layout breadcrumb
        ]);
    }

    public function detail($id)
    {
        $userId = session('user_id'); // ✅ pakai session user_id
        $guruModel = new GuruModel();
        $guru = $guruModel->where('user_id', $userId)->first();

        if (!$guru) {
            return redirect()->to('/logout')->with('errors', ['Data guru tidak ditemukan.']);
        }

        $guruId = $guru['id'];
        $mapelModel   = new MapelModel();
        $jadwalModel  = new JadwalModel();
        $kelasModel   = new KelasModel();

        // Cek apakah mapel ini memang dimiliki oleh guru login
        $mapel = $mapelModel->where('id', $id)->where('guru_id', $guruId)->first();
        if (!$mapel) {
            return redirect()->to(base_url('guru/jadwal'))->with('errors', ['Data mapel tidak ditemukan']);
        }

        // Ambil semua jadwal untuk mapel tersebut
        $jadwal = $jadwalModel
            ->where('guru_id', $guruId)
            ->where('mapel_id', $id)
            ->findAll();

        $kelasList = [];
        foreach ($jadwal as $j) {
            $kelas = $kelasModel->find($j['kelas_id']);
            if ($kelas) {
                $kelasList[$kelas['id']] = $kelas['nama_kelas'];
            }
        }

        return view('guru/jadwal/mapel_detail', [
            'mapel'      => $mapel,
            'kelasList'  => array_values($kelasList),
            'breadcrumb' => ['Jadwal', 'Detail Mapel'], // ✅ breadcrumb tambahan
        ]);
    }
}
