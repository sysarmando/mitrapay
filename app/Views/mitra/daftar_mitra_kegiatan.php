<?= $this->extend('templates/adminlte') ?>
<?= $this->section('content') ?>

<section class="app-content-header">
    <div class="container-fluid">
        <h1>Daftar Mitra untuk Kegiatan: <?= esc($kegiatan['nama_kegiatan']) ?></h1>
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
        <div class="card">
            <div class="card-body table-responsive">
                <table id="tabelMitraKegiatan" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Jenis Kelamin</th>
                            <th>No HP</th>
                            <th>Email</th>
                            <th>Alamat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1;
                        foreach ($mitra as $m): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= esc($m['nama_lengkap']) ?></td>
                                <td><?= esc($m['jk']) ?></td>
                                <td><?= esc($m['no_hp']) ?></td>
                                <td><?= esc($m['email']) ?></td>
                                <td><?= esc($m['alamat']) ?></td>
                                <td>
                                    <a href="<?= base_url('dokumen/generate/kontrak_template.docx/' . $m['id'] . '/' . $kegiatan['id']) ?>"
                                        class="btn btn-sm btn-primary">
                                        <i class="fas fa-file-word"></i> Kontrak
                                    </a>

                                    <a href="<?= base_url('mitra/hapus-penugasan/' . $m['id'] . '/' . $kegiatan['id']) ?>"
                                        class="btn btn-sm btn-danger btn-hapus-penugasan">
                                        <i class="fas fa-trash-alt"></i> Hapus
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
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<script>
    $(document).ready(function() {
        $('#tabelMitraKegiatan').DataTable({
            language: {
                url: "//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json"
            }
        });
        $(document).on('click', '.btn-hapus-penugasan', function(e) {
            e.preventDefault();
            const href = $(this).attr('href');

            Swal.fire({
                title: 'Yakin hapus penugasan?',
                text: "Data ini akan dihapus dari kegiatan.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, hapus',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = href;
                }
            });
        });

    });
</script>
<?= $this->endSection() ?>