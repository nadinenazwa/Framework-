-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 28, 2025 at 07:11 AM
-- Server version: 8.0.41
-- PHP Version: 8.2.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kuliah_wf_2025`
--

-- --------------------------------------------------------

--
-- Table structure for table `detail_rekam_medis`
--

CREATE TABLE `detail_rekam_medis` (
  `iddetail_rekam_medis` int NOT NULL,
  `idrekam_medis` int NOT NULL,
  `idkode_tindakan_terapi` int NOT NULL,
  `detail` varchar(1000) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `detail_rekam_medis`
--

INSERT INTO `detail_rekam_medis` (`iddetail_rekam_medis`, `idrekam_medis`, `idkode_tindakan_terapi`, `detail`) VALUES
(2, 4, 21, 'Bismillah 5kg'),
(3, 5, 20, 'zxa'),
(4, 7, 16, '3x'),
(5, 6, 19, '3x'),
(6, 9, 11, 'yyyy'),
(7, 10, 25, '3x'),
(8, 10, 20, '\\'),
(9, 11, 3, '1x'),
(10, 11, 20, '12'),
(13, 8, 18, 'ko'),
(14, 8, 16, 'uu'),
(15, 8, 16, 'kp'),
(16, 8, 16, 'kl'),
(17, 4, 13, 'JXSWK'),
(18, 4, 13, 'K'),
(19, 4, 13, 'OPPP');

-- --------------------------------------------------------

--
-- Table structure for table `dokter`
--

CREATE TABLE `dokter` (
  `id_dokter` int NOT NULL,
  `alamat` varchar(100) DEFAULT NULL,
  `no_hp` varchar(45) DEFAULT NULL,
  `bidang_dokter` varchar(100) DEFAULT NULL,
  `jenis_kelamin` varchar(1) DEFAULT NULL,
  `iduser` bigint DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `dokter`
--

INSERT INTO `dokter` (`id_dokter`, `alamat`, `no_hp`, `bidang_dokter`, `jenis_kelamin`, `iduser`) VALUES
(1, 'Rungkut', '089725470273', 'Umum', 'P', 8);

-- --------------------------------------------------------

--
-- Table structure for table `jenis_hewan`
--

CREATE TABLE `jenis_hewan` (
  `idjenis_hewan` int NOT NULL,
  `nama_jenis_hewan` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `status` tinyint DEFAULT '1',
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `jenis_hewan`
--

INSERT INTO `jenis_hewan` (`idjenis_hewan`, `nama_jenis_hewan`, `status`, `is_deleted`) VALUES
(1, 'Anjing (Canis lupus familiaris)', 1, 0),
(2, 'Kucing (Felis catus)', 1, 0),
(3, 'Kelinci (Oryctolagus cuniculus)', 1, 0),
(4, 'Burung', 1, 0),
(5, 'Reptil', 1, 0),
(6, 'Rodent / Hewan Kecil', 1, 0),
(7, 'Ayam', 1, 0),
(17, 'Kura-kura ninja', 1, 1),
(18, 'Kura-kura ninja', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `idkategori` int NOT NULL,
  `nama_kategori` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`idkategori`, `nama_kategori`) VALUES
(1, 'Vaksinasi'),
(2, 'Bedah / Operasi'),
(3, 'Cairan infus'),
(4, 'Terapi Injeksi'),
(5, 'Terapi Oral'),
(6, 'Diagnostik'),
(7, 'Rawat Inap'),
(8, 'Lain-lain');

-- --------------------------------------------------------

--
-- Table structure for table `kategori_klinis`
--

CREATE TABLE `kategori_klinis` (
  `idkategori_klinis` int NOT NULL,
  `nama_kategori_klinis` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kategori_klinis`
--

INSERT INTO `kategori_klinis` (`idkategori_klinis`, `nama_kategori_klinis`) VALUES
(1, 'Terapi'),
(2, 'Tindakan'),
(3, 'Konsiltasi');

-- --------------------------------------------------------

--
-- Table structure for table `kode_tindakan_terapi`
--

CREATE TABLE `kode_tindakan_terapi` (
  `idkode_tindakan_terapi` int NOT NULL,
  `kode` varchar(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `deskripsi_tindakan_terapi` varchar(1000) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `idkategori` int NOT NULL,
  `idkategori_klinis` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kode_tindakan_terapi`
--

INSERT INTO `kode_tindakan_terapi` (`idkode_tindakan_terapi`, `kode`, `deskripsi_tindakan_terapi`, `idkategori`, `idkategori_klinis`) VALUES
(1, 'T01', 'Vaksinasi Rabies', 1, 1),
(2, 'T02', 'Vaksinasi Polivalen (DHPPi/L untuk anjing)', 1, 1),
(3, 'T03', 'Vaksinasi Panleukopenia / Tricat kucing', 1, 1),
(4, 'T04', 'Vaksinasi lainnya (bordetella, influenza, dsb.)', 1, 1),
(5, 'T05', 'Sterilisasi jantan', 2, 2),
(6, 'T06', 'Sterilisasi betina', 2, 2),
(9, 'T07', 'Minor surgery (luka, abses)', 2, 2),
(10, 'T08', 'Major surgery (laparotomi, tumor)', 2, 2),
(11, 'T09', 'Infus intravena cairan kristaloid', 3, 1),
(12, 'T10', 'Infus intravena cairan koloid', 3, 1),
(13, 'T11', 'Antibiotik injeksi', 4, 1),
(14, 'T12', 'Antiparasit injeksi', 4, 1),
(15, 'T13', 'Antiemetik / gastroprotektor', 4, 1),
(16, 'T14', 'Analgesik / antiinflamasi', 4, 1),
(17, 'T15', 'Kortikosteroid', 4, 1),
(18, 'T16', 'Antibiotik oral', 5, 1),
(19, 'T17', 'Antiparasit oral', 5, 1),
(20, 'T18', 'Vitamin / suplemen', 5, 1),
(21, 'T19', 'Diet khusus', 5, 1),
(22, 'T20', 'Pemeriksaan darah rutin', 6, 2),
(23, 'T21', 'Pemeriksaan kimia darah', 6, 2),
(24, 'T22', 'Pemeriksaan feses / parasitologi', 6, 2),
(25, 'T23', 'Pemeriksaan urin', 6, 2),
(26, 'T24', 'Radiografi (rontgen)', 6, 2),
(27, 'T25', 'USG Abdomen', 6, 2),
(28, 'T26', 'Sitologi / biopsi', 6, 2),
(29, 'T27', 'Rapid test penyakit infeksi', 6, 2),
(30, 'T28', 'Observasi sehari', 7, 2),
(31, 'T29', 'Observasi lebih dari 1 hari', 7, 2),
(32, 'T30', 'Grooming medis', 8, 2),
(33, 'T31', 'Deworming', 8, 1),
(34, 'T32', 'Ektoparasit control', 8, 1);

-- --------------------------------------------------------

--
-- Table structure for table `pemilik`
--

CREATE TABLE `pemilik` (
  `idpemilik` int NOT NULL,
  `no_wa` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `alamat` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `iduser` bigint NOT NULL,
  `is_deleted` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pemilik`
--

INSERT INTO `pemilik` (`idpemilik`, `no_wa`, `alamat`, `iduser`, `is_deleted`) VALUES
(1, '01121212111', 'Putra Bangsa', 7, 0),
(2, '081239212282', 'zimbabwe', 10, 0),
(3, '082121234527', 'kutub utara', 12, 0),
(4, '081992234321', 'rusia', 14, 0),
(5, '088432147894', 'blok m', 16, 0),
(6, '081230212222', 'wiguna', 11, 0),
(7, '088112345421', 'kendangsari', 13, 0),
(9, '09898', 'upn', 17, 0);

-- --------------------------------------------------------

--
-- Table structure for table `perawat`
--

CREATE TABLE `perawat` (
  `id_perawat` int NOT NULL,
  `alamat` varchar(100) DEFAULT NULL,
  `no_hp` varchar(45) DEFAULT NULL,
  `jenis_kelamin` varchar(1) DEFAULT NULL,
  `pendidikan` varchar(100) DEFAULT NULL,
  `iduser` bigint DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `perawat`
--

INSERT INTO `perawat` (`id_perawat`, `alamat`, `no_hp`, `jenis_kelamin`, `pendidikan`, `iduser`) VALUES
(1, 'Malang', '087364265826', 'P', 'Profesi', 18);

-- --------------------------------------------------------

--
-- Table structure for table `pet`
--

CREATE TABLE `pet` (
  `idpet` int NOT NULL,
  `nama` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `warna_tanda` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `jenis_kelamin` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `idpemilik` int NOT NULL,
  `idras_hewan` int NOT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pet`
--

INSERT INTO `pet` (`idpet`, `nama`, `tanggal_lahir`, `warna_tanda`, `jenis_kelamin`, `idpemilik`, `idras_hewan`, `is_deleted`) VALUES
(1, 'kiyu', '2023-01-01', 'Coklat', 'J', 1, 1, 0),
(2, 'viansyay', '2024-09-13', 'Pink', 'B', 2, 4, 1),
(3, 'kiyu', '2025-09-09', 'Biru', 'B', 3, 2, 0),
(4, 'kiko', '2025-01-17', 'putih', 'J', 4, 18, 0),
(5, 'codigo', '2025-07-16', 'Hitam', 'B', 5, 10, 0),
(6, 'bocil', '2025-09-26', 'Blue', 'J', 6, 14, 0),
(7, 'topik', '2024-12-30', 'Putih', 'B', 7, 3, 0),
(8, 'yaya', '2025-01-05', 'putih', 'J', 9, 5, 0);

-- --------------------------------------------------------

--
-- Table structure for table `ras_hewan`
--

CREATE TABLE `ras_hewan` (
  `idras_hewan` int NOT NULL,
  `nama_ras` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `idjenis_hewan` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ras_hewan`
--

INSERT INTO `ras_hewan` (`idras_hewan`, `nama_ras`, `idjenis_hewan`) VALUES
(1, 'Golden Retriever', 1),
(2, 'Labrador Retriever', 1),
(3, 'German Shepherd', 1),
(4, 'Bulldog (English, French)', 1),
(5, 'Poodle (Toy, Miniature, Standard)', 1),
(6, 'Beagle', 1),
(7, 'Siberian Husky', 1),
(8, 'Shih Tzu', 1),
(9, 'Dachshund', 1),
(10, 'Chihuahua', 1),
(11, 'Persia', 2),
(12, 'Maine Coon', 2),
(13, 'Siamese', 2),
(14, 'Bengal', 2),
(15, 'Sphynx', 2),
(16, 'Scottish Fold', 2),
(17, 'British Shorthair', 2),
(18, 'Anggora', 2),
(19, 'Domestic Shorthair (kampung)', 2),
(20, 'Ragdoll', 2),
(21, 'Holland Lop', 3),
(22, 'Netherland Dwarf', 3),
(23, 'Flemish Giant', 3),
(24, 'Lionhead', 3),
(25, 'Rex', 3),
(26, 'Angora Rabbit', 3),
(27, 'Mini Lop', 3),
(28, 'Lovebird (Agapornis sp.)', 4),
(29, 'Kakatua (Cockatoo)', 4),
(30, 'Parrot / Nuri (Macaw, African Grey, Amazon Parrot)', 4),
(31, 'Kenari (Serinus canaria)', 4),
(32, 'Merpati (Columba livia)', 4),
(33, 'Parkit (Budgerigar / Melopsittacus undulatus)', 4),
(34, 'Jalak (Sturnus sp.)', 4),
(35, 'Kura-kura Sulcata (African spurred tortoise)', 5),
(36, 'Red-Eared Slider (Trachemys scripta elegans)', 5),
(37, 'Leopard Gecko', 5),
(38, 'Iguana hijau', 5),
(39, 'Ball Python', 5),
(40, 'Corn Snake', 5),
(41, 'Hamster (Syrian, Roborovski, Campbell, Winter White)', 6),
(42, 'Guinea Pig (Abyssinian, Peruvian, American Shorthair)', 6),
(43, 'Gerbil', 6),
(44, 'Chinchilla', 6),
(47, 'Cemani', 7);

-- --------------------------------------------------------

--
-- Table structure for table `rekam_medis`
--

CREATE TABLE `rekam_medis` (
  `idrekam_medis` int NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `anamnesa` varchar(1000) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `temuan_klinis` varchar(1000) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `diagnosa` varchar(1000) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `dokter_pemeriksa` int NOT NULL,
  `idreservasi_dokter` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rekam_medis`
--

INSERT INTO `rekam_medis` (`idrekam_medis`, `created_at`, `anamnesa`, `temuan_klinis`, `diagnosa`, `dokter_pemeriksa`, `idreservasi_dokter`) VALUES
(4, NULL, 'flu', 'cairan lendir hijau', 'mencret', 3, 7),
(5, NULL, 'kukuruyuk', 'pekka', 'yihaaaaa', 3, 8),
(6, NULL, 'Pusing', 'Benjolan', 'Demensia', 3, 9),
(7, NULL, 'flu', 'tidak ada apa apa', 'kanker', 3, 10),
(8, NULL, 'kinnk', 'cici', 'cici', 3, 11),
(9, NULL, 'batuk', 'berdahak', 'Isoplus', 3, 14),
(10, NULL, 'sakit perut', '-', '-', 3, 18),
(11, NULL, 'Terlalu sering ', '-', 'Diare', 3, 20);

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `idrole` int NOT NULL,
  `nama_role` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`idrole`, `nama_role`) VALUES
(1, 'Administrator'),
(2, 'Dokter'),
(3, 'Perawat'),
(4, 'Resepsionis'),
(5, 'Pemilik');

-- --------------------------------------------------------

--
-- Table structure for table `role_user`
--

CREATE TABLE `role_user` (
  `idrole_user` int NOT NULL,
  `iduser` bigint NOT NULL,
  `idrole` int NOT NULL,
  `status` tinyint NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `role_user`
--

INSERT INTO `role_user` (`idrole_user`, `iduser`, `idrole`, `status`) VALUES
(2, 7, 5, 1),
(3, 8, 2, 1),
(4, 9, 4, 1),
(12, 6, 1, 1),
(16, 12, 5, 1),
(17, 11, 5, 1),
(18, 10, 5, 1),
(19, 13, 5, 1),
(20, 17, 5, 1),
(21, 16, 5, 1),
(22, 14, 5, 1),
(23, 18, 3, 1);

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `temu_dokter`
--

CREATE TABLE `temu_dokter` (
  `idreservasi_dokter` int NOT NULL,
  `no_urut` int DEFAULT NULL,
  `waktu_daftar` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` char(1) DEFAULT NULL COMMENT 'Contoh: 1=Menunggu, 2=Selesai, 3=Batal',
  `idpet` int NOT NULL,
  `idrole_user` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `temu_dokter`
--

INSERT INTO `temu_dokter` (`idreservasi_dokter`, `no_urut`, `waktu_daftar`, `status`, `idpet`, `idrole_user`) VALUES
(1, 1, '2025-09-17 17:20:04', '1', 2, 3),
(2, 2, '2025-09-18 13:26:55', '1', 3, 3),
(4, 1, '2025-09-19 09:14:02', '1', 3, 3),
(5, 2, '2025-09-19 09:14:08', '1', 1, 3),
(7, 2, '2025-09-20 14:08:46', '1', 1, 3),
(8, 3, '2025-09-20 14:23:03', '1', 2, 3),
(9, 1, '2025-09-20 18:38:52', '2', 4, 3),
(10, 2, '2025-09-20 18:40:00', '2', 3, 3),
(11, 3, '2025-09-20 18:45:48', '2', 1, 3),
(12, 4, '2025-09-20 18:47:37', '1', 5, 3),
(13, 1, '2025-09-26 07:31:05', '1', 2, 3),
(14, 2, '2025-09-26 07:32:14', '2', 6, 3),
(15, 3, '2025-09-26 08:13:06', '1', 7, 3),
(16, 1, '2025-10-02 09:58:14', '1', 7, 3),
(17, 2, '2025-10-02 09:58:23', '1', 5, 3),
(18, 1, '2025-10-05 20:00:04', '2', 6, 3),
(19, 2, '2025-10-05 20:00:13', '1', 4, 3),
(20, 1, '2025-10-06 17:47:46', '2', 8, 3),
(21, 2, '2025-10-06 17:57:03', '1', 7, 3);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `iduser` bigint NOT NULL,
  `nama` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(300) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`iduser`, `nama`, `email`, `password`) VALUES
(6, 'admin', 'admin@mail.com', '$2y$10$o1YFcFalLv1H0Xz3H6RPEeH3fh9vSOWk7ltzYXPeLzLj4JBelCyiq'),
(7, 'adel', 'adel@mail.com', '$2y$10$80PKValwazsMo/EOJOiCMujDcNYE9zorbUSBf7sJVsolkyZTztA86'),
(8, 'lusi', 'lusi@mail.com', '$2y$10$OzHmokpesOj3MEIHthKcpOT.QQjEBekVcL6fZk/29y1rWoLaztjMC'),
(9, 'alifia', 'alifia@mail.com', '$2y$10$M91QVi/9kf1RxhpkzHU7WuCrP9ZX9vsCHX0ZcvDhjB84XuROM5T4G'),
(10, 'arvi', 'arvi@mail.com', '$2y$10$QIf/P0uhFFkkkTJWeTH8Pe/pvTgzhL2XPh/j9a0I2WnUSBHDA5AFG'),
(11, 'eca', 'eca@mail.com', '$2y$10$9VznFrjAWuoiTGDb6yyAaO2SELKPun/AOUIbg5Xr6QPSdHG.prXaO'),
(12, 'reta', 'reta@mail.com', '$2y$10$0LRBOAo4SmlbIRzw/bp.UuLfrosaKmCySA04q0nLekKD1l.B.D2kG'),
(13, 'aska', 'aska@mail.com', '$2y$10$Z6jVadGkQkrLiIXH85/k7.KI/w6KLZqglrqPKy5YVoIKSSYZ9WTG6'),
(14, 'risa', 'risa@mail.com', '$2y$10$.R2WV5iTTK1LfrjTfRi/ruj9//JtiPdKOAOaJ6u/0SBGA4LYQNEPO'),
(16, 'nana', 'nana@mail.com', '$2y$10$Xnvj6ClTVQNuKtLH6ATq/eWuSmwTO4nq/0YyvmxN5f0I8ysqiNn2K'),
(17, 'fera', 'fera@mail.com', '$2y$10$NWYkKbWSHZ2R81Sqdllb.u4RetHHdOHPKOPUSRZvBQI70oo/28uAy'),
(18, 'siwa', 'siwa@mail.com', '$2y$10$AWs5890cN1BBMK.DdD8Ep.kuQsyyIOoBkKq5coFkMUn7ofFleesM6');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `detail_rekam_medis`
--
ALTER TABLE `detail_rekam_medis`
  ADD PRIMARY KEY (`iddetail_rekam_medis`),
  ADD KEY `fk_detail_rekam_medis_rekam_medis1_idx` (`idrekam_medis`),
  ADD KEY `idkode_tindakan_terapi` (`idkode_tindakan_terapi`);

--
-- Indexes for table `dokter`
--
ALTER TABLE `dokter`
  ADD PRIMARY KEY (`id_dokter`),
  ADD KEY `fk_dokter_user` (`iduser`);

--
-- Indexes for table `jenis_hewan`
--
ALTER TABLE `jenis_hewan`
  ADD PRIMARY KEY (`idjenis_hewan`);

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`idkategori`);

--
-- Indexes for table `kategori_klinis`
--
ALTER TABLE `kategori_klinis`
  ADD PRIMARY KEY (`idkategori_klinis`);

--
-- Indexes for table `kode_tindakan_terapi`
--
ALTER TABLE `kode_tindakan_terapi`
  ADD PRIMARY KEY (`idkode_tindakan_terapi`),
  ADD KEY `fk_kode_tindakan_terapi_kategori1_idx` (`idkategori`),
  ADD KEY `fk_kode_tindakan_terapi_kategori_klinis1_idx` (`idkategori_klinis`);

--
-- Indexes for table `pemilik`
--
ALTER TABLE `pemilik`
  ADD PRIMARY KEY (`idpemilik`),
  ADD KEY `fk_pemilik_user1_idx` (`iduser`);

--
-- Indexes for table `perawat`
--
ALTER TABLE `perawat`
  ADD PRIMARY KEY (`id_perawat`),
  ADD KEY `fk_perawat_user` (`iduser`);

--
-- Indexes for table `pet`
--
ALTER TABLE `pet`
  ADD PRIMARY KEY (`idpet`),
  ADD KEY `fk_pet_pemilik1_idx` (`idpemilik`),
  ADD KEY `fk_pet_ras_hewan1_idx` (`idras_hewan`);

--
-- Indexes for table `ras_hewan`
--
ALTER TABLE `ras_hewan`
  ADD PRIMARY KEY (`idras_hewan`),
  ADD KEY `fk_ras_hewan_jenis_hewan1_idx` (`idjenis_hewan`);

--
-- Indexes for table `rekam_medis`
--
ALTER TABLE `rekam_medis`
  ADD PRIMARY KEY (`idrekam_medis`),
  ADD KEY `fk_rekam_medis_role_user1_idx` (`dokter_pemeriksa`),
  ADD KEY `fk_rekam_medis_temu_dokter` (`idreservasi_dokter`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`idrole`);

--
-- Indexes for table `role_user`
--
ALTER TABLE `role_user`
  ADD PRIMARY KEY (`idrole_user`),
  ADD KEY `fk_role_user_user_idx` (`iduser`),
  ADD KEY `fk_role_user_role1_idx` (`idrole`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `temu_dokter`
--
ALTER TABLE `temu_dokter`
  ADD PRIMARY KEY (`idreservasi_dokter`),
  ADD KEY `fk_temu_dokter_pet` (`idpet`),
  ADD KEY `fk_temu_dokter_role_user` (`idrole_user`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`iduser`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `detail_rekam_medis`
--
ALTER TABLE `detail_rekam_medis`
  MODIFY `iddetail_rekam_medis` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `dokter`
--
ALTER TABLE `dokter`
  MODIFY `id_dokter` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `jenis_hewan`
--
ALTER TABLE `jenis_hewan`
  MODIFY `idjenis_hewan` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `idkategori` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `kategori_klinis`
--
ALTER TABLE `kategori_klinis`
  MODIFY `idkategori_klinis` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `kode_tindakan_terapi`
--
ALTER TABLE `kode_tindakan_terapi`
  MODIFY `idkode_tindakan_terapi` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `pemilik`
--
ALTER TABLE `pemilik`
  MODIFY `idpemilik` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `perawat`
--
ALTER TABLE `perawat`
  MODIFY `id_perawat` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `pet`
--
ALTER TABLE `pet`
  MODIFY `idpet` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `ras_hewan`
--
ALTER TABLE `ras_hewan`
  MODIFY `idras_hewan` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `rekam_medis`
--
ALTER TABLE `rekam_medis`
  MODIFY `idrekam_medis` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `idrole` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `role_user`
--
ALTER TABLE `role_user`
  MODIFY `idrole_user` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `temu_dokter`
--
ALTER TABLE `temu_dokter`
  MODIFY `idreservasi_dokter` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `iduser` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `detail_rekam_medis`
--
ALTER TABLE `detail_rekam_medis`
  ADD CONSTRAINT `fk_detail_rekam_medis_ktt` FOREIGN KEY (`idkode_tindakan_terapi`) REFERENCES `kode_tindakan_terapi` (`idkode_tindakan_terapi`),
  ADD CONSTRAINT `fk_detail_rekam_medis_rekam_medis1` FOREIGN KEY (`idrekam_medis`) REFERENCES `rekam_medis` (`idrekam_medis`);

--
-- Constraints for table `dokter`
--
ALTER TABLE `dokter`
  ADD CONSTRAINT `fk_dokter_user` FOREIGN KEY (`iduser`) REFERENCES `user` (`iduser`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `kode_tindakan_terapi`
--
ALTER TABLE `kode_tindakan_terapi`
  ADD CONSTRAINT `fk_ktt_kategori` FOREIGN KEY (`idkategori`) REFERENCES `kategori` (`idkategori`),
  ADD CONSTRAINT `fk_ktt_kategori_klinis` FOREIGN KEY (`idkategori_klinis`) REFERENCES `kategori_klinis` (`idkategori_klinis`);

--
-- Constraints for table `pemilik`
--
ALTER TABLE `pemilik`
  ADD CONSTRAINT `fk_pemilik_user1` FOREIGN KEY (`iduser`) REFERENCES `user` (`iduser`);

--
-- Constraints for table `perawat`
--
ALTER TABLE `perawat`
  ADD CONSTRAINT `fk_perawat_user` FOREIGN KEY (`iduser`) REFERENCES `user` (`iduser`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `pet`
--
ALTER TABLE `pet`
  ADD CONSTRAINT `fk_pet_pemilik1` FOREIGN KEY (`idpemilik`) REFERENCES `pemilik` (`idpemilik`),
  ADD CONSTRAINT `fk_pet_ras_hewan1` FOREIGN KEY (`idras_hewan`) REFERENCES `ras_hewan` (`idras_hewan`);

--
-- Constraints for table `ras_hewan`
--
ALTER TABLE `ras_hewan`
  ADD CONSTRAINT `fk_ras_hewan_jenis_hewan1` FOREIGN KEY (`idjenis_hewan`) REFERENCES `jenis_hewan` (`idjenis_hewan`);

--
-- Constraints for table `rekam_medis`
--
ALTER TABLE `rekam_medis`
  ADD CONSTRAINT `fk_rekam_medis_temu_dokter` FOREIGN KEY (`idreservasi_dokter`) REFERENCES `temu_dokter` (`idreservasi_dokter`),
  ADD CONSTRAINT `rekam_medis_ibfk_1` FOREIGN KEY (`dokter_pemeriksa`) REFERENCES `role_user` (`idrole_user`);

--
-- Constraints for table `role_user`
--
ALTER TABLE `role_user`
  ADD CONSTRAINT `fk_role_user_role1` FOREIGN KEY (`idrole`) REFERENCES `role` (`idrole`),
  ADD CONSTRAINT `fk_role_user_user` FOREIGN KEY (`iduser`) REFERENCES `user` (`iduser`);

--
-- Constraints for table `temu_dokter`
--
ALTER TABLE `temu_dokter`
  ADD CONSTRAINT `fk_temu_dokter_pet` FOREIGN KEY (`idpet`) REFERENCES `pet` (`idpet`),
  ADD CONSTRAINT `fk_temu_dokter_role_user` FOREIGN KEY (`idrole_user`) REFERENCES `role_user` (`idrole_user`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
