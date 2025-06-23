<?php

namespace App\Models;
use CodeIgniter\Model;

class PresensiModel extends Model {
    protected $table = 'presensi';
    protected $primaryKey = 'id';
    protected $allowedFields = ['siswa_id', 'guru_id', 'mapel_id', 'kelas_id', 'tanggal', 'keterangan'];
    protected $useTimestamps = true;
}
