<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="<?= base_url('mitra') ?>" class="brand-link text-center">
        <img src="<?= base_url('assets/logo-bps.png') ?>" alt="Logo BPS" class="brand-image img-circle"
            style="opacity: .8; width: 40px;">
        <span class="brand-text fw-bold">Mitra</span>
    </a>

    <div class="sidebar">
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">

                <li class="nav-item">
                    <a href="<?= base_url('mitra') ?>" class="nav-link">
                        <i class="nav-icon fas fa-users"></i>
                        <p>Daftar Mitra</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="<?= base_url('mitra/kegiatan') ?>" class="nav-link">
                        <i class="nav-icon fas fa-briefcase"></i>
                        <p>Daftar Kegiatan</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="<?= base_url('mitra/laporan-honor') ?>" class="nav-link">
                        <i class="nav-icon fas fa-money-check-dollar"></i>
                        <p>Laporan Honor</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="<?= base_url('/logout') ?>" class="nav-link">
                        <i class="nav-icon fas fa-sign-out-alt"></i>
                        <p>Logout</p>
                    </a>
                </li>

            </ul>
        </nav>
    </div>
</aside>