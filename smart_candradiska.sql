-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 21 Jun 2023 pada 18.00
-- Versi server: 10.4.17-MariaDB
-- Versi PHP: 8.0.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `smart_candradiska`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `alternatif`
--

CREATE TABLE `alternatif` (
  `id_alternatif` int(11) NOT NULL,
  `kode_alternatif` varchar(10) NOT NULL,
  `nama_alternatif` varchar(25) NOT NULL,
  `username` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `alternatif`
--

INSERT INTO `alternatif` (`id_alternatif`, `kode_alternatif`, `nama_alternatif`, `username`) VALUES
(16, 'A1', 'Samsung Galaxy Note 10+', 'candra'),
(17, 'A2', 'Samsung Galaxy Z Fold 2', 'candra'),
(18, 'A3', 'Oppo Reno 6', 'candra'),
(19, 'A4', 'Oppo A12', 'candra'),
(20, 'A5', 'Oppo A54', 'candra'),
(21, 'A6', 'Vivo Y36', 'candra'),
(22, 'A7', 'Vivo V27', 'candra'),
(23, 'A8', 'Vivo X60 Pro', 'candra'),
(24, 'A9', 'Vivo Y53s', 'candra'),
(25, 'A10', 'Xiaomi 13 Pro ', 'candra'),
(26, 'A11', 'Xiaomi 12T 5G', 'candra'),
(27, 'A12', 'Xiaomi 12', 'candra'),
(28, 'A13', 'Xiaomi Note 12', 'candra'),
(29, 'A14', 'Redmi 10 5G', 'candra'),
(30, 'A15', 'Asus ROG Phone 7 Ultimate', 'candra'),
(31, 'A16', 'Asus Zenfone 9', 'candra'),
(32, 'A17', 'Huawei nova 9', 'candra'),
(33, 'A18', 'Huawei Y8p', 'candra'),
(34, 'A19', 'Samsung Galaxy A34 5G', 'candra'),
(35, 'A20', 'Samsung Galaxy A52', 'candra');

-- --------------------------------------------------------

--
-- Struktur dari tabel `checked`
--

CREATE TABLE `checked` (
  `id_checked` int(11) NOT NULL,
  `id_alternatif` int(11) NOT NULL,
  `username` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `checked`
--

INSERT INTO `checked` (`id_checked`, `id_alternatif`, `username`) VALUES
(1, 1, 'dira'),
(2, 2, 'dira'),
(3, 3, 'dira'),
(4, 4, 'dira'),
(5, 5, 'dira'),
(6, 6, 'dira'),
(7, 7, 'dira'),
(8, 8, 'dira'),
(9, 9, 'dira'),
(10, 10, 'dira'),
(11, 11, 'dira'),
(12, 12, 'dira'),
(13, 13, 'dira'),
(19, 18, 'candra'),
(20, 19, 'candra'),
(21, 22, 'candra'),
(22, 23, 'candra'),
(23, 27, 'candra'),
(24, 30, 'candra'),
(25, 33, 'candra'),
(94, 16, 'diska'),
(95, 17, 'diska'),
(96, 18, 'diska'),
(97, 19, 'diska'),
(98, 20, 'diska'),
(99, 21, 'diska'),
(100, 22, 'diska'),
(101, 23, 'diska'),
(102, 24, 'diska'),
(103, 25, 'diska'),
(104, 26, 'diska'),
(105, 27, 'diska'),
(106, 28, 'diska'),
(107, 29, 'diska'),
(108, 30, 'diska'),
(109, 31, 'diska'),
(110, 32, 'diska'),
(111, 33, 'diska'),
(112, 34, 'diska'),
(113, 35, 'diska');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kriteria`
--

CREATE TABLE `kriteria` (
  `id_kriteria` int(11) NOT NULL,
  `kode_kriteria` varchar(10) NOT NULL,
  `nama_kriteria` varchar(25) NOT NULL,
  `jenis_kriteria` set('Benefit','Cost') NOT NULL,
  `bobot_kriteria` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `kriteria`
--

INSERT INTO `kriteria` (`id_kriteria`, `kode_kriteria`, `nama_kriteria`, `jenis_kriteria`, `bobot_kriteria`) VALUES
(1, 'C1', 'Chipset', 'Benefit', 0.06),
(2, 'C2', 'Kapasitas Memori atau RAM', 'Benefit', 0.12),
(3, 'C3', 'Penyimpanan atau ROM', 'Benefit', 0.12),
(4, 'C4', 'Megapixel Kamera Depan', 'Benefit', 0.1),
(5, 'C5', 'Megapixel Kamera Belakang', 'Benefit', 0.1),
(6, 'C6', 'CPU', 'Benefit', 0.1),
(7, 'C7', 'Versi OS', 'Benefit', 0.1),
(8, 'C8', 'Harga', 'Cost', 0.15),
(9, 'C9', 'Kapasitas Baterai', 'Benefit', 0.1),
(10, 'C10', 'Ukuran Display', 'Benefit', 0.05);

-- --------------------------------------------------------

--
-- Struktur dari tabel `matriks`
--

CREATE TABLE `matriks` (
  `id_matriks` int(11) NOT NULL,
  `id_alternatif` int(11) NOT NULL,
  `id_kriteria` int(11) NOT NULL,
  `id_subkriteria` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `matriks`
--

INSERT INTO `matriks` (`id_matriks`, `id_alternatif`, `id_kriteria`, `id_subkriteria`) VALUES
(1, 1, 1, 3),
(2, 1, 2, 6),
(3, 1, 3, 12),
(4, 1, 4, 16),
(5, 1, 5, 22),
(6, 2, 1, 3),
(7, 2, 2, 6),
(8, 2, 3, 12),
(9, 2, 4, 17),
(10, 2, 5, 22),
(11, 3, 1, 2),
(12, 3, 2, 6),
(13, 3, 3, 10),
(14, 3, 4, 16),
(15, 3, 5, 19),
(16, 4, 1, 2),
(17, 4, 2, 5),
(18, 4, 3, 10),
(19, 4, 4, 15),
(20, 4, 5, 19),
(21, 6, 1, 2),
(22, 6, 2, 5),
(23, 6, 3, 11),
(24, 6, 4, 15),
(25, 6, 5, 19),
(26, 7, 1, 1),
(27, 7, 2, 4),
(28, 7, 3, 11),
(29, 7, 4, 15),
(30, 7, 5, 22),
(31, 8, 1, 1),
(32, 8, 2, 4),
(33, 8, 3, 10),
(34, 8, 4, 13),
(35, 8, 5, 22),
(36, 9, 1, 1),
(37, 9, 2, 5),
(38, 9, 3, 11),
(39, 9, 4, 16),
(40, 9, 5, 21),
(41, 10, 1, 1),
(42, 10, 2, 5),
(43, 10, 3, 12),
(44, 10, 4, 15),
(45, 10, 5, 21),
(46, 11, 1, 2),
(47, 11, 2, 4),
(48, 11, 3, 9),
(49, 11, 4, 13),
(50, 11, 5, 21),
(51, 12, 1, 2),
(52, 12, 2, 5),
(53, 12, 3, 11),
(54, 12, 4, 16),
(55, 12, 5, 20),
(56, 13, 1, 1),
(57, 13, 2, 5),
(58, 13, 3, 11),
(59, 13, 4, 16),
(60, 13, 5, 20),
(61, 5, 1, 1),
(62, 5, 2, 5),
(63, 5, 3, 10),
(64, 5, 4, 15),
(65, 5, 5, 19),
(66, 15, 1, 3),
(67, 15, 2, 4),
(68, 15, 3, 9),
(69, 15, 4, 15),
(70, 15, 5, 21),
(71, 15, 6, 30),
(72, 15, 7, 33),
(73, 15, 8, 28),
(74, 15, 9, 36),
(75, 15, 10, 40),
(106, 18, 1, 1),
(107, 18, 2, 4),
(108, 18, 3, 10),
(109, 18, 4, 13),
(110, 18, 5, 18),
(111, 18, 6, 31),
(112, 18, 7, 33),
(113, 18, 8, 28),
(114, 18, 9, 39),
(115, 18, 10, 42),
(126, 20, 1, 2),
(127, 20, 2, 6),
(128, 20, 3, 11),
(129, 20, 4, 14),
(130, 20, 5, 21),
(131, 20, 6, 31),
(132, 20, 7, 35),
(133, 20, 8, 29),
(134, 20, 9, 36),
(135, 20, 10, 41),
(136, 21, 1, 1),
(137, 21, 2, 4),
(138, 21, 3, 9),
(139, 21, 4, 14),
(140, 21, 5, 19),
(141, 21, 6, 30),
(142, 21, 7, 33),
(143, 21, 8, 29),
(144, 21, 9, 36),
(145, 21, 10, 40),
(156, 23, 1, 1),
(157, 23, 2, 4),
(158, 23, 3, 9),
(159, 23, 4, 13),
(160, 23, 5, 20),
(161, 23, 6, 30),
(162, 23, 7, 33),
(163, 23, 8, 27),
(164, 23, 9, 39),
(165, 23, 10, 41),
(176, 25, 1, 1),
(177, 25, 2, 4),
(178, 25, 3, 9),
(179, 25, 4, 13),
(180, 25, 5, 19),
(181, 25, 6, 30),
(182, 25, 7, 33),
(183, 25, 8, 26),
(184, 25, 9, 37),
(185, 25, 10, 40),
(196, 27, 1, 1),
(197, 27, 2, 4),
(198, 27, 3, 9),
(199, 27, 4, 13),
(200, 27, 5, 19),
(201, 27, 6, 30),
(202, 27, 7, 33),
(203, 27, 8, 27),
(204, 27, 9, 38),
(205, 27, 10, 42),
(206, 28, 1, 1),
(207, 28, 2, 6),
(208, 28, 3, 11),
(209, 28, 4, 17),
(210, 28, 5, 20),
(211, 28, 6, 32),
(212, 28, 7, 33),
(213, 28, 8, 29),
(214, 28, 9, 36),
(215, 28, 10, 40),
(216, 29, 1, 2),
(217, 29, 2, 6),
(218, 29, 3, 10),
(219, 29, 4, 17),
(220, 29, 5, 20),
(221, 29, 6, 32),
(222, 29, 7, 34),
(223, 29, 8, 29),
(224, 29, 9, 36),
(225, 29, 10, 40),
(226, 30, 1, 1),
(227, 30, 2, 4),
(228, 30, 3, 9),
(229, 30, 4, 15),
(230, 30, 5, 19),
(231, 30, 6, 30),
(232, 30, 7, 33),
(233, 30, 8, 26),
(234, 30, 9, 36),
(235, 30, 10, 40),
(236, 31, 1, 3),
(237, 31, 2, 4),
(238, 31, 3, 9),
(239, 31, 4, 15),
(240, 31, 5, 19),
(241, 31, 6, 32),
(242, 31, 7, 33),
(243, 31, 8, 28),
(244, 31, 9, 39),
(245, 31, 10, 42),
(246, 32, 1, 1),
(247, 32, 2, 4),
(248, 32, 3, 9),
(249, 32, 4, 13),
(250, 32, 5, 19),
(251, 32, 6, 31),
(252, 32, 7, 33),
(253, 32, 8, 28),
(254, 32, 9, 39),
(255, 32, 10, 41),
(276, 35, 1, 1),
(277, 35, 2, 6),
(278, 35, 3, 11),
(279, 35, 4, 15),
(280, 35, 5, 18),
(281, 35, 6, 31),
(282, 35, 7, 34),
(283, 35, 8, 29),
(284, 35, 9, 38),
(285, 35, 10, 40),
(286, 16, 1, 3),
(287, 16, 2, 4),
(288, 16, 3, 9),
(289, 16, 4, 14),
(290, 16, 5, 18),
(291, 16, 6, 30),
(292, 16, 7, 33),
(293, 16, 8, 27),
(294, 16, 9, 36),
(295, 16, 10, 40),
(296, 17, 1, 1),
(297, 17, 2, 4),
(298, 17, 3, 9),
(299, 17, 4, 15),
(300, 17, 5, 21),
(301, 17, 6, 30),
(302, 17, 7, 35),
(303, 17, 8, 26),
(304, 17, 9, 36),
(305, 17, 10, 40),
(306, 33, 1, 3),
(307, 33, 2, 25),
(308, 33, 3, 12),
(309, 33, 4, 14),
(310, 33, 5, 20),
(311, 33, 6, 32),
(312, 33, 7, 35),
(313, 33, 8, 29),
(314, 33, 9, 39),
(315, 33, 10, 41),
(316, 24, 1, 2),
(317, 24, 2, 25),
(318, 24, 3, 12),
(319, 24, 4, 14),
(320, 24, 5, 18),
(321, 24, 6, 32),
(322, 24, 7, 34),
(323, 24, 8, 29),
(324, 24, 9, 39),
(325, 24, 10, 41),
(336, 19, 1, 2),
(337, 19, 2, 25),
(338, 19, 3, 12),
(339, 19, 4, 17),
(340, 19, 5, 22),
(341, 19, 6, 31),
(342, 19, 7, 35),
(343, 19, 8, 29),
(344, 19, 9, 39),
(345, 19, 10, 42),
(346, 22, 1, 1),
(347, 22, 2, 5),
(348, 22, 3, 11),
(349, 22, 4, 16),
(350, 22, 5, 21),
(351, 22, 6, 30),
(352, 22, 7, 33),
(353, 22, 8, 28),
(354, 22, 9, 37),
(355, 22, 10, 40),
(356, 26, 1, 3),
(357, 26, 2, 5),
(358, 26, 3, 10),
(359, 26, 4, 14),
(360, 26, 5, 18),
(361, 26, 6, 31),
(362, 26, 7, 33),
(363, 26, 8, 28),
(364, 26, 9, 36),
(365, 26, 10, 40),
(366, 34, 1, 3),
(367, 34, 2, 5),
(368, 34, 3, 10),
(369, 34, 4, 15),
(370, 34, 5, 20),
(371, 34, 6, 30),
(372, 34, 7, 33),
(373, 34, 8, 28),
(374, 34, 9, 36),
(375, 34, 10, 41);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengguna`
--

CREATE TABLE `pengguna` (
  `id_pengguna` int(11) NOT NULL,
  `nama` varchar(25) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `level` set('User','Admin') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `pengguna`
--

INSERT INTO `pengguna` (`id_pengguna`, `nama`, `username`, `password`, `level`) VALUES
(2, 'candra apridita putri', 'candra', '8c6976e5b5410415bde908bd4dee15dfb167a9c873fc4bb8a81f6f2ab448a918', 'Admin'),
(3, 'diska oktavia', 'diska', 'd785d63511a645a24875a109e0ef1da6560dd94d149b6734949a96556cb3449f', 'User');

-- --------------------------------------------------------

--
-- Struktur dari tabel `peringkat`
--

CREATE TABLE `peringkat` (
  `id_peringkat` int(11) NOT NULL,
  `id_alternatif` int(11) NOT NULL,
  `nilai_peringkat` float NOT NULL,
  `username` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `subkriteria`
--

CREATE TABLE `subkriteria` (
  `id_subkriteria` int(11) NOT NULL,
  `id_kriteria` int(11) NOT NULL,
  `nama_subkriteria` varchar(30) NOT NULL,
  `nilai_subkriteria` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `subkriteria`
--

INSERT INTO `subkriteria` (`id_subkriteria`, `id_kriteria`, `nama_subkriteria`, `nilai_subkriteria`) VALUES
(1, 1, 'Qualcomm Snapdragon', 3),
(2, 1, 'Mediatek Hellio', 2),
(3, 1, 'Exynos', 1),
(4, 2, '4 GB - 6 GB', 4),
(5, 2, '3 GB - 3.9 GB', 3),
(6, 2, '2 GB - 2.9 GB', 2),
(9, 3, '32 GB - 64 GB', 4),
(10, 3, '16 GB - 31.9 GB', 3),
(11, 3, '8 GB - 15.9 GB', 2),
(12, 3, '4 GB - 7.9 GB', 1),
(13, 4, '13 MP -  20 MP', 5),
(14, 4, '8 MP -  12.9 MP', 4),
(15, 4, '5 MP - 7.9 MP', 3),
(16, 4, '3 MP - 4.9 MP', 2),
(17, 4, '2 MP - 2.9 MP', 1),
(18, 5, '64 MP', 5),
(19, 5, '50 MP', 4),
(20, 5, '48 MP', 3),
(21, 5, '20 MP', 2),
(22, 5, '13 MP', 1),
(25, 2, '1 GB - 1.9 GB', 1),
(26, 8, 'Rp 4.000.000 - Rp 4.499.000', 4),
(27, 8, 'Rp 3.500.000 - Rp 3.999.000', 3),
(28, 8, 'Rp 3.000.000 - Rp 3.499.000', 2),
(29, 8, 'Rp 2.500.000 - Rp 2.999.000', 1),
(30, 6, 'Octa-core 2.84', 3),
(31, 6, 'Octa-core 2.4', 2),
(32, 6, 'Octa-core 1.8', 1),
(33, 7, 'Android 12', 3),
(34, 7, 'Android 11', 2),
(35, 7, 'Android 10', 1),
(36, 9, '5000 mAH', 4),
(37, 9, '4800 mAh', 3),
(38, 9, '4500 mAH', 2),
(39, 9, '4000 mAH', 1),
(40, 10, '6 inci - 7 inci', 3),
(41, 10, '5 inci - 5.9 inci', 2),
(42, 10, '4 inci - 4.9 inci', 1);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `alternatif`
--
ALTER TABLE `alternatif`
  ADD PRIMARY KEY (`id_alternatif`);

--
-- Indeks untuk tabel `checked`
--
ALTER TABLE `checked`
  ADD PRIMARY KEY (`id_checked`);

--
-- Indeks untuk tabel `kriteria`
--
ALTER TABLE `kriteria`
  ADD PRIMARY KEY (`id_kriteria`);

--
-- Indeks untuk tabel `matriks`
--
ALTER TABLE `matriks`
  ADD PRIMARY KEY (`id_matriks`);

--
-- Indeks untuk tabel `pengguna`
--
ALTER TABLE `pengguna`
  ADD PRIMARY KEY (`id_pengguna`);

--
-- Indeks untuk tabel `peringkat`
--
ALTER TABLE `peringkat`
  ADD PRIMARY KEY (`id_peringkat`);

--
-- Indeks untuk tabel `subkriteria`
--
ALTER TABLE `subkriteria`
  ADD PRIMARY KEY (`id_subkriteria`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `alternatif`
--
ALTER TABLE `alternatif`
  MODIFY `id_alternatif` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT untuk tabel `checked`
--
ALTER TABLE `checked`
  MODIFY `id_checked` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=114;

--
-- AUTO_INCREMENT untuk tabel `kriteria`
--
ALTER TABLE `kriteria`
  MODIFY `id_kriteria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `matriks`
--
ALTER TABLE `matriks`
  MODIFY `id_matriks` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=376;

--
-- AUTO_INCREMENT untuk tabel `pengguna`
--
ALTER TABLE `pengguna`
  MODIFY `id_pengguna` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `peringkat`
--
ALTER TABLE `peringkat`
  MODIFY `id_peringkat` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=114;

--
-- AUTO_INCREMENT untuk tabel `subkriteria`
--
ALTER TABLE `subkriteria`
  MODIFY `id_subkriteria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
