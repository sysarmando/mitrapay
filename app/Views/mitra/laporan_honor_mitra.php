<?= $this->extend('templates/adminlte') ?>
<?= $this->section('content') ?>

<section class="app-content-header">
    <div class="container-fluid">
        <h1>Laporan Honor Tahunan - <?= esc($mitra['nama_lengkap']) ?> </h1>
    </div>
</section>

<section class="app-content">
    <div class="container-fluid">
        <form method="get" class="mb-3">
            <div class="row">
                <div class="col-md-3">
                    <label for="tahun">Pilih Tahun</label>
                    <select name="tahun" class="form-control" onchange="this.form.submit()">
                        <?php for ($y = date('Y'); $y >= 2020; $y--): ?>
                            <option value="<?= $y ?>" <?= ($tahun == $y ? 'selected' : '') ?>><?= $y ?></option>
                        <?php endfor ?>
                    </select>
                </div>
            </div>
        </form>

        <div class="card">
            <div class="card-body table-responsive">
                <table class="table table-bordered table-striped" id="tabelLaporan">
                    <thead>
                        <tr>
                            <th>Bulan</th>
                            <th>Nama Kegiatan</th>
                            <th>Jenis Satuan</th>
                            <th>Jumlah</th>
                            <th>Potongan Pajak</th>
                            <th>Total Diterima</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $bulanIndo = [
                            '01' => 'Januari',
                            '02' => 'Februari',
                            '03' => 'Maret',
                            '04' => 'April',
                            '05' => 'Mei',
                            '06' => 'Juni',
                            '07' => 'Juli',
                            '08' => 'Agustus',
                            '09' => 'September',
                            '10' => 'Oktober',
                            '11' => 'November',
                            '12' => 'Desember'
                        ];
                        $total = 0;
                        foreach ($honorList as $row):
                            $total += $row['total_diterima'];
                        ?>
                            <tr>
                                <td><?= $bulanIndo[$row['bulan_pembayaran']] ?? $row['bulan_pembayaran'] ?></td>
                                <td><?= esc($row['nama_kegiatan']) ?></td>
                                <td><?= esc($row['nama_satuan']) ?></td>
                                <td><?= number_format($row['jumlah_satuan'], 0, ',', '.') ?></td>
                                <td>Rp<?= number_format($row['potongan_pajak'], 0, ',', '.') ?></td>
                                <td><strong>Rp<?= number_format($row['total_diterima'], 0, ',', '.') ?></strong></td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="5" class="text-right">Total Honor Tahun <?= $tahun ?></th>
                            <th>Rp<?= number_format($total, 0, ',', '.') ?></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</section>

<?= $this->endSection() ?>
<?= $this->section('js') ?>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function() {
        $('#tabelLaporan').DataTable({
            ordering: false,
            paging: false,
            searching: false,
            info: false
        });
    });
</script>
<?= $this->endSection() ?>