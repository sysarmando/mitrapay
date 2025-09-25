<?php

namespace App\Models;

use CodeIgniter\Model;

class HonorSatuanModel extends Model
{
    protected $DBGroup = 'mitra';

    protected $table = 'honor_satuan';
    protected $allowedFields = ['kegiatan_id', 'nama_satuan', 'harga_per_satuan'];
    public $timestamps = false;
}
