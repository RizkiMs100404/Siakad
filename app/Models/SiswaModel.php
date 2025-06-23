<?php

namespace App\Models;
use CodeIgniter\Model;

class SiswaModel extends Model {
    protected $table = 'siswa';
     protected $primaryKey = 'id';
    protected $allowedFields = ['user_id','nama_lengkap', 'nis', 'nisn', 'kelas_id', 'jurusan', 'no_hp', 'alamat'];
    protected $useTimestamps = true;
}
