<?php

namespace App\Models;
use CodeIgniter\Model;

class GuruModel extends Model {
    protected $table = 'guru';
    protected $primaryKey = 'id';
    protected $allowedFields = ['user_id','nama_lengkap', 'nip', 'mapel', 'no_hp', 'alamat'];
    protected $useTimestamps = true;
}
