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

if ($cek != 0) {
	header("Location: data-hasil.php?validasi=minus");
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
	<title>Sistem Pendukung Keputusan Metode SMART</title>
	<link rel="icon" type="image/x-icon" href="assets/img/logo.png" />
	<link href="css/styles_dash.css" rel="stylesheet" />
	<script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
	<link rel="stylesheet" type="text/css" href="css/jquery.dataTables.css">
	<style type="text/css">
		@media print {

			@page {
				size: A4;
			}

			h4.head {
				page-break-after: avoid;
			}

			p.title {
				page-break-after: avoid;
			}


			table {
				page-break-inside: avoid;
			}

		}
	</style>
</head>

<body>

	<div class="container">
		<div class="row">
			<div class="col-sm-12 mt-3">
				<div class="d-flex">
					<img src="assets/img/logo.png" width="90">
					<h3 class="text-center ms-2">Sistem Pendukung Keputusan Rekomendasi Smartphone Menggunakan Metode Simple Multi Attribute Rating Technique (SMART)</h3>
				</div>
			</div>
			<div class="col-sm-12 mt-3">
				<?php
				$username = $_SESSION['username'];
				$query = mysqli_query($koneksi, "SELECT alternatif.nama_alternatif AS nama_alternatif FROM peringkat JOIN alternatif ON peringkat.id_alternatif = alternatif.id_alternatif WHERE peringkat.username = '$username' ORDER BY peringkat.nilai_peringkat DESC LIMIT 1");
				$data_rekom = mysqli_fetch_array($query);
				?>
				<p class="fs-5" style="text-align: justify;">Berdasarkan hasil perhitungan Sistem Pendukung Keputusan dengan menggunakan metode SMART, didapatkan bahwa <span class="fw-bold">"<?= $data_rekom['nama_alternatif']; ?>"</span> adalah jenis smartphone yang paling direkomendasikan untuk anda.</p>
				<div class="table-responsive">
					<table class="table table-bordered" width="100%">
						<thead class="bg-primary">
							<tr>
								<th class="text-center">No</th>
								<th class="text-center">Kode Alternatif</th>
								<th class="text-center">Nama Alternatif</th>
								<th class="text-center">Nilai Peringkat</th>
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
				        				<td class='text-center'>" . $no . "</td>
				        				<td class='text-center'>" . $baris['kode'] . "</td>
				        				<td class='text-center'>" . $baris['nama'] . "</td>
				        				<td class='text-center'>" . $baris['nilai'] . "</td>
				        				<td class='text-center'>" . $no . "</td>
				        			</tr>
			        				";
								$no++;
							}
							?>
						</tbody>
					</table>
				</div>
			</div>
			<div class="col-sm-12 mt-3">
				<h4 class="head">Tahapan Proses Perhitungan</h4>
				<p class="title fs-5 mt-3">1. Menentukan Kriteria</p>
				<div class="table-responsive">
					<table class="table table-bordered" width="100%">
						<thead class="bg-primary">
							<tr>
								<th class="text-center">No</th>
								<th class="text-center">Kode Kriteria</th>
								<th class="text-center">Nama Kriteria</th>
								<th class="text-center">Jenis Kriteria</th>
							</tr>
						</thead>
						<tbody>
							<?php
							$no = 1;
							$query = mysqli_query($koneksi, "SELECT * FROM kriteria");
							while ($baris = mysqli_fetch_array($query)) {
								echo "
	    							<tr>
	    								<td class='text-center'>" . $no . "</td>
	    								<td class='text-center'>" . $baris['kode_kriteria'] . "</td>
	    								<td class='text-center'>" . $baris['nama_kriteria'] . "</td>
	    								<td class='text-center'>" . $baris['jenis_kriteria'] . "</td>
	    							</tr>
    								";
								$no++;
							}
							?>
						</tbody>
					</table>
				</div>
				<p class="title fs-5 mt-3">2. Menentukan Bobot Kriteria</p>
				<div class="table-responsive">
					<table class="table table-bordered" width="100%">
						<thead class="bg-primary">
							<tr>
								<th class="text-center">No</th>
								<th class="text-center">Kode Kriteria</th>
								<th class="text-center">Nama Kriteria</th>
								<th class="text-center">Bobot Kriteria</th>
							</tr>
						</thead>
						<tbody>
							<?php
							$no = 1;
							$query = mysqli_query($koneksi, "SELECT * FROM kriteria");
							while ($baris = mysqli_fetch_array($query)) {
								echo "
	    							<tr>
	    								<td class='text-center'>" . $no . "</td>
	    								<td class='text-center'>" . $baris['kode_kriteria'] . "</td>
	    								<td class='text-center'>" . $baris['nama_kriteria'] . "</td>
	    								<td class='text-center'>" . ($baris['bobot_kriteria'] * 100) . "%</td>
	    							</tr>
    								";
								$no++;
							}
							?>
						</tbody>
					</table>
				</div>
				<p class="title fs-5 mt-3">3. Normalisasi Bobot Kriteria</p>
				<div class="table-responsive">
					<table class="table table-bordered" width="100%">
						<thead class="bg-primary">
							<tr>
								<th class="text-center">No</th>
								<th class="text-center">Kode Kriteria</th>
								<th class="text-center">Nama Kriteria</th>
								<th class="text-center">Bobot Kriteria</th>
								<th class="text-center">Normalisasi</th>
							</tr>
						</thead>
						<tbody>
							<?php
							$no = 1;
							$query = mysqli_query($koneksi, "SELECT * FROM kriteria");
							while ($baris = mysqli_fetch_array($query)) {
								echo "
	    							<tr>
	    								<td class='text-center'>" . $no . "</td>
	    								<td class='text-center'>" . $baris['kode_kriteria'] . "</td>
	    								<td class='text-center'>" . $baris['nama_kriteria'] . "</td>
	    								<td class='text-center'>" . ($baris['bobot_kriteria'] * 100) . "</td>
	    								<td class='text-center'>" . $baris['bobot_kriteria'] . "</td>
	    							</tr>
    								";
								$no++;
							}
							?>
						</tbody>
					</table>
				</div>
				<p class="title fs-5 mt-3">4. Memberikan Nilai Kriteria Pada Masing-Masing Alternatif</p>
				<div class="table-responsive">
					<table class="table table-bordered" width="100%">
						<thead class="bg-primary">
							<tr>
								<th class="text-center">No</th>
								<th class="text-center">Nama Alternatif</th>
								<?php
								$query = mysqli_query($koneksi, "SELECT * FROM kriteria");
								while ($baris = mysqli_fetch_array($query)) {
									echo "
	    								<th class='text-center'>" . $baris['nama_kriteria'] . "</th>
	    								";
								}
								?>
							</tr>
						</thead>
						<tbody>
							<?php
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
							for ($i = 0; $i < count($array_nilai[0]); $i++) {
								$value = array_column($array_nilai, $i);
								$min[] = min($value);
								$max[] = max($value);
							}

							$query = mysqli_query($koneksi, "SELECT alternatif.nama_alternatif FROM alternatif JOIN checked ON alternatif.id_alternatif = checked.id_alternatif WHERE checked.username = '$username'");
							for ($i = 0; $i < count($array_nilai); $i++) {
								$baris = mysqli_fetch_array($query);
							?>
								<tr>
									<td class='text-center'><?= $i + 1; ?></td>
									<td class='text-center'><?= $baris['nama_alternatif']; ?></td>
									<?php
									for ($j = 0; $j < count($array_nilai[0]); $j++) {
										echo "
    									<td class='text-center'>" . $array_nilai[$i][$j] . "</td>
    									";
									}
									?>
								</tr>
							<?php
							}
							?>
						</tbody>
					</table>
				</div>
				<p class="title fs-5 mt-3">5. Menghitung Nilai Utility</p>
				<div class="table-responsive">
					<table class="table table-bordered" width="100%">
						<thead class="bg-primary">
							<tr>
								<th class="text-center">No</th>
								<th class="text-center">Nama Alternatif</th>
								<?php
								$query = mysqli_query($koneksi, "SELECT * FROM kriteria");
								while ($baris = mysqli_fetch_array($query)) {
									echo "
	    								<th class='text-center'>" . $baris['nama_kriteria'] . "</th>
	    								";
								}
								?>
							</tr>
						</thead>
						<tbody>
							<?php
							$jenis_kriteria = array();
							$bobot_kriteria = array();
							$query = mysqli_query($koneksi, "SELECT * FROM kriteria");
							while ($baris = mysqli_fetch_array($query)) {
								$jenis_kriteria[] = $baris['jenis_kriteria'];
								$bobot_kriteria[] = $baris['bobot_kriteria'];
							}

							$nilai_utility = array();
							for ($i = 0; $i < count($array_nilai); $i++) {
								for ($j = 0; $j < count($array_nilai[0]); $j++) {
									$nilai = 0;
									if ($jenis_kriteria[$j] == "Cost") {
										if (($max[$j] - $min[$j]) == 0) {
											$nilai = 0;
										} else {
											$nilai = ($max[$j] - $array_nilai[$i][$j]) / ($max[$j] - $min[$j]);
										}
									} else if ($jenis_kriteria[$j] == "Benefit") {
										if (($max[$j] - $min[$j]) == 0) {
											$nilai = 0;
										} else {
											$nilai = ($array_nilai[$i][$j] - $min[$j]) / ($max[$j] - $min[$j]);
										}
									}
									$nilai_utility[$i][$j] = $nilai;
								}
							}

							$query = mysqli_query($koneksi, "SELECT alternatif.nama_alternatif FROM alternatif JOIN checked ON alternatif.id_alternatif = checked.id_alternatif WHERE checked.username = '$username'");
							for ($i = 0; $i < count($nilai_utility); $i++) {
								$baris = mysqli_fetch_array($query);
							?>
								<tr>
									<td class='text-center'><?= $i + 1; ?></td>
									<td class='text-center'><?= $baris['nama_alternatif']; ?></td>
									<?php
									for ($j = 0; $j < count($nilai_utility[0]); $j++) {
										echo "
    									<td class='text-center'>" . round($nilai_utility[$i][$j], 3) . "</td>
    									";
									}
									?>
								</tr>
							<?php
							}
							?>
						</tbody>
					</table>
				</div>
				<p class="title fs-5 mt-3">6. Menghitung Nilai Akhir</p>
				<div class="table-responsive">
					<table class="table table-bordered" width="100%">
						<thead class="bg-primary">
							<tr>
								<th class="text-center">No</th>
								<th class="text-center">Nama Alternatif</th>
								<?php
								$query = mysqli_query($koneksi, "SELECT * FROM kriteria");
								while ($baris = mysqli_fetch_array($query)) {
									echo "
	    								<th class='text-center'>" . $baris['nama_kriteria'] . "</th>
	    								";
								}
								?>
								<th class="text-center">Nilai Akhir</th>
							</tr>
						</thead>
						<tbody>
							<?php
							$query = mysqli_query($koneksi, "SELECT alternatif.nama_alternatif FROM alternatif JOIN checked ON alternatif.id_alternatif = checked.id_alternatif WHERE checked.username = '$username'");
							for ($i = 0; $i < count($nilai_utility); $i++) {
								$nilai = 0;
								$baris = mysqli_fetch_array($query);
							?>
								<tr>
									<td class='text-center'><?= $i + 1; ?></td>
									<td class='text-center'><?= $baris['nama_alternatif']; ?></td>
									<?php
									for ($j = 0; $j < count($nilai_utility[0]); $j++) {
										$nilai += $nilai_utility[$i][$j] * $bobot_kriteria[$j];
										echo "
    									<td class='text-center'>" . round($nilai_utility[$i][$j] * $bobot_kriteria[$j], 3) . "</td>
    									";
									}
									?>
									<td class='text-center'><?= round($nilai, 3); ?></td>
								</tr>
							<?php
							}
							?>
						</tbody>
					</table>
				</div>
			</div>
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