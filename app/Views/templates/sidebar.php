<!--begin::Sidebar-->
<aside class="app-sidebar bg-body-secondary shadow " data-bs-theme="dark">
  <!--begin::Sidebar Brand-->
  <div class="sidebar-brand">
    <!--begin::Brand Link-->
    <a href="<?= base_url('mitra') ?>" class="brand-link text-center">
      <img src="<?= base_url('assets/logo-bps.png') ?>" alt="Logo BPS" class="brand-image img-circle"
        style="opacity: .8; width: 40px;">
      <span class="brand-text fw-bold">MitraPay</span>
    </a>
    <!--end::Brand Link-->
  </div>
  <!--end::Sidebar Brand-->
  <!--begin::Sidebar Wrapper-->
  <div class="sidebar-wrapper">
    <nav class="mt-2">
      <!--begin::Sidebar Menu-->
      <ul
        class="nav sidebar-menu flex-column"
        data-lte-toggle="treeview"
        role="menu"
        data-accordion="false">
        <<li class="nav-item">
          <a href="<?= base_url('mitra') ?>" class="nav-link">
            <i class="nav-icon fas fa-users"></i>
            <p>Daftar Mitra</p>
          </a>
          </li>

          <li class="nav-item">
            <a href="<?= base_url('mitra/kegiatan') ?>" class="nav-link">
              <i class="nav-icon fas fa-briefcase"></i>
              <p>Daftar Kegiatan Statistik</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="<?= base_url('mitra/laporan-honor') ?>" class="nav-link">
              <i class="nav-icon fas fa-money-check-dollar"></i>
              <p>Monitoring Honor</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="<?= base_url('/logout') ?>" class="nav-link">
              <i class="nav-icon fas fa-sign-out-alt"></i>
              <p>Logout</p>
            </a>
          </li>
      </ul>
      <!--end::Sidebar Menu-->
    </nav>
  </div>
  <!--end::Sidebar Wrapper-->
</aside>
<!--end::Sidebar-->