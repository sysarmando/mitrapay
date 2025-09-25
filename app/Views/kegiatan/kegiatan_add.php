<?= $this->extend('templates/adminlte') ?>
<?= $this->section('content') ?>

<section class="app-content-header">
    <div class="container-fluid">
        <h1>Tambah Kegiatan Statistik</h1>
    </div>
</section>

<section class="app-content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <form action="<?= base_url('mitra/kegiatan/tambah') ?>" method="post">
                    <div class="mb-3">
                        <label>Nama Kegiatan</label>
                        <input type="text" name="nama_kegiatan" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Tahun</label>
                        <select name="tahun" class="form-control select2" data-placeholder="Tahun Kegiatan Berlangsung" required>
                            <option></option> <!-- kosongkan default -->
                            <?php for ($i = date('Y'); $i >= 2022; $i--): ?>
                                <option value="<?= $i ?>"><?= $i ?></option>
                            <?php endfor; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Tim PJ</label>
                        <select name="pj" class="form-control select2" data-placeholder="Pilih Tim Kerja Yang Bertanggung Jawab" required>
                            <option></option> <!-- kosongkan default -->
                            <?php foreach ($pj as $r): ?>
                                <?php
                                $disabled = '';
                                if ($role === '1' && $r['id'] != $tim_kerja) {
                                    $disabled = 'disabled';
                                }
                                ?>
                                <option value="<?= $r['id'] ?>" <?= $disabled ?>>
                                    <?= $r['tim_kerja'] ?><?= $disabled ? '(Tidak dapat dipilih)' : '' ?>
                                </option>
                            <?php endforeach; ?>
                        </select>

                    </div>
                    <!-- <div class="mb-3">
                        <label>Tanggal Mulai</label>
                        <input type="date" name="tanggal_mulai" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label>Tanggal Selesai</label>
                        <input type="date" name="tanggal_selesai" class="form-control">
                    </div> -->
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="<?= base_url('mitra/kegiatan') ?>" class="btn btn-secondary">Kembali</a>
                </form>
            </div>
        </div>
    </div>
</section>

<?= $this->endSection() ?>
<?= $this->section('js') ?>
<script>
    $(document).ready(function() {
        $('.select2').select2({
            allowClear: true,
            placeholder: function() {
                return $(this).data('placeholder');
            }
        });
    });
</script>
<?= $this->endSection() ?>