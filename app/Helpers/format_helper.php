<?php
if (!function_exists('bulanIndo')) {
    function bulanIndo($bln)
    {
        $map = [
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
            '12' => 'Desember',
        ];
        return $map[str_pad($bln, 2, '0', STR_PAD_LEFT)] ?? '';
    }
}

function terbilang($angka)
{
    $angka = abs($angka);
    $bilangan = ["", "Satu", "Dua", "Tiga", "Empat", "Lima", "Enam", "Tujuh", "Delapan", "Sembilan", "Sepuluh", "Sebelas"];

    if ($angka < 12) {
        return $bilangan[$angka];
    } elseif ($angka < 20) {
        return terbilang($angka - 10) . " Belas";
    } elseif ($angka < 100) {
        return terbilang($angka / 10) . " Puluh " . terbilang($angka % 10);
    } elseif ($angka < 200) {
        return "Seratus " . terbilang($angka - 100);
    } elseif ($angka < 1000) {
        return terbilang($angka / 100) . " Ratus " . terbilang($angka % 100);
    } elseif ($angka < 2000) {
        return "Seribu " . terbilang($angka - 1000);
    } elseif ($angka < 1000000) {
        return terbilang($angka / 1000) . " Ribu " . terbilang($angka % 1000);
    } elseif ($angka < 1000000000) {
        return terbilang($angka / 1000000) . " Juta " . terbilang($angka % 1000000);
    } elseif ($angka < 1000000000000) {
        return terbilang($angka / 1000000000) . " Miliar " . terbilang($angka % 1000000000);
    }

    return "Angka terlalu besar";
}

function tanggalIndo($tanggal)
{
    $bulan = [
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
        '12' => 'Desember',
    ];

    $parts = explode('-', $tanggal); // format: yyyy-mm-dd
    if (count($parts) !== 3) return $tanggal;

    $tahun = $parts[0];
    $bulanIndo = $bulan[$parts[1]] ?? $parts[1];
    $hari = ltrim($parts[2], '0'); // hilangkan leading zero

    return "$hari $bulanIndo $tahun";
}
