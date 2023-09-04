<?php
session_start();
include 'koneksi.php';
include 'base-url.php';
if (isset($_SESSION['nama']) && isset($_SESSION['level'])) {
    header("Location: menu-utama.php?validasi=sukses");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Rekomendasi Smartphone</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="assets/img/logo.png" />
    <!-- Bootstrap Icons-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
    <!-- Google fonts-->
    <link href="https://fonts.googleapis.com/css?family=Merriweather+Sans:400,700" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Merriweather:400,300,300italic,400italic,700,700italic" rel="stylesheet" type="text/css" />
    <!-- SimpleLightbox plugin CSS-->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/SimpleLightbox/2.1.0/simpleLightbox.min.css" rel="stylesheet" />
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="css/styles.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="css/jquery.dataTables.css">
</head>

<body id="page-top">
    <!-- Navigation-->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top py-3" id="mainNav">
        <div class="container px-4 px-lg-5">
            <div class="d-inline">
                <img src="assets/img/logo.png" width="75" class="me-2">
                <!-- <a class="navbar-brand" href="#page-top">SPK TOMATO</a> -->
            </div>
            <button class="navbar-toggler navbar-toggler-right" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ms-auto my-2 my-lg-0">
                    <li class="nav-item"><a class="nav-link py-2" href="#rekomendasi">Hasil Rekomendasi</a></li>
                    <li class="nav-item"><a class="nav-link py-2" href="#penggunaan">Panduan Penggunaan</a></li>
                    <li class="nav-item"><a class="nav-link bg-primary pe-3 py-2 ms-2 rounded" href="masuk.php">Masuk</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- Masthead-->
    <header class="masthead">
        <div class="container px-4 px-lg-5 h-100">
            <div class="row gx-4 gx-lg-5 h-100">
                <div class="col-lg-8 align-self-end">
                    <h1 class="text-white font-weight-bold">Sistem Pendukung Keputusan</h1>
                    <hr class="divider" />
                </div>
                <div class="col-lg-8 align-self-baseline">
                    <p class="text-white-75 mb-5">Rekomendasi Smartphone Menggunakan Metode Simple Multi Attribute Rating Technique (SMART)</p>
                    <a class="btn btn-primary btn-xl" href="#rekomendasi">Lihat Rekomendasi</a>
                </div>
            </div>
        </div>
    </header>
    <!-- Services-->
    <section class="" id="rekomendasi">
        <div class="container px-4 px-lg-5">
            <h2 class="text-center mt-0">Hasil Rekomendasi</h2>
            <hr class="divider-title" />
            <?php
            $get_admin_user = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM pengguna WHERE level = 'Admin' ORDER BY id_pengguna ASC LIMIT 1"));
            $username = $get_admin_user['username'];

            $query = mysqli_query($koneksi, "SELECT alternatif.nama_alternatif AS nama_alternatif FROM peringkat JOIN alternatif ON peringkat.id_alternatif = alternatif.id_alternatif WHERE peringkat.username = '$username' ORDER BY peringkat.nilai_peringkat DESC LIMIT 1");
            $data_rekom = mysqli_fetch_array($query);
            ?>
            <p class="text-center mb-4">Berdasarkan hasil perhitungan Sistem Pendukung Keputusan dengan menggunakan metode SMART, didapatkan bahwa <span class="fw-bold">"<?= $data_rekom['nama_alternatif']; ?>"</span> adalah jenis Smartphone yang paling direkomendasikan untuk anda.</p>
            <div class="row gx-4 gx-lg-5">
                <div class="col-lg-12 text-center">
                    <div class="mt-5">
                        <div class="mb-2"><i class="bi-gem fs-1 text-primary"></i></div>
                        <h3 class="h4 mb-2">Pengurutan Peringkat Rekomendasi Smartphone</h3>
                        <p class="text-muted mb-0">Berikut hasil perankingan berdasarkan sistem</p>
                        <div class="table-responsive mt-3">
                            <table id="data-rekomendasi" class="cell-bordered display" width="100%">
                                <thead>
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th class="text-center">Kode Alternatif</th>
                                        <th class="text-center">Nama Alternatif</th>
                                        <th class="text-center">Peringkat</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    $query = mysqli_query($koneksi, "SELECT alternatif.kode_alternatif AS kode, alternatif.nama_alternatif AS nama, peringkat.nilai_peringkat AS nilai FROM alternatif JOIN peringkat ON alternatif.id_alternatif = peringkat.id_alternatif WHERE peringkat.username = '$username' ORDER BY peringkat.nilai_peringkat DESC");
                                    while ($baris = mysqli_fetch_array($query)) {
                                        echo "
                                            <tr>
                                                <td>" . $no . "</td>
                                                <td>" . $baris['kode'] . "</td>
                                                <td>" . $baris['nama'] . "</td>
                                                <td>" . $no . "</td>
                                            </tr>
                                            ";
                                        $no++;
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- About-->
    <section class="page-section bg-primary" id="penggunaan">
        <div class="container px-4 px-lg-5">
            <div class="row gx-4 gx-lg-5 justify-content-center">
                <div class="col-lg-8 text-center">
                    <h2 class="text-white mt-0">Panduan Penggunaan</h2>
                    <hr class="divider-title divider-light" />
                    <p class="text-white-75 mb-4">Panduan penggunaan sistem pendukung keputusan rekomendasi Smartphone dapat diunduh pada link di bawah ini.</p>
                    <a class="btn btn-light btn-xl" href="https://drive.google.com/file/d/17N0fZkOh2Gxk7DahjrRMHsZjTvN-nDYL/view?usp=share_link">Unduh</a>
                </div>
            </div>
        </div>
    </section>
    <!-- Footer-->
    <footer class="bg-light py-5">
        <div class="container px-4 px-lg-5">
            <div class="small text-center text-muted">By : Candra Apridita dan Diska Oktavia ^-^</div>
        </div>
    </footer>
    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- SimpleLightbox plugin JS-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/SimpleLightbox/2.1.0/simpleLightbox.min.js"></script>
    <!-- Core theme JS-->
    <script src="js/scripts.js"></script>
    <!-- * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *-->
    <!-- * *                               SB Forms JS                               * *-->
    <!-- * * Activate your form at https://startbootstrap.com/solution/contact-forms * *-->
    <!-- * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *-->
    <script src="https://cdn.startbootstrap.com/sb-forms-latest.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.3.js"></script>
    <script src="js/jquery.dataTables.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#data-rekomendasi').DataTable();
        })
    </script>
</body>

</html>