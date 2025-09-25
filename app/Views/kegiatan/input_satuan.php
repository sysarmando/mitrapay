<?= $this->extend('templates/adminlte') ?>
<?= $this->section('content') ?>

<section class="app-content-header">
  <div class="container-fluid">
    <h1>Input Satuan Honor - <?= esc($kegiatan['nama_kegiatan']) ?></h1>
  </div>
</section>

<section class="app-content">
  <div class="container-fluid">

    <?php if (session()->getFlashdata('success')): ?>
      <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
    <?php elseif (session()->getFlashdata('error')): ?>
      <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
    <?php endif; ?>

    <div class="card">
      <div class="card-body">
        <form method="post" action="<?= base_url('mitra/simpan-satuan') ?>">
          <?= csrf_field() ?>
          <input type="hidden" name="kegiatan_id" value="<?= $kegiatan['id'] ?>">

          <div id="form-satuan-wrapper">
            <div class="row mb-2">
              <div class="col-md-7">
                <input type="text" name="nama_satuan[]" class="form-control" placeholder="Contoh: Responden" required>
              </div>
              <div class="col-md-5">
                <input type="number" name="harga_per_satuan[]" class="form-control" placeholder="Harga per Satuan" required>
              </div>
            </div>
          </div>

          <button type="button" class="btn btn-sm btn-secondary mb-3" id="tambahSatuan">+ Tambah Baris</button>
          <br>
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
  document.getElementById('tambahSatuan').addEventListener('click', function() {
    const wrapper = document.getElementById('form-satuan-wrapper');
    const row = document.createElement('div');
    row.className = 'row mb-2';
    row.innerHTML = `
      <div class="col-md-7">
        <input type="text" name="nama_satuan[]" class="form-control" placeholder="Contoh: Responden" required>
      </div>
      <div class="col-md-5">
        <input type="number" name="harga_per_satuan[]" class="form-control" placeholder="Harga per Satuan" required>
      </div>
    `;
    wrapper.appendChild(row);
  });
</script>
<?= $this->endSection() ?>