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

if (!isset($_GET['id_subkriteria']) && !isset($_GET['id_kriteria'])) {
	header("Location: 404.php");
	exit();
} else {
	$id_subkriteria = $_GET['id_subkriteria'];
	$id_kriteria = $_GET['id_kriteria'];
	$cek = mysqli_query($koneksi, "SELECT * FROM subkriteria WHERE id_kriteria = '$id_kriteria'");
	if (mysqli_num_rows($cek) == 1) {
		$delete1 = mysqli_query($koneksi, "DELETE FROM kriteria WHERE id_kriteria = '$id_kriteria'");
		$delete2 = mysqli_query($koneksi, "DELETE FROM matriks WHERE id_kriteria = '$id_kriteria'");
		$delete3 = mysqli_query($koneksi, "DELETE FROM subkriteria WHERE id_kriteria = '$id_kriteria'");
		if ($delete1 && $delete2 && $delete3) {
			header("Location: data-subkriteria.php?validasi=sukses-hapus");
		} else {
			header("Location: data-subkriteria.php?validasi=error");
		}
	} else {
		$cek = mysqli_query($koneksi, "SELECT * FROM matriks WHERE id_subkriteria = '$id_subkriteria'");
		if (mysqli_num_rows($cek) > 0) {
			$delete = mysqli_query($koneksi, "DELETE FROM subkriteria WHERE id_subkriteria = '$id_subkriteria'");
			if ($delete) {
				$get_new_subkriteria = mysqli_query($koneksi, "SELECT * FROM subkriteria WHERE id_kriteria = '$id_kriteria' ORDER BY nilai_subkriteria DESC LIMIT 1");
				$get_data = mysqli_fetch_array($get_new_subkriteria);
				$id_new_subkriteria = $get_data['id_subkriteria'];
				$update = mysqli_query($koneksi, "UPDATE matriks SET id_subkriteria = '$id_new_subkriteria' WHERE id_subkriteria = '$id_subkriteria'");
				if ($update) {
					header("Location: data-subkriteria.php?validasi=sukses-hapus");
				} else {
					header("Location: data-subkriteria.php?validasi=error");
				}
			} else {
				header("Location: data-subkriteria.php?validasi=error");
			}
		} else {
			$delete = mysqli_query($koneksi, "DELETE FROM subkriteria WHERE id_subkriteria = '$id_subkriteria'");
			if ($delete) {
				header("Location: data-subkriteria.php?validasi=sukses-hapus");
			} else {
				header("Location: data-subkriteria.php?validasi=error");
			}
		}
	}
}
