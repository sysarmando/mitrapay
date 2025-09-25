<?= $this->extend('templates/adminlte') ?>
<?= $this->section('content') ?>

<section class="app-content-header">
    <div class="container-fluid">
        <h1>Import Mitra Statistik</h1>
    </div>
</section>

<section class="app-content">
    <div class="container-fluid">

        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
        <?php endif; ?>

        <div class="card">
            <div class="card-body">
                <form action="<?= base_url('admin/import-mitra') ?>" method="post" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="file_excel" class="form-label">Upload File Excel Mitra</label>
                        <input type="file" name="file_excel" class="form-control" required accept=".xlsx,.xls">
                        <small class="form-text text-muted">Gunakan format Excel: NIK, Nama Mitra, Alamat, No HP, Email</small>
                    </div>

                    <div class="mb-3">
                        <label for="tahun" class="form-label">Tahun Penugasan</label>
                        <select name="tahun" class="form-control" required>
                            <?php for ($i = date('Y'); $i >= 2022; $i--): ?>
                                <option value="<?= $i ?>"><?= $i ?></option>
                            <?php endfor; ?>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-upload"></i> Import
                    </button>

                    <a href="<?= base_url('assets/template/mitra_import_template.xlsx') ?>" class="btn btn-success float-end">
                        <i class="fa fa-download"></i> Download Template
                    </a>
                </form>
            </div>
        </div>
    </div>
</section>

<?= $this->endSection() ?>
