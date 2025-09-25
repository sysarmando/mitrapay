<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title><?= $title ?? 'Form Kepuasan' ?></title>
    <link rel="icon" type="image/png" href="<?= base_url('assets/favicon.png') ?>">

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- FontAwesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f8f9fa;
        }

        .rating-btn {
            padding: 20px;
            margin: 5px;
            border-radius: 10px !important;
            transition: all 0.3s;
        }

        .rating-btn:hover {
            transform: scale(1.05);
        }

        .rating-btn.active {
            transform: scale(1.1);
            font-weight: bold;
        }

        .card {
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }

        .chart-container {
            max-width: 400px;
            margin: 0 auto;
        }

        @media (max-width: 576px) {
            .chart-container {
                max-width: 100%;
            }
        }
    </style>
</head>

<body class="d-flex align-items-center min-vh-100">
    <div class="container py-5">
        <?= $this->renderSection('content') ?>
    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    <script>
        $(document).ready(function() {
            $('.rating-btn').click(function() {
                $('.rating-btn').removeClass('active');
                $(this).addClass('active');
            });
        });
    </script>
    <?= $this->renderSection('js') ?>

</body>

</html>