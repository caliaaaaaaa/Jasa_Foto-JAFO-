-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 05, 2026 at 08:02 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `jafo`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity_log`
--

CREATE TABLE `activity_log` (
  `id_log` int NOT NULL,
  `id_user` int DEFAULT NULL,
  `aktivitas` text,
  `action` varchar(50) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `role` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `activity_log`
--

INSERT INTO `activity_log` (`id_log`, `id_user`, `aktivitas`, `action`, `created_at`, `role`) VALUES
(1, 1, 'Menambah user', 'insert', '2026-03-27 12:38:07', 'admin'),
(2, 1, 'Nonaktifkan user', 'update', '2026-03-27 12:38:11', 'admin'),
(3, 1, 'Menambah paket foto', 'insert', '2026-03-27 15:22:40', 'admin'),
(4, 1, 'Menambah paket foto', 'insert', '2026-03-27 15:33:47', 'admin'),
(5, 1, 'Menambah paket foto', 'insert', '2026-03-27 15:45:30', 'admin'),
(6, 1, 'Menambah paket foto', 'insert', '2026-03-27 15:46:22', 'admin'),
(7, 1, 'Nonaktifkan user', 'update', '2026-03-28 08:26:30', 'admin'),
(8, 1, 'Nonaktifkan user', 'update', '2026-03-28 08:26:32', 'admin'),
(9, 1, 'Hapus paket foto', 'delete', '2026-03-29 09:23:08', 'admin'),
(10, 1, 'Hapus paket foto', 'delete', '2026-03-29 09:23:16', 'admin'),
(11, 1, 'Hapus paket foto', 'delete', '2026-03-29 09:23:21', 'admin'),
(12, 1, 'Hapus paket foto', 'delete', '2026-03-29 09:23:26', 'admin'),
(13, 1, 'Hapus paket foto', 'delete', '2026-03-29 09:23:30', 'admin'),
(14, 1, 'Hapus paket foto', 'delete', '2026-03-29 09:23:34', 'admin'),
(15, 1, 'Hapus paket foto', 'delete', '2026-03-29 09:23:38', 'admin'),
(16, 1, 'Hapus paket foto', 'delete', '2026-03-29 09:23:42', 'admin'),
(17, 1, 'Hapus paket foto', 'delete', '2026-03-29 09:23:48', 'admin'),
(18, 1, 'Update paket foto', 'update', '2026-03-29 09:23:56', 'admin'),
(19, 1, 'Update paket foto', 'update', '2026-03-29 09:24:11', 'admin'),
(20, 1, 'Update user', 'update', '2026-03-29 09:59:22', 'admin'),
(21, 1, 'Update user', 'update', '2026-03-29 09:59:27', 'admin'),
(22, 1, 'Nonaktifkan user', 'update', '2026-03-29 09:59:31', 'admin'),
(23, 1, 'Nonaktifkan user', 'update', '2026-03-29 10:06:15', 'admin'),
(24, 1, 'Menambah user', 'insert', '2026-03-29 10:47:42', 'admin'),
(25, 1, 'Menambah user', 'insert', '2026-03-29 10:48:08', 'admin'),
(26, 1, 'Menambah user', 'insert', '2026-03-29 10:48:34', 'admin'),
(27, 1, 'Nonaktifkan user', 'update', '2026-03-29 11:31:17', 'admin'),
(28, 1, 'Hapus paket foto', 'delete', '2026-03-29 12:58:04', 'admin'),
(29, 1, 'Hapus paket foto', 'delete', '2026-03-29 12:58:11', 'admin'),
(30, 1, 'Hapus paket foto', 'delete', '2026-03-29 13:00:21', 'admin'),
(31, 1, 'Update paket foto', 'update', '2026-03-29 13:00:35', 'admin'),
(32, 1, 'Hapus paket foto', 'delete', '2026-03-29 13:00:43', 'admin'),
(33, 1, 'Update paket foto', 'update', '2026-04-05 04:41:15', NULL),
(34, 1, 'Update paket foto', 'update', '2026-04-05 04:41:21', NULL),
(35, 1, 'Update paket foto', 'update', '2026-04-05 04:41:30', NULL),
(36, 1, 'Update user', 'update', '2026-04-05 04:41:46', NULL),
(37, 1, 'Menambah user', 'insert', '2026-04-05 04:42:03', NULL),
(38, 2, 'Menambah transaksi', 'insert', '2026-04-05 06:30:20', 'kasir'),
(39, 1, 'Update paket foto', 'update', '2026-04-05 07:02:35', 'admin'),
(40, 1, 'Update paket foto', 'update', '2026-04-05 07:02:46', 'admin'),
(41, 1, 'Hapus paket foto', 'delete', '2026-04-05 07:03:29', 'admin'),
(42, 1, 'Update paket foto', 'update', '2026-04-05 07:42:49', 'admin'),
(43, 1, 'Update paket foto', 'update', '2026-04-05 07:43:03', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id_customer` int NOT NULL,
  `nama_lengkap` varchar(100) NOT NULL,
  `no_hp` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `paket_foto`
--

CREATE TABLE `paket_foto` (
  `id_paket` int NOT NULL,
  `nama_paket` varchar(100) NOT NULL,
  `deskripsi` text,
  `harga` int NOT NULL,
  `durasi_jam` int DEFAULT NULL,
  `gambar` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `jenis` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `paket_foto`
--

INSERT INTO `paket_foto` (`id_paket`, `nama_paket`, `deskripsi`, `harga`, `durasi_jam`, `gambar`, `created_at`, `updated_at`, `jenis`) VALUES
(9, 'Prewedding', '✅ Durasi max 2 Jam\r\n✅ Semua file foto softcopy HD\r\n✅ 10 foto edit premium\r\n✅ File dikirim melalui Google Drive / Flashdisk', 600000, 2, 'download_(4).jpg', '2026-03-29 06:28:21', NULL, 'Premium'),
(15, 'wisuda', 'free\r\nfree', 30000, 2, '54134130d2035bad09538ffae6f2164c.jpg', '2026-03-29 13:02:21', NULL, 'Basic'),
(17, 'Foto keluarga', 'fre fre\r\nahay ahay', 300000, 2, 'Kami__(@kamiidea)_•_Instagram_photos_and_videos.jpg', '2026-04-01 09:09:24', NULL, 'Basic');

-- --------------------------------------------------------

--
-- Table structure for table `status_pesanan`
--

CREATE TABLE `status_pesanan` (
  `id_status` int NOT NULL,
  `id_transaction` int DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `tanggal_update` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id_transaction` int NOT NULL,
  `nomor_pesanan` varchar(50) NOT NULL,
  `id_customer` int DEFAULT NULL,
  `id_paket` int DEFAULT NULL,
  `tanggal_transaksi` date DEFAULT NULL,
  `tanggal_acara` date DEFAULT NULL,
  `jam_acara` time DEFAULT NULL,
  `lokasi` text,
  `total_harga` int DEFAULT NULL,
  `uang_bayar` int DEFAULT NULL,
  `uang_kembali` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `nama_lengkap` varchar(100) DEFAULT NULL,
  `no_hp` varchar(20) DEFAULT NULL,
  `status` enum('menunggu','proses','selesai') DEFAULT 'menunggu',
  `id_user` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id_transaction`, `nomor_pesanan`, `id_customer`, `id_paket`, `tanggal_transaksi`, `tanggal_acara`, `jam_acara`, `lokasi`, `total_harga`, `uang_bayar`, `uang_kembali`, `created_at`, `nama_lengkap`, `no_hp`, `status`, `id_user`) VALUES
(9, 'ORD-20260404-6847', NULL, 17, '2026-04-04', '2026-04-10', '20:00:00', 'bandung', 300000, 400000, 100, '2026-04-04 09:38:09', 'cimey', '081572244702', 'proses', 2),
(10, 'ORD-20260404-5255', NULL, 15, '2026-04-04', '2026-04-22', '16:40:00', 'bandung', 30000, 7000, -23, '2026-04-04 09:38:49', 'meysa aulia', '081572244702', 'selesai', 2),
(11, 'ORD-20260405-7201', NULL, 15, '2026-04-05', '2026-04-22', '11:45:00', 'bandung', 30000, 40000, 10, '2026-04-05 04:42:52', 'vini', '081572244702', 'menunggu', 2),
(12, 'ORD-20260405-1390', NULL, 15, '2026-04-05', '2026-04-30', '12:50:00', 'bandung', 30000, 90000, 60, '2026-04-05 05:50:43', 'meysa aulia', '081572244702', 'menunggu', 2),
(13, 'ORD-20260405-4101', NULL, 15, '2026-04-05', '2026-04-29', '13:30:00', 'bandung', 30000, 90000, 60, '2026-04-05 06:30:20', 'nana', '081572244702', 'menunggu', 2);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id_user` int NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','kasir','owner') NOT NULL,
  `nama_lengkap` varchar(100) DEFAULT NULL,
  `status` enum('aktif','nonaktif') DEFAULT 'aktif',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id_user`, `username`, `password`, `role`, `nama_lengkap`, `status`, `created_at`) VALUES
(1, 'Hany', '00ba7ceab606427071d5d755ea99e976', 'admin', 'Hanyfiah Bilqis', 'aktif', '2026-03-26 14:40:10'),
(2, 'Nady', '7d61e5f3d03280bf4b009e53784dbfe6', 'kasir', 'Nadya Galuh', 'aktif', '2026-03-26 14:40:10'),
(3, 'Mely', '56c425f732f5236c13a1ed8e87a7861d', 'owner', 'Meli Handayani', 'aktif', '2026-03-26 14:40:10'),
(4, 'memey', 'b43f0d17637a093a46572ec02c0ab9c7', 'kasir', 'Meysa Aulia', 'nonaktif', '2026-03-27 12:38:07'),
(5, 'wapiq', 'bbe42cde3b1ce695322a035d5c34fcc2', 'kasir', 'wapiq nurjanah', 'aktif', '2026-03-29 10:47:42'),
(6, 'erika', '6f0444177f8f6b8f7fe30c3126f411d3', 'kasir', 'erika iklima', 'aktif', '2026-03-29 10:48:08'),
(7, 'kia', 'a92fd82c10a14bf92482e01ed5a9b069', 'kasir', 'saskia putria', 'aktif', '2026-03-29 10:48:34'),
(8, 'ujin', '31e3eb8ac14a80d86fe8bae1f60f3a37', 'admin', 'sutsujin', 'aktif', '2026-04-05 04:42:03');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity_log`
--
ALTER TABLE `activity_log`
  ADD PRIMARY KEY (`id_log`),
  ADD KEY `fk_user_log` (`id_user`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id_customer`);

--
-- Indexes for table `paket_foto`
--
ALTER TABLE `paket_foto`
  ADD PRIMARY KEY (`id_paket`);

--
-- Indexes for table `status_pesanan`
--
ALTER TABLE `status_pesanan`
  ADD PRIMARY KEY (`id_status`),
  ADD KEY `fk_transaksi_status` (`id_transaction`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id_transaction`),
  ADD KEY `fk_customer` (`id_customer`),
  ADD KEY `fk_paket` (`id_paket`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity_log`
--
ALTER TABLE `activity_log`
  MODIFY `id_log` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id_customer` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `paket_foto`
--
ALTER TABLE `paket_foto`
  MODIFY `id_paket` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `status_pesanan`
--
ALTER TABLE `status_pesanan`
  MODIFY `id_status` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id_transaction` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `activity_log`
--
ALTER TABLE `activity_log`
  ADD CONSTRAINT `fk_user_log` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`);

--
-- Constraints for table `status_pesanan`
--
ALTER TABLE `status_pesanan`
  ADD CONSTRAINT `fk_transaksi_status` FOREIGN KEY (`id_transaction`) REFERENCES `transactions` (`id_transaction`);

--
-- Constraints for table `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `fk_customer` FOREIGN KEY (`id_customer`) REFERENCES `customers` (`id_customer`),
  ADD CONSTRAINT `fk_paket` FOREIGN KEY (`id_paket`) REFERENCES `paket_foto` (`id_paket`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
