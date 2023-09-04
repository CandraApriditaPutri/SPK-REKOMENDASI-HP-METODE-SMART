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
}

$jum_krit = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM kriteria"));
$query_alternatif = mysqli_query($koneksi, "SELECT * FROM alternatif");
$cek = 0;
while ($baris = mysqli_fetch_array($query_alternatif)) {
	$id_alternatif = $baris['id_alternatif'];
	$query = mysqli_query($koneksi, "SELECT * FROM matriks WHERE id_alternatif = '$id_alternatif'");
	if (mysqli_num_rows($query) < $jum_krit) {
		$cek++;
	}
}

if ($cek > 0) {
	header("Location: data-perhitungan.php?validasi=minus");
} else {
	$username = $_SESSION['username'];
	$query = mysqli_query($koneksi, "SELECT CAST(SUM(bobot_kriteria) AS DECIMAL(10,3)) AS bobot FROM kriteria");
	$data_sum = mysqli_fetch_array($query);
	$total_bobot = $data_sum['bobot'] * 100;
	if ($total_bobot > 100 || $total_bobot < 100) {
		header("Location: data-perhitungan.php?validasi=warning");
	} else {
		$array_nilai = array();
		$i = 0;
		$query_checked = mysqli_query($koneksi, "SELECT * FROM checked WHERE username = '$username'");
		while ($data_checked = mysqli_fetch_array($query_checked)) {
			$id_alternatif = $data_checked['id_alternatif'];
			$j = 0;
			$query_matriks = mysqli_query($koneksi, "SELECT subkriteria.nilai_subkriteria AS nilai FROM matriks JOIN subkriteria ON matriks.id_subkriteria = subkriteria.id_subkriteria JOIN checked ON matriks.id_alternatif = checked.id_alternatif WHERE checked.id_alternatif = '$id_alternatif' AND checked.username = '$username'");
			while ($data_matriks = mysqli_fetch_array($query_matriks)) {
				$nilai = $data_matriks['nilai'];
				$array_nilai[$i][$j] = $nilai;
				$j++;
			}
			$i++;	
		}

		$min = array();
		$max = array();
		for ($i=0; $i < count($array_nilai[0]); $i++) {
			$value = array_column($array_nilai, $i);
			$min[] = min($value);
			$max[] = max($value);
		}

		$jenis_kriteria = array();
		$bobot_kriteria = array();
		$query = mysqli_query($koneksi, "SELECT * FROM kriteria");
		while ($baris = mysqli_fetch_array($query)) {
			$jenis_kriteria[] = $baris['jenis_kriteria'];
			$bobot_kriteria[] = $baris['bobot_kriteria'];
		}

		$nilai_utility = array();
		for ($i=0; $i < count($array_nilai); $i++) { 
			for ($j=0; $j < count($array_nilai[0]); $j++) { 
				$nilai = 0;
				if ($jenis_kriteria[$j] == "Cost") {
					if (($max[$j] - $min[$j]) == 0) {
						$nilai = 0;
					} else {
						$nilai = ($max[$j] - $array_nilai[$i][$j])/($max[$j] - $min[$j]);
					}
				} else if ($jenis_kriteria[$j] == "Benefit") {
					if (($max[$j] - $min[$j]) == 0) {
						$nilai = 0;
					} else {
						$nilai = ($array_nilai[$i][$j] - $min[$j])/($max[$j] - $min[$j]);
					}
				}
				$nilai_utility[$i][$j] = $nilai;
			}
		}

		$nilai_akhir = array();
		for ($i=0; $i < count($array_nilai); $i++) { 
			$nilai = 0;
			for ($j=0; $j < count($array_nilai[0]); $j++) { 
				$nilai += $nilai_utility[$i][$j] * $bobot_kriteria[$j];
			}
			$nilai_akhir[] = round($nilai, 3);
		}

		$id_alternatif = array();
		$query_checked = mysqli_query($koneksi, "SELECT alternatif.id_alternatif AS id_alternatif FROM alternatif JOIN checked ON alternatif.id_alternatif = checked.id_alternatif WHERE checked.username = '$username'");
		while ($data_checked = mysqli_fetch_array($query_checked)) {
			$id_alternatif[] = $data_checked['id_alternatif'];
		}

		$cek = mysqli_query($koneksi, "SELECT * FROM peringkat");
		if (mysqli_num_rows($cek) > 0) {
			$kosongkan = mysqli_query($koneksi, "DELETE FROM peringkat WHERE username = '$username'");
			if ($kosongkan) {
				for ($i=0; $i < count($id_alternatif); $i++) { 
					$id = $id_alternatif[$i];
					$nilai = $nilai_akhir[$i];

					$insert = mysqli_query($koneksi, "INSERT INTO peringkat(id_alternatif, nilai_peringkat, username) VALUES('$id', '$nilai', '$username')");
					if ($insert) {
						header("Location: data-hasil.php?validasi=sukses");
					} else {
						header("Location: data-perhitungan.php?validasi=error");
					}
				}
			}
		} else {
			for ($i=0; $i < count($id_alternatif); $i++) { 
				$id = $id_alternatif[$i];
				$nilai = $nilai_akhir[$i];

				$insert = mysqli_query($koneksi, "INSERT INTO peringkat(id_alternatif, nilai_peringkat, username) VALUES('$id', '$nilai', '$username')");
				if ($insert) {
					header("Location: data-hasil.php?validasi=sukses");
				} else {
					header("Location: data-perhitungan.php?validasi=error");
				}
			}
		}
	}
}

?>