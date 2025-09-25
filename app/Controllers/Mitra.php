<?php

namespace App\Controllers;

use App\Models\MitraModel;
use App\Models\KegiatanModel;
use App\Models\MitraKegiatanModel;
use Sqids\Sqids;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;

// helper('format');

class Mitra extends BaseController
{

    public function index()
    {
        $model = new \App\Models\MitraModel();
        $mitra = $model->getMitraLengkap();
        $sqids = new \Sqids\Sqids();

        // Ubah $mitra by reference
        foreach ($mitra as &$m) {
            $originalId = (int) $m['id'];
            $encodedId = $sqids->encode([$originalId]);
            $m['id'] = $encodedId; // simpan kembali ke array
        }
        unset($m); // bersihkan referensi

        $data = [
            'title' => 'Daftar Mitra Statistik',
            'mitra' => $mitra
        ];
        return view('mitra/mitra_list', $data);
    }

    public function importMitraForm()
    {
        $role = session()->get('role_user');
        $model = new MitraModel();
        if ($role == '99') {
            $data = [
                'title' => 'Import Mitra',
                // 'role_user' => '99'
            ];
            return view('mitra/import_mitra', $data);
        } else {
            // return view('mitra/mitra_list', ['title' => 'Daftar Mitra Statistik', 'mitra' => $model->getMitraLengkap()]);
            return redirect()->to('mitra')->with('warning', "Akun anda tidak bisa mengakses halaman untuk melakukan import mitra.");
        }
    }

    public function importMitra()
    {
        $file = $this->request->getFile('file_excel');
        $tahun = $this->request->getPost('tahun');

        if (!$file->isValid()) {
            return redirect()->back()->with('error', 'File tidak valid.');
        }

        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($file->getTempName());
        $sheet = $spreadsheet->getActiveSheet();
        $rows = $sheet->toArray();

        $model = new \App\Models\MitraModel();
        $success = 0;
        $fail = 0;

        foreach ($rows as $i => $row) {
            if ($i === 0) continue; // Skip header row

            $data = [
                'nama_lengkap' => $row[0] ?? '',
                'posisi'       => $row[1] ?? '',
                'alamat'       => $row[2] ?? '',
                'kab'          => $row[3] ?? '',
                'kec'          => $row[4] ?? '',
                'desa'         => $row[5] ?? '',
                'jk'           => strtoupper($row[6] ?? ''),
                'no_hp'        => $row[7] ?? '',
                'sobat_id'     => $row[8] ?? '',
                'email'        => $row[9] ?? '',
                'tahun'        => $tahun,
            ];

            // Validasi minimal nama dan no hp
            if (trim($data['nama_lengkap']) !== '' && trim($data['no_hp']) !== '') {
                $model->insert($data);
                $success++;
            } else {
                $fail++;
            }
        }

        return redirect()->back()->with('success', "Import selesai. $success berhasil, $fail gagal.");
    }

    public function tambahKegiatanForm()
    {
        $pjModel = new \App\Models\TimKerjaModel();
        $role = session()->get('role_user');
        $my_team_id = session()->get('tim_kerja');

        $pj = $pjModel
            ->whereNotIn('id', [817100, 817199])
            ->orderBy('id', 'asc')
            ->findAll();
        $data['title'] = 'Tambah Kegiatan Statistik';
        $data['pj'] = $pj;
        $data['role'] = $role;
        $data['tim_kerja'] = $my_team_id;
        return view('kegiatan/kegiatan_add', $data);
    }

    public function simpanKegiatan()
    {
        $model = new KegiatanModel();
        $data = $this->request->getPost([
            'nama_kegiatan',
            'tahun',
            'pj'
        ]);
        // var_dump($data);die;

        $model->insert($data);
        return redirect()->to('/mitra/kegiatan')->with('success', 'Kegiatan berhasil ditambahkan.');
    }

    public function kegiatanList()
    {
        $sqids = new \Sqids\Sqids();

        $model = new \App\Models\KegiatanModel();
        $role = session()->get('role_user');
        $timKerja = session()->get('tim_kerja');
        if ($role == '1') {
            $kegiatan = $model->getPJ($timKerja);
            // $data['kegiatan'] = $model->getPJ($timKerja);
        } else {
            $kegiatan = $model->getPJ();
            // $data['kegiatan'] = $model->getPJ();
        }
        // Ubah $mitra by reference
        foreach ($kegiatan as &$m) {
            $originalId = (int) $m['id'];
            $encodedId = $sqids->encode([$originalId]);
            $m['id'] = $encodedId; // simpan kembali ke array
        }
        unset($m);
        $data['kegiatan'] = $kegiatan;
        $data['title'] = 'Daftar Kegiatan Statistik';
        $data['role'] = $role;
        return view('kegiatan/kegiatan_list', $data);
    }

    public function hapusKegiatan($id)
    {
        $model = new \App\Models\KegiatanModel();
        $sqids = new \Sqids\Sqids();
        $decoded = $sqids->decode($id);
        if (empty($decoded)) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Mitra tidak ditemukan');
        }

        $idd = $decoded[0]; // ambil ID asli
        if (session()->get('role_user') == '99')
            $model->delete($idd);
        return redirect()->to('/mitra/kegiatan')->with('success', 'Kegiatan berhasil dihapus.');
    }

    public function formPenugasan($kegiatan_id)
    {
        $kegiatanModel = new \App\Models\KegiatanModel();
        $mitraModel = new \App\Models\MitraModel();
        $penugasanModel = new \App\Models\MitraKegiatanModel();
        $sqids = new \Sqids\Sqids();
        $decoded = $sqids->decode($kegiatan_id);
        if (empty($decoded)) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Mitra tidak ditemukan');
        }

        $id = $decoded[0]; // ambil ID asli

        // Ambil ID mitra yang sudah ditugaskan ke kegiatan ini
        $db = db_connect('mitra');
        $assigned = $db->table('mitra_kegiatan')
            ->select('mitra_id')
            ->where('kegiatan_id', $id)
            ->get()
            ->getResultArray();
        $assignedIds = array_column($assigned, 'mitra_id');

        $data['kegiatan'] = $kegiatanModel->find($id);
        $data['mitra'] = $mitraModel->getMitraLengkap($assignedIds); // Hanya mitra yang belum ditugaskan
        $data['title'] = 'Assign Mitra';

        return view('mitra/assign_mitra', $data);
    }


    public function simpanPenugasan()
    {
        $kegiatan_id = $this->request->getPost('kegiatan_id');
        $mitra_ids = $this->request->getPost('mitra_ids');

        $model = db_connect('mitra');
        foreach ($mitra_ids as $id) {
            $model->table('mitra_kegiatan')->insert([
                'mitra_id' => $id,
                'kegiatan_id' => $kegiatan_id
            ]);
        }

        return redirect()->to('/mitra/kegiatan')->with('success', 'Penugasan mitra berhasil disimpan.');
    }

    public function hapusPenugasan($mitra_id, $kegiatan_id)
    {
        $model = new MitraKegiatanModel();
        $sqids = new \Sqids\Sqids();
        $decodedK = $sqids->decode($kegiatan_id);
        $decodedM = $sqids->decode($mitra_id);
        if (empty($decodedK)) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Kegiatan atau Mitra tidak ditemukan');
        }
        if (empty($decodedM)) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Kegiatan atau Mitra tidak ditemukan');
        }

        $idK = $decodedK[0]; // ambil ID asli
        $idM = $decodedM[0]; // ambil ID asli
        $model->where('mitra_id', $idM)
            ->where('kegiatan_id', $idK)
            ->delete();

        return redirect()->back()->with('success', 'Penugasan berhasil dihapus.');
    }


    public function inputHonor($kegiatan_id)
    {
        $kegiatanModel = new \App\Models\KegiatanModel();
        $mitraModel = new \App\Models\MitraModel();
        $satuanModel = new \App\Models\HonorSatuanModel();
        $mkModel = new MitraKegiatanModel();
        $sqids = new \Sqids\Sqids();
        $decoded = $sqids->decode($kegiatan_id);
        if (empty($decoded)) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Kegiatan tidak ditemukan');
        }

        $id = $decoded[0]; // ambil ID asli
        $satuan = $satuanModel->where('kegiatan_id', $id)->findAll();
        $bulanList = [
            '01' => 'Januari',
            '02' => 'Februari',
            '03' => 'Maret',
            '04' => 'April',
            '05' => 'Mei',
            '06' => 'Juni',
            '07' => 'Juli',
            '08' => 'Agustus',
            '09' => 'September',
            '10' => 'Oktober',
            '11' => 'November',
            '12' => 'Desember'
        ];
        $data['satuan'] = $satuan;
        $data['perlu_satuan'] = empty($satuan); // True jika belum ada
        $data['bulanList'] = $bulanList;
        $data['kegiatan'] = $kegiatanModel->find($id);
        // $data['satuan'] = $satuanModel->where('kegiatan_id', $kegiatan_id)->findAll();
        $data['title'] = 'Input Honor';
        $data['mitra'] = db_connect('mitra')
            ->table('mitra_kegiatan')
            ->select('mitra_kegiatan.*, mitra.nama_lengkap,
        honor_mitra.id as honor_mitra_id,
        honor_mitra.honor_satuan_id, honor_mitra.jumlah_satuan,
        honor_mitra.bulan_pembayaran, honor_mitra.potongan_pajak,
        hs.harga_per_satuan')
            ->join('mitra', 'mitra.id = mitra_kegiatan.mitra_id')
            ->join('honor_mitra', 'honor_mitra.mitra_id = mitra_kegiatan.mitra_id AND honor_mitra.kegiatan_id = mitra_kegiatan.kegiatan_id', 'inner')
            ->join('honor_satuan hs', 'hs.id = honor_mitra.honor_satuan_id', 'inner')
            ->where('mitra_kegiatan.kegiatan_id', $id)
            ->get()
            ->getResultArray();

        $data['mitra_select'] = $mkModel->select('mitra_kegiatan.*,m.nama_lengkap')->where('kegiatan_id', $id)->join('mitra m', 'm.id = mitra_kegiatan.mitra_id')->findAll();
        // var_dump($data['mitra']);
        // var_dump($data['mitra_select']);die;

        return view('mitra/input_honor', $data);
    }

    public function inputSatuan($kegiatan_id)
    {
        $db = \Config\Database::connect('mitra');
        $sqids = new \Sqids\Sqids();
        $decoded = $sqids->decode($kegiatan_id);
        if (empty($decoded)) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Mitra tidak ditemukan');
        }

        $id = $decoded[0]; // ambil ID asli

        $kegiatan = $db->table('kegiatan_statistik')->where('id', $id)->get()->getRowArray();


        if (!$kegiatan) {
            return redirect()->back()->with('error', 'Kegiatan tidak ditemukan.');
        }

        return view('kegiatan/input_satuan', [
            'kegiatan' => $kegiatan,
            'title' => 'Input Satuan'
        ]);
    }

    public function simpanSatuan()
    {
        $db = \Config\Database::connect('mitra');
        $sqids = new \Sqids\Sqids();
        $originalId = (int) $this->request->getPost('kegiatan_id');
        $encodedId = $sqids->encode([$originalId]);
        $nama_satuan = $this->request->getPost('nama_satuan');
        $harga_per_satuan = $this->request->getPost('harga_per_satuan');

        if (!$nama_satuan || !$harga_per_satuan || count($nama_satuan) != count($harga_per_satuan)) {
            return redirect()->back()->with('error', 'Input tidak valid.');
        }

        foreach ($nama_satuan as $i => $nama) {
            if (trim($nama) == '' || !is_numeric($harga_per_satuan[$i])) continue;
            $db->table('honor_satuan')->insert([
                'kegiatan_id' => $sqids->decode($encodedId),
                'nama_satuan' => $nama,
                'harga_per_satuan' => $harga_per_satuan[$i],
                'created_at' => date('Y-m-d H:i:s'),
            ]);
        }

        return redirect()->to('mitra/input-satuan/' . $encodedId)->with('success', 'Data satuan honor berhasil disimpan.');
    }

    public function simpanHonor()
    {
        $honorModel = new \App\Models\HonorModel();
        $mitraModel = new \App\Models\MitraModel();

        $kegiatan_id = $this->request->getPost('kegiatan_id');
        $mitra_ids = $this->request->getPost('mitra_id');
        $honor_ids = $this->request->getPost('honor_mitra_id');
        $satuan_ids = $this->request->getPost('honor_satuan_id');
        $jumlah = $this->request->getPost('jumlah_satuan');
        $pajak = $this->request->getPost('potongan_pajak');
        $harga = $this->request->getPost('harga_per_satuan');
        $bulan = $this->request->getPost('bulan_pembayaran');
        $mk_ids = $this->request->getPost('mk_id');

        // Max Honor Sebulan
        $MAX_HONOR_BULAN = 4300000;
        $mitraList  = $mitraModel->select('id, nama_lengkap')->findAll();
        $mitraNames = array_column($mitraList, 'nama_lengkap', 'id');

        $bulanList = [
            '01' => 'Januari',
            '02' => 'Februari',
            '03' => 'Maret',
            '04' => 'April',
            '05' => 'Mei',
            '06' => 'Juni',
            '07' => 'Juli',
            '08' => 'Agustus',
            '09' => 'September',
            '10' => 'Oktober',
            '11' => 'November',
            '12' => 'Desember'
        ];

        $peringatan = [];


        foreach ($mitra_ids as $i => $mitra_id) {
            $total_diterima = $harga[$i] * $jumlah[$i];
            $data = [
                'id' => $honor_ids[$i],
                'kegiatan_id' => $kegiatan_id,
                'mitra_id' => $mitra_id,
                'mk_id' => $mk_ids[$i],
                'honor_satuan_id' => $satuan_ids[$i],
                'jumlah_satuan' => $jumlah[$i],
                'potongan_pajak' => $pajak[$i],
                // 'harga_per_satuan' => $harga[$i],
                'bulan_pembayaran' => $bulan[$i],
                'total_diterima' => $total_diterima,
            ];

            $bulan_terpilih = str_pad($bulan[$i], 2, '0', STR_PAD_LEFT);
            // Hitung total sebelumnya
            $total_sebelumnya = $honorModel
                ->where('mitra_id', $mitra_id)
                ->where('bulan_pembayaran', $bulan_terpilih)
                ->selectSum('total_diterima')
                ->first()['total_diterima'] ?? 0;

            $honorModel->updateHonor($data);
        }

        return redirect()->to('mitra/kegiatan')->with('success', 'Data honor berhasil diperbarui.');
    }

    public function laporanHonor($mitra_id = null)
    {
        $db = \Config\Database::connect('mitra');
        if (!$mitra_id) {
            $data = $db->table('mitra m')
                ->select("m.id AS mitra_id, m.nama_lengkap, hm.bulan_pembayaran,
        SUM((hm.jumlah_satuan * hs.harga_per_satuan) - hm.potongan_pajak) AS total")
                ->join('honor_mitra hm', 'hm.mitra_id = m.id', 'LEFT')
                ->join('honor_satuan hs', 'hs.id = hm.honor_satuan_id', 'LEFT')
                ->groupBy('m.id, hm.bulan_pembayaran')
                ->orderBy('m.nama_lengkap')
                ->get()->getResultArray();

            $laporan = [];

            foreach ($data as $row) {
                $id = $row['mitra_id'];
                $bulan = (int) ($row['bulan_pembayaran'] ?? 0); // bisa null
                if (!isset($laporan[$id])) {
                    $laporan[$id] = [
                        'nama_lengkap' => $row['nama_lengkap'],
                        'total_per_bulan' => array_fill(1, 12, 0)
                    ];
                }
                if ($bulan >= 1 && $bulan <= 12) {
                    $laporan[$id]['total_per_bulan'][$bulan] = (float) $row['total'];
                }
            }

            return view('mitra/laporan_honor_bulanan', [
                'laporan' => $laporan,
                'title' => 'Laporan Honor Bulanan'
            ]);
        } else {
            $sqids = new \Sqids\Sqids();
            $decoded = $sqids->decode($mitra_id);
            if (empty($decoded)) {
                throw new \CodeIgniter\Exceptions\PageNotFoundException('Mitra tidak ditemukan');
            }

            $id = $decoded[0]; // ambil ID asli
            $tahun = $this->request->getGet('tahun') ?? date('Y');

            $honorModel = new \App\Models\HonorModel();
            $mitraModel = new \App\Models\MitraModel();

            $honorList = $honorModel->getHonorPerMitraPerTahun($id, $tahun);
            $mitra = $mitraModel->find($id);

            return view('mitra/laporan_honor_mitra', [
                'honorList' => $honorList,
                'mitra' => $mitra,
                'tahun' => $tahun,
                'title' => 'Laporan Honor ' . $mitra['nama_lengkap']
            ]);
        }
    }

    public function daftarMitraKegiatan($kegiatan_id)
    {
        $db = \Config\Database::connect('mitra');
        $sqids = new \Sqids\Sqids();
        $decoded = $sqids->decode($kegiatan_id);
        if (empty($decoded)) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Mitra tidak ditemukan');
        }
        $id = $decoded[0]; // ambil ID asli

        $kegiatan = $db->table('kegiatan_statistik')->where('id', $id)->get()->getRowArray();

        $mitra = $db->table('mitra_kegiatan mk')
            ->select('m.nama_lengkap,jk.jenis_kelamin as jk, m.no_hp, m.email, m.alamat,m.id')
            ->join('mitra m', 'm.id = mk.mitra_id')
            ->join('master_jk jk', 'jk.id = m.jk')
            ->where('mk.kegiatan_id', $id)
            ->get()->getResultArray();

        // Ubah $mitra by reference
        foreach ($mitra as &$m) {
            $originalId = (int) $m['id'];
            $encodedId = $sqids->encode([$originalId]);
            $m['id'] = $encodedId; // simpan kembali ke array
        }
        unset($m);

        if (!$kegiatan) {
            return redirect()->back()->with('warning', 'Kegiatan tidak ditemukan.');
        }
        $originalId = (int) $kegiatan['id'];
        $encodedId = $sqids->encode([$originalId]);
        $kegiatan['id'] = $encodedId; // simpan kembali ke array

        // unset($m);
        return view('mitra/daftar_mitra_kegiatan', [
            'title' => 'Daftar Mitra - ' . $kegiatan['nama_kegiatan'],
            'kegiatan' => $kegiatan,
            'mitra' => $mitra
        ]);
    }

    // public function exportHonor($kegiatan_id)
    // {
    //     $sqids = new \Sqids\Sqids();
    //     $decoded = $sqids->decode($kegiatan_id);
    //     if (empty($decoded)) {
    //         throw new \CodeIgniter\Exceptions\PageNotFoundException('Kegiatan tidak ditemukan');
    //     }
    //     $id = $decoded[0];

    //     // Ambil data honor dari DB
    //     $db = db_connect('mitra');
    //     $honor = $db->table('honor_mitra')
    //         ->select('m.nama_lengkap, hs.nama_satuan, honor_mitra.jumlah_satuan, hs.harga_per_satuan,
    //              honor_mitra.total_diterima, honor_mitra.potongan_pajak, honor_mitra.bulan_pembayaran')
    //         ->join('mitra m', 'm.id = honor_mitra.mitra_id')
    //         ->join('honor_satuan hs', 'hs.id = honor_mitra.honor_satuan_id')
    //         ->where('honor_mitra.kegiatan_id', $id)
    //         ->get()
    //         ->getResultArray();

    //     // Ambil nama kegiatan (opsional)
    //     $kegiatanModel = new \App\Models\KegiatanModel();
    //     $nama_kegiatan = $kegiatanModel->find($id)['nama_kegiatan'] ?? 'Kegiatan';

    //     // Buat spreadsheet
    //     $spreadsheet = new Spreadsheet();
    //     $sheet = $spreadsheet->getActiveSheet();

    //     // Judul
    //     $sheet->setCellValue('A1', 'Daftar Penerima Honor');
    //     $sheet->setCellValue('A2', 'Kegiatan: ' . $nama_kegiatan);
    //     $sheet->mergeCells('A1:I1');
    //     $sheet->mergeCells('A2:I2');

    //     // Header kolom
    //     $header = ['No', 'Nama Mitra', 'Jenis Satuan', 'Jumlah', 'Harga/Satuan', 'Total', 'Pajak', 'Diterima Bersih', 'Bulan'];
    //     $sheet->fromArray($header, null, 'A4');

    //     // Isi data
    //     $row = 5;
    //     foreach ($honor as $i => $h) {
    //         $sheet->setCellValue("A{$row}", $i + 1);
    //         $sheet->setCellValue("B{$row}", $h['nama_lengkap']);
    //         $sheet->setCellValue("C{$row}", $h['nama_satuan']);
    //         $sheet->setCellValue("D{$row}", $h['jumlah_satuan']);
    //         $sheet->setCellValue("E{$row}", $h['harga_per_satuan']);
    //         $sheet->setCellValue("F{$row}", $h['jumlah_satuan'] * $h['harga_per_satuan']);
    //         $sheet->setCellValue("G{$row}", $h['potongan_pajak']);
    //         $sheet->setCellValue("H{$row}", $h['total_diterima']);
    //         $sheet->setCellValue("I{$row}", date('F Y', strtotime("2025-" . $h['bulan_pembayaran'] . "-01"))); // format bulan
    //         $row++;
    //     }

    //     // Format kolom uang (E, F, G, H)
    //     foreach (['E', 'F', 'G', 'H'] as $col) {
    //         for ($r = 5; $r < $row; $r++) {
    //             $sheet->getStyle("{$col}{$r}")->getNumberFormat()
    //                 ->setFormatCode('#,##0');
    //         }
    //     }

    //     // Download file
    //     $filename = 'Honor_' . str_replace(' ', '_', $nama_kegiatan) . '_' . date('Ymd_His') . '.xlsx';
    //     header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    //     header("Content-Disposition: attachment;filename=\"$filename\"");
    //     header('Cache-Control: max-age=0');
    //     $writer = new Xlsx($spreadsheet);
    //     $writer->save('php://output');
    //     exit;
    // }

    // public function exportHonorExcel($kegiatan_id)
    // {
    //     $sqids = new \Sqids\Sqids();
    //     $decoded = $sqids->decode($kegiatan_id);
    //     if (empty($decoded)) {
    //         throw new \CodeIgniter\Exceptions\PageNotFoundException('Kegiatan tidak ditemukan');
    //     }
    //     $id = $decoded[0];

    //     $kegiatanModel = new \App\Models\KegiatanModel();
    //     $kegiatan = $kegiatanModel->find($id);

    //     $db = db_connect('mitra');
    //     $honor = $db->table('honor_mitra')
    //         ->select('m.nama_lengkap, hs.nama_satuan, honor_mitra.jumlah_satuan, hs.harga_per_satuan,
    //              honor_mitra.total_diterima, honor_mitra.potongan_pajak, honor_mitra.bulan_pembayaran')
    //         ->join('mitra m', 'm.id = honor_mitra.mitra_id')
    //         ->join('honor_satuan hs', 'hs.id = honor_mitra.honor_satuan_id')
    //         ->where('honor_mitra.kegiatan_id', $id)
    //         ->get()
    //         ->getResultArray();
    //     // var_dump($honor);
    //     // var_dump($kegiatan);
    //     // die;

    //     $templatePath = WRITEPATH . 'templates/spj-honor.xlsx'; // pastikan ada
    //     $spreadsheet = IOFactory::load($templatePath);
    //     $sheet = $spreadsheet->getActiveSheet();

    //     // Replace global placeholders
    //     $highestRow = $sheet->getHighestRow();
    //     $highestColumn = $sheet->getHighestColumn();
    //     $highestColumnIndex = Coordinate::columnIndexFromString($highestColumn);

    //     for ($row = 1; $row <= $highestRow; $row++) {
    //         for ($col = 1; $col <= $highestColumnIndex; $col++) {
    //             $cellAddress = Coordinate::stringFromColumnIndex($col) . $row;
    //             $cell = $sheet->getCell($cellAddress);
    //             $val = $cell->getValue();
    //             if ($val === null) continue;

    //             if (strpos($val, '$kegiatan') !== false) {
    //                 $cell->setValue(str_replace('$kegiatan', $kegiatan['nama_kegiatan'], $val));
    //             }

    //             if (strpos($val, '$bulan') !== false) {
    //                 $bulanText = bulanIndo($honor[0]['bulan_pembayaran'] ?? '01');
    //                 $cell->setValue(str_replace('$bulan', $bulanText, $val));
    //             }
    //         }
    //     }


    //     // Cari baris awal data (baris yang ada $i)
    //     $startRow = null;
    //     foreach ($sheet->getRowIterator() as $row) {
    //         foreach ($row->getCellIterator() as $cell) {
    //             if (strpos($cell->getValue(), '$i') !== false) {
    //                 $startRow = $cell->getRow();
    //                 break 2;
    //             }
    //         }
    //     }

    //     if (!$startRow) {
    //         throw new \Exception("Tidak ditemukan baris template yang berisi \$i");
    //     }

    //     $currentRow = $startRow;
    //     $totalDiterima = 0;

    //     foreach ($honor as $i => $h) {
    //         $rowVals = [
    //             '$urutan' => $i + 1,
    //             '$nama' => $h['nama_lengkap'],
    //             '$sobatid' => '8171xxx',
    //             '$honorsatuan' => $h['harga_per_satuan'],
    //             '$jumlah' => $h['jumlah_satuan'],
    //             '$bruto' => $h['jumlah_satuan'] * $h['harga_per_satuan'],
    //             '$pajak' => $h['potongan_pajak'],
    //             '$diterima' => $h['total_diterima']
    //         ];
    //         $totalDiterima += $h['total_diterima'];

    //         // Ganti semua placeholder di baris aktif
    //         for ($col = 1; $col <= $highestColumnIndex; $col++) {
    //             $colLetter = Coordinate::stringFromColumnIndex($col);
    //             $cellAddr = "{$colLetter}{$currentRow}";
    //             $cell = $sheet->getCell($cellAddr);
    //             $val = $cell->getValue();

    //             if ($val === null) continue;

    //             foreach ($rowVals as $key => $replacement) {
    //                 if (strpos($val, $key) !== false) {
    //                     $val = str_replace($key, $replacement, $val);
    //                 }
    //             }

    //             $cell->setValue($val);
    //         }

    //         // Jika masih ada data berikutnya, baru duplikat baris
    //         if ($i < count($honor) - 1) {
    //             $sheet->insertNewRowBefore($currentRow + 1, 1);

    //             for ($col = 1; $col <= $highestColumnIndex; $col++) {
    //                 $colLetter = Coordinate::stringFromColumnIndex($col);
    //                 $srcCell = $sheet->getCell($colLetter . $currentRow);
    //                 $newCell = $sheet->getCell($colLetter . ($currentRow + 1));
    //                 $newCell->setValue($srcCell->getValue());
    //                 $sheet->duplicateStyle($srcCell->getStyle(), $newCell->getCoordinate());
    //             }

    //             $currentRow++;
    //         }
    //     }

    //     // die;

    //     // Replace total
    //     foreach ($sheet->getRowIterator() as $row) {
    //         foreach ($row->getCellIterator() as $cell) {
    //             $val = $cell->getValue();
    //             if (strpos($val, '$totaldit') !== false) {
    //                 $cell->setValue(str_replace('$totaldit', $totalDiterima, $val));
    //             }
    //         }
    //     }


    //     // Output
    //     $filename = 'SPJ_Honor_' . str_replace(' ', '_', $kegiatan['nama_kegiatan']) . '_' . date('YmdHis') . '.xlsx';
    //     header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    //     header("Content-Disposition: attachment;filename=\"$filename\"");
    //     header('Cache-Control: max-age=0');

    //     $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
    //     $writer->save('php://output');
    //     exit;
    // }
    public function exportHonorExcel($kegiatan_id)
    {
        $sqids = new \Sqids\Sqids();
        $decoded = $sqids->decode($kegiatan_id);
        if (empty($decoded)) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Kegiatan tidak ditemukan');
        }
        $id = $decoded[0];

        $kegiatanModel = new \App\Models\KegiatanModel();
        $kegiatan = $kegiatanModel->find($id);
        $tanggal = $this->request->getGet('tanggal');
        $namaDaftar = $this->request->getGet('nama_daftar');
        $nip = $this->request->getGet('nip');
        $tanggalFormatted = tanggalIndo($tanggal);

        $db = db_connect('mitra');
        $honor = $db->table('honor_mitra')
            ->select('m.nama_lengkap, hs.nama_satuan, honor_mitra.jumlah_satuan, hs.harga_per_satuan,
             honor_mitra.total_diterima, honor_mitra.potongan_pajak, honor_mitra.bulan_pembayaran,m.sobat_id')
            ->join('mitra m', 'm.id = honor_mitra.mitra_id')
            ->join('honor_satuan hs', 'hs.id = honor_mitra.honor_satuan_id')
            ->where('honor_mitra.kegiatan_id', $id)
            ->get()
            ->getResultArray();

        if (empty($honor)) {
            throw new \Exception("Tidak ada data honor untuk kegiatan ini.");
        }

        $templatePath = WRITEPATH . 'templates/spj-honor.xlsx';
        $spreadsheet = IOFactory::load($templatePath);
        $sheet = $spreadsheet->getActiveSheet();

        // Replace global placeholders
        $highestRow = $sheet->getHighestRow();
        $highestColumn = $sheet->getHighestColumn();
        $highestColumnIndex = Coordinate::columnIndexFromString($highestColumn);

        for ($row = 1; $row <= $highestRow; $row++) {
            for ($col = 1; $col <= $highestColumnIndex; $col++) {
                $cellAddress = Coordinate::stringFromColumnIndex($col) . $row;
                $cell = $sheet->getCell($cellAddress);
                $val = $cell->getValue();
                if ($val === null) continue;

                if (strpos($val, '$kegiatan') !== false) {
                    $cell->setValue(str_replace('$kegiatan', $kegiatan['nama_kegiatan'], $val));
                }

                if (strpos($val, '$bulan') !== false) {
                    $bulanText = bulanIndo($honor[0]['bulan_pembayaran'] ?? '01');
                    $cell->setValue(str_replace('$bulan', $bulanText, $val));
                }
            }
        }

        // Cari baris template ($i)
        $startRow = null;
        foreach ($sheet->getRowIterator() as $row) {
            foreach ($row->getCellIterator() as $cell) {
                if (strpos($cell->getValue(), '$i') !== false || strpos($cell->getValue(), '$urutan') !== false) {
                    $startRow = $cell->getRow();
                    break 2;
                }
            }
        }

        if (!$startRow) {
            throw new \Exception("Tidak ditemukan baris template yang berisi \$i atau \$urutan");
        }

        // Simpan isi & style baris template asli
        $templateRowValues = [];
        $templateRowStyles = [];

        for ($col = 1; $col <= $highestColumnIndex; $col++) {
            $colLetter = Coordinate::stringFromColumnIndex($col);
            $cellAddr = "{$colLetter}{$startRow}";
            $cell = $sheet->getCell($cellAddr);
            $templateRowValues[$colLetter] = $cell->getValue();
            $templateRowStyles[$colLetter] = $cell->getStyle();
        }

        $currentRow = $startRow;
        $totalDiterima = 0;

        // 1. Gandakan baris template sesuai jumlah data
        for ($i = 1; $i < count($honor); $i++) {
            $sheet->insertNewRowBefore($startRow + $i, 1);
            for ($col = 1; $col <= $highestColumnIndex; $col++) {
                $colLetter = Coordinate::stringFromColumnIndex($col);
                $sourceCell = $sheet->getCell("{$colLetter}{$startRow}");
                $targetCell = $sheet->getCell("{$colLetter}" . ($startRow + $i));
                $targetCell->setValue($sourceCell->getValue());
                $sheet->duplicateStyle($sourceCell->getStyle(), $targetCell->getCoordinate());
            }
        }

        // 2. Iterasi dan isi placeholder
        $totalDiterima = 0;
        foreach ($honor as $i => $h) {
            $currentRow = $startRow + $i;

            $rowVals = [
                '$i' => $i + 1,
                '$urutan' => $i + 1,
                '$nama' => $h['nama_lengkap'],
                '$sobatid' => $h['sobat_id'],
                '$honorsatuan' => (int) $h['harga_per_satuan'],
                '$jumlah' => (int) $h['jumlah_satuan'],
                '$bruto' => (int) ($h['jumlah_satuan'] * $h['harga_per_satuan']),
                '$pajak' => (int) $h['potongan_pajak'],
                '$diterima' => (int) $h['total_diterima']
            ];

            $totalDiterima += $h['total_diterima'];

            for ($col = 1; $col <= $highestColumnIndex; $col++) {
                $colLetter = Coordinate::stringFromColumnIndex($col);
                $cellAddr = "{$colLetter}{$currentRow}";
                $cell = $sheet->getCell($cellAddr);
                $val = $cell->getValue();

                if ($val === null) continue;

                foreach ($rowVals as $key => $replacement) {
                    if (strpos($val, $key) !== false) {
                        $val = str_replace($key, $replacement, $val);
                    }
                }

                // Deteksi apakah cell berisi sobat_id (untuk selalu dianggap teks)
                $isSobatId = isset($templateRowValues[$colLetter]) && strpos($templateRowValues[$colLetter], '$sobatid') !== false;
                if ($isSobatId) {
                    $sheet->setCellValueExplicit($cellAddr, $val, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                } elseif (is_numeric($val) && !preg_match('/^\$[a-z]+$/i', $val)) {
                    $sheet->setCellValueExplicit($cellAddr, $val, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC);
                } else {
                    $sheet->setCellValueExplicit($cellAddr, $val, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                }
            }
        }


        foreach ($sheet->getRowIterator() as $row) {
            foreach ($row->getCellIterator() as $cell) {
                $val = $cell->getValue();

                if (strpos($val, '$totaldit') !== false) {
                    $cell->setValue(str_replace('$totaldit', $totalDiterima, $val));
                }

                if (strpos($val, '$terbilang') !== false) {
                    $cell->setValue(str_replace('$terbilang', trim(terbilang($totalDiterima)) . ' Rupiah', $val));
                }

                if (strpos($val, '$tanggal') !== false) {
                    $cell->setValue(str_replace('$tanggal', $tanggalFormatted, $val));
                }

                if (strpos($val, '$nama_daftar') !== false) {
                    $cell->setValue(str_replace('$nama_daftar', $namaDaftar, $val));
                }

                if (strpos($val, '$nip') !== false) {
                    $cell->setValue(str_replace('$nip', $nip, $val));
                }
            }
        }

        // Output
        $filename = 'SPJ_Honor_' . str_replace(' ', '_', $kegiatan['nama_kegiatan']) . '_' . date('YmdHis') . '.xlsx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment;filename=\"$filename\"");
        header('Cache-Control: max-age=0');

        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output');
        exit;
    }

    // public function exportHonorExcel($kegiatan_id)
    // {
    //     $sqids = new \Sqids\Sqids();
    //     $decoded = $sqids->decode($kegiatan_id);
    //     if (empty($decoded)) {
    //         throw new \CodeIgniter\Exceptions\PageNotFoundException('Kegiatan tidak ditemukan');
    //     }
    //     $id = $decoded[0];

    //     $kegiatanModel = new \App\Models\KegiatanModel();
    //     $kegiatan = $kegiatanModel->find($id);

    //     $tanggal = $this->request->getGet('tanggal');
    //     $namaDaftar = $this->request->getGet('nama_daftar');
    //     $nip = $this->request->getGet('nip');
    //     $tanggalFormatted = tanggalIndo($tanggal);

    //     $db = db_connect('mitra');
    //     $honor = $db->table('honor_mitra')
    //         ->select('m.nama_lengkap, hs.nama_satuan, honor_mitra.jumlah_satuan, hs.harga_per_satuan,
    //         honor_mitra.total_diterima, honor_mitra.potongan_pajak, honor_mitra.bulan_pembayaran')
    //         ->join('mitra m', 'm.id = honor_mitra.mitra_id')
    //         ->join('honor_satuan hs', 'hs.id = honor_mitra.honor_satuan_id')
    //         ->where('honor_mitra.kegiatan_id', $id)
    //         ->get()
    //         ->getResultArray();

    //     if (empty($honor)) {
    //         throw new \Exception("Tidak ada data honor untuk kegiatan ini.");
    //     }

    //     $templatePath = WRITEPATH . 'templates/spj-honor.xlsx';
    //     $spreadsheet = IOFactory::load($templatePath);
    //     $sheet = $spreadsheet->getActiveSheet();

    //     // Ganti placeholder umum
    //     $sheet->setCellValue('F2', $kegiatan['nama_kegiatan']); // $kegiatan
    //     $sheet->setCellValue('C11', bulanIndo($honor[0]['bulan_pembayaran'] ?? '01')); // $bulan

    //     $startRow = 15; // posisi $i

    //     // Simpan template value dan style dari baris 15
    //     $highestColumnIndex = Coordinate::columnIndexFromString($sheet->getHighestColumn());
    //     $templateValues = [];
    //     $templateStyles = [];
    //     $templateNumberFormats = []; // untuk jaga-jaga, tapi tak wajib lagi

    //     for ($col = 1; $col <= $highestColumnIndex; $col++) {
    //         $colLetter = Coordinate::stringFromColumnIndex($col);
    //         $cellAddr = "{$colLetter}{$startRow}";
    //         $cell = $sheet->getCell($cellAddr);

    //         $templateValues[$colLetter] = $cell->getValue();

    //         // Simpan seluruh objek style (font, border, alignment, fill, dll)
    //         $templateStyles[$colLetter] = clone $sheet->getStyle($cellAddr);
    //     }


    //     // Duplikat baris untuk jumlah data - 1
    //     for ($i = 1; $i < count($honor); $i++) {
    //         $sheet->insertNewRowBefore($startRow + $i, 1);
    //         foreach ($templateStyles as $colLetter => $style) {
    //             $targetCell = $colLetter . ($startRow + $i);
    //             $sheet->duplicateStyle($style, $targetCell);
    //             $sheet->setCellValue($targetCell, $templateValues[$colLetter]); // clone template value dulu
    //         }
    //     }

    //     // Isi value setelah semua style sudah di-copy
    //     $totalDiterima = 0;
    //     foreach ($honor as $i => $h) {
    //         $row = $startRow + $i;

    //         $rowVals = [
    //             '$i' => $i + 1,
    //             '$urutan' => $i + 1,
    //             '$nama' => $h['nama_lengkap'],
    //             '$sobatid' => '8171xxx',
    //             '$honorsatuan' => $h['harga_per_satuan'],
    //             '$jumlah' => $h['jumlah_satuan'],
    //             '$bruto' => $h['jumlah_satuan'] * $h['harga_per_satuan'],
    //             '$pajak' => $h['potongan_pajak'],
    //             '$diterima' => $h['total_diterima']
    //         ];

    //         foreach ($templateValues as $colLetter => $templateVal) {
    //             $cellAddr = $colLetter . $row;

    //             // Ganti isi
    //             $val = $templateVal;
    //             foreach ($rowVals as $key => $replacement) {
    //                 $val = str_replace($key, $replacement, $val);
    //             }
    //             $sheet->setCellValue($cellAddr, $val);

    //             // Terapkan semua style dari template
    //             $sheet->getStyle($cellAddr)->applyFromArray(
    //                 $templateStyles[$colLetter]->getBorders()->toArray() +
    //                     $templateStyles[$colLetter]->getAlignment()->toArray() +
    //                     $templateStyles[$colLetter]->getFont()->toArray() +
    //                     $templateStyles[$colLetter]->getFill()->toArray()
    //             );

    //             // Format angka (opsional, jika mau dipastikan)
    //             $sheet->getStyle($cellAddr)
    //                 ->getNumberFormat()
    //                 ->setFormatCode($templateStyles[$colLetter]->getNumberFormat()->getFormatCode());
    //         }
    //     }



    //     // Ganti placeholder lain
    //     $rowTerbilang = $startRow + count($honor);
    //     $rowTanggal = $rowTerbilang + 2;
    //     $rowNama = $rowTanggal + 4;
    //     $rowNip = $rowNama + 1;

    //     for ($row = 1; $row <= $sheet->getHighestRow(); $row++) {
    //         for ($col = 1; $col <= $highestColumnIndex; $col++) {
    //             $cellAddr = Coordinate::stringFromColumnIndex($col) . $row;
    //             $val = $sheet->getCell($cellAddr)->getValue();

    //             if ($val === null) continue;

    //             if (strpos($val, '$totaldit') !== false) {
    //                 $sheet->setCellValue($cellAddr, str_replace('$totaldit', $totalDiterima, $val));
    //             }
    //             if (strpos($val, '$terbilang') !== false) {
    //                 $sheet->setCellValue($cellAddr, str_replace('$terbilang', trim(terbilang($totalDiterima)) . ' Rupiah', $val));
    //             }
    //             if (strpos($val, '$tanggal') !== false) {
    //                 $sheet->setCellValue($cellAddr, str_replace('$tanggal', $tanggalFormatted, $val));
    //             }
    //             if (strpos($val, '$nama_daftar') !== false) {
    //                 $sheet->setCellValue($cellAddr, str_replace('$nama_daftar', $namaDaftar, $val));
    //             }
    //             if (strpos($val, '$nip') !== false) {
    //                 $sheet->setCellValue($cellAddr, str_replace('$nip', $nip, $val));
    //             }
    //         }
    //     }

    //     // Output file
    //     $filename = 'SPJ_Honor_' . str_replace(' ', '_', $kegiatan['nama_kegiatan']) . '_' . date('YmdHis') . '.xlsx';
    //     header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    //     header("Content-Disposition: attachment;filename=\"$filename\"");
    //     header('Cache-Control: max-age=0');

    //     $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
    //     $writer->save('php://output');
    //     exit;
    // }


    public function formExportHonor($kegiatan_id)
    {
        return view('mitra/form_export_honor', [
            'kegiatan_id' => $kegiatan_id,
            'title' => 'Form Export Honor'
        ]);
    }
}
