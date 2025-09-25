<?php

namespace App\Controllers;

use PhpOffice\PhpWord\TemplateProcessor;
use App\Models\MitraModel;
use App\Models\KegiatanModel;
use App\Models\MitraKegiatanModel;
use Sqids\Sqids;

class Dokumen extends BaseController
{
    public function generate($templateName, $mitraId, $kegiatanId)
    {
        $templatePath = WRITEPATH . 'templates/' . $templateName;

        if (!file_exists($templatePath)) {
            return redirect()->back()->with('error', 'Template tidak ditemukan.');
        }

        $mitraModel = new MitraModel();
        $kegiatanModel = new KegiatanModel();
        $mitraKegiatanModel = new MitraKegiatanModel();

        $mitraData = $mitraModel->find($mitraId);
        $kegiatan = $kegiatanModel->find($kegiatanId);
        $relasi = $mitraKegiatanModel->where('mitra_id', $mitraId)
            ->where('kegiatan_id', $kegiatanId)
            ->first();

        if (!$mitraData || !$kegiatan || !$relasi) {
            return redirect()->back()->with('error', 'Data mitra, kegiatan, atau relasi tidak ditemukan.');
        }

        // Isi template
        $template = new TemplateProcessor($templatePath);
        // var_dump($mitraData);
        // var_dump($kegiatan);
        // var_dump($relasi);
        // exit;
        $template->setValue('nama_mitra', $mitraData['nama_lengkap'] );
        $template->setValue('nomor', $relasi['nomor'] ?? '0000');
        $template->setValue('tanggal_kegiatan', date('d-m-Y', strtotime($kegiatan['tanggal_pelaksanaan'] ?? 'now')));
        $template->setValue('nama_kegiatan', $kegiatan['nama_kegiatan']);

        // Simpan dokumen hasil
        $safeName = preg_replace('/[^A-Za-z0-9_\-]/', '_', $mitraData['nama_lengkap'] ?? 'default');
        $outputName = 'Kontrak_' . $safeName . '.docx';
        $outputPath = WRITEPATH . 'dokumen/' . $outputName;

        // Buat folder jika belum ada
        if (!is_dir(WRITEPATH . 'dokumen')) {
            mkdir(WRITEPATH . 'dokumen', 0777, true);
        }

        $template->saveAs($outputPath);

        return $this->response->download($outputPath, null);
    }
}
