<?php

namespace App\Models;

use CodeIgniter\Model;

class TimKerjaModel extends Model
{
    protected $table = 'timkerja';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'tim_kerja'
    ];
}
