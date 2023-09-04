<?php
session_start();
include 'koneksi.php';
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
                    <li><a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#keluar">Keluar</a></li>
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
                    <h1 class="mt-4"><i class="fas fa-cube"></i> Data Alternatif</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active">Data Alternatif</li>
                    </ol>
                    <div class="row">
                        <div class="col-sm-12">
                            <?php
                            if ($validasi == "sukses-tambah") {
                                echo "
                                    <div class='alert alert-success alert-dismissible fade show mb-3' role='alert'>
                                        Data Alternatif berhasil ditambahkan!
                                        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                                    </div>
                                    ";
                            } else if ($validasi == "sukses-perbarui") {
                                echo "
                                    <div class='alert alert-success alert-dismissible fade show mb-3' role='alert'>
                                        Data Alternatif berhasil diperbarui!
                                        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                                     </div>
                                        ";
                            } else if ($validasi == "sukses-hapus") {
                                echo "
                                     <div class='alert alert-success alert-dismissible fade show mb-3' role='alert'>
                                        Data Alternatif berhasil dihapus!
                                            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                                    </div>
                                    ";
                            } else if ($validasi == "error") {
                                echo "
                                    <div class='alert alert-danger alert-dismissible fade show mb-3' role='alert'>
                                        Proses Gagal!
                                        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                                    </div>
                                    ";
                            } else if ($validasi == "warning") {
                                echo "
                                    <div class='alert alert-warning alert-dismissible fade show mb-3' role='alert'>
                                        Kode alternatif telah digunakan, Silahkan gunakan kode alternatif yang berbeda!
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
                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Data Alternatif</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form action="proses.php" method="post">
                                            <div class="modal-body">
                                                <div class="form-floating mb-3">
                                                    <input name="kode" class="form-control" id="inputEmail" type="text" placeholder="Kode Alternatif" pattern="[A-Za-z0-9]+" oninvalid="this.setCustomValidity('Tidak Boleh Simbol')" oninput="setCustomValidity('')" required autocomplete="off" />
                                                    <label for="inputEmail">Kode Alternatif</label>
                                                </div>
                                                <div class="form-floating mb-3">
                                                    <input name="nama" class="form-control" id="inputEmail" type="text" placeholder="Nama Alternatif" required autocomplete="off" />
                                                    <label for="inputEmail">Nama Alternatif</label>
                                                </div>
                                                <?php
                                                $query = mysqli_query($koneksi, "SELECT * FROM kriteria");
                                                while ($baris = mysqli_fetch_array($query)) {
                                                    $id_kriteria = $baris['id_kriteria'];
                                                ?>
                                                    <div class="form-floating mb-3">
                                                        <input type="hidden" name="kriteria[]" value="<?= $id_kriteria; ?>">
                                                        <input type="hidden" name="user" value="<?= $_SESSION['username']; ?>">
                                                        <select name="subkriteria[]" class="form-select" id="floatingSelect" aria-label="Floating label select example" required>
                                                            <option></option>
                                                            <?php
                                                            $select = mysqli_query($koneksi, "SELECT * FROM subkriteria WHERE id_kriteria = '$id_kriteria'");
                                                            while ($option = mysqli_fetch_array($select)) {
                                                                echo "
                                                                <option value='" . $option['id_subkriteria'] . "'>" . $option['nama_subkriteria'] . "</option>
                                                                ";
                                                            }
                                                            ?>
                                                        </select>
                                                        <label for="floatingSelect"><?= $baris['nama_kriteria']; ?></label>
                                                    </div>
                                                <?php
                                                }
                                                ?>
                                            </div>
                                            <div class="modal-footer">
                                                <a class="btn btn-secondary" data-bs-dismiss="modal">Tutup</a>
                                                <button name="tambah-alternatif" class="btn btn-primary">Tambah</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="modal fade" id="sample" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Contoh bagian belakang kemasan</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form>
                                            <div class="modal-body text-center">
                                                <img src="assets/img/sample.jpg" width="90%">
                                            </div>
                                            <div class="modal-footer">
                                                <a class="btn btn-secondary" data-bs-dismiss="modal">Tutup</a>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive mt-3">
                                <?php
                                if ($_SESSION['level'] == "User") {
                                ?>
                                    <p class="text-danger fst-italic">*anda dapat melihat data alternatif (data Smartphone) yang telah di tambahkan oleh admin secara detail dengan cara klik logo "mata" pada tabel detail.</p>
                                    <p class="text-danger fst-italic">*anda dapat menambahkan data alternatif (data Smartphone) yang anda ketahui, dengan cara menekan tombol "Tambah Data". Setelah itu, Anda dapat mengisi nama alternatif (nama Smartphone), chipset, kapasitas memori atau RAM, 
                                        penyimpanan atau ROM, megapixel kamera depan, megapixel kamera belakang, CPU, versi OS, harga, kapasitas baterai, ukuran display yang dapat dilihat pada disbox Smartphone tersebut. <a href="#" data-bs-toggle="modal" data-bs-target="#sample">Klik disini</a> untuk melihat contoh dari belakang kemasan untuk mengisi kriteria.</p>
                                <?php
                                }
                                ?>
                                <table id="data-alternatif" class="cell-bordered display" width="100%">
                                    <thead class="bg-primary">
                                        <tr>
                                            <th class="text-center text-white">No.</th>
                                            <th class="text-center text-white">Kode Alternatif</th>
                                            <th class="text-center text-white">Nama Alternatif</th>
                                            <th class="text-center text-white">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $get_admin_user = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM pengguna WHERE level = 'Admin' ORDER BY id_pengguna ASC LIMIT 1"));
                                        $username1 = $_SESSION['username'];
                                        $username2 = $get_admin_user['username'];
                                        $query = mysqli_query($koneksi, "SELECT * FROM alternatif WHERE username = '$username1' OR username = '$username2'");
                                        $no = 1;
                                        while ($baris = mysqli_fetch_array($query)) {
                                        ?>
                                            <tr>
                                                <td class="text-center"><?= $no; ?></td>
                                                <td class="text-center"><?= $baris['kode_alternatif']; ?></td>
                                                <td class="text-center"><?= $baris['nama_alternatif']; ?></td>
                                                <td class="text-center">
                                                    <?php
                                                    if ($_SESSION['level'] == "Admin") {
                                                    ?>
                                                        <div class='d-flex justify-content-center'>
                                                            <a class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#view_data<?= $baris['id_alternatif']; ?>"><i class="fas fa-eye"></i></a>
                                                            <a class="btn btn-warning me-2" data-bs-toggle="modal" data-bs-target="#edit_data<?= $baris['id_alternatif']; ?>"><i class="fas fa-pencil"></i></a>
                                                            <a class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#hapus_data<?= $baris['id_alternatif']; ?>"><i class="fas fa-trash"></i></a>
                                                        </div>
                                                    <?php
                                                    } else if ($_SESSION['level'] == "User" && $username1 == $baris['username']) {
                                                    ?>
                                                        <div class='d-flex justify-content-center'>
                                                            <a class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#view_data<?= $baris['id_alternatif']; ?>"><i class="fas fa-eye"></i></a>
                                                            <a class="btn btn-warning me-2" data-bs-toggle="modal" data-bs-target="#edit_data<?= $baris['id_alternatif']; ?>"><i class="fas fa-pencil"></i></a>
                                                            <a class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#hapus_data<?= $baris['id_alternatif']; ?>"><i class="fas fa-trash"></i></a>
                                                        </div>
                                                    <?php
                                                    } else if ($_SESSION['level'] == "User" && $username1 != $baris['username']) {
                                                    ?>
                                                        <a class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#view_data<?= $baris['id_alternatif']; ?>"><i class="fas fa-eye"></i></a>
                                                    <?php
                                                    }
                                                    ?>
                                                </td>
                                            </tr>
                                        <?php
                                            $no++;
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                            <?php
                            $query = mysqli_query($koneksi, "SELECT * FROM alternatif");
                            while ($baris = mysqli_fetch_array($query)) {
                                $id = $baris['id_alternatif'];
                            ?>
                                <div class="modal fade" id="edit_data<?= $id; ?>" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Data Alternatif</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <form action="proses.php" method="post">
                                                <div class="modal-body">
                                                    <?php
                                                    $baris_sub = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM alternatif WHERE id_alternatif = '$id'"));
                                                    ?>
                                                    <div class="form-floating mb-3">
                                                        <input type="hidden" name="id" value="<?= $id; ?>">
                                                        <input name="kode" class="form-control" id="inputEmail" type="text" placeholder="Kode Alternatif" value="<?= $baris_sub['kode_alternatif']; ?>" readonly />
                                                        <label for="inputEmail">Kode Alternatif</label>
                                                    </div>
                                                    <div class="form-floating mb-3">
                                                        <input name="nama" class="form-control" id="inputEmail" type="text" placeholder="Nama Alternatif" value="<?= $baris_sub['nama_alternatif']; ?>" required autocomplete="off" />
                                                        <label for="inputEmail">Nama Alternatif</label>
                                                    </div>
                                                    <?php
                                                    $query_sub = mysqli_query($koneksi, "SELECT * FROM kriteria");
                                                    $matriks = mysqli_query($koneksi, "SELECT * FROM matriks WHERE id_alternatif = '$id'");
                                                    while ($baris_sub = mysqli_fetch_array($query_sub)) {
                                                        $selected = mysqli_fetch_array($matriks);
                                                        $id_kriteria = $baris_sub['id_kriteria'];
                                                    ?>
                                                        <div class="form-floating mb-3">
                                                            <input type="hidden" name="kriteria[]" value="<?= $id_kriteria; ?>">
                                                            <input type="hidden" name="user" value="<?= $_SESSION['username']; ?>">
                                                            <select name="subkriteria[]" class="form-select" id="floatingSelect" aria-label="Floating label select example" required>
                                                                <option></option>
                                                                <?php
                                                                $select = mysqli_query($koneksi, "SELECT * FROM subkriteria WHERE id_kriteria = '$id_kriteria'");
                                                                while ($option = mysqli_fetch_array($select)) {
                                                                    $kondisi_null = isset($selected['id_subkriteria']) ? trim($selected['id_subkriteria']) : "";
                                                                ?>
                                                                    <option value="<?= $option['id_subkriteria']; ?>" <?php if ($option['id_subkriteria'] == $kondisi_null) {echo "selected";
                                                                    } ?>><?= $option['nama_subkriteria']; ?></option>
                                                                <?php
                                                                }
                                                                ?>
                                                            </select>
                                                            <label for="floatingSelect"><?= $baris_sub['nama_kriteria']; ?></label>
                                                        </div>
                                                    <?php
                                                    }
                                                    ?>
                                                </div>
                                                <div class="modal-footer">
                                                    <a class="btn btn-secondary" data-bs-dismiss="modal">Tutup</a>
                                                    <button name="edit-alternatif" class="btn btn-primary">Edit</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal fade" id="view_data<?= $id; ?>" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="exampleModalLabel">Data Alternatif</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <form>
                                                <div class="modal-body">
                                                    <?php
                                                    $baris_sub = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM alternatif WHERE id_alternatif = '$id'"));
                                                    ?>
                                                    <div class="form-floating mb-3">
                                                        <input type="hidden" name="id" value="<?= $id; ?>">
                                                        <input class="form-control" id="inputEmail" type="text" placeholder="Kode Alternatif" value="<?= $baris_sub['kode_alternatif']; ?>" readonly />
                                                        <label for="inputEmail">Kode Alternatif</label>
                                                    </div>
                                                    <div class="form-floating mb-3">
                                                        <input class="form-control" id="inputEmail" type="text" placeholder="Nama Alternatif" value="<?= $baris_sub['nama_alternatif']; ?>" readonly />
                                                        <label for="inputEmail">Nama Alternatif</label>
                                                    </div>
                                                    <?php
                                                    $query_sub = mysqli_query($koneksi, "SELECT * FROM kriteria");
                                                    $matriks = mysqli_query($koneksi, "SELECT * FROM matriks WHERE id_alternatif = '$id'");
                                                    while ($baris_sub = mysqli_fetch_array($query_sub)) {
                                                        $selected = mysqli_fetch_array($matriks);
                                                        $id_sub = isset($selected['id_subkriteria']) ? trim($selected['id_subkriteria']) : "";


                                                        $data_sub = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM subkriteria WHERE id_subkriteria = '$id_sub'"));
                                                        $show_data_sub = isset($data_sub['nama_subkriteria']) ? trim($data_sub['nama_subkriteria']) : "";
                                                    ?>
                                                        <div class="form-floating mb-3">
                                                            <input class="form-control" id="inputEmail" type="text" placeholder="Nama Alternatif" value="<?= $show_data_sub; ?>" readonly />
                                                            <label for="inputEmail"><?= $baris_sub['nama_kriteria']; ?></label>
                                                        </div>
                                                    <?php
                                                    }
                                                    ?>
                                                </div>
                                                <div class="modal-footer">
                                                    <a class="btn btn-secondary" data-bs-dismiss="modal">Tutup</a>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal fade" id="hapus_data<?= $id; ?>" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="exampleModalLabel">Hapus Data Alternatif</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <form>
                                                <div class="modal-body">
                                                    <p>Apakah anda yakin ingin menghapus alternatif yang dipilih?</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <a class="btn btn-secondary" data-bs-dismiss="modal">Tidak</a>
                                                    <a href="hapus-data-alternatif.php?id=<?= $id; ?>" class="btn btn-danger">Ya</a>
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
            $('#data-alternatif').DataTable();
        })
    </script>
</body>

</html>