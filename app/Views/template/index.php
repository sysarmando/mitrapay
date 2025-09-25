<?= $this->extend('templates/adminlte') ?>
<?= $this->section('content') ?>

<h3>Upload Template Dokumen</h3>

<form action="<?= base_url('template/upload') ?>" method="post" enctype="multipart/form-data">
    <?= csrf_field() ?>
    <input type="file" name="template" accept=".docx" required>
    <button class="btn btn-primary" type="submit">Upload</button>
</form>

<hr>

<h4>Template yang tersedia:</h4>
<ul>
<?php foreach ($templates as $t): ?>
    <li><?= esc($t) ?></li>
<?php endforeach ?>
</ul>

<?= $this->endSection() ?>
