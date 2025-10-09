-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 09 Okt 2025 pada 09.34
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
-- Database: `simara_db`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `data_aktivitas`
--

CREATE TABLE `data_aktivitas` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `olahraga_per_minggu` int(11) DEFAULT NULL,
  `gadget_jam_per_hari` float DEFAULT NULL,
  `tanggal_input` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `data_aktivitas`
--

INSERT INTO `data_aktivitas` (`id`, `user_id`, `olahraga_per_minggu`, `gadget_jam_per_hari`, `tanggal_input`) VALUES
(1, 2, 2, 5, '2025-10-08 14:53:07');

-- --------------------------------------------------------

--
-- Struktur dari tabel `data_imt`
--

CREATE TABLE `data_imt` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `tinggi_cm` float NOT NULL,
  `berat_kg` float NOT NULL,
  `hasil_imt` float NOT NULL,
  `status_imt` varchar(50) DEFAULT NULL,
  `tanggal_input` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `data_imt`
--

INSERT INTO `data_imt` (`id`, `user_id`, `tinggi_cm`, `berat_kg`, `hasil_imt`, `status_imt`, `tanggal_input`) VALUES
(1, 2, 165, 55, 20.202, 'Normal', '2025-10-08 14:38:52');

-- --------------------------------------------------------

--
-- Struktur dari tabel `data_pola_makan`
--

CREATE TABLE `data_pola_makan` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `sarapan_per_minggu` int(11) DEFAULT NULL,
  `buah_sayur_per_minggu` int(11) DEFAULT NULL,
  `liter_air_per_hari` float DEFAULT NULL,
  `tanggal_input` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `data_pola_makan`
--

INSERT INTO `data_pola_makan` (`id`, `user_id`, `sarapan_per_minggu`, `buah_sayur_per_minggu`, `liter_air_per_hari`, `tanggal_input`) VALUES
(1, 2, 7, 5, 2, '2025-10-08 14:52:50');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pemeriksaan_kader`
--

CREATE TABLE `pemeriksaan_kader` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `kader_id` int(11) DEFAULT NULL,
  `tinggi_cm` float DEFAULT NULL,
  `berat_kg` float DEFAULT NULL,
  `lingkar_lengan_cm` float DEFAULT NULL,
  `tekanan_darah` varchar(50) DEFAULT NULL,
  `deskripsi_riwayat` text DEFAULT NULL,
  `hemoglobin` float DEFAULT NULL,
  `tanggal_periksa` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pemeriksaan_kader`
--

INSERT INTO `pemeriksaan_kader` (`id`, `user_id`, `kader_id`, `tinggi_cm`, `berat_kg`, `lingkar_lengan_cm`, `tekanan_darah`, `deskripsi_riwayat`, `hemoglobin`, `tanggal_periksa`) VALUES
(1, 4, 3, 167, 41, 50, NULL, NULL, NULL, '2025-10-09 13:11:11');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `nama` varchar(150) NOT NULL,
  `no_hp` varchar(15) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('remaja','kader','admin') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `nama`, `no_hp`, `email`, `password`, `role`, `created_at`) VALUES
(1, 'admin', '087965465', 'admin@simara.test', '$2y$10$.lLjtHaAVa5eZryfRIQpiuXX5LrUyp9jDM3LrZO2wEB30xVgy7joq', 'admin', '2025-10-08 07:17:54'),
(2, 'frdhy', '089671253', 'ferdhybagus93@gmail.com', '$2y$10$YqWYq4.1U037cm23ewuj8u.5YFLPUy7ceehaVVC.OuSqR3/K5JM5q', 'remaja', '2025-10-08 07:38:02'),
(3, 'kader', '08512345', 'kader@simara.com', '$2y$10$/jqFdDKFWXSF3Hq92qX.P.lnhYlz2A0hpQbEqhhwwsW0fOKE.vb/2', 'kader', '2025-10-08 07:49:43'),
(4, 'sep', '089457134', 'sep123@gmail.com', '$2y$10$Cd4VW7fE9oB0fbClHBbepeYswRbJbCJwjZ.39HQYWT/hBYYuegcTq', 'remaja', '2025-10-08 11:31:18'),
(5, 'bp ahmad', '089563156', 'ahmad356@gmail.com', '$2y$10$iWABjQ7k9FJT4A.LcgtkLewoB3ulqDfR9LEBLEmAF8tq4ttpbI6PC', 'kader', '2025-10-09 03:14:02'),
(14, 'bp sidik', '082375614555', 'sidikakhmad@gmail.com', '$2y$10$vUVeEcwo03G.o9loJkqdB.8.gz.e1Ti3zqr.HaiQsf295RwBczeCm', 'kader', '2025-10-09 04:04:01'),
(15, 'rahmat', '08992172155', 'rahmat456@gmail.com', '$2y$10$5hW1Brn3OLQS36Ibm6wBb.gBAy6oOTIJ8brjNr7CjGHUhfrP8.L7y', 'kader', '2025-10-09 04:07:31'),
(18, 'under pret', '', 'prettt123@gmail.com', '$2y$10$sm..gXEpm1pHlMiITUIfY.ib8.hBc8YeLJl/K.n7ZUtBiyAjVbqw2', 'remaja', '2025-10-09 07:17:45');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `data_aktivitas`
--
ALTER TABLE `data_aktivitas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indeks untuk tabel `data_imt`
--
ALTER TABLE `data_imt`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indeks untuk tabel `data_pola_makan`
--
ALTER TABLE `data_pola_makan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indeks untuk tabel `pemeriksaan_kader`
--
ALTER TABLE `pemeriksaan_kader`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `kader_id` (`kader_id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `data_aktivitas`
--
ALTER TABLE `data_aktivitas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `data_imt`
--
ALTER TABLE `data_imt`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `data_pola_makan`
--
ALTER TABLE `data_pola_makan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `pemeriksaan_kader`
--
ALTER TABLE `pemeriksaan_kader`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `data_aktivitas`
--
ALTER TABLE `data_aktivitas`
  ADD CONSTRAINT `data_aktivitas_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `data_imt`
--
ALTER TABLE `data_imt`
  ADD CONSTRAINT `data_imt_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `data_pola_makan`
--
ALTER TABLE `data_pola_makan`
  ADD CONSTRAINT `data_pola_makan_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `pemeriksaan_kader`
--
ALTER TABLE `pemeriksaan_kader`
  ADD CONSTRAINT `pemeriksaan_kader_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `pemeriksaan_kader_ibfk_2` FOREIGN KEY (`kader_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
