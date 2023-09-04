<?php
session_start();
include 'koneksi.php';
if (!isset($_SESSION['nama']) && !isset($_SESSION['level'])) {
    header("Location: index.php");
    exit;
}

if ($_SESSION['level'] != "Admin") {
    header("Location: menu-utama.php");
    exit();
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
                    <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#keluar" s>Keluar</a></li>
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
                    <h1 class="mt-4"><i class="fas fa-cube"></i> Data Kriteria</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active">Data Kriteria</li>
                    </ol>
                    <div class="row">
                        <div class="col-sm-12">
                            <?php
                            if ($validasi == "sukses-tambah") {
                                echo "
                                    <div class='alert alert-success alert-dismissible fade show mb-3' role='alert'>
                                        Data Kriteria berhasil ditambahkan!
                                        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                                    </div>
                                    ";
                            } else if ($validasi == "sukses-perbarui") {
                                echo "
                                    <div class='alert alert-success alert-dismissible fade show mb-3' role='alert'>
                                        Data Kriteria berhasil diperbarui!
                                        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                                    </div>
                                    ";
                            } else if ($validasi == "sukses-hapus") {
                                echo "
                                    <div class='alert alert-success alert-dismissible fade show mb-3' role='alert'>
                                        Data Kriteria berhasil dihapus!
                                        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                                    </div>
                                    ";
                            } else if ($validasi == "error") {
                                echo "
                                    <div class='alert alert-danger alert-dismissible fade show mb-3' role='alert'>
                                        Proses gagal!
                                        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                                    </div>
                                    ";
                            } else if ($validasi == "warning") {
                                echo "
                                    <div class='alert alert-warning alert-dismissible fade show mb-3' role='alert'>
                                        Kode kriteria telah digunakan, Silahkan gunakan kode kriteria yang berbeda!
                                        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                                    </div>
                                    ";
                            }
                            ?>
                            <a class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambah_data"><i class="fas fa-plus"></i> Tambah data</a>
                            <div class="modal fade" id="tambah_data" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Data Kriteria</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form action="proses.php" method="post">
                                            <div class="modal-body">
                                                <div class="form-floating mb-3">
                                                    <input name="kode" class="form-control" id="inputEmail" type="text" placeholder="Kode Kriteria" pattern="[A-Za-z0-9]+" oninvalid="this.setCustomValidity('Tidak Boleh Simbol')" oninput="setCustomValidity('')" required autocomplete="off" />
                                                    <label for="inputEmail">Kode Kriteria</label>
                                                </div>
                                                <div class="form-floating mb-3">
                                                    <input name="nama" class="form-control" id="inputEmail" type="text" placeholder="Nama Kriteria" pattern="[A-Za-z ]+" oninvalid="this.setCustomValidity('Input hanya huruf')" oninput="setCustomValidity('')" required autocomplete="off" />
                                                    <label for="inputEmail">Nama Kriteria</label>
                                                </div>
                                                <div class="form-floating mb-3">
                                                    <input name="bobot" class="form-control" id="inputEmail" type="text" placeholder="Bobot Kriteria" pattern="[0-9]{1,2}" oninvalid="this.setCustomValidity('Input hanya angka 2 digit')" oninput="setCustomValidity('')" required autocomplete="off" />
                                                    <label for="inputEmail">Bobot Kriteria</label>
                                                </div>
                                                <div class="form-floating mb-3">
                                                    <select name="jenis" class="form-select" id="floatingSelect" aria-label="Floating label select example" required>
                                                        <option></option>
                                                        <option value="Benefit">Benefit</option>
                                                        <option value="Cost">Cost</option>
                                                    </select>
                                                    <label for="floatingSelect">Jenis Kriteria</label>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <a class="btn btn-secondary" data-bs-dismiss="modal">Tutup</a>
                                                <button name="tambah-kriteria" class="btn btn-primary">Tambah</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive mt-3">
                                <table id="data-kriteria" class="cell-bordered display" width="100%">
                                    <thead class="bg-primary">
                                        <tr>
                                            <th class="text-center text-white">No.</th>
                                            <th class="text-center text-white">Kode Kriteria</th>
                                            <th class="text-center text-white">Nama Kriteria</th>
                                            <th class="text-center text-white">Bobot</th>
                                            <th class="text-center text-white">Jenis</th>
                                            <th class="text-center text-white">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $query = mysqli_query($koneksi, "SELECT * FROM kriteria");
                                        $no = 1;
                                        while ($baris = mysqli_fetch_array($query)) {
                                            echo "
                                                <tr>
                                                    <td class='text-center'>" . $no . "</td>
                                                    <td class='text-center'>" . $baris['kode_kriteria'] . "</td>
                                                    <td class='text-center'>" . $baris['nama_kriteria'] . "</td>
                                                    <td class='text-center'>" . ($baris['bobot_kriteria'] * 100) . "%</td>
                                                    <td class='text-center'>" . $baris['jenis_kriteria'] . "</td>
                                                    <td class='text-center'>
                                                        <div class='d-flex justify-content-center'>
                                                            <a class='btn btn-warning me-2' data-bs-toggle='modal' data-bs-target='#edit_data" . $baris['id_kriteria'] . "'><i class='fas fa-pencil'></i></a>
                                                            <a class='btn btn-danger' data-bs-toggle='modal' data-bs-target='#hapus_data" . $baris['id_kriteria'] . "'><i class='fas fa-trash'></i></a>
                                                        </div>
                                                    </td>
                                                </tr>
                                                ";
                                            $no++;
                                        }
                                        ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th></th>
                                            <th></th>
                                            <th class="text-end">Total Bobot</th>
                                            <th class="text-center">
                                                <?php
                                                $baris = mysqli_fetch_array(mysqli_query($koneksi, "SELECT CAST(SUM(bobot_kriteria) AS DECIMAL(10,2)) AS bobot FROM kriteria"));
                                                echo ($baris['bobot'] * 100) . "%";
                                                ?>
                                            </th>
                                            <th></th>
                                            <th></th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <?php
                            $query = mysqli_query($koneksi, "SELECT * FROM kriteria");
                            while ($baris = mysqli_fetch_array($query)) {
                                $id = $baris['id_kriteria'];
                            ?>
                                <div class="modal fade" id="edit_data<?= $id; ?>" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Data Kriteria</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <form action="proses.php" method="post">
                                                <div class="modal-body">
                                                    <?php
                                                    $baris = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM kriteria WHERE id_kriteria = '$id'"));
                                                    ?>
                                                    <div class="form-floating mb-3">
                                                        <input type="hidden" name="id" value="<?= $id; ?>">
                                                        <input name="kode" class="form-control" id="inputEmail" type="text" placeholder="Kode Kriteria" value="<?= $baris['kode_kriteria']; ?>" readonly />
                                                        <label for="inputEmail">Kode Kriteria</label>
                                                    </div>
                                                    <div class="form-floating mb-3">
                                                        <input name="nama" class="form-control" id="inputEmail" type="text" placeholder="Nama Kriteria" pattern="[A-Za-z ]+" oninvalid="this.setCustomValidity('Input hanya huruf')" oninput="setCustomValidity('')" value="<?= $baris['nama_kriteria']; ?>" required autocomplete="off" />
                                                        <label for="inputEmail">Nama Kriteria</label>
                                                    </div>
                                                    <div class="form-floating mb-3">
                                                        <input name="bobot" class="form-control" id="inputEmail" type="text" placeholder="Bobot Kriteria" pattern="[0-9]{1,2}" oninvalid="this.setCustomValidity('Input hanya angka 2 digit')" oninput="setCustomValidity('')" value="<?= $baris['bobot_kriteria'] * 100; ?>" required autocomplete="off" />
                                                        <label for="inputEmail">Bobot Kriteria</label>
                                                    </div>
                                                    <div class="form-floating mb-3">
                                                        <select name="jenis" class="form-select" id="floatingSelect" aria-label="Floating label select example" required>
                                                            <option></option>
                                                            <option value="Benefit" <?php if ($baris['jenis_kriteria'] == "Benefit") {
                                                                                        echo "selected";
                                                                                    } ?>>Benefit</option>
                                                            <option value="Cost" <?php if ($baris['jenis_kriteria'] == "Cost") {
                                                                                        echo "selected";
                                                                                    } ?>>Cost</option>
                                                        </select>
                                                        <label for="floatingSelect">Jenis Kriteria</label>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <a class="btn btn-secondary" data-bs-dismiss="modal">Tutup</a>
                                                    <button name="edit-kriteria" class="btn btn-primary">Edit</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal fade" id="hapus_data<?= $id; ?>" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="exampleModalLabel">Hapus Data Kriteria</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <form>
                                                <div class="modal-body">
                                                    <p>Apakah anda yakin ingin menghapus kriteria yang dipilih?</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <a class="btn btn-secondary" data-bs-dismiss="modal">Tidak</a>
                                                    <a href="hapus-data-kriteria.php?id=<?= $id; ?>" class="btn btn-danger">Ya</a>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            <?php
                            }
                            ?>
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
    </script>
</body>

</html>