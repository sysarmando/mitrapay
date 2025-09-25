<!DOCTYPE html>
<html lang="id">

<head>
    <?= $this->include('templates/parts/head') ?>
</head>

  <body class="layout-fixed sidebar-expand-lg sidebar-mini bg-body-tertiary">
    <div class="app-wrapper">

        <!-- NAVBAR -->
        <?= $this->include('templates/navbar') ?>

        <!-- SIDEBAR -->
        <?= $this->include('templates/sidebar') ?>

        <!-- CONTENT -->
        <main class="app-main">
            <div class="content-wrapper">
                <div class="content pt-3 px-3">
                    <?= $this->renderSection('content') ?>
                </div>
            </div>

        </main>
        <!-- FOOTER -->
        <?= $this->include('templates/footer') ?>
    </div>

    <?= $this->include('templates/parts/scripts') ?>
    <?= $this->renderSection('js') ?>
</body>

</html>