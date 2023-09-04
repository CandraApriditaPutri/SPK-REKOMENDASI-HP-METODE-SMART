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

if (!isset($_GET['id'])) {
	header("Location: 404.php");
    exit();
} else {
	$id = $_GET['id'];
	$delete1 = mysqli_query($koneksi, "DELETE FROM kriteria WHERE id_kriteria = '$id'");
	$delete2 = mysqli_query($koneksi, "DELETE FROM matriks WHERE id_kriteria = '$id'");
	$delete3 = mysqli_query($koneksi, "DELETE FROM subkriteria WHERE id_kriteria = '$id'");
	if ($delete1 && $delete2 && $delete3) {
		header("Location: data-kriteria.php?validasi=sukses-hapus");
	} else {
		header("Location: data-kriteria.php?validasi=error");
	}
}
