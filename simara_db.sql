-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 15 Okt 2025 pada 08.20
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
-- Struktur dari tabel `artikel`
--

CREATE TABLE `artikel` (
  `id` int(11) NOT NULL,
  `judul` varchar(255) NOT NULL,
  `konten` text NOT NULL,
  `poster` varchar(255) DEFAULT NULL,
  `video` varchar(255) DEFAULT NULL,
  `tanggal` datetime DEFAULT current_timestamp(),
  `foto_lain` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `artikel`
--

INSERT INTO `artikel` (`id`, `judul`, `konten`, `poster`, `video`, `tanggal`, `foto_lain`) VALUES
(6, 'PANDUAN PENCEGAHAN MEROKOK UNTUK REMAJA', 'BAGIAN 1 : MENGAPA MEROKOK BERBAHAYA\r\n\r\nPengenalan: Apa yang Terdapat dalam Rokok dan Dampaknya pada Tubuh\r\nRokok bukanlah sekadar sebatang batang yang terbakar dan dihirup asapnya. Mereka adalah campuran kompleks bahan kimia yang ketika dibakar menghasilkan ribuan senyawa yang berbahaya bagi tubuh manusia. Mari kita melihat lebih dekat apa yang sebenarnya terdapat dalam rokok dan bagaimana setiap komponen tersebut memengaruhi kesehatan tubuh kita.\r\n\r\n1. Nikotin\r\n                Nikotin adalah zat adiktif utama dalam rokok. Ini adalah zat yang membuat seseorang ketagihan dan sulit untuk berhenti merokok. Nikotin bekerja dengan memengaruhi sistem saraf, menyebabkan pelepasan dopamin, neurotransmiter yang terkait dengan sensasi kenikmatan dan kepuasan.\r\n\r\n2. Tar\r\n                Tar adalah hasil pembakaran dari tembakau. Ini terdiri dari sejumlah besar zat yang berbahaya, termasuk benzopiren, yang merupakan senyawa karsinogenik yang terkait dengan risiko kanker.\r\n\r\n3. Karbon Monoksida\r\n                Karbon monoksida adalah gas beracun yang dihasilkan oleh pembakaran tembakau. Ini mengikat pada hemoglobin dalam darah, mengurangi kemampuan darah untuk membawa oksigen ke seluruh tubuh, yang dapat menyebabkan kerusakan jangka panjang pada jantung dan paru-paru.\r\n\r\n4. Bahan Kimia Beracun Lainnya\r\n                Selain nikotin, tar, dan karbon monoksida, rokok mengandung berbagai bahan kimia beracun lainnya seperti formaldehida, amonia, dan arsenik. Zat-zat ini memiliki dampak yang merugikan pada sistem pernapasan, jantung, otak, dan organ lain dalam tubuh.\r\n\r\nDampaknya pada Tubuh\r\n  • Sistem Pernapasan: Merokok dapat menyebabkan iritasi pada saluran pernapasan, merusak paru-paru, dan meningkatkan risiko penyakit paru-paru kronis seperti emfisema dan bronkitis kronis.\r\n• Sistem Kardiovaskular: Nikotin dalam rokok dapat meningkatkan tekanan darah dan meningkatkan risiko penyakit jantung, serangan jantung, dan stroke.\r\n• Sistem Saraf: Nikotin juga memengaruhi sistem saraf, menyebabkan ketergantungan dan dampak negatif pada kesehatan mental dan kognitif.\r\n• Sistem Reproduksi: Merokok dapat mengganggu fungsi reproduksi baik pada pria maupun wanita, meningkatkan risiko infertilitas dan masalah kehamilan.\r\n\r\nDengan memahami apa yang sebenarnya terdapat dalam rokok dan dampaknya pada tubuh, kita dapat lebih memahami mengapa penting untuk menghindari kebiasaan merokok. Langkah pertama menuju kehidupan yang lebih sehat adalah dengan mengerti risiko yang terlibat dan memilih untuk tidak terlibat dalam perilaku merokok.', '1760361507_roko0k.jpg', 'https://youtu.be/DB9n7aNM6q0?si=E-TB0Balpc4L7USb', '2025-10-13 20:18:27', '[\"1760496324_1_Waspada-Bahaya-Merokok-2024-qzelj9me0zuowhqwb7qlww8wwhugk312p37wygi360.jpg\"]'),
(7, 'Pentingnya cek kesehatan', 'Masa pubertas\r\nTubuh remaja tampaknya berubah setiap hari. Ada perkembangan fisik yang seiring dengan pertumbuhan mental dan emosional yang luar biasa. Pubertas adalah masa kritis bagi anak Anda untuk secara teratur mengunjungi penyedia layanan kesehatan guna mendapatkan bimbingan dan bertanya dari seseorang yang mereka percaya. Masa remaja adalah masa di mana pengambilan risiko meningkat, masalah kesehatan mental seperti depresi, kecemasan, bahkan pikiran untuk melukai diri sendiri. Di masa inilah beberapa anak muda akan mencoba zat-zat seperti tembakau, alkohol, dan obat-obatan terlarang lainnya. Dan ini adalah masa perkembangan seksual. Anda dan anak Anda mungkin memiliki pertanyaan untuk penyedia layanan kesehatan Anda. Kami menyarankan untuk memberikan anak Anda beberapa menit berduaan dengan penyedia layanan kesehatannya agar mereka memiliki kesempatan untuk mengajukan pertanyaan yang mungkin tidak nyaman mereka tanyakan di depan anggota keluarga.\r\n\r\nKesehatan Mental\r\nSelain stres sehari-hari yang dialami remaja, masa ini juga merupakan masa di mana masalah kesehatan mental kronis dapat muncul, seperti gangguan bipolar dan skizofrenia. Pemeriksaan rutin dengan penyedia layanan kesehatan Anda dapat membantu mengidentifikasi dan mengelola masalah-masalah ini.\r\n\r\nInstitut Kesehatan Mental Nasional membahas beberapa tanda dan gejala yang mungkin dialami remaja saat mengalami masalah kesehatan mental.', '1760408826_remaja.jpg', 'https://youtu.be/DQH8xa9sFXY?si=RWha5edHxTYuMEr7', '2025-10-13 20:46:00', '[\"1760408561_2_remaja.jpg\",\"1760409245_2_cek.jpg\"]');

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
(1, 2, 2, 5, '2025-10-08 14:53:07'),
(2, 19, 3, 20, '2025-10-14 14:24:19'),
(3, 20, 3, 15, '2025-10-15 09:48:15');

-- --------------------------------------------------------

--
-- Struktur dari tabel `data_gad7`
--

CREATE TABLE `data_gad7` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `total_score` int(11) DEFAULT NULL,
  `result_text` varchar(100) DEFAULT NULL,
  `tanggal_input` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `q1` tinyint(4) NOT NULL,
  `q2` tinyint(4) NOT NULL,
  `q3` tinyint(4) NOT NULL,
  `q4` tinyint(4) NOT NULL,
  `q5` tinyint(4) NOT NULL,
  `q6` tinyint(4) NOT NULL,
  `q7` tinyint(4) NOT NULL,
  `total_skor` int(11) NOT NULL,
  `kategori` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `data_gad7`
--

INSERT INTO `data_gad7` (`id`, `user_id`, `total_score`, `result_text`, `tanggal_input`, `q1`, `q2`, `q3`, `q4`, `q5`, `q6`, `q7`, `total_skor`, `kategori`) VALUES
(16, 19, NULL, NULL, '2025-10-14 06:50:24', 0, 1, 1, 0, 1, 0, 1, 4, 'Minimal'),
(17, 20, NULL, NULL, '2025-10-15 02:47:08', 0, 1, 1, 0, 1, 1, 1, 5, 'Ringan');

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
(1, 2, 165, 55, 20.202, 'Normal', '2025-10-08 14:38:52'),
(2, 19, 180, 68, 20.99, 'Normal', '2025-10-14 10:48:11'),
(3, 19, 170, 50, 17.3, 'Kurus', '2025-10-14 14:06:22'),
(4, 2, 170, 58, 20.07, 'Normal', '2025-10-14 14:27:39'),
(5, 2, 167, 60, 21.51, 'Normal', '2025-10-14 14:37:46'),
(6, 20, 168, 58, 20.55, 'Normal', '2025-10-15 09:47:40');

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
(1, 2, 7, 5, 2, '2025-10-08 14:52:50'),
(12, 19, 5, 5, 5, '2025-10-14 14:19:12'),
(13, 20, 7, 4, 2, '2025-10-15 09:47:56');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kecamatan`
--

CREATE TABLE `kecamatan` (
  `id` int(11) NOT NULL,
  `nama_kecamatan` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `kecamatan`
--

INSERT INTO `kecamatan` (`id`, `nama_kecamatan`) VALUES
(1, 'Wonosari'),
(2, 'Playen'),
(3, 'Karangmojo');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kelurahan`
--

CREATE TABLE `kelurahan` (
  `id` int(11) NOT NULL,
  `kecamatan_id` int(11) NOT NULL,
  `nama_kelurahan` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `kelurahan`
--

INSERT INTO `kelurahan` (`id`, `kecamatan_id`, `nama_kelurahan`) VALUES
(1, 1, 'Kepek'),
(2, 1, 'Piyaman'),
(3, 2, 'Ngleri'),
(4, 3, 'Bejiharjo');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pemberian_suplemen`
--

CREATE TABLE `pemberian_suplemen` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `kader_id` int(11) NOT NULL,
  `vit_bkomplek` tinyint(1) DEFAULT 0,
  `vit_d3` tinyint(1) DEFAULT 0,
  `vit_c` tinyint(1) DEFAULT 0,
  `zinc` tinyint(1) DEFAULT 0,
  `tablet_tambah_darah` tinyint(1) DEFAULT 0,
  `tanggal_pemberian` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pemberian_suplemen`
--

INSERT INTO `pemberian_suplemen` (`id`, `user_id`, `kader_id`, `vit_bkomplek`, `vit_d3`, `vit_c`, `zinc`, `tablet_tambah_darah`, `tanggal_pemberian`) VALUES
(1, 2, 3, 1, 1, 1, 1, 1, '2025-10-13 12:46:38'),
(2, 19, 3, 0, 0, 1, 0, 0, '2025-10-14 13:56:37'),
(3, 20, 3, 0, 0, 1, 0, 0, '2025-10-15 09:49:47');

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
(1, 4, 3, 167, 41, 50, NULL, NULL, NULL, '2025-10-09 13:11:11'),
(3, 20, 3, 168, 58, 35, NULL, NULL, NULL, '2025-10-15 09:49:26'),
(4, 20, 3, NULL, NULL, NULL, '110', 'tidak ada', 12, '2025-10-15 09:50:25');

-- --------------------------------------------------------

--
-- Struktur dari tabel `poster`
--

CREATE TABLE `poster` (
  `id_artikel` int(11) NOT NULL,
  `judul` varchar(255) NOT NULL,
  `file_gambar` varchar(255) NOT NULL,
  `tanggal` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `sekolah`
--

CREATE TABLE `sekolah` (
  `id` int(11) NOT NULL,
  `kelurahan_id` int(11) NOT NULL,
  `nama_sekolah` varchar(150) NOT NULL,
  `jenjang` enum('SMP','SMA','SMK','MA') NOT NULL,
  `alamat` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `sekolah`
--

INSERT INTO `sekolah` (`id`, `kelurahan_id`, `nama_sekolah`, `jenjang`, `alamat`) VALUES
(1, 1, 'SMPN 1 Wonosari', 'SMP', 'Jl. Wonosari No.1'),
(2, 1, 'SMAN 1 Wonosari', 'SMA', 'Jl. Veteran No.3'),
(3, 2, 'SMKN 1 Playen', 'SMK', 'Jl. Playen No.5'),
(4, 4, 'MAN 1 Gunung Kidul', 'MA', 'Jl. Bejiharjo No.2');

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
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `kecamatan_id` int(11) DEFAULT NULL,
  `kelurahan_id` int(11) DEFAULT NULL,
  `sekolah_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `nama`, `no_hp`, `email`, `password`, `role`, `created_at`, `kecamatan_id`, `kelurahan_id`, `sekolah_id`) VALUES
(1, 'admin', '087965465', 'admin@simara.test', '$2y$10$.lLjtHaAVa5eZryfRIQpiuXX5LrUyp9jDM3LrZO2wEB30xVgy7joq', 'admin', '2025-10-08 07:17:54', NULL, NULL, NULL),
(2, 'frdhy', '089671253', 'ferdhybagus93@gmail.com', '$2y$10$YqWYq4.1U037cm23ewuj8u.5YFLPUy7ceehaVVC.OuSqR3/K5JM5q', 'remaja', '2025-10-08 07:38:02', NULL, NULL, NULL),
(3, 'kader', '08512345', 'kader@simara.com', '$2y$10$/jqFdDKFWXSF3Hq92qX.P.lnhYlz2A0hpQbEqhhwwsW0fOKE.vb/2', 'kader', '2025-10-08 07:49:43', NULL, NULL, NULL),
(4, 'sep', '089457134', 'sep123@gmail.com', '$2y$10$Cd4VW7fE9oB0fbClHBbepeYswRbJbCJwjZ.39HQYWT/hBYYuegcTq', 'remaja', '2025-10-08 11:31:18', NULL, NULL, NULL),
(5, 'bp ahmad', '089563156', 'ahmad356@gmail.com', '$2y$10$iWABjQ7k9FJT4A.LcgtkLewoB3ulqDfR9LEBLEmAF8tq4ttpbI6PC', 'kader', '2025-10-09 03:14:02', NULL, NULL, NULL),
(14, 'bp sidik', '082375614555', 'sidikakhmad@gmail.com', '$2y$10$vUVeEcwo03G.o9loJkqdB.8.gz.e1Ti3zqr.HaiQsf295RwBczeCm', 'kader', '2025-10-09 04:04:01', NULL, NULL, NULL),
(15, 'rahmat', '08992172155', 'rahmat456@gmail.com', '$2y$10$5hW1Brn3OLQS36Ibm6wBb.gBAy6oOTIJ8brjNr7CjGHUhfrP8.L7y', 'kader', '2025-10-09 04:07:31', NULL, NULL, NULL),
(18, 'under pret', '', 'prettt123@gmail.com', '$2y$10$sm..gXEpm1pHlMiITUIfY.ib8.hBc8YeLJl/K.n7ZUtBiyAjVbqw2', 'remaja', '2025-10-09 07:17:45', NULL, NULL, NULL),
(19, 'diikkaaaa', '08965342', 'diikkkaaa@gmail.com', '$2y$10$FFLdReZLGTFL9O/hEkSC8O3NrhwZyZQP3n0pnkuRVaGkVvuvJMT6O', 'remaja', '2025-10-14 03:46:43', NULL, NULL, NULL),
(20, 'zidann', '', 'ziiiidaaannnn290@gmail.com', '$2y$10$osLLcHjyQzVa27QUdjXC0.euz7uc.KyAkgjQlFDaaWaMyJYgjVKEq', 'remaja', '2025-10-15 02:41:07', 3, 4, 2);

-- --------------------------------------------------------

--
-- Struktur dari tabel `video`
--

CREATE TABLE `video` (
  `id` int(11) NOT NULL,
  `judul` varchar(255) NOT NULL,
  `link_video` varchar(255) NOT NULL,
  `tanggal` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `artikel`
--
ALTER TABLE `artikel`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `data_aktivitas`
--
ALTER TABLE `data_aktivitas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indeks untuk tabel `data_gad7`
--
ALTER TABLE `data_gad7`
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
-- Indeks untuk tabel `kecamatan`
--
ALTER TABLE `kecamatan`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `kelurahan`
--
ALTER TABLE `kelurahan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kecamatan_id` (`kecamatan_id`);

--
-- Indeks untuk tabel `pemberian_suplemen`
--
ALTER TABLE `pemberian_suplemen`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `kader_id` (`kader_id`);

--
-- Indeks untuk tabel `pemeriksaan_kader`
--
ALTER TABLE `pemeriksaan_kader`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `kader_id` (`kader_id`);

--
-- Indeks untuk tabel `poster`
--
ALTER TABLE `poster`
  ADD PRIMARY KEY (`id_artikel`);

--
-- Indeks untuk tabel `sekolah`
--
ALTER TABLE `sekolah`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kelurahan_id` (`kelurahan_id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `fk_user_kecamatan` (`kecamatan_id`),
  ADD KEY `fk_user_kelurahan` (`kelurahan_id`),
  ADD KEY `fk_user_sekolah` (`sekolah_id`);

--
-- Indeks untuk tabel `video`
--
ALTER TABLE `video`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `artikel`
--
ALTER TABLE `artikel`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `data_aktivitas`
--
ALTER TABLE `data_aktivitas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `data_gad7`
--
ALTER TABLE `data_gad7`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT untuk tabel `data_imt`
--
ALTER TABLE `data_imt`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `data_pola_makan`
--
ALTER TABLE `data_pola_makan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT untuk tabel `kecamatan`
--
ALTER TABLE `kecamatan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `kelurahan`
--
ALTER TABLE `kelurahan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `pemberian_suplemen`
--
ALTER TABLE `pemberian_suplemen`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `pemeriksaan_kader`
--
ALTER TABLE `pemeriksaan_kader`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `poster`
--
ALTER TABLE `poster`
  MODIFY `id_artikel` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `sekolah`
--
ALTER TABLE `sekolah`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT untuk tabel `video`
--
ALTER TABLE `video`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `data_aktivitas`
--
ALTER TABLE `data_aktivitas`
  ADD CONSTRAINT `data_aktivitas_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `data_gad7`
--
ALTER TABLE `data_gad7`
  ADD CONSTRAINT `data_gad7_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

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
-- Ketidakleluasaan untuk tabel `kelurahan`
--
ALTER TABLE `kelurahan`
  ADD CONSTRAINT `kelurahan_ibfk_1` FOREIGN KEY (`kecamatan_id`) REFERENCES `kecamatan` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `pemberian_suplemen`
--
ALTER TABLE `pemberian_suplemen`
  ADD CONSTRAINT `pemberian_suplemen_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `pemberian_suplemen_ibfk_2` FOREIGN KEY (`kader_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `pemeriksaan_kader`
--
ALTER TABLE `pemeriksaan_kader`
  ADD CONSTRAINT `pemeriksaan_kader_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `pemeriksaan_kader_ibfk_2` FOREIGN KEY (`kader_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Ketidakleluasaan untuk tabel `sekolah`
--
ALTER TABLE `sekolah`
  ADD CONSTRAINT `sekolah_ibfk_1` FOREIGN KEY (`kelurahan_id`) REFERENCES `kelurahan` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_user_kecamatan` FOREIGN KEY (`kecamatan_id`) REFERENCES `kecamatan` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_user_kelurahan` FOREIGN KEY (`kelurahan_id`) REFERENCES `kelurahan` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_user_sekolah` FOREIGN KEY (`sekolah_id`) REFERENCES `sekolah` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
