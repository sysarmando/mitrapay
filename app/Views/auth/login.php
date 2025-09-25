<?= $this->extend('templates/blank') ?>

<?= $this->section('content') ?>
<style>
    :root {
        --bps-blue: #00529c;
        --bps-yellow: #ffc107;
        --bps-light: #f8f9fa;
    }

    body {
        background-color: var(--bps-light);
        min-height: 100vh;
        margin: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .login-wrapper {
        display: flex;
        justify-content: center;
        align-items: center;
        width: 100%;
        height: 100vh;
        padding: 20px;
    }

    .login-container {
        width: 100%;
        max-width: 400px;
        margin: auto; /* Untuk memastikan centering horizontal */
    }

    .login-card {
        border: none;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 0.5rem 1.5rem rgba(0, 0, 0, 0.1);
    }

    .login-header {
        background-color: rgba(190, 175, 175, 0.1);
        color: white;
        padding: 20px;
        text-align: center;
    }

    .login-header img {
        height: 70px;
        /* margin-bottom: 15px; */
    }

    .login-header h3 {
        color: var(--bps-yellow);
        font-weight: bold;
        margin-bottom: 5px;
    }

    .login-body {
        padding: 30px;
        background-color: white;
    }

    .form-control:focus {
        border-color: var(--bps-blue);
        box-shadow: 0 0 0 0.25rem rgba(0, 82, 156, 0.25);
    }

    .btn-bps {
        background-color: var(--bps-blue);
        color: white;
        font-weight: bold;
    }

    .btn-bps:hover {
        background-color: #003d6f;
        color: white;
    }

    .input-group-text {
        background-color: var(--bps-blue);
        color: white;
        border-color: var(--bps-blue);
    }

    .login-footer {
        background-color: var(--bps-blue);
        color: white;
        padding: 15px;
        text-align: center;
        font-size: 0.8rem;
    }

    .login-footer img {
        height: 25px;
        filter: brightness(0) invert(1);
        margin-right: 10px;
    }
</style>

<div class="login-wrapper">
    <div class="login-container">
        <div class="card login-card">
            <!-- Header -->
            <div class="login-header">
                <img src="<?= base_url('assets/logo-bps-kota-ambon.png') ?>" alt="Logo BPS">
                <!-- <h3>PST</h3> -->
                <!-- <p>BPS KOTA AMBON</p> -->
            </div>

            <!-- Body -->
            <div class="login-body">
                <?php if (session()->getFlashdata('error')) : ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <?= session()->getFlashdata('error') ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <form action="<?= base_url('login') ?>" method="post">
                    <?= csrf_field() ?>

                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <div class="input-group">
                            <input type="text" name="username" id="username" class="form-control" placeholder="Masukkan username" required autofocus>
                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="password" class="form-label">Password</label>
                        <div class="input-group">
                            <input type="password" name="password" id="password" class="form-control" placeholder="Masukkan password" required>
                            <span class="input-group-text" onclick="togglePassword()">
                                <i class="fas fa-eye" id="eyeIcon"></i>
                            </span>
                        </div>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-bps btn-lg py-2">
                            <i class="fas fa-sign-in-alt me-2"></i> LOGIN
                        </button>
                    </div>
                </form>
            </div>

            <!-- Footer -->
            <div class="login-footer">
                <div class="d-flex justify-content-center align-items-center">
                    <img src="<?= base_url('assets/logo-bps.png') ?>" alt="Logo BPS">
                    <small>BPS Kota Ambon © <?= date('Y') ?></small>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function togglePassword() {
    const passwordInput = document.getElementById('password');
    const eyeIcon = document.getElementById('eyeIcon');
    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        eyeIcon.classList.remove('fa-eye');
        eyeIcon.classList.add('fa-eye-slash');
    } else {
        passwordInput.type = 'password';
        eyeIcon.classList.remove('fa-eye-slash');
        eyeIcon.classList.add('fa-eye');
    }
}
</script>

<?= $this->endSection() ?>