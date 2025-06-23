<?php

namespace App\Models;
use CodeIgniter\Model;

class JadwalModel extends Model {
    protected $table = 'jadwal';
     protected $primaryKey = 'id';
    protected $allowedFields = ['kelas_id', 'mapel_id', 'guru_id', 'hari', 'jam_mulai', 'jam_selesai'];
    protected $useTimestamps = true;
}
