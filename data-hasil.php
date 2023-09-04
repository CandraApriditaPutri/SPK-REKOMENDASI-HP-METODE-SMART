<?php
session_start();
include 'koneksi.php';
if (!isset($_SESSION['nama']) && !isset($_SESSION['level'])) {
    header("Location: index.php");
    exit;
}

if (!isset($_GET['validasi'])) {
    header("Location: 404.php");
    exit;
} else {
    $validasi = $_GET['validasi'];
}
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
    <link rel="stylesheet" type="text/css" href="css/jquery.dataTables.css">
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
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Keluar dari Sistem </h1>
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
                    <h1 class="mt-4"><i class="fas fa-cube"></i> Data Hasil</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active">Data Hasil</li>
                    </ol>
                    <div class="row">
                        <div class="col-sm-12">
                            <?php
                            if ($validasi == "sukses") {
                                echo "
                                    <div class='alert alert-success alert-dismissible fade show mb-3' role='alert'>
                                        Proses Perhitungan Berhasil!
                                        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                                    </div>
                                    ";
                            } else if ($validasi == "error") {
                                echo "
                                    <div class='alert alert-danger alert-dismissible fade show mb-3' role='alert'>
                                        Proses perhitungan gagal!
                                        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                                    </div>
                                    ";
                            }
                            ?>
                            <?php
                            $username = $_SESSION['username'];
                            $query = mysqli_query($koneksi, "SELECT alternatif.nama_alternatif AS nama_alternatif FROM peringkat JOIN alternatif ON peringkat.id_alternatif = alternatif.id_alternatif WHERE peringkat.username = '$username' ORDER BY peringkat.nilai_peringkat DESC LIMIT 1");
                            $data_rekom = mysqli_fetch_array($query);
                            ?>
                            <p class="fs-5" style="text-align: justify;">Berdasarkan hasil perhitungan Sistem Pendukung Keputusan dengan menggunakan metode SMART, didapatkan bahwa <span class="fw-bold">"<?= $data_rekom['nama_alternatif']; ?>"</span> adalah jenis Smartphone yang paling direkomendasikan untuk anda.</p>
                            <div class="table-responsive" action="proses.php" method="post">
                                <table class="table table-bordered" width="100%">
                                    <thead class="bg-primary">
                                        <tr>
                                            <th class="text-center text-white">No.</th>
                                            <th class="text-center text-white">Kode Alternatif</th>
                                            <th class="text-center text-white">Nama Alternatif</th>
                                            <th class="text-center text-white">Nilai Akhir</th>
                                            <th class="text-center text-white">Peringkat</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $username = $_SESSION['username'];
                                        $query = mysqli_query($koneksi, "SELECT alternatif.kode_alternatif AS kode, alternatif.nama_alternatif AS nama, peringkat.nilai_peringkat AS nilai FROM alternatif JOIN peringkat ON alternatif.id_alternatif = peringkat.id_alternatif WHERE peringkat.username = '$username' ORDER BY peringkat.nilai_peringkat DESC");
                                        $no = 1;
                                        while ($baris = mysqli_fetch_array($query)) {
                                        ?>
                                            <tr>
                                                <td class="text-center"><?= $no; ?></td>
                                                <td class="text-center"><?= $baris['kode']; ?></td>
                                                <td class="text-center"><?= $baris['nama']; ?></td>
                                                <td class="text-center"><?= $baris['nilai']; ?></td>
                                                <td class="text-center"><?= $no; ?></td>
                                            </tr>
                                        <?php
                                            $no++;
                                        }
                                        ?>
                                    </tbody>
                                </table>
                                <div class="text-center mb-3">
                                    <a href="print.php?validasi=sukses" class="btn btn-primary">Print hasil</a>
                                </div>
                            </div>
                        </div>
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
    <script src="https://code.jquery.com/jquery-3.6.3.js"></script>
    <script src="js/jquery.dataTables.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#data-kriteria').DataTable();
        })

        $('#pilih_semua').click(function() {
            $(this.form.elements).filter(':checkbox').prop('checked', this.checked);
        });
    </script>
</body>

</html>