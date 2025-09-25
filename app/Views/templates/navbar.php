<nav class="app-header navbar navbar-expand bg-body">
  <!--begin::Container-->
  <div class="container-fluid">
    <!--begin::Start Navbar Links-->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-lte-toggle="sidebar" href="#"><i class="fas fa-bars"></i></a>
      </li>
    </ul>
    <?php if (session('role_user') == '99') {
      $role = 'Admin';
    } else {
      $role = 'Operator';
    }
    ?>
    <!--end::Start Navbar Links-->
    <!--begin::End Navbar Links-->
    <ul class="navbar-nav ms-auto">
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button">
          <?= session('nama_lengkap') ?? 'User' ?>
        </a>
        <ul class="dropdown-menu dropdown-menu-end">
          <li class="dropdown-item text-muted"><?= $role ?? 'Role Tidak Ditemukan' ?> </li>
          <li>
            <hr class="dropdown-divider">
          </li>
          <li><a class="dropdown-item" href="<?= base_url('logout') ?>">Logout</a></li>
        </ul>
      </li>
    </ul>
    <!--end::End Navbar Links-->
  </div>
  <!--end::Container-->
</nav>
<!--end::Header-->