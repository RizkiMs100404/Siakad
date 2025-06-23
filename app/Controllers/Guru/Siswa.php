<?php

namespace App\Controllers\Guru;

use App\Controllers\BaseController;
use App\Models\SiswaModel;
use App\Models\KelasModel;
use App\Models\GuruModel;

class Siswa extends BaseController
{
    public function index()
    {
        $userId = session('user_id');
        $guru = (new GuruModel())->where('user_id', $userId)->first();

        if (!$guru) {
            return redirect()->to('/logout')->with('errors', ['Data guru tidak ditemukan.']);
        }

        $guruId        = $guru['id'];
        $kelasModel    = new KelasModel();
        $siswaModel    = new SiswaModel();

        $kelasList     = $kelasModel->where('guru_id', $guruId)->findAll();

        $selectedKelasId = $this->request->getGet('kelas_id');
        $searchKeyword   = $this->request->getGet('search');
        $siswaList       = [];

        if ($selectedKelasId) {
            $siswaModel = $siswaModel->where('kelas_id', $selectedKelasId);

            if ($searchKeyword) {
                $siswaModel = $siswaModel->like('nama_lengkap', $searchKeyword);
            }

            $siswaList = $siswaModel->orderBy('nama_lengkap', 'ASC')->findAll();
        }

        return view('guru/siswa/index', [
            'kelasList'  => $kelasList,
            'kelas_id'   => $selectedKelasId,
            'search'     => $searchKeyword,
            'siswaList'  => $siswaList,
            'breadcrumb' => ['Siswa']
        ]);
    }
}
