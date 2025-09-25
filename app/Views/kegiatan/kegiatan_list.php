<?= $this->extend('templates/adminlte') ?>
<?= $this->section('content') ?>

<section class="app-content-header">
    <div class="container-fluid">
        <h1>Daftar Kegiatan Statistik Tahun <?= date("Y") ?></h1>
    </div>
</section>

<section class="app-content">
    <div class="container-fluid">

        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('warning')): ?>
            <div class="alert alert-warning">
                <?= session()->getFlashdata('warning') ?>
            </div>
        <?php endif; ?>

        <div class="mb-3">
            <a href="<?= base_url('mitra/kegiatan/tambah') ?>" class="btn btn-primary">
                <i class="fas fa-plus"></i> Tambah Kegiatan Baru
            </a>
        </div>

        <div class="card">
            <div class="card-body table-responsive">
                <table id="tabelKegiatan" class="table table-bordered table-striped">
                    <thead class="thead-dark">
                        <tr>
                            <th>No</th>
                            <th>Nama Kegiatan</th>
                            <th>Tahun</th>
                            <th>PJ</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1;
                        foreach ($kegiatan as $k): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= esc($k['nama_kegiatan']) ?></td>
                                <td><?= esc($k['tahun']) ?></td>
                                <td><?= esc($k['tim_kerja']) ?></td>
                                <td>
                                    <a href="<?= base_url('mitra/input-satuan/' . $k['id']) ?>" class="btn btn-sm btn-secondary mb-1">
                                        <i class="fas fa-cogs"></i> Input Satuan
                                    </a>
                                    <a href="<?= base_url('mitra/input-honor/' . $k['id']) ?>" class="btn btn-sm btn-success mb-1">
                                        <i class="fas fa-money-bill-wave"></i> Input Honor
                                    </a>
                                    <a href="<?= base_url('mitra/kegiatan/assign/' . $k['id']) ?>" class="btn btn-sm btn-primary mb-1">
                                        <i class="fas fa-user-plus"></i> Tambah Mitra
                                    </a>
                                    <a href="<?= base_url('mitra/daftar-mitra-kegiatan/' . $k['id']) ?>" class="btn btn-sm btn-info mb-1">
                                        <i class="fas fa-users"></i> Daftar Mitra
                                    </a>
                                    <a href="<?= base_url('mitra/form-export-honor/' . $k['id']) ?>" class="btn btn-sm btn-success">
                                        <i class="fas fa-file-excel"></i> Export Honor
                                    </a>
                                    <?php if ($role === '99'): ?>
                                        <a href="<?= base_url('mitra/kegiatan/hapus/' . $k['id']) ?>"
                                            class="btn btn-sm btn-danger mb-1"
                                            onclick="return confirm('Yakin ingin menghapus kegiatan ini?')">
                                            <i class="fas fa-trash"></i> Hapus
                                        </a>
                                    <?php endif; ?>

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
<!-- DataTables -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<script>
    $(document).ready(function() {
        $('#tabelKegiatan').DataTable({
            language: {
                url: "//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json"
            }
        });
    });
</script>
<?= $this->endSection() ?>