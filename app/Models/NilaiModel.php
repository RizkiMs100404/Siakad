<?php

namespace App\Models;
use CodeIgniter\Model;

class NilaiModel extends Model {
    protected $table = 'nilai';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'siswa_id',
        'mapel_id',
        'guru_id',
        'kelas_id', 
        'nilai_angka',
        'nilai_huruf',
        'semester',
        'tahun_ajaran'
    ];
    protected $useTimestamps = true;
}
