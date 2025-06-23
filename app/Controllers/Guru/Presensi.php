<?php

namespace App\Controllers\Guru;

use App\Controllers\BaseController;
use App\Models\KelasModel;
use App\Models\MapelModel;
use App\Models\SiswaModel;
use App\Models\PresensiModel;
use App\Models\GuruModel;

class Presensi extends BaseController
{
    protected function getGuru()
    {
        $userId = session('user_id');
        $guru = (new GuruModel())->where('user_id', $userId)->first();

        if (!$guru) {
            redirect()->to('/logout')->with('errors', ['Data guru tidak ditemukan.'])->send();
            exit;
        }

        return $guru;
    }

    public function index()
    {
        $guru = $this->getGuru();
        $guruId = $guru['id'];

        $mapelModel = new MapelModel();
        $kelasModel = new KelasModel();

        $mapel = $mapelModel->where('guru_id', $guruId)->findAll();
        $kelas = $kelasModel->where('guru_id', $guruId)->findAll();

        return view('guru/presensi/index', [
            'mapel' => $mapel,
            'kelas' => $kelas,
            'breadcrumb' => ['Presensi', 'Input']
        ]);
    }

    public function load()
    {
        $kelas_id = $this->request->getPost('kelas_id');
        $mapel_id = $this->request->getPost('mapel_id');
        $tanggal  = $this->request->getPost('tanggal');

        if (!$kelas_id || !$mapel_id || !$tanggal) {
            return redirect()->back()->with('errors', ['Silakan isi semua field.']);
        }

        $siswaModel = new SiswaModel();
        $siswa = $siswaModel->where('kelas_id', $kelas_id)->orderBy('nama_lengkap')->findAll();

        return view('guru/presensi/input', [
            'siswa'    => $siswa,
            'kelas_id' => $kelas_id,
            'mapel_id' => $mapel_id,
            'tanggal'  => $tanggal,
            'breadcrumb' => ['Presensi', 'Input']
        ]);
    }

    public function simpan()
    {
        $guru = $this->getGuru();
        $guruId = $guru['id'];

        $mapel_id   = $this->request->getPost('mapel_id');
        $kelas_id   = $this->request->getPost('kelas_id');
        $tanggal    = $this->request->getPost('tanggal');
        $keterangan = $this->request->getPost('keterangan');

        if (!$mapel_id || !$kelas_id || !$tanggal || empty($keterangan)) {
            return redirect()->back()->with('errors', ['Data presensi tidak lengkap.']);
        }

        $presensiModel = new PresensiModel();

        foreach ($keterangan as $siswa_id => $ket) {
            $exists = $presensiModel->where([
                'siswa_id' => $siswa_id,
                'mapel_id' => $mapel_id,
                'kelas_id' => $kelas_id,
                'tanggal'  => $tanggal
            ])->first();

            if (!$exists) {
                $presensiModel->save([
                    'siswa_id'   => $siswa_id,
                    'guru_id'    => $guruId,
                    'mapel_id'   => $mapel_id,
                    'kelas_id'   => $kelas_id,
                    'tanggal'    => $tanggal,
                    'keterangan' => $ket
                ]);
            }
        }

        return redirect()->to(base_url('guru/presensi'))->with('success', 'Presensi berhasil disimpan.');
    }

    public function rekap()
{
    $guru = $this->getGuru();
    $guruId = $guru['id'];

    $presensiModel = new PresensiModel();
    $kelasModel = new KelasModel();
    $mapelModel = new MapelModel();

    // Ambil data rekap presensi per tanggal, mapel, dan kelas
    $data = $presensiModel
        ->select('kelas_id, mapel_id, tanggal, COUNT(*) as total')
        ->where('guru_id', $guruId)
        ->groupBy('tanggal, kelas_id, mapel_id')
        ->orderBy('tanggal', 'DESC')
        ->findAll();

    // Ambil seluruh kelas yang diampu
    $kelasList = $kelasModel->where('guru_id', $guruId)->findAll();
    $kelasMap = [];
    foreach ($kelasList as $k) {
        $kelasMap[$k['id']] = $k['nama_kelas'];
    }

    // Ambil seluruh mapel yang diajar
    $mapelList = $mapelModel->where('guru_id', $guruId)->findAll();
    $mapelMap = [];
    foreach ($mapelList as $m) {
        $mapelMap[$m['id']] = $m['nama_mapel'];
    }

    return view('guru/presensi/rekap', [
        'data' => $data,
        'kelasMap' => $kelasMap,
        'mapelMap' => $mapelMap,
        'breadcrumb' => ['Presensi', 'Rekap']
    ]);
}

}
