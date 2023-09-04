<?php
session_start();
if (isset($_SESSION['nama']) && isset($_SESSION['level'])) {
    header("Location: menu-utama.php?validasi=sukses");
    exit;
}
$validasi = isset($_GET['validasi']) ? trim($_GET['validasi']) : "";
$user = isset($_GET['user']) ? trim($_GET['user']) : "";
if ($validasi == "" && $user = "") {
    header("Location: index.php");
    exit;
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
    <title>Ubah Password</title>
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
                            <div class="card shadow-lg border-0 rounded-lg mt-5">
                                <div class="card-header">
                                    <h3 class="text-center font-weight-light my-4">Ubah Password</h3>
                                </div>
                                <div class="card-body">
                                    <?php
                                    if ($validasi == "error") {
                                        echo "
                                        <div class='alert alert-danger alert-dismissible fade show mb-3' role='alert'>
                                            Konfirmasi password salah!
                                            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                                        </div>
                                        ";
                                    }
                                    ?>
                                    <form action="proses.php" method="post">
                                        <div class="form-floating mb-3">
                                            <input type="hidden" name="user" value="<?= $user; ?>">
                                            <input name="pass" class="form-control" id="inputPassword" type="password" placeholder="Masukkan Password Baru" pattern="[^&#34;&#39;&#60;&#62;]+" minlength="5" required autocomplete="off" />
                                            <label for="inputPassword">Masukkan Password Baru</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input name="konfir" class="form-control" id="inputPassword" type="password" placeholder="Konfirmasi Password Baru" pattern="[^&#34;&#39;&#60;&#62;]+" minlength="5" required autocomplete="off" />
                                            <label for="inputPassword">Konfirmasi Password Baru</label>
                                        </div>
                                        <div class="text-center">
                                            <button name="pass-new" class="btn btn-primary px-3">Ubah</button>
                                        </div>
                                    </form>
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
    <script type="text/javascript">
        var view = document.getElementById('view');
        var pass = document.getElementById('pass');

        view.addEventListener('click', function() {
            if (view.checked == true) {
                pass.type = "text";
            } else {
                pass.type = "password";
            }
        });
    </script>
</body>

</html>