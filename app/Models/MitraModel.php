<?php

namespace App\Models;

use CodeIgniter\Model;

class MitraModel extends Model
{
    protected $DBGroup          = 'mitra';
    protected $table            = 'mitra';
    protected $primaryKey       = 'id';
    protected $allowedFields    = [
        'nama_lengkap',
        'posisi',
        'alamat',
        'kab',
        'kec',
        'desa',
        'jk',
        'no_hp',
        'sobat_id',
        'email',
        'tahun',
    ];
    protected $useTimestamps    = true;

    public function getWithPosisi($id = null)
    {
        if (!$id) {
            return $this->select('mitra.*, posisi.posisi, master_jk.jenis_kelamin as jk')
                ->join('posisi', 'posisi.id = mitra.posisi', 'left')
                ->join('master_jk', 'master_jk.id = mitra.jk', 'left')
                ->orderBy('nama_lengkap', 'asc')
                ->findAll();
        } else {
            return $this->select('mitra.*, posisi.posisi')
                ->join('posisi', 'posisi.id = mitra.posisi', 'left')
                ->where('mitra.id', $id)
                ->orderBy('nama_lengkap', 'asc')
                ->find();
        }
    }

    public function getMitraLengkap($excludeIds = [])
    {
        $dbMaster = \Config\Database::connect('master');
        $builder = $this->db->table('mitra m')
            ->select('m.*, mk.kecamatan as nama_kec, md.desa as nama_desa, mkab.kab as nama_kab, p.posisi, mjk.jenis_kelamin as jk')
            ->join($dbMaster->database . '.master_kec mk', 'mk.id = CONCAT(81, m.kab, m.kec)', 'left')
            ->join($dbMaster->database . '.master_desa md', 'md.id = CONCAT(81, m.kab, m.kec, m.desa)', 'left')
            ->join($dbMaster->database . '.master_kab mkab', 'mkab.id = m.kab', 'left')
            ->join('posisi p', 'p.id = m.posisi', 'left')
            ->join('master_jk mjk', 'mjk.id = m.jk', 'left');

        if (!empty($excludeIds)) {
            $builder->whereNotIn('m.id', $excludeIds);
        }

        return $builder->get()->getResultArray();
    }
}
