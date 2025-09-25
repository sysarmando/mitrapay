<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'user';
    protected $primaryKey = 'user_id';

    protected $allowedFields = [
        'username',
        'password',
        'nama_lengkap',
        'tim_kerja'
    ];

    public function getTimKerja()
    {
        return $this->select('timkerja.*')->orderBy('id', 'desc')->findAll();
    }
}
