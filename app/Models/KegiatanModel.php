<?php

namespace App\Models;

use CodeIgniter\Model;

class KegiatanModel extends Model
{
    protected $DBGroup          = 'mitra';
    protected $table            = 'kegiatan_statistik';
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['nama_kegiatan', 'tahun', 'pj'];
    protected $useTimestamps    = true;

    public function getPJ($timkerja = null)
    {
        $dbMaster = \Config\Database::connect('default');
        if ($timkerja) {
            return $this->db->table('kegiatan_statistik ks')
                ->select('ks.*,tk.tim_kerja')
                ->join($dbMaster->database . '.timkerja tk', 'tk.id = ks.pj', 'left')
                ->where('pj', $timkerja)
                ->get()
                ->getResultArray();
        } else {
            return $this->db->table('kegiatan_statistik ks')
                ->select('ks.*,tk.tim_kerja')
                ->join($dbMaster->database . '.timkerja tk', 'tk.id = ks.pj', 'left')
                ->get()
                ->getResultArray();
        }
    }
}
