<?php

namespace App\Controllers\Guru;

use App\Controllers\BaseController;
use App\Models\KelasModel;
use App\Models\SiswaModel;
use App\Models\MapelModel;
use App\Models\NilaiModel;
use App\Models\GuruModel;

class Nilai extends BaseController
{
    public function index()
    {
        $userId = session('user_id');
        $guru = (new GuruModel())->where('user_id', $userId)->first();

        if (!$guru) {
            return redirect()->to('/logout')->with('errors', ['Data guru tidak ditemukan.']);
        }

        $guruId     = $guru['id'];
        $kelasModel = new KelasModel();
        $mapelModel = new MapelModel();
        $siswaModel = new SiswaModel();
        $nilaiModel = new NilaiModel();

        $kelasList  = $kelasModel->where('guru_id', $guruId)->findAll();
        $mapelList  = $mapelModel->where('guru_id', $guruId)->findAll();

        $kelas_id   = $this->request->getGet('kelas_id');
        $mapel_id   = $this->request->getGet('mapel_id');
        $siswaList  = [];
        $nilaiData  = [];

        if ($kelas_id && $mapel_id) {
            $siswaList = $siswaModel->where('kelas_id', $kelas_id)->findAll();

            $existingNilai = $nilaiModel
                ->where('guru_id', $guruId)
                ->where('kelas_id', $kelas_id)
                ->where('mapel_id', $mapel_id)
                ->findAll();

            foreach ($existingNilai as $n) {
                $nilaiData[$n['siswa_id']] = [
                    'angka' => $n['nilai_angka'],
                    'huruf' => $n['nilai_huruf']
                ];
            }
        }

        return view('guru/nilai/index', [
            'kelasList'  => $kelasList,
            'mapelList'  => $mapelList,
            'siswaList'  => $siswaList,
            'kelas_id'   => $kelas_id,
            'mapel_id'   => $mapel_id,
            'nilaiData'  => $nilaiData,
            'breadcrumb' => ['Nilai', 'Input/Edit']
        ]);
    }

    public function simpan()
    {
        $userId = session('user_id');
        $guru = (new GuruModel())->where('user_id', $userId)->first();

        if (!$guru) {
            return redirect()->to('/logout')->with('errors', ['Data guru tidak ditemukan.']);
        }

        $guruId      = $guru['id'];
        $mapelId     = $this->request->getPost('mapel_id');
        $kelasId     = $this->request->getPost('kelas_id');
        $semester    = $this->request->getPost('semester');
        $tahunAjaran = $this->request->getPost('tahun_ajaran');
        $nilaiInput  = $this->request->getPost('nilai');

        $nilaiModel = new NilaiModel();

        foreach ($nilaiInput as $siswaId => $nilai) {
            $angka = (int) $nilai['angka'];
            $huruf = strtoupper(trim($nilai['huruf']));

            if ($angka < 0 || $angka > 100 || $huruf === '') {
                continue;
            }

            $existing = $nilaiModel->where([
                'siswa_id' => $siswaId,
                'mapel_id' => $mapelId,
                'kelas_id' => $kelasId,
                'guru_id'  => $guruId,
            ])->first();

            if ($existing) {
                $nilaiModel->update($existing['id'], [
                    'nilai_angka' => $angka,
                    'nilai_huruf' => $huruf,
                    'semester'    => $semester,
                    'tahun_ajaran'=> $tahunAjaran
                ]);
            } else {
                $nilaiModel->save([
                    'siswa_id'     => $siswaId,
                    'mapel_id'     => $mapelId,
                    'kelas_id'     => $kelasId,
                    'guru_id'      => $guruId,
                    'nilai_angka'  => $angka,
                    'nilai_huruf'  => $huruf,
                    'semester'     => $semester,
                    'tahun_ajaran' => $tahunAjaran
                ]);
            }
        }

        return redirect()->to(base_url("guru/nilai?kelas_id=$kelasId&mapel_id=$mapelId"))
            ->with('success', 'Data nilai berhasil disimpan.');
    }

    public function rekap()
{
    $userId = session('user_id');
    $guru = (new GuruModel())->where('user_id', $userId)->first();

    if (!$guru) {
        return redirect()->to('/logout')->with('errors', ['Data guru tidak ditemukan.']);
    }

    $guruId     = $guru['id'];
    $kelasModel = new KelasModel();
    $mapelModel = new MapelModel();
    $nilaiModel = new NilaiModel();
    $siswaModel = new SiswaModel();

    $kelasList  = $kelasModel->where('guru_id', $guruId)->findAll();
    $mapelList  = $mapelModel->where('guru_id', $guruId)->findAll();

    $kelas_id   = $this->request->getGet('kelas_id');
    $mapel_id   = $this->request->getGet('mapel_id');

    $dataNilai  = [];
    $siswaMap   = [];
    $mapel      = null;

    if ($kelas_id && $mapel_id) {
        // Ambil semua nilai siswa
        $dataNilai = $nilaiModel
            ->where('guru_id', $guruId)
            ->where('kelas_id', $kelas_id)
            ->where('mapel_id', $mapel_id)
            ->findAll();

        // Ambil data siswa berdasarkan kelas
        $siswaList = $siswaModel->where('kelas_id', $kelas_id)->findAll();
        foreach ($siswaList as $s) {
            $siswaMap[$s['id']] = $s['nama_lengkap'];
        }

        // Ambil data mapel untuk ditampilkan
        $mapel = $mapelModel->find($mapel_id);
    }

    return view('guru/nilai/rekap', [
        'kelasList' => $kelasList,
        'mapelList' => $mapelList,
        'kelas_id'  => $kelas_id,
        'mapel_id'  => $mapel_id,
        'dataNilai' => $dataNilai,
        'siswaMap'  => $siswaMap,
        'mapel'     => $mapel,
    ]);
}

}
