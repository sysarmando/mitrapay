<?php
$belumAdaHonor = empty(array_filter($mitra, function ($m) {
    return !empty($m['honor_satuan_id']) || !empty($m['jumlah_satuan']);
}));
?>

<?= $this->extend('templates/adminlte') ?>
<?= $this->section('content') ?>

<section class="app-content-header">
    <div class="container-fluid">
        <h1>Input Honor - <?= esc($kegiatan['nama_kegiatan']) ?></h1>
    </div>
</section>

<section class="app-content">
    <?php if (session()->getFlashdata('peringatan')): ?>
        <div class="alert alert-warning">
            <ul>
                <?php foreach (session()->getFlashdata('peringatan') as $p): ?>
                    <li><?= $p ?></li>
                <?php endforeach ?>
            </ul>
        </div>
    <?php endif ?>

    <div class="container-fluid">
        <form action="<?= base_url('mitra/simpan-honor') ?>" method="post" id="formHonor">
            <?= csrf_field() ?>
            <input type="hidden" name="kegiatan_id" value="<?= $kegiatan['id'] ?>">

            <div class="card">
                <div class="card-body table-responsive">
                    <table class="table table-bordered" id="tabelHonor">
                        <thead>
                            <tr>
                                <th>Nama Mitra</th>
                                <th>Jenis Satuan</th>
                                <th>Harga per Satuan</th>
                                <th>Jumlah</th>
                                <th>Bulan Pembayaran</th>
                                <th>Potongan Pajak</th>
                                <th>Total Diterima</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($mitra as $i => $m): ?>
                                <tr>
                                    <td>
                                        <?= esc($m['nama_lengkap']) ?>
                                        <input type="hidden" name="mitra_id[]" value="<?= $m['mitra_id'] ?>">
                                        <input type="hidden" name="honor_mitra_id[]" value="<?= $m['honor_mitra_id'] ?? '' ?>">
                                        <input type="hidden" name="mk_id[]" value="<?= $m['id'] ?? '' ?>">
                                    </td>

                                    <td>
                                        <!-- Dropdown untuk tampil -->
                                        <select class="form-control satuan-select" data-index="<?= $i ?>" disabled>
                                            <option value="">Pilih</option>
                                            <?php foreach ($satuan as $s): ?>
                                                <option value="<?= $s['id'] ?>" data-harga="<?= $s['harga_per_satuan'] ?>"
                                                    <?= ($m['honor_satuan_id'] ?? '') == $s['id'] ? 'selected' : '' ?>>
                                                    <?= esc($s['nama_satuan']) ?>
                                                </option>
                                            <?php endforeach ?>
                                        </select>
                                        <!-- Hidden untuk kirim -->
                                        <input type="hidden" name="honor_satuan_id[]" value="<?= $m['honor_satuan_id'] ?? '' ?>" class="is-edited input-satuan-<?= $i ?>">
                                    </td>

                                    <td>
                                        <input type="hidden" name="harga_per_satuan[]" id="harga_<?= $i ?>" value="<?= $m['harga_per_satuan'] ?? 0 ?>">
                                        <input type="text" class="form-control" id="harga_format_<?= $i ?>"
                                            value="<?= isset($m['harga_per_satuan']) ? 'Rp. ' . number_format($m['harga_per_satuan'], 0, ',', '.') : '' ?>" readonly>
                                    </td>

                                    <td>
                                        <input type="number" name="jumlah_satuan[]" class="form-control jumlah is-edited" data-index="<?= $i ?>"
                                            value="<?= $m['jumlah_satuan'] ?? '' ?>" readonly>
                                    </td>

                                    <td>
                                        <!-- Dropdown untuk tampil -->
                                        <select class="form-control" disabled data-index="<?= $i ?>">
                                            <option value="">Pilih</option>
                                            <?php foreach ($bulanList as $key => $val): ?>
                                                <option value="<?= $key ?>" <?= ($m['bulan_pembayaran'] ?? '') == $key ? 'selected' : '' ?>>
                                                    <?= $val ?>
                                                </option>
                                            <?php endforeach ?>
                                        </select>
                                        <!-- Hidden untuk kirim -->
                                        <input type="hidden" name="bulan_pembayaran[]" value="<?= str_pad($m['bulan_pembayaran'] ?? '', 2, '0', STR_PAD_LEFT) ?>" class="is-edited input-bulan-<?= $i ?>">
                                    </td>

                                    <td>
                                        <input type="number" name="potongan_pajak[]" class="is-edited form-control pajak" data-index="<?= $i ?>"
                                            value="<?= $m['potongan_pajak'] ?? 0 ?>" readonly>
                                    </td>

                                    <td>
                                        <input type="hidden" class="is-edited" name="total_diterima_fake[]" id="total_<?= $i ?>_val"
                                            value="<?= ($m['jumlah_satuan'] ?? 0) * ($m['harga_per_satuan'] ?? 0) - ($m['potongan_pajak'] ?? 0) ?>">
                                        <input type="text" class="form-control total" id="total_<?= $i ?>" readonly
                                            value="<?= 'Rp. ' . number_format((($m['jumlah_satuan'] ?? 0) * ($m['harga_per_satuan'] ?? 0) - ($m['potongan_pajak'] ?? 0)), 0, ',', '.') ?>">
                                    </td>

                                    <td>
                                        <button type="button" class="btn btn-warning btn-sm edit-row" data-index="<?= $i ?>">Edit</button>
                                    </td>
                                </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>

                    <button type="submit" class="btn btn-success mt-3">Simpan Semua</button>
                    <button type="button" class="btn btn-secondary mt-3" id="btnTambahBaris">Tambah Baris</button>

                </div>
            </div>
        </form>
    </div>
</section>

<?= $this->endSection() ?>

<?= $this->section('js') ?>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script>
    const daftarMitra = <?= json_encode(array_map(function ($m) {
                            return [
                                'id' => $m['mitra_id'],
                                'nama' => $m['nama_lengkap'],
                                'mk_id' => $m['id']
                            ];
                        }, $mitra_select)) ?>;



    const daftarSatuan = <?= json_encode($satuan) ?>;

    let barisIndex = <?= count($mitra) ?>;
</script>

<script>
    $(document).ready(function() {
        let barisIndex = $('#tabelHonor tbody tr').length;

        $('#tabelHonor').DataTable({
            scrollY: '400px',
            scrollCollapse: true,
            paging: false,
            ordering: false,
            info: false,
            searching: false,
            language: {
                emptyTable: "Belum ada honor yang ditambahkan di kegiatan ini. Silahkan tambah baris baru."
            },
            destroy: true
        });


        $('.edit-row').on('click', function() {
            const i = $(this).data('index');
            $(`select[data-index="${i}"]`).prop('disabled', false);
            $(`.jumlah[data-index="${i}"]`).prop('readonly', false);
            $(`.pajak[data-index="${i}"]`).prop('readonly', false);
            // $(`.is-edited`).eq(i).val('1'); // tandai baris sebagai telah diedit
        });

        $('.satuan-select').on('change', function() {
            const i = $(this).data('index');
            const harga = $(this).find(':selected').data('harga') || 0;
            $('#harga_' + i).val(harga);
            $('#harga_format_' + i).val('Rp. ' + harga.toLocaleString('id-ID'));
            $(`.input-satuan-${i}`).val($(this).val());
        });

        $('select[data-index]').on('change', function() {
            const i = $(this).data('index');
            const val = $(this).val();
            $(`.input-bulan-${i}`).val(val);
        });

        $('.jumlah, .pajak').on('input', function() {
            const i = $(this).data('index');
            const jml = parseInt($(`.jumlah[data-index="${i}"]`).val()) || 0;
            const pajak = parseInt($(`.pajak[data-index="${i}"]`).val()) || 0;
            const harga = parseInt($('#harga_' + i).val()) || 0;
            const total = (jml * harga) - pajak;

            $('#total_' + i + '_val').val(total);
            $('#total_' + i).val('Rp. ' + total.toLocaleString('id-ID'));
        });
        $('#btnTambahBaris').on('click', function() {
            $('#tabelHonor tbody .dataTables_empty').closest('tr').remove();
            if ($('#no-data-row').length) {
                $('#no-data-row').remove();
            }

            const baris = `
    <tr>
        <td>
            <select class="form-control" name="mitra_id[]">
                <option value="">Pilih Mitra</option>
                ${daftarMitra.map(m => `<option value="${m.id}" data-mk-id="${m.mk_id}">${m.nama}</option>`).join('')}
            </select>
            <input type="hidden" name="honor_mitra_id[]" value="">
            <input type="hidden" name="mk_id[]" class="input-mk-id">
        </td>

        <td>
            <select class="form-control satuan-select" data-index="${barisIndex}">
                <option value="">Pilih</option>
                ${daftarSatuan.map(s => `<option value="${s.id}" data-harga="${s.harga_per_satuan}">${s.nama_satuan}</option>`).join('')}
            </select>
            <input type="hidden" name="honor_satuan_id[]" class="input-satuan-${barisIndex}">
        </td>

        <td>
            <input type="hidden" name="harga_per_satuan[]" id="harga_${barisIndex}" value="0">
            <input type="text" class="form-control" id="harga_format_${barisIndex}" readonly>
        </td>

        <td>
            <input type="number" name="jumlah_satuan[]" class="form-control jumlah" data-index="${barisIndex}" value="0">
        </td>

        <td>
            <select class="form-control" data-index="${barisIndex}">
                <option value="">Pilih</option>
                <?php foreach ($bulanList as $key => $val): ?>
                <option value="<?= $key ?>"><?= $val ?></option>
                <?php endforeach ?>
            </select>
            <input type="hidden" name="bulan_pembayaran[]" class="input-bulan-${barisIndex}">
        </td>

        <td>
            <input type="number" name="potongan_pajak[]" class="form-control pajak" data-index="${barisIndex}" value="0">
        </td>

        <td>
            <input type="hidden" name="total_diterima_fake[]" id="total_${barisIndex}_val" value="0">
            <input type="text" class="form-control total" id="total_${barisIndex}" value="Rp. 0" readonly>
        </td>

        <td><button type="button" class="btn btn-danger btn-sm btn-hapus">Hapus</button></td>
    </tr>`;

            $('#tabelHonor tbody').append(baris);
            barisIndex++;
        });

        $(document).on('change', '.satuan-select', function() {
            const i = $(this).data('index');
            const harga = $(this).find(':selected').data('harga') || 0;
            $('#harga_' + i).val(harga);
            $('#harga_format_' + i).val('Rp. ' + harga.toLocaleString('id-ID'));
            $(`.input-satuan-${i}`).val($(this).val());
        });

        $(document).on('change', 'select[data-index]', function() {
            const i = $(this).data('index');
            const val = $(this).val();
            $(`.input-bulan-${i}`).val(val);
        });

        $(document).on('input', '.jumlah, .pajak', function() {
            const i = $(this).data('index');
            const jml = parseInt($(`.jumlah[data-index="${i}"]`).val()) || 0;
            const pajak = parseInt($(`.pajak[data-index="${i}"]`).val()) || 0;
            const harga = parseInt($('#harga_' + i).val()) || 0;
            const total = (jml * harga) - pajak;

            $('#total_' + i + '_val').val(total);
            $('#total_' + i).val('Rp. ' + total.toLocaleString('id-ID'));
        });

        $(document).on('click', '.btn-hapus', function() {
            $(this).closest('tr').remove();
        });

        $(document).on('change', 'select[name="mitra_id[]"]', function() {
            const mkId = $(this).find(':selected').data('mk-id');
            $(this).siblings('.input-mk-id').val(mkId);
        });

    });
</script>
<?= $this->endSection() ?>