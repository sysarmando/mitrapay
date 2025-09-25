-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.4.32-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win64
-- HeidiSQL Version:             12.10.0.7000
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for pemalu
CREATE DATABASE IF NOT EXISTS `pemalu` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;
USE `pemalu`;

-- Dumping structure for table pemalu.antrian
CREATE TABLE IF NOT EXISTS `antrian` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nomor` varchar(10) DEFAULT NULL,
  `layanan` varchar(25) DEFAULT NULL,
  `nama` varchar(250) DEFAULT NULL,
  `nohp` varchar(15) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `tanggal` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `waktu_selesai` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table pemalu.antrian: ~18 rows (approximately)
REPLACE INTO `antrian` (`id`, `nomor`, `layanan`, `nama`, `nohp`, `status`, `tanggal`, `created_at`, `updated_at`, `waktu_selesai`) VALUES
	(14, 'B-001', 'Permintaan Data', 'ryan', '6281210937653', 'selesai', '2025-05-21 16:22:16', '2025-05-21 16:22:16', '2025-06-05 14:18:34', NULL),
	(15, 'B-002', 'Permintaan Data', 'uji', '6281216513132', 'selesai', '2025-05-21 16:27:31', '2025-05-21 16:27:31', '2025-06-06 00:23:22', NULL),
	(16, 'A-003', 'Konsultasi Statistik', 'saya', '6251984132131', 'menunggu', '2025-05-21 16:27:43', '2025-05-21 16:27:43', '2025-05-21 17:12:43', NULL),
	(20, 'B-001', 'Permintaan Data', 'lagilagi', '6281210937653', 'selesai', '2025-05-22 08:10:19', '2025-05-22 08:10:19', '2025-06-05 14:18:34', NULL),
	(21, 'A-002', 'Konsultasi Statistik', 'ryanana', '62815321321', 'selesai', '2025-05-22 08:24:07', '2025-05-22 08:24:07', '2025-05-22 09:12:09', NULL),
	(22, 'C-003', 'Pengaduan', 'hayo', '628123641321', 'dipanggil', '2025-05-22 08:30:58', '2025-05-22 08:30:58', '2025-05-22 09:13:53', NULL),
	(23, 'B-004', 'Permintaan Data', 'halohalo', '62812156431356', 'menunggu', '2025-05-22 08:55:30', '2025-05-22 08:55:30', '2025-05-22 08:55:30', NULL),
	(24, 'B-001', 'Permintaan Data', 'Ryanasd', '6281210937653', 'selesai', '2025-05-31 19:32:59', '2025-05-31 19:32:59', '2025-06-05 14:18:34', NULL),
	(25, 'B-002', 'Permintaan Data', 'hasbi', '62815616516511', 'selesai', '2025-05-31 19:33:12', '2025-05-31 19:33:12', '2025-06-06 00:23:22', NULL),
	(26, 'A-003', 'Konsultasi Statistik', 'Konsultasi', '62841651651651', 'menunggu', '2025-05-31 19:54:50', '2025-05-31 19:54:50', '2025-05-31 19:54:50', NULL),
	(27, 'B-004', 'Permintaan Data', 'Rasadjl', '621561561555', 'menunggu', '2025-05-31 20:52:50', '2025-05-31 20:52:50', '2025-05-31 20:52:50', NULL),
	(28, 'B-001', 'Permintaan Data', 'GGGG', '62812416516130', 'selesai', '2025-06-04 13:40:28', '2025-06-04 13:40:28', '2025-06-05 14:18:34', NULL),
	(29, 'B-001', 'Permintaan Data', 'Ryan Tes QR', '6281210937653', 'selesai', '2025-06-05 11:34:33', '2025-06-05 11:34:33', '2025-06-05 18:57:31', NULL),
	(30, 'B-002', 'Permintaan Data', 'Ryan CCC', '62812103654321', 'selesai', '2025-06-05 14:19:59', '2025-06-05 14:19:59', '2025-06-06 00:23:22', NULL),
	(31, 'B-003', 'Permintaan Data', 'Aldo', '628124651651', 'selesai', '2025-06-05 23:39:31', '2025-06-05 23:39:31', '2025-06-05 23:44:47', NULL),
	(32, 'B-001', 'Permintaan Data', 'Ryan testes', '6281210937653', 'selesai', '2025-06-06 00:00:55', '2025-06-06 00:00:55', '2025-06-06 00:22:12', NULL),
	(33, 'B-002', 'Permintaan Data', 'tes antrian', '6205616516516', 'dipanggil', '2025-06-06 00:20:40', '2025-06-06 00:20:40', '2025-06-06 00:31:39', NULL),
	(34, 'B-003', 'Permintaan Data', 'Ryanan', '621896165165', 'selesai', '2025-06-06 00:32:33', '2025-06-06 00:32:33', '2025-06-06 00:45:01', NULL);

-- Dumping structure for table pemalu.kepuasan
CREATE TABLE IF NOT EXISTS `kepuasan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kepuasan` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table pemalu.kepuasan: ~4 rows (approximately)
REPLACE INTO `kepuasan` (`id`, `kepuasan`) VALUES
	(1, 'Sangat Tidak Puas'),
	(2, 'Tidak Puas'),
	(3, 'Cukup Puas'),
	(4, 'Puas'),
	(5, 'Sangat Puas');

-- Dumping structure for table pemalu.pelayanan
CREATE TABLE IF NOT EXISTS `pelayanan` (
  `kode` varchar(1) NOT NULL,
  `pelayanan` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`kode`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table pemalu.pelayanan: ~3 rows (approximately)
REPLACE INTO `pelayanan` (`kode`, `pelayanan`) VALUES
	('A', 'Konsultasi Statistik'),
	('B', 'Permintaan Data'),
	('C', 'Pengaduan');

-- Dumping structure for table pemalu.status_user
CREATE TABLE IF NOT EXISTS `status_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `status_user` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=100 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table pemalu.status_user: ~2 rows (approximately)
REPLACE INTO `status_user` (`id`, `status_user`) VALUES
	(1, 'operator'),
	(2, 'viewer'),
	(99, 'admin');

-- Dumping structure for table pemalu.survey_kepuasan
CREATE TABLE IF NOT EXISTS `survey_kepuasan` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `rating` varchar(50) DEFAULT NULL,
  `komentar` varchar(250) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table pemalu.survey_kepuasan: ~4 rows (approximately)
REPLACE INTO `survey_kepuasan` (`id`, `rating`, `komentar`, `created_at`, `updated_at`) VALUES
	(7, '3', 'Pelayanan sangat memuaskan. Terimakasih.', '2025-05-21 12:53:39', '2025-05-21 13:15:15'),
	(8, '3', 'Tes Drive', '2025-05-21 13:57:43', '2025-05-21 13:57:43'),
	(9, '3', 'Petugas pelayan melayani kami dengan baik. Terimakasih', '2025-05-22 09:29:12', '2025-05-22 09:29:12'),
	(10, '1', 'Petugas pelayan tidak berpakaian rapi', '2025-05-22 09:29:38', '2025-05-22 09:29:38'),
	(11, '2', 'Pelayanan memuaskan', '2025-05-22 09:33:56', '2025-05-22 09:33:56'),
	(12, '2', 'kkkk\r\n\r\n', '2025-05-31 18:08:02', '2025-05-31 18:08:02'),
	(13, '3', 'Pelayanan prima dan memuaskan', '2025-06-06 00:04:58', '2025-06-06 00:04:58');

-- Dumping structure for table pemalu.users
CREATE TABLE IF NOT EXISTS `users` (
  `username` varchar(50) NOT NULL,
  `password` varchar(250) NOT NULL,
  `nama_lengkap` varchar(250) NOT NULL,
  `email` varchar(250) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `role_id` int(11) DEFAULT NULL,
  `status` varchar(1) DEFAULT '1',
  PRIMARY KEY (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table pemalu.users: ~4 rows (approximately)
REPLACE INTO `users` (`username`, `password`, `nama_lengkap`, `email`, `created_at`, `role_id`, `status`) VALUES
	('admin', '$2y$10$WG5dZgfuJw8AhtuDU66dX.VFd6edpFMCj871As0YWmq4wVnCywv.a', 'ADMINISTRATOR', 'admin@example.com', '2025-04-28 07:43:09', 99, '1'),
	('operator', '$2y$10$eVm2.8C4g7m6t9WO3/AR/ObwmeJjwlmDzIzosUH82LuXxXObqzeLm', 'OPERATOR', 'operator@example.com', '2025-04-28 11:36:09', 1, '1'),
	('super', '$2y$10$1KUGbYRDX5nXsovu89sPhOPNHlgXdfqaZaob0qHgnF3..po5YjVze', 'Super', 'super@user.com', '2025-06-05 15:00:08', 99, '1'),
	('viewer', '$2y$10$6zvgzI5PkL7npgAUY0FPFuxsNiSzq4wqUAUALW6KPICiSHLijnDHG', 'VIEWER', 'viewer@example.com', '2025-04-29 00:40:25', 2, '1');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
