<?php
session_start();
if (!isset($_SESSION['nama']) && !isset($_SESSION['level'])) {
    header("Location: index.php");
    exit;
}
$validasi = isset($_GET['validasi']) ? trim($_GET['validasi']) : "";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Sistem Pendukung Keputusan Metode SMART</title>
    <link rel="icon" type="image/x-icon" href="assets/img/logo.png" />
    <link href="css/styles_dash.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
</head>

<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-primary hstack gap-3">
        <!-- Navbar Brand-->
        <a class="navbar-brand ps-3" href="menu-utama.php">Smartphone</a>
        <!-- Sidebar Toggle-->
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
        <!-- Navbar-->
        <ul class="navbar-nav ms-auto pe-2">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="#!"><?= $_SESSION['username']; ?></a></li>
                    <li><a class="dropdown-item" href="data-profile.php">Profil</a></li>
                    <li>
                        <hr class="dropdown-divider" />
                    </li>
                    <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#keluar">Keluar</a></li>
                </ul>
            </li>
        </ul>
    </nav>
    <div class="modal fade" id="keluar" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Keluar dari Sistem</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form>
                    <div class="modal-body">
                        <p>Apakah anda yakin ingin Keluar?</p>
                    </div>
                    <div class="modal-footer">
                        <a class="btn btn-secondary" data-bs-dismiss="modal">Tidak</a>
                        <a href="keluar.php" class="btn btn-danger">Ya</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-light" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <div class="sb-sidenav-menu-heading">Menu Utama</div>
                        <a class="nav-link" href="menu-utama.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-home"></i></div>
                            Dashboard
                        </a>
                        <div class="sb-sidenav-menu-heading">Proses</div>
                        <?php
                        if ($_SESSION['level'] == "Admin") {
                            echo "
                            <a class='nav-link' href='data-kriteria.php'>
                                <div class='sb-nav-link-icon'><i class='fas fa-cube'></i></div>
                                Data Kriteria
                            </a>
                            <a class='nav-link' href='data-subkriteria.php'>
                                <div class='sb-nav-link-icon'><i class='fas fa-cube'></i></div>
                                Data Subkriteria
                            </a>
                            ";
                        }
                        ?>
                        <a class="nav-link" href="data-alternatif.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-cube"></i></div>
                            Data Alternatif
                        </a>
                        <a class="nav-link" href="data-perhitungan.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-calculator"></i></div>
                            Data Perhitungan
                        </a>
                        <div class="sb-sidenav-menu-heading">Pengguna</div>
                        <a class="nav-link" href="data-profile.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-user"></i></div>
                            Data Profil
                        </a>
                        <?php
                        if ($_SESSION['level'] == "Admin") {
                            echo "
                            <a class='nav-link' href='data-pengguna.php'>
                                <div class='sb-nav-link-icon'><i class='fas fa-users'></i></div>
                                Data Pengguna
                            </a>
                            ";
                        }
                        ?>
                        <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#keluar">
                            <div class="sb-nav-link-icon"><i class="fas fa-sign-out-alt"></i></div>
                            Keluar
                        </a>
                    </div>
                </div>
                <div class="sb-sidenav-footer">
                    <div class="small">Masuk sebagai:</div>
                    <?= $_SESSION['username']; ?>
                </div>
            </nav>
        </div>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4"><i class="fas fa-home"></i> Dashboard</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                    <?php
                    if ($validasi == "sukses") {
                        echo "
                        <div class='alert alert-success alert-dismissible fade show' role='alert'>
                            Selamat datang " . $_SESSION['level'] . "! Anda dapat menggunakan sistem dengan pilihan menu yang ada di bawah ini.
                            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                        </div>
                        ";
                    }
                    ?>
                    <div class="row">
                        <?php
                        if ($_SESSION['level'] == "Admin") {
                            echo "
                            <div class='col-sm-4'>
                                <div class='card mb-4 border-bs-primary'>
                                    <div class='card-body'>
                                        <h5 class='card-title'>Data Kriteria</h5>
                                    </div>
                                    <div class='card-footer'>
                                        <a class='text-dark' href='data-kriteria.php'>Lihat Detail<i class='fas fa-chevron-right ms-2'></i></a>
                                    </div>
                                </div>
                            </div>
                            <div class='col-sm-4'>
                                <div class='card mb-4 border-bs-primary'>
                                    <div class='card-body'>
                                        <h5 class='card-title'>Data Subkriteria</h5>
                                    </div>
                                    <div class='card-footer'>
                                        <a class='text-dark' href='data-subkriteria.php'>Lihat Detail<i class='fas fa-chevron-right ms-2'></i></a>
                                    </div>
                                </div>
                            </div>
                            ";
                        }
                        ?>
                        <div class="col-sm-4">
                            <div class="card mb-4 border-bs-primary">
                                <div class="card-body">
                                    <h5 class="card-title">Data Alternatif</h5>
                                </div>
                                <div class="card-footer">
                                    <a class="text-dark" href="data-alternatif.php">Lihat Detail<i class="fas fa-chevron-right ms-2"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="card mb-4 border-bs-primary">
                                <div class="card-body">
                                    <h5 class="card-title">Data Perhitungan</h5>
                                </div>
                                <div class="card-footer">
                                    <a class="text-dark" href="data-perhitungan.php">Lihat Detail<i class="fas fa-chevron-right ms-2"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="card mb-4 border-bs-primary">
                                <div class="card-body">
                                    <h5 class="card-title">Data Profil</h5>
                                </div>
                                <div class="card-footer">
                                    <a class="text-dark" href="data-profile.php">Lihat Detail<i class="fas fa-chevron-right ms-2"></i></a>
                                </div>
                            </div>
                        </div>
                        <?php
                        if ($_SESSION['level'] == "Admin") {
                            echo "
                            <div class='col-sm-4'>
                                <div class='card mb-4 border-bs-primary'>
                                    <div class='card-body'>
                                        <h5 class='card-title'>Data Pengguna</h5>
                                    </div>
                                    <div class='card-footer'>
                                        <a class='text-dark' href='data-pengguna.php'>Lihat Detail<i class='fas fa-chevron-right ms-2'></i></a>
                                    </div>
                                </div>
                            </div>
                            ";
                        }
                        ?>
                    </div>
                </div>
            </main>
            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">By : Candra Apridita dan Diska Oktavia ^-^</div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts_dash.js"></script>
</body>

</html>