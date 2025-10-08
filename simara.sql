-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 08 Okt 2025 pada 06.04
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `simara`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `admin`
--

CREATE TABLE `admin` (
  `id_admin` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `dashboard`
--

CREATE TABLE `dashboard` (
  `id_dashboard` int(11) NOT NULL,
  `total_kader` int(11) DEFAULT 0,
  `total_remaja` int(11) DEFAULT 0,
  `total_posyandu` int(11) DEFAULT 0,
  `total_pemeriksaan` int(11) DEFAULT 0,
  `periode_bulan` varchar(20) DEFAULT NULL,
  `periode_tahun` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `kader`
--

CREATE TABLE `kader` (
  `id_kader` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `id_admin` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pemeriksaan_kader`
--

CREATE TABLE `pemeriksaan_kader` (
  `id_periksa` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `tinggi` decimal(5,2) NOT NULL,
  `berat` decimal(5,2) NOT NULL,
  `tekanan_darah` varchar(20) DEFAULT NULL,
  `hemoglobin` decimal(4,2) DEFAULT NULL,
  `riwayat_penyakit` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `self_report`
--

CREATE TABLE `self_report` (
  `id_self` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `tinggi` decimal(5,2) NOT NULL,
  `berat` decimal(5,2) NOT NULL,
  `pola_makan` text DEFAULT NULL,
  `olahraga` varchar(100) DEFAULT NULL,
  `gadget_time` int(11) DEFAULT NULL COMMENT 'Waktu penggunaan gadget dalam menit',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `user_remaja`
--

CREATE TABLE `user_remaja` (
  `id_user` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `tgl_lahir` date NOT NULL,
  `jenis_kelamin` enum('L','P') NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Stand-in struktur untuk tampilan `view_kader_lengkap`
-- (Lihat di bawah untuk tampilan aktual)
--
CREATE TABLE `view_kader_lengkap` (
`id_kader` int(11)
,`nama_kader` varchar(100)
,`username_kader` varchar(50)
,`id_admin` int(11)
,`nama_admin` varchar(100)
,`created_at` timestamp
,`updated_at` timestamp
);

-- --------------------------------------------------------

--
-- Stand-in struktur untuk tampilan `view_remaja_lengkap`
-- (Lihat di bawah untuk tampilan aktual)
--
CREATE TABLE `view_remaja_lengkap` (
`id_user` int(11)
,`nama` varchar(100)
,`tgl_lahir` date
,`jenis_kelamin` enum('L','P')
,`username` varchar(50)
,`usia` bigint(21)
,`tinggi_self` decimal(5,2)
,`berat_self` decimal(5,2)
,`pola_makan` text
,`olahraga` varchar(100)
,`gadget_time` int(11)
,`tinggi_periksa` decimal(5,2)
,`berat_periksa` decimal(5,2)
,`tekanan_darah` varchar(20)
,`hemoglobin` decimal(4,2)
,`riwayat_penyakit` text
);

-- --------------------------------------------------------

--
-- Struktur untuk view `view_kader_lengkap`
--
DROP TABLE IF EXISTS `view_kader_lengkap`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_kader_lengkap`  AS SELECT `k`.`id_kader` AS `id_kader`, `k`.`nama` AS `nama_kader`, `k`.`username` AS `username_kader`, `k`.`id_admin` AS `id_admin`, `a`.`nama` AS `nama_admin`, `k`.`created_at` AS `created_at`, `k`.`updated_at` AS `updated_at` FROM (`kader` `k` left join `admin` `a` on(`k`.`id_admin` = `a`.`id_admin`)) ;

-- --------------------------------------------------------

--
-- Struktur untuk view `view_remaja_lengkap`
--
DROP TABLE IF EXISTS `view_remaja_lengkap`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_remaja_lengkap`  AS SELECT `ur`.`id_user` AS `id_user`, `ur`.`nama` AS `nama`, `ur`.`tgl_lahir` AS `tgl_lahir`, `ur`.`jenis_kelamin` AS `jenis_kelamin`, `ur`.`username` AS `username`, timestampdiff(YEAR,`ur`.`tgl_lahir`,curdate()) AS `usia`, `sr`.`tinggi` AS `tinggi_self`, `sr`.`berat` AS `berat_self`, `sr`.`pola_makan` AS `pola_makan`, `sr`.`olahraga` AS `olahraga`, `sr`.`gadget_time` AS `gadget_time`, `pk`.`tinggi` AS `tinggi_periksa`, `pk`.`berat` AS `berat_periksa`, `pk`.`tekanan_darah` AS `tekanan_darah`, `pk`.`hemoglobin` AS `hemoglobin`, `pk`.`riwayat_penyakit` AS `riwayat_penyakit` FROM ((`user_remaja` `ur` left join `self_report` `sr` on(`ur`.`id_user` = `sr`.`id_user`)) left join `pemeriksaan_kader` `pk` on(`ur`.`id_user` = `pk`.`id_user`)) ;

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id_admin`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `idx_username_admin` (`username`);

--
-- Indeks untuk tabel `dashboard`
--
ALTER TABLE `dashboard`
  ADD PRIMARY KEY (`id_dashboard`);

--
-- Indeks untuk tabel `kader`
--
ALTER TABLE `kader`
  ADD PRIMARY KEY (`id_kader`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `idx_username_kader` (`username`),
  ADD KEY `idx_admin_kader` (`id_admin`);

--
-- Indeks untuk tabel `pemeriksaan_kader`
--
ALTER TABLE `pemeriksaan_kader`
  ADD PRIMARY KEY (`id_periksa`),
  ADD KEY `idx_user_periksa` (`id_user`);

--
-- Indeks untuk tabel `self_report`
--
ALTER TABLE `self_report`
  ADD PRIMARY KEY (`id_self`),
  ADD KEY `idx_user_self` (`id_user`);

--
-- Indeks untuk tabel `user_remaja`
--
ALTER TABLE `user_remaja`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `idx_username_remaja` (`username`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `admin`
--
ALTER TABLE `admin`
  MODIFY `id_admin` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `dashboard`
--
ALTER TABLE `dashboard`
  MODIFY `id_dashboard` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `kader`
--
ALTER TABLE `kader`
  MODIFY `id_kader` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `pemeriksaan_kader`
--
ALTER TABLE `pemeriksaan_kader`
  MODIFY `id_periksa` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `self_report`
--
ALTER TABLE `self_report`
  MODIFY `id_self` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `user_remaja`
--
ALTER TABLE `user_remaja`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `kader`
--
ALTER TABLE `kader`
  ADD CONSTRAINT `kader_ibfk_1` FOREIGN KEY (`id_admin`) REFERENCES `admin` (`id_admin`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `pemeriksaan_kader`
--
ALTER TABLE `pemeriksaan_kader`
  ADD CONSTRAINT `pemeriksaan_kader_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user_remaja` (`id_user`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `self_report`
--
ALTER TABLE `self_report`
  ADD CONSTRAINT `self_report_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user_remaja` (`id_user`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
