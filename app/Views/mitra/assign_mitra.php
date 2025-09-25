<?= $this->extend('templates/adminlte') ?>
<?= $this->section('content') ?>

<section class="app-content-header">
  <div class="container-fluid">
    <h1>Penugasan Mitra ke Kegiatan</h1>
  </div>
</section>

<section class="app-content">
  <div class="container-fluid">

    <?php if (session()->getFlashdata('success')): ?>
      <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
    <?php endif; ?>

    <div class="card">
      <div class="card-body">

        <form action="<?= base_url('mitra/simpan-penugasan') ?>" method="post">
          <?= csrf_field() ?>
          <input type="hidden" name="kegiatan_id" value="<?= $kegiatan['id'] ?>">

          <div class="mb-3">
            <label>Nama Kegiatan</label>
            <input type="text" class="form-control" value="<?= $kegiatan['nama_kegiatan'] ?>" readonly disabled>
          </div>

          <div class="mb-3">
            <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#modalMitra">
              Pilih Mitra
            </button>
          </div>

          <div id="daftar-terpilih" class="mb-3">
            <h5>Mitra Terpilih:</h5>
            <ul id="listMitraTerpilih"></ul>
          </div>

          <button type="submit" class="btn btn-primary">Simpan Penugasan</button>
        </form>

      </div>
    </div>

  </div>
</section>

<!-- Modal -->
<div class="modal fade" id="modalMitra" tabindex="-1" aria-labelledby="modalMitraLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Pilih Mitra</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
      </div>
      <div class="modal-body">
        <table class="table table-bordered table-sm" id="tabelMitra" style="width: 100%;">
          <thead>
            <tr>
              <th>#</th>
              <th>Nama</th>
              <th>Posisi</th>
              <th>No HP</th>
              <th>Tempat Tinggal</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($mitra as $m): ?>
              <tr>
                <td>
                  <input type="checkbox" class="checkbox-mitra" value="<?= $m['id'] ?>" data-nama="<?= $m['nama_lengkap'] ?>">
                </td>
                <td><?= esc($m['nama_lengkap']) ?></td>
                <td><?= esc($m['posisi'] ?? '-') ?></td>
                <td><?= esc($m['no_hp']) ?></td>
                <td><?= esc(ucwords(strtolower($m['nama_desa'])) . ', ' . $m['nama_kec'] . ', ' . $m['nama_kab']) ?></td>
              </tr>
            <?php endforeach ?>
          </tbody>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="btnSimpanMitra" data-bs-dismiss="modal">Gunakan Mitra</button>
      </div>
    </div>
  </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('js') ?>
<!-- DataTables dan logika checkbox -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<script>
  $(document).ready(function() {
    tabelMitra = $('#tabelMitra').DataTable({
      scrollX: true,
      scrollY: "500px",
      scrollCollapse: true,
      paging: false,
      autoWidth: false, // Penting agar kolom tidak auto hitung lebar acak
      responsive: true,
      language: {
        url: "//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json"
      }
    });

    // Saat modal dibuka
    $('#modalMitra').on('shown.bs.modal', function() {
      tabelMitra.columns.adjust().responsive.recalc();
    });

    // Simpan pilihan mitra
    $('#btnSimpanMitra').click(function() {
      $('#listMitraTerpilih').empty();
      $('.checkbox-mitra:checked').each(function() {
        let id = $(this).val();
        let nama = $(this).data('nama');

        // tampilkan daftar
        $('#listMitraTerpilih').append(`<li>${nama}</li>`);

        // tambahkan input tersembunyi ke form
        $('<input>').attr({
          type: 'hidden',
          name: 'mitra_ids[]',
          value: id
        }).appendTo('form');
      });
    });
  });
</script>
<?= $this->endSection() ?>