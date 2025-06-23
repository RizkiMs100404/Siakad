<?php

namespace App\Controllers\Siswa;

use App\Controllers\BaseController;
use App\Models\PengumumanModel;
use App\Models\SiswaModel;

class Pengumuman extends BaseController
{
    protected $pengumumanModel;

    public function __construct()
    {
        $this->pengumumanModel = new PengumumanModel();
    }

    protected function getSiswa()
    {
        $userId = session('user_id');
        $siswa = (new SiswaModel())->where('user_id', $userId)->first();

        if (!$siswa) {
            return redirect()->to('/logout')->with('errors', ['Data siswa tidak ditemukan.']);
        }

        return $siswa;
    }

    public function index()
    {
        $userId = session('user_id');
        if (!$userId) {
            return redirect()->to(base_url('login'))->with('errors', ['Silakan login dahulu.']);
        }

        $pengumuman = $this->pengumumanModel->orderBy('created_at', 'DESC')->findAll();

        return view('siswa/pengumuman/index', [
            'pengumuman' => $pengumuman,
            'pageTitle'  => 'Pengumuman Sekolah',
            'breadcrumb' => ['Pengumuman']
        ]);
    }
}
