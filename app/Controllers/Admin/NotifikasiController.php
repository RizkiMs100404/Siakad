<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\SiswaModel;
use App\Models\GuruModel;
use App\Models\KelasModel;
use App\Models\MapelModel;
use App\Models\JadwalModel;
use App\Models\NilaiModel;

class NotifikasiController extends BaseController
{
    public function datamaster()
    {
        $notif = [];
        $now = time();
        $limit = 5; // jumlah data yg diambil per model

        // Siswa
        $siswaModel = new SiswaModel();
        $siswa = $siswaModel->orderBy('created_at', 'DESC')->findAll($limit);
        foreach ($siswa as $s) {
            if (empty($s['created_at']) || ($now - strtotime($s['created_at']) > 86400)) continue;
            $notif[] = [
                'title'      => 'Siswa baru ditambahkan',
                'desc'       => esc($s['nama_lengkap']) . ' (' . esc($s['nis']) . ')',
                'icon'       => 'fa-solid fa-user-graduate',
                'icon_bg'    => 'bg-blue-100',
                'icon_color' => 'text-blue-600',
                'time'       => waktu_lalu($s['created_at']),
                'time_raw'   => $s['created_at']
            ];
        }

        // Guru
        $guruModel = new GuruModel();
        $guru = $guruModel->orderBy('created_at', 'DESC')->findAll($limit);
        foreach ($guru as $g) {
            if (empty($g['created_at']) || ($now - strtotime($g['created_at']) > 86400)) continue;
            $notif[] = [
                'title'      => 'Guru baru ditambahkan',
                'desc'       => esc($g['nama_lengkap']) . ' (' . esc($g['nip']) . ')',
                'icon'       => 'fa-solid fa-user-tie',
                'icon_bg'    => 'bg-lime-100',
                'icon_color' => 'text-lime-600',
                'time'       => waktu_lalu($g['created_at']),
                'time_raw'   => $g['created_at']
            ];
        }

        // Kelas
        $kelasModel = new KelasModel();
        $kelas = $kelasModel->orderBy('created_at', 'DESC')->findAll($limit);
        foreach ($kelas as $k) {
            if (empty($k['created_at']) || ($now - strtotime($k['created_at']) > 86400)) continue;
            $notif[] = [
                'title'      => 'Kelas baru ditambahkan',
                'desc'       => esc($k['nama_kelas']),
                'icon'       => 'fa-solid fa-school',
                'icon_bg'    => 'bg-purple-100',
                'icon_color' => 'text-purple-600',
                'time'       => waktu_lalu($k['created_at']),
                'time_raw'   => $k['created_at']
            ];
        }

        // Mapel
        $mapelModel = new MapelModel();
        $mapel = $mapelModel->orderBy('created_at', 'DESC')->findAll($limit);
        foreach ($mapel as $m) {
            if (empty($m['created_at']) || ($now - strtotime($m['created_at']) > 86400)) continue;
            $notif[] = [
                'title'      => 'Mapel baru ditambahkan',
                'desc'       => esc($m['nama_mapel']),
                'icon'       => 'fa-solid fa-book-open',
                'icon_bg'    => 'bg-indigo-100',
                'icon_color' => 'text-indigo-600',
                'time'       => waktu_lalu($m['created_at']),
                'time_raw'   => $m['created_at']
            ];
        }

        // Jadwal
        $jadwalModel = new JadwalModel();
        $jadwal = $jadwalModel->orderBy('created_at', 'DESC')->findAll($limit);
        foreach ($jadwal as $j) {
            if (empty($j['created_at']) || ($now - strtotime($j['created_at']) > 86400)) continue;
            $notif[] = [
                'title'      => 'Jadwal baru ditambahkan',
                'desc'       => 'Kelas: ' . esc($j['kelas_id']) . ', Mapel: ' . esc($j['mapel_id']) . ', Hari: ' . esc($j['hari']),
                'icon'       => 'fa-solid fa-calendar-days',
                'icon_bg'    => 'bg-pink-100',
                'icon_color' => 'text-pink-500',
                'time'       => waktu_lalu($j['created_at']),
                'time_raw'   => $j['created_at']
            ];
        }

        // Nilai
        $nilaiModel = new NilaiModel();
        $nilai = $nilaiModel->orderBy('created_at', 'DESC')->findAll($limit);
        foreach ($nilai as $n) {
            if (empty($n['created_at']) || ($now - strtotime($n['created_at']) > 86400)) continue;
            $notif[] = [
                'title'      => 'Nilai baru diinputkan',
                'desc'       => 'Siswa: ' . esc($n['siswa_id']) . ', Mapel: ' . esc($n['mapel_id']),
                'icon'       => 'fa-solid fa-marker',
                'icon_bg'    => 'bg-teal-100',
                'icon_color' => 'text-teal-500',
                'time'       => waktu_lalu($n['created_at']),
                'time_raw'   => $n['created_at']
            ];
        }

        // Urutkan terbaru
        usort($notif, function($a, $b) {
            return strtotime($b['time_raw']) - strtotime($a['time_raw']);
        });

        // Batasi 10 notif terbaru
        $notif = array_slice($notif, 0, 10);

        return $this->response->setJSON([
            'unread' => count($notif),
            'data'   => $notif
        ]);
    }
}

// Helper waktu_lalu() (kalau belum ada di helper)
if (!function_exists('waktu_lalu')) {
    function waktu_lalu($datetime) {
        $timestamp = strtotime($datetime);
        $diff = time() - $timestamp;
        if ($diff < 60) return $diff . ' detik lalu';
        if ($diff < 3600) return floor($diff / 60) . ' menit lalu';
        if ($diff < 86400) return floor($diff / 3600) . ' jam lalu';
        if ($diff < 2592000) return floor($diff / 86400) . ' hari lalu';
        return date('d/m/Y', $timestamp);
    }
}
