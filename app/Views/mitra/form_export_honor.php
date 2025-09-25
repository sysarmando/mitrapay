<?= $this->extend('templates/adminlte.php') ?>
<?= $this->section('content') ?>

<section class="app-content-header">
    <div class="container-fluid">
        <h1>Form Export SPJ Honor Mitra</h1>
    </div>
</section>

<section class="app-content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <form action="<?= site_url('mitra/exportHonorExcel/' . $kegiatan_id) ?>" method="get" target="_blank">
                    <div class="form-group">
                        <label for="tanggal">Tanggal SPJ</label>
                        <input type="date" name="tanggal" id="tanggal" class="form-control" required>
                    </div>

                    <div class="form-group mt-3">
                        <label for="nama_daftar">Nama Pembuat Daftar</label>
                        <input type="text" name="nama_daftar" id="nama_daftar" class="form-control" placeholder="Iskan Nama Pembuat Daftar Honor Mitra" required>
                    </div>

                    <div class="form-group mt-3">
                        <label for="nip">NIP Pembuat Daftar</label>
                        <input type="text" name="nip" id="nip" class="form-control" placeholder="Isikan NIP dari Pembuat Daftar" required>
                    </div>
                    <div class="form-group mt-3">
                        <label for="program">Program</label>
                        <input type="text" name="program" id="nip" class="form-control" placeholder="Dalam Pengembangan" disabled>
                    </div>
                    <div class="form-group mt-3">
                        <label for="kegiatan">Kegiatan</label>
                        <input type="text" name="kegiatan" id="nip" class="form-control" placeholder="Dalam Pengembangan" disabled>
                    </div>
                    <div class="form-group mt-3">
                        <label for="output">Output</label>
                        <input type="text" name="output" id="nip" class="form-control" placeholder="Dalam Pengembangan" disabled>
                    </div>
                    <div class="form-group mt-3">
                        <label for="komponen">Komponen</label>
                        <input type="text" name="komponen" id="nip" class="form-control" placeholder="Dalam Pengembangan" disabled>
                    </div>
                    <div class="form-group mt-3">
                        <label for="akun">Akun</label>
                        <input type="text" name="akun" id="nip" class="form-control" placeholder="Dalam Pengembangan" disabled>
                    </div>

                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-file-export"></i> Export Excel
                        </button>
                        <a href="<?= previous_url() ?>" class="btn btn-secondary">Kembali</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<?= $this->endSection() ?>