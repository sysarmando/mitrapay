<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Auth::login');
$routes->get('/login', 'Auth::login');
$routes->post('/login', 'Auth::attemptLogin');
$routes->get('/logout', 'Auth::logout');


$routes->get('mitra', 'Mitra::index', ['filter' => 'auth']);
$routes->get('mitra/import-mitra', 'Mitra::importMitraForm', ['filter' => 'auth']);
$routes->post('mitra/import-mitra', 'Mitra::importMitra', ['filter' => 'auth']);
$routes->get('mitra/kegiatan/tambah', 'Mitra::tambahKegiatanForm', ['filter' => 'auth']);
$routes->post('mitra/kegiatan/tambah', 'Mitra::simpanKegiatan', ['filter' => 'auth']);
$routes->get('mitra/kegiatan', 'Mitra::kegiatanList', ['filter' => 'auth']);
$routes->post('mitra/kegiatan/hapus/(:any)', 'Mitra::hapusKegiatan/$1', ['filter' => 'auth']);
$routes->get('mitra/kegiatan/hapus/(:any)', 'Mitra::hapusKegiatan/$1', ['filter' => 'auth']);
$routes->get('mitra/kegiatan/assign/(:any)', 'Mitra::formPenugasan/$1', ['filter' => 'auth']);
$routes->post('mitra/simpan-penugasan', 'Mitra::simpanPenugasan', ['filter' => 'auth']);
$routes->get('mitra/kegiatan/honor/(:any)', 'Mitra::inputHonor/$1', ['filter' => 'auth']);
$routes->post('mitra/simpan-honor', 'Mitra::simpanHonor', ['filter' => 'auth']);
$routes->get('mitra/export-honor/(:any)', 'Mitra::exportHonorExcel/$1', ['filter' => 'auth']);
$routes->post('mitra/simpan-satuan', 'Mitra::simpanSatuan', ['filter' => 'auth']);
$routes->get('mitra/input-satuan/(:any)', 'Mitra::inputSatuan/$1', ['filter' => 'auth']);
$routes->get('mitra/input-honor/(:any)', 'Mitra::inputHonor/$1', ['filter' => 'auth']);
$routes->get('mitra/tambah-mitra-ke-kegiatan/(:any)', 'Mitra::tambahMitraKeKegiatan/$1', ['filter' => 'auth']);
$routes->get('mitra/laporan-honor', 'Mitra::laporanHonor', ['filter' => 'auth']);
$routes->get('mitra/laporan-honor/(:any)', 'Mitra::laporanHonor/$1', ['filter' => 'auth']);
$routes->get('mitra/daftar-mitra-kegiatan/(:any)', 'Mitra::daftarMitraKegiatan/$1');
$routes->get('mitra/hapus-penugasan/(:any)/(:any)', 'Mitra::hapusPenugasan/$1/$2');

$routes->get('mitra/form-export-honor/(:any)', 'Mitra::formExportHonor/$1');
$routes->get('mitra/exportHonorExcel/(:any)', 'Mitra::exportHonorExcel/$1');



$routes->get('template', 'Template::index', ['filter' => 'auth']);
$routes->post('template/upload', 'Template::upload', ['filter' => 'auth']);

$routes->get('dokumen/generate/(:any)/(:any)/(:any)', 'Dokumen::generate/$1/$2/$3');

$routes->post('admin/import-mitra', 'Mitra::importMitra', ['filter' => 'auth']);
