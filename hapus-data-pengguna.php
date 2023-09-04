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
	$cek = mysqli_fetch_array(mysqli_query($koneksi, "SELECT level FROM pengguna WHERE id_pengguna = '$id'"));
	if ($cek['level'] == "Admin") {
		header("Location: data-pengguna.php?validasi=error");
	} else {
		$delete = mysqli_query($koneksi, "DELETE FROM pengguna WHERE id_pengguna = '$id'");
		if ($delete) {
			header("Location: data-pengguna.php?validasi=sukses-hapus");
		} else {
			header("Location: data-pengguna.php?validasi=error");
		}
	}
}
