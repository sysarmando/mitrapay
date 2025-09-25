<?php

namespace App\Models;

use CodeIgniter\Model;

class HonorModel extends Model
{
    protected $DBGroup = 'mitra';
    protected $table = 'honor_mitra';
    protected $allowedFields = [
        'kegiatan_id',
        'mitra_id',
        'honor_satuan_id',
        'jumlah_satuan',
        'potongan_pajak',
        'bulan_pembayaran',
        'total_diterima'
    ];
    protected $useTimestamps = true;

    public function totalHonorPerMitraPerBulan($mitra_id, $bulan)
    {
        return $this->selectSum('total_diterima')
            ->where('mitra_id', $mitra_id)
            ->where('bulan_pembayaran', $bulan)
            ->first()['total_diterima'] ?? 0;
    }

    public function getHonorPerMitraPerTahun($mitra_id, $tahun)
    {
        return $this->select('k.nama_kegiatan, honor_satuan.nama_satuan, honor_mitra.jumlah_satuan, honor_mitra.potongan_pajak, honor_mitra.total_diterima, honor_mitra.bulan_pembayaran')
            ->join('kegiatan_statistik k', 'k.id = honor_mitra.kegiatan_id')
            ->join('honor_satuan', 'honor_satuan.id = honor_mitra.honor_satuan_id')
            ->where('honor_mitra.mitra_id', $mitra_id)
            ->where('YEAR(honor_mitra.created_at)', $tahun)
            ->orderBy('bulan_pembayaran')
            ->findAll();
    }

    public function updateHonor($data)
    {
        $this->replace($data);
    }
}
