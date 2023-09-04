<?php
session_start();
include 'koneksi.php';

if (isset($_POST['masuk'])) {
	$user = htmlspecialchars($_POST['user']);
	$pass = htmlspecialchars($_POST['pass']);
	$hash = hash('sha256', $pass);

	$query = mysqli_query($koneksi, "SELECT * FROM pengguna WHERE username = '$user' AND password = '$hash'");
	if (mysqli_num_rows($query) > 0) {
		$baris = mysqli_fetch_array($query);
		$_SESSION['id'] = $baris['id_pengguna'];
		$_SESSION['username'] = $baris['username'];
		$_SESSION['nama'] = $baris['nama'];
		$_SESSION['level'] = $baris['level'];
		header("Location: menu-utama.php?validasi=sukses");
	} else {
		header("Location: masuk.php?validasi=error");
	}
}

if (isset($_POST['regis'])) {
	$nama = htmlspecialchars($_POST['nama']);
	$user = htmlspecialchars($_POST['user']);
	$pass = htmlspecialchars($_POST['pass']);
	$konfir = htmlspecialchars($_POST['konfir']);

	if ($pass == $konfir) {
		$query = mysqli_query($koneksi, "SELECT username FROM pengguna WHERE username = '$user'");
		if (mysqli_num_rows($query) > 0) {
			header("Location: regis.php?validasi=warning");
		} else {
			$hash = hash('sha256', $pass);
			$insert = mysqli_query($koneksi, "INSERT INTO pengguna(nama, username, password, level) VALUES('$nama', '$user', '$hash', 'User')");
			if ($insert) {
				header("Location: regis.php?validasi=sukses");
			} else {
				header("Location: regis.php?validasi=error");
			}
		}
	} else {
		header("Location: regis.php?validasi=error");
	}
}

if (isset($_POST['tambah-kriteria'])) {
	$kode = htmlspecialchars($_POST['kode']);
	$nama = htmlspecialchars($_POST['nama']);
	$bobot = htmlspecialchars($_POST['bobot']);
	$jenis = htmlspecialchars($_POST['jenis']);

	$bobot = $bobot / 100;

	$query = mysqli_query($koneksi, "SELECT kode_kriteria FROM kriteria WHERE kode_kriteria = '$kode'");
	if (mysqli_num_rows($query) > 0) {
		header("Location: data-kriteria.php?validasi=warning");
	} else {
		$insert = mysqli_query($koneksi, "INSERT INTO kriteria(kode_kriteria, nama_kriteria, jenis_kriteria, bobot_kriteria) VALUES('$kode', '$nama', '$jenis', '$bobot')");
		if ($insert) {
			header("Location: data-kriteria.php?validasi=sukses-tambah");
		} else {
			header("Location: data-kriteria.php?validasi=error");
		}
	}
}

if (isset($_POST['edit-kriteria'])) {
	$id = htmlspecialchars($_POST['id']);
	$kode = htmlspecialchars($_POST['kode']);
	$nama = htmlspecialchars($_POST['nama']);
	$bobot = htmlspecialchars($_POST['bobot']);
	$jenis = htmlspecialchars($_POST['jenis']);

	$bobot = $bobot / 100;

	$update = mysqli_query($koneksi, "UPDATE kriteria SET kode_kriteria = '$kode', nama_kriteria = '$nama', jenis_kriteria = '$jenis', bobot_kriteria = '$bobot' WHERE id_kriteria = '$id'");
	if ($update) {
		header("Location: data-kriteria.php?validasi=sukses-perbarui");
	} else {
		header("Location: data-kriteria.php?validasi=error");
	}
}

if (isset($_POST['tambah-subkriteria'])) {
	$id = htmlspecialchars($_POST['id']);
	$nama = htmlspecialchars($_POST['nama']);
	$nilai = htmlspecialchars($_POST['nilai']);

	$insert = mysqli_query($koneksi, "INSERT INTO subkriteria(id_kriteria, nama_subkriteria, nilai_subkriteria) VALUES('$id', '$nama', '$nilai')");
	if ($insert) {
		header("Location: data-subkriteria.php?validasi=sukses-tambah");
	} else {
		header("Location: data-subkriteria.php?validasi=error");
	}
}

if (isset($_POST['edit-subkriteria'])) {
	$id = htmlspecialchars($_POST['id']);
	$nama = htmlspecialchars($_POST['nama']);
	$nilai = htmlspecialchars($_POST['nilai']);

	$update = mysqli_query($koneksi, "UPDATE subkriteria SET nama_subkriteria = '$nama', nilai_subkriteria = '$nilai' WHERE id_subkriteria = '$id'");
	if ($update) {
		header("Location: data-subkriteria.php?validasi=sukses-perbarui");
	} else {
		header("Location: data-subkriteria.php?validasi=error");
	}
}

if (isset($_POST['tambah-alternatif'])) {
	$kode = htmlspecialchars($_POST['kode']);
	$user = htmlspecialchars($_POST['user']);
	$nama = htmlspecialchars($_POST['nama']);
	$kriteria = $_POST['kriteria'];
	$subkriteria = $_POST['subkriteria'];

	$query = mysqli_query($koneksi, "SELECT kode_alternatif FROM alternatif WHERE kode_alternatif = '$kode'");
	if (mysqli_num_rows($query) > 0) {
		header("Location: data-alternatif.php?validasi=warning");
	} else {
		$insert = mysqli_query($koneksi, "INSERT INTO alternatif(kode_alternatif, nama_alternatif, username) VALUES('$kode', '$nama' , '$user')");
		if ($insert) {
			$get_id = mysqli_fetch_array(mysqli_query($koneksi, "SELECT id_alternatif FROM alternatif ORDER BY id_alternatif DESC LIMIT 1"));
			$id_alternatif = $get_id['id_alternatif'];
			for ($i = 0; $i < count($kriteria); $i++) {
				$insert = mysqli_query($koneksi, "INSERT INTO matriks(id_alternatif, id_kriteria, id_subkriteria) VALUES('$id_alternatif', '$kriteria[$i]', '$subkriteria[$i]')");
				if (!$insert) {
					header("Location: data-alternatif.php?validasi=error");
				}
			}
			header("Location: data-alternatif.php?validasi=sukses-tambah");
		} else {
			header("Location: data-alternatif.php?validasi=error");
		}
	}
}

if (isset($_POST['edit-alternatif'])) {
	$id = htmlspecialchars($_POST['id']);
	$kode = htmlspecialchars($_POST['kode']);
	$user = htmlspecialchars($_POST['user']);
	$nama = htmlspecialchars($_POST['nama']);
	$kriteria = $_POST['kriteria'];
	$subkriteria = $_POST['subkriteria'];

	$update = mysqli_query($koneksi, "UPDATE alternatif SET kode_alternatif = '$kode', nama_alternatif = '$nama', username = '$user' WHERE id_alternatif = '$id'");
	if ($update) {
		$delete = mysqli_query($koneksi, "DELETE FROM matriks WHERE id_alternatif = '$id'");
		if ($delete) {
			for ($i = 0; $i < count($kriteria); $i++) {
				$insert = mysqli_query($koneksi, "INSERT INTO matriks(id_alternatif, id_kriteria, id_subkriteria) VALUES('$id', '$kriteria[$i]', '$subkriteria[$i]')");
				if (!$insert) {
					header("Location: data-alternatif.php?validasi=error");
				}
			}
			header("Location: data-alternatif.php?validasi=sukses-perbarui");
		} else {
			header("Location: data-alternatif.php?validasi=error");
		}
	} else {
		header("Location: data-alternatif.php?validasi=error");
	}
}

if (isset($_POST['hitung'])) {
	$user = $_POST['user'];
	$pilih = isset($_POST['pilih']) ? $_POST['pilih'] : 0;

	if ($pilih == 0 || count($pilih) < 2) {
		header("Location: data-perhitungan.php?validasi=error");
	} else {
		$cek = mysqli_query($koneksi, "SELECT * FROM checked WHERE username = '$user'");
		if (mysqli_num_rows($cek) > 0) {
			$delete = mysqli_query($koneksi, "DELETE FROM checked WHERE username = '$user'");
			if ($delete) {
				for ($i = 0; $i < count($pilih); $i++) {
					$insert = mysqli_query($koneksi, "INSERT INTO checked(id_alternatif, username) VALUES('$pilih[$i]', '$user')");
					if (!$insert) {
						header("Location: data-perhitungan.php?validasi=error");
					}
				}
				header("Location: proses-perhitungan.php?validasi=sukses");
			} else {
				header("Location: data-perhitungan.php?validasi=error");
			}
		} else {
			for ($i = 0; $i < count($pilih); $i++) {
				$insert = mysqli_query($koneksi, "INSERT INTO checked(id_alternatif, username) VALUES('$pilih[$i]', '$user')");
				if (!$insert) {
					header("Location: data-perhitungan.php?validasi=error");
				}
			}
			header("Location: proses-perhitungan.php?validasi=sukses");
		}
	}
}

if (isset($_POST['edit-profile'])) {
	$id = htmlspecialchars($_POST['id']);
	$nama = htmlspecialchars($_POST['nama']);
	$user = htmlspecialchars($_POST['user']);
	$pass_old = htmlspecialchars($_POST['pass_old']);
	$pass_new = htmlspecialchars($_POST['pass_new']);
	$konfir = htmlspecialchars($_POST['konfir']);

	echo $pass_new;

	if ($pass_old == "" || $pass_new == "" || $konfir == "") {
		$update = mysqli_query($koneksi, "UPDATE pengguna SET nama = '$nama', username = '$user' WHERE id_pengguna = '$id'");
		if ($update) {
			header("Location: data-profile.php?validasi=sukses");
		} else {
			header("Location: data-profile.php?validasi=error");
		}
	} else {
		$baris = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM pengguna WHERE id_pengguna = '$id'"));
		if (hash('sha256', $pass_old) === $baris['password']) {
			if ($pass_new === $konfir) {
				$pass_new = hash('sha256', $pass_new);
				$update = mysqli_query($koneksi, "UPDATE pengguna SET nama = '$nama', username = '$user', password = '$pass_new' WHERE id_pengguna = '$id'");
				if ($update) {
					header("Location: data-profile.php?validasi=sukses");
				}
			} else {
				header("Location: data-profile.php?validasi=error");
			}
		} else {
			header("Location: data-profile.php?validasi=error");
		}
	}
}

if (isset($_POST['tambah-pengguna'])) {
	$nama = htmlspecialchars($_POST['nama']);
	$user = htmlspecialchars($_POST['user']);
	$level = htmlspecialchars($_POST['level']);
	$pass = htmlspecialchars($_POST['pass']);
	$konfir = htmlspecialchars($_POST['konfir']);

	if ($pass == $konfir) {
		$query = mysqli_query($koneksi, "SELECT username FROM pengguna WHERE username = '$user'");
		if (mysqli_num_rows($query) > 0) {
			header("Location: data-pengguna.php?validasi=warning");
		} else {
			$hash = hash('sha256', $pass);
			$insert = mysqli_query($koneksi, "INSERT INTO pengguna(nama, username, password, level) VALUES('$nama', '$user', '$hash', '$level')");
			if ($insert) {
				header("Location: data-pengguna.php?validasi=sukses-tambah");
			} else {
				header("Location: data-pengguna.php?validasi=error");
			}
		}
	} else {
		header("Location: data-pengguna.php?validasi=error");
	}
}

if (isset($_POST['edit-pengguna'])) {
	$id = htmlspecialchars($_POST['id']);
	$nama = htmlspecialchars($_POST['nama']);
	$user = htmlspecialchars($_POST['user']);
	$level = htmlspecialchars($_POST['level']);
	$pass = htmlspecialchars($_POST['pass']);
	$konfir = htmlspecialchars($_POST['konfir']);

	if ($pass == "" && $konfir == "") {
		$update = mysqli_query($koneksi, "UPDATE pengguna SET nama = '$nama', username = '$user', level = '$level' WHERE id_pengguna = '$id'");
		if ($update) {
			header("Location: data-pengguna.php?validasi=sukses-perbarui");
		} else {
			header("Location: data-pengguna.php?validasi=error");
		}
	} else {
		if ($pass == $konfir) {
			$hash = hash('sha256', $pass);
			$update = mysqli_query($koneksi, "UPDATE pengguna SET nama = '$nama', username = '$user', password = '$hash', level = '$level' WHERE id_pengguna = '$id'");
			if ($update) {
				header("Location: data-pengguna.php?validasi=sukses-perbarui");
			} else {
				header("Location: data-pengguna.php?validasi=error");
			}
		} else {
			header("Location: data-pengguna.php?validasi=error");
		}
	}
}

if (isset($_POST['verif'])) {
	$nama = htmlspecialchars($_POST['nama']);
	$user = htmlspecialchars($_POST['user']);

	$verifikasi = mysqli_query($koneksi, "SELECT * FROM pengguna WHERE nama = '$nama' AND username = '$user'");
	if (mysqli_num_rows($verifikasi) > 0) {
		header("Location: ubah-pass.php?validasi=sukses&user=" . $user . "");
	} else {
		header("Location: lupa-pass.php?validasi=error");
	}
}

if (isset($_POST['pass-new'])) {
	$user = htmlspecialchars($_POST['user']);
	$pass = htmlspecialchars($_POST['pass']);
	$konfir = htmlspecialchars($_POST['konfir']);

	if ($pass === $konfir) {
		$hash = hash('sha256', $pass);
		$update = mysqli_query($koneksi, "UPDATE pengguna SET password = '$hash' WHERE username = '$user'");
		if ($update) {
			echo "
			<script>
				alert('Ubah password berhasil');
				document.location.href = 'masuk.php';
			</script>
			";
			exit;
		} else {
			header("Location: ubah-pass.php?validasi=error");
		}
	} else {
		header("Location: ubah-pass.php?validasi=error");
	}
}
