<?php
session_start();
if (isset($_SESSION['nama']) && isset($_SESSION['level'])) {
    header("Location: menu-utama.php?validasi=sukses");
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
    <title>Registrasi</title>
    <link rel="icon" type="image/x-icon" href="assets/img/logo.png" />
    <link href="css/styles_dash.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
</head>

<body class="bg-primary">
    <div id="layoutAuthentication">
        <div id="layoutAuthentication_content">
            <main>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-5">
                            <div class="card shadow-lg border-0 rounded-lg mt-5 mb-3">
                                <div class="card-header">
                                    <h3 class="text-center font-weight-light my-4">Daftar Akun</h3>
                                </div>
                                <div class="card-body">
                                    <?php
                                    if ($validasi == "sukses") {
                                        echo "
                                        <div class='alert alert-success alert-dismissible fade show mb-3' role='alert'>
                                            Registrasi Berhasil, Silahkan login menggunakan akun Anda!
                                            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                                        </div>
                                        ";
                                    } else if ($validasi == "error") {
                                        echo "
                                        <div class='alert alert-danger alert-dismissible fade show mb-3' role='alert'>
                                            Registrasi Gagal, Silahkan melakukan registasi kembali!
                                            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                                        </div>
                                        ";
                                    } else if ($validasi == "warning") {
                                        echo "
                                        <div class='alert alert-warning alert-dismissible fade show mb-3' role='alert'>
                                            Username telah digunakan, Silahkan menggunakan username yang berbeda!
                                            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                                        </div>
                                        ";
                                    }
                                    ?>
                                    <form action="proses.php" method="post">
                                        <div class="form-floating mb-3">
                                            <input name="nama" class="form-control" id="inputEmail" type="text" placeholder="Username" pattern="[A-Za-z ]+" title="Inputan hanya boleh huruf" required autocomplete="off" />
                                            <label for="inputEmail">Nama Lengkap</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input name="user" class="form-control" id="inputEmail" type="text" placeholder="Username" pattern="[A-Za-z0-9]+" title="Tidak boleh simbol" required autocomplete="off" />
                                            <label for="inputEmail">Username</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input name="pass" class="form-control" id="inputPassword" type="password" placeholder="Password" pattern="[^&#34;&#39;&#60;&#62;]+" minlength="5" required autocomplete="off" />
                                            <label for="inputPassword">Password</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input name="konfir" class="form-control" id="inputPassword" type="password" placeholder="Konfirmasi Password" pattern="[^&#34;&#39;&#60;&#62;]+" minlength="5" required autocomplete="off" />
                                            <label for="inputPassword">Konfirmasi Password</label>
                                        </div>
                                        <div class="text-center">
                                            <button name="regis" class="btn btn-primary px-3">Daftar</button>
                                        </div>
                                    </form>
                                </div>
                                <div class="card-footer text-center py-3">
                                    <div class="small">Sudah punya akun? <a href="masuk.php">Klik untuk masuk</a></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
        <div id="layoutAuthentication_footer">
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