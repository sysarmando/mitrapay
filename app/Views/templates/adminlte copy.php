<!DOCTYPE html>
<html lang="id">

<head>
    <?= $this->include('templates/parts/head') ?>
</head>

<body class="layout-fixed sidebar-mini">
    <div class="wrapper">

        <!-- NAVBAR -->
        <?= $this->include('templates/navbar') ?>

        <!-- SIDEBAR -->
        <?= $this->include('templates/sidebar') ?>

        <!-- CONTENT -->
        <div class="content-wrapper">
            <div class="content pt-3 px-3">
                <?= $this->renderSection('content') ?>
            </div>
        </div>

        <!-- FOOTER -->
        <?= $this->include('templates/footer') ?>

    </div>

    <?= $this->include('templates/parts/scripts') ?>
    <?= $this->renderSection('js') ?>
</body>

</html>