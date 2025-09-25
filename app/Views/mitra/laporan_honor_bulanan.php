<?= $this->extend('templates/adminlte') ?>
<?= $this->section('content') ?>

<section class="app-content-header">
  <div class="container-fluid">
    <h1>Laporan Honor Mitra per Bulan Tahun <?= date("Y") ?></h1>
  </div>
</section>

<section class="app-content">
  <div class="container-fluid">
    <div class="card">
      <div class="card-body">
        <table id="tabelLaporan" class="table table-bordered table-striped text-nowrap">
          <thead class="text-center">
            <tr>
              <th>Nama Mitra</th>
              <?php
              $bulanIndo = [
                1 => 'Jan',
                2 => 'Feb',
                3 => 'Mar',
                4 => 'Apr',
                5 => 'Mei',
                6 => 'Jun',
                7 => 'Jul',
                8 => 'Agu',
                9 => 'Sep',
                10 => 'Okt',
                11 => 'Nov',
                12 => 'Des'
              ];
              foreach ($bulanIndo as $bln): ?>
                <th><?= $bln ?></th>
              <?php endforeach ?>
              <th>Total</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($laporan as $row): ?>
              <tr>
                <td><?= esc($row['nama_lengkap']) ?></td>
                <?php
                $total = 0;
                foreach ($bulanIndo as $i => $namaBulan):
                  $val = $row['total_per_bulan'][$i] ?? 0;
                  $total += $val;
                ?>
                  <td>Rp <?= number_format($val, 0, ',', '.') ?></td>
                <?php endforeach ?>
                <td class="font-weight-bold">Rp <?= number_format($total, 0, ',', '.') ?></td>
              </tr>
            <?php endforeach ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</section>

<?= $this->endSection() ?>
<?= $this->section('css') ?>
<style>
  #tabelLaporan th,
  #tabelLaporan td {
    white-space: nowrap;
    vertical-align: middle;
    text-align: right;
    min-width: 100px;
    /* kolom default */
  }

  #tabelLaporan td:first-child,
  #tabelLaporan th:first-child {
    text-align: left;
    min-width: 200px;
  }

  #tabelLaporan th {
    background-color: #f8f9fa;
  }

  #tabelLaporan_wrapper {
    overflow-x: auto;
  }
</style>
<?= $this->endSection() ?>

<?= $this->section('js') ?>
<script>
  $('#tabelLaporan').DataTable({
    scrollX: true,
    scrollY: "500px",
    scrollCollapse: true,
    autoWidth: false,
    paging: false,
    searching: true,
    ordering: true,
    info: true,
    language: {
      url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json'
    },
    columnDefs: [{
        width: "200px",
        targets: 0
      }, // kolom nama mitra
      {
        width: "100px",
        targets: "_all"
      } // kolom bulan dan total
    ]
  });
</script>
<?= $this->endSection() ?>