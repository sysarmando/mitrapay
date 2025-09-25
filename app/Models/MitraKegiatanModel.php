<?php

namespace App\Models;

use CodeIgniter\Model;

class MitraKegiatanModel extends Model
{
    protected $DBGroup = 'mitra';
    protected $table = 'mitra_kegiatan';
    protected $primaryKey = 'id';
    protected $allowedFields = ['mitra_id', 'kegiatan_id', 'nomor', 'created_at'];
    public $useTimestamps = true;
}
