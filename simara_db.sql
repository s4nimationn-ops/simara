-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 08, 2025 at 01:15 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

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
-- Table structure for table `data_aktivitas`
--

CREATE TABLE `data_aktivitas` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `olahraga_per_minggu` int(11) DEFAULT NULL,
  `gadget_jam_per_hari` float DEFAULT NULL,
  `tanggal_input` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `data_aktivitas`
--

INSERT INTO `data_aktivitas` (`id`, `user_id`, `olahraga_per_minggu`, `gadget_jam_per_hari`, `tanggal_input`) VALUES
(1, 2, 2, 5, '2025-10-08 14:53:07');

-- --------------------------------------------------------

--
-- Table structure for table `data_imt`
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
-- Dumping data for table `data_imt`
--

INSERT INTO `data_imt` (`id`, `user_id`, `tinggi_cm`, `berat_kg`, `hasil_imt`, `status_imt`, `tanggal_input`) VALUES
(1, 2, 165, 55, 20.202, 'Normal', '2025-10-08 14:38:52');

-- --------------------------------------------------------

--
-- Table structure for table `data_pola_makan`
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
-- Dumping data for table `data_pola_makan`
--

INSERT INTO `data_pola_makan` (`id`, `user_id`, `sarapan_per_minggu`, `buah_sayur_per_minggu`, `liter_air_per_hari`, `tanggal_input`) VALUES
(1, 2, 7, 5, 2, '2025-10-08 14:52:50');

-- --------------------------------------------------------

--
-- Table structure for table `pemeriksaan_kader`
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

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `nama` varchar(150) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('remaja','kader','admin') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `nama`, `email`, `password`, `role`, `created_at`) VALUES
(1, 'admin', 'admin@simara.test', '$2y$10$.lLjtHaAVa5eZryfRIQpiuXX5LrUyp9jDM3LrZO2wEB30xVgy7joq', 'admin', '2025-10-08 07:17:54'),
(2, 'frdhy', 'ferdhybagus93@gmail.com', '$2y$10$YqWYq4.1U037cm23ewuj8u.5YFLPUy7ceehaVVC.OuSqR3/K5JM5q', 'remaja', '2025-10-08 07:38:02'),
(3, 'kader', 'kader@simara.com', '$2y$10$/jqFdDKFWXSF3Hq92qX.P.lnhYlz2A0hpQbEqhhwwsW0fOKE.vb/2', 'kader', '2025-10-08 07:49:43');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `data_aktivitas`
--
ALTER TABLE `data_aktivitas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `data_imt`
--
ALTER TABLE `data_imt`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `data_pola_makan`
--
ALTER TABLE `data_pola_makan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `pemeriksaan_kader`
--
ALTER TABLE `pemeriksaan_kader`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `kader_id` (`kader_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `data_aktivitas`
--
ALTER TABLE `data_aktivitas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `data_imt`
--
ALTER TABLE `data_imt`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `data_pola_makan`
--
ALTER TABLE `data_pola_makan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `pemeriksaan_kader`
--
ALTER TABLE `pemeriksaan_kader`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `data_aktivitas`
--
ALTER TABLE `data_aktivitas`
  ADD CONSTRAINT `data_aktivitas_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `data_imt`
--
ALTER TABLE `data_imt`
  ADD CONSTRAINT `data_imt_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `data_pola_makan`
--
ALTER TABLE `data_pola_makan`
  ADD CONSTRAINT `data_pola_makan_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `pemeriksaan_kader`
--
ALTER TABLE `pemeriksaan_kader`
  ADD CONSTRAINT `pemeriksaan_kader_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `pemeriksaan_kader_ibfk_2` FOREIGN KEY (`kader_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
