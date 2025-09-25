<?= $this->extend('templates/adminlte') ?>
<?= $this->section('content') ?>

<section class="app-content-header">
    <div class="container-fluid">
        <h1>Daftar Mitra Kepka Tahun <?= date('Y') ?></h1>
    </div>
</section>

<section class="app-content">
    <div class="container-fluid">

        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('warning')): ?>
            <div class="alert alert-warning"><?= session()->getFlashdata('warning') ?></div>
        <?php endif; ?>

        <div class="mb-3">
            <a href="<?= base_url('mitra/import-mitra') ?>" class="btn btn-primary">
                <i class="fas fa-plus"></i> Import Mitra
            </a>
        </div>

        <div class="card">
            <div class="card-body table-responsive">
                <table id="tabelMitra" class="table table-bordered table-striped">
                    <thead class="thead-dark">
                        <tr>
                            <th>No</th>
                            <th>Nama Lengkap</th>
                            <th>Posisi</th>
                            <th>Alamat</th>
                            <th>Wilayah</th>
                            <th>Jenis Kelamin</th>
                            <th>No HP</th>
                            <th>Email</th>
                            <th>Tahun</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1;
                        foreach ($mitra as $row): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= esc($row['nama_lengkap']) ?></td>
                                <td><?= esc($row['nama_posisi'] ?? $row['posisi']) ?></td>
                                <td><?= esc($row['alamat']) ?></td>
                                <td>
                                    <?= esc(ucwords(strtolower($row['nama_desa']))) ?>,
                                    <?= esc($row['nama_kec']) ?>,
                                    <?= esc($row['nama_kab']) ?>
                                </td>
                                <td><?= $row['jk'] ?></td>
                                <td><?= esc($row['no_hp']) ?></td>
                                <td><?= esc($row['email']) ?></td>
                                <td><?= esc($row['tahun']) ?></td>
                                <td><a href="<?= base_url('mitra/laporan-honor/' . $row['id']) ?>" class="btn btn-sm btn-info">
                                        <i class="fas fa-file-alt"></i> Laporan Honor
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</section>

<?= $this->endSection() ?>

<?= $this->section('js') ?>
<!-- DataTables JS (gunakan CDN) -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<script>
    $(document).ready(function() {
        $('#tabelMitra').DataTable({
            scrollY: "500px",
            scrollCollapse: true,
            paging: false,
            language: {
                url: "//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json"
            }
        });
    });
</script>
<?= $this->endSection() ?>