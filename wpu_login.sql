-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.4.22-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win64
-- HeidiSQL Version:             12.5.0.6677
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Dumping structure for table wpu_login.b_legal
DROP TABLE IF EXISTS `b_legal`;
CREATE TABLE IF NOT EXISTS `b_legal` (
  `no` int(11) NOT NULL AUTO_INCREMENT,
  `id_mp` varchar(30) DEFAULT NULL,
  `id_coa` varchar(30) NOT NULL,
  `tanggal` date NOT NULL,
  `followup` enum('STAFF','ANALYST','SECTION HEAD','DEPT HEAD','DEPUTY','KADIV','BOD','LEGAL','DONE','NONE') NOT NULL,
  `proses` enum('0','1','2') NOT NULL,
  `filename` text NOT NULL,
  `m1` int(1) NOT NULL,
  `m2` varchar(128) NOT NULL,
  `m3` int(1) NOT NULL,
  `m4` int(1) NOT NULL,
  `m5` int(1) NOT NULL,
  PRIMARY KEY (`no`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC;

-- Dumping data for table wpu_login.b_legal: ~0 rows (approximately)
DELETE FROM `b_legal`;

-- Dumping structure for table wpu_login.b_mp
DROP TABLE IF EXISTS `b_mp`;
CREATE TABLE IF NOT EXISTS `b_mp` (
  `no` int(11) NOT NULL AUTO_INCREMENT,
  `id_mp` varchar(30) NOT NULL,
  `id_coa` varchar(30) NOT NULL,
  `tanggal` date NOT NULL,
  `followup` enum('STAFF','ANALYST','SECTION HEAD','DEPT HEAD','DEPUTY','KADIV','BOD','LEGAL','DONE','NONE') NOT NULL DEFAULT 'NONE',
  `proses` enum('0','1','2') NOT NULL,
  `filename` text NOT NULL,
  `m1` text NOT NULL,
  `m2` int(1) NOT NULL,
  `m3` int(1) NOT NULL,
  `m4` int(1) NOT NULL,
  `m5` int(1) NOT NULL,
  PRIMARY KEY (`no`) USING BTREE,
  UNIQUE KEY `id_mp` (`id_mp`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC;

-- Dumping data for table wpu_login.b_mp: ~0 rows (approximately)
DELETE FROM `b_mp`;

-- Dumping structure for table wpu_login.b_plan_busage
DROP TABLE IF EXISTS `b_plan_busage`;
CREATE TABLE IF NOT EXISTS `b_plan_busage` (
  `no` int(11) NOT NULL AUTO_INCREMENT,
  `id_mp` varchar(30) DEFAULT NULL,
  `id_coa` varchar(30) DEFAULT NULL,
  `nama_coa` varchar(255) DEFAULT NULL,
  `estimasi` bigint(20) DEFAULT NULL,
  `keterangan` enum('0','1') DEFAULT NULL,
  `kategori_budjet` enum('MP','Petty Cash','CAR') DEFAULT NULL,
  PRIMARY KEY (`no`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC;

-- Dumping data for table wpu_login.b_plan_busage: ~0 rows (approximately)
DELETE FROM `b_plan_busage`;

-- Dumping structure for table wpu_login.b_procurement
DROP TABLE IF EXISTS `b_procurement`;
CREATE TABLE IF NOT EXISTS `b_procurement` (
  `no` int(11) NOT NULL AUTO_INCREMENT,
  `id_mp` varchar(30) NOT NULL,
  `id_coa` varchar(30) NOT NULL,
  `tanggal` date NOT NULL,
  `followup` enum('STAFF','ANALYST','SECTION HEAD','DEPT HEAD','DEPUTY','KADIV','BOD','LEGAL','DONE','NONE') NOT NULL,
  `proses` enum('0','1','2') NOT NULL,
  `filename` text NOT NULL,
  `m1` text NOT NULL,
  `m2` varchar(100) NOT NULL,
  `m3` bigint(20) NOT NULL,
  `m4` text NOT NULL,
  `m5` int(1) NOT NULL,
  PRIMARY KEY (`no`) USING BTREE,
  UNIQUE KEY `id_mp` (`id_mp`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC;

-- Dumping data for table wpu_login.b_procurement: ~0 rows (approximately)
DELETE FROM `b_procurement`;

-- Dumping structure for table wpu_login.b_si
DROP TABLE IF EXISTS `b_si`;
CREATE TABLE IF NOT EXISTS `b_si` (
  `no` int(11) NOT NULL AUTO_INCREMENT,
  `id_mp` varchar(30) NOT NULL,
  `id_coa` varchar(30) NOT NULL,
  `tanggal` date NOT NULL,
  `proses` enum('0','1','2') NOT NULL,
  `followup` enum('STAFF','ANALYST','SECTION HEAD','DEPT HEAD','DEPUTY','KADIV','BOD','LEGAL','DONE','NONE','VENDOR') NOT NULL,
  `filename` text NOT NULL,
  `mulai` date NOT NULL,
  `akhir` date NOT NULL,
  `aktual_end` date NOT NULL,
  `m1` int(11) NOT NULL,
  `m2` int(11) NOT NULL,
  PRIMARY KEY (`no`) USING BTREE,
  UNIQUE KEY `id_mp` (`id_mp`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC;

-- Dumping data for table wpu_login.b_si: ~0 rows (approximately)
DELETE FROM `b_si`;

-- Dumping structure for table wpu_login.departement
DROP TABLE IF EXISTS `departement`;
CREATE TABLE IF NOT EXISTS `departement` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `inisial` varchar(128) NOT NULL DEFAULT '',
  `departement` varchar(128) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table wpu_login.departement: ~13 rows (approximately)
DELETE FROM `departement`;
INSERT INTO `departement` (`id`, `inisial`, `departement`) VALUES
	(1, 'MAIN', 'Maintenance'),
	(2, 'CCO', 'Corporate communication'),
	(3, 'FIN', 'Finance'),
	(4, 'TRAF', 'Traffic'),
	(5, 'CEHS', 'ISO, EHS & RSA'),
	(6, 'TRANS', 'Transaction'),
	(7, 'GS', 'HC Operation'),
	(8, 'COMM', 'Business Development'),
	(9, 'CP', 'Corporate Planning'),
	(10, 'IT', 'IT'),
	(11, 'HCD', 'HC Development'),
	(12, 'LEG', 'Legal'),
	(13, 'GS', 'General service');

-- Dumping structure for table wpu_login.log_download
DROP TABLE IF EXISTS `log_download`;
CREATE TABLE IF NOT EXISTS `log_download` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kategori` varchar(128) NOT NULL,
  `filename` varchar(128) NOT NULL,
  `tahun` int(11) NOT NULL,
  `departement` varchar(128) NOT NULL,
  `created_date` datetime NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table wpu_login.log_download: ~2 rows (approximately)
DELETE FROM `log_download`;
INSERT INTO `log_download` (`id`, `kategori`, `filename`, `tahun`, `departement`, `created_date`) VALUES
	(1, 'report budget rencana', 'Report-budget-rencana-20230626145858.xlsx', 2023, 'IT', '2023-06-26 14:59:01'),
	(2, 'report budget rencana', 'Report-budget-rencana-20230626150024.xlsx', 2023, 'IT', '2023-06-26 15:00:24'),
	(3, 'report budget rencana', 'Report-budget-rencana-20230711160148.xlsx', 2023, 'IT', '2023-07-11 16:01:51');

-- Dumping structure for table wpu_login.m_coa
DROP TABLE IF EXISTS `m_coa`;
CREATE TABLE IF NOT EXISTS `m_coa` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `account_number` int(11) NOT NULL DEFAULT 0,
  `account_name` varchar(128) NOT NULL,
  `budget_category` char(20) NOT NULL DEFAULT '',
  `departement_id` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table wpu_login.m_coa: ~9 rows (approximately)
DELETE FROM `m_coa`;
INSERT INTO `m_coa` (`id`, `account_number`, `account_name`, `budget_category`, `departement_id`) VALUES
	(1, 106103, 'Surveilance equipment', 'Capex', 10),
	(2, 506102, 'Maint - Computer', 'Opex', 10),
	(3, 105106, 'Cost - Computer', 'Capex', 10),
	(4, 506107, 'Maint - Telecommunication', 'Opex', 10),
	(5, 106104, 'IT infrastructure', 'Capex', 10),
	(6, 510103, 'Internet Connection', 'Opex', 10),
	(7, 513107, 'Prof Fee - Other', 'Opex', 10),
	(8, 521100, 'Riset &amp; Development', 'Opex', 10),
	(9, 516106, 'Meeting Expenses', 'Opex', 10);

-- Dumping structure for table wpu_login.semester
DROP TABLE IF EXISTS `semester`;
CREATE TABLE IF NOT EXISTS `semester` (
  `semester_id` int(11) NOT NULL AUTO_INCREMENT,
  `semester` varchar(128) NOT NULL,
  PRIMARY KEY (`semester_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Dumping data for table wpu_login.semester: ~0 rows (approximately)
DELETE FROM `semester`;

-- Dumping structure for table wpu_login.t_budget
DROP TABLE IF EXISTS `t_budget`;
CREATE TABLE IF NOT EXISTS `t_budget` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `kode_budget` varchar(128) NOT NULL DEFAULT '',
  `m_coa_id` int(11) NOT NULL,
  `departement_id` int(11) NOT NULL,
  `departement_id_real` int(11) NOT NULL,
  `keterangan` varchar(100) NOT NULL,
  `lokasi` char(50) NOT NULL DEFAULT '',
  `tahun` char(50) NOT NULL DEFAULT '',
  `file` varchar(128) NOT NULL,
  `kategori` enum('MP','PETTY CASH','CAR') NOT NULL DEFAULT 'MP',
  `qty` varchar(10) NOT NULL,
  `satuan` varchar(20) NOT NULL,
  `total_budget_referensi` bigint(15) NOT NULL,
  `total_budget_reals` bigint(15) NOT NULL,
  `saldo` bigint(15) NOT NULL DEFAULT 0,
  `ppn` int(2) NOT NULL,
  `pic_user_id` int(11) NOT NULL,
  `status` enum('0','1','2','3','4','5') NOT NULL DEFAULT '0',
  `analisis` text NOT NULL,
  `created_date` datetime NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC;

-- Dumping data for table wpu_login.t_budget: ~18 rows (approximately)
DELETE FROM `t_budget`;
INSERT INTO `t_budget` (`id`, `kode_budget`, `m_coa_id`, `departement_id`, `departement_id_real`, `keterangan`, `lokasi`, `tahun`, `file`, `kategori`, `qty`, `satuan`, `total_budget_referensi`, `total_budget_reals`, `saldo`, `ppn`, `pic_user_id`, `status`, `analisis`, `created_date`) VALUES
	(1, 'IT/COA/0814-00001/2023', 1, 10, 10, 'Project Penambahan CCTV Mainline (cikedung - kertajati)', 'bo', '2023', 'Form_Analisa_Budget.xlsx', 'MP', '1', 'Tahun', 1412500000, 0, 0, 0, 0, '0', '', '2023-08-14 11:26:03'),
	(2, 'IT/COA/0814-00002/2023', 1, 10, 10, 'Project CCTV Building (untuk di gerbang)', 'bo', '2023', 'Form_Analisa_Budget.xlsx', 'MP', '12', 'Unit', 93600000, 0, 0, 0, 0, '0', '', '2023-08-14 14:16:35'),
	(3, 'IT/COA/0814-00003/2023', 1, 10, 10, 'Network Video Recorder', 'bo', '2023', 'Form_Analisa_Budget.xlsx', 'MP', '1', 'Tahun', 364000000, 0, 0, 0, 0, '0', '', '2023-08-14 14:21:28'),
	(4, 'IT/COA/0814-00004/2023', 1, 10, 10, 'Video Processor', 'bo', '2023', 'Form_Analisa_Budget.xlsx', 'MP', '1', 'Tahun', 378000000, 0, 0, 0, 0, '0', '', '2023-08-14 14:27:06'),
	(5, 'IT/COA/0814-00005/2023', 1, 10, 10, 'CCTV Analytics Rest Area', 'bo', '2023', 'Form_Analisa_Budget.xlsx', 'MP', '3', 'Unit', 2250000000, 0, 0, 0, 0, '0', '', '2023-08-14 14:28:11'),
	(6, 'IT/COA/0814-00006/2023', 1, 10, 10, 'Smart VMS', 'bo', '2023', 'Form_Analisa_Budget.xlsx', 'MP', '4', 'Unit', 3000000000, 0, 0, 0, 0, '0', '', '2023-08-14 14:30:00'),
	(7, 'IT/COA/0814-00007/2023', 1, 10, 10, 'VideoTron RSA 86A/B', 'bo', '2023', 'Form_Analisa_Budget.xlsx', 'MP', '2', 'Unit', 400000000, 0, 0, 0, 0, '0', '', '2023-08-14 14:31:06'),
	(8, 'IT/COA/0814-00008/2023', 5, 10, 10, 'TMC Centralize', 'bo', '2023', 'Form_Analisa_Budget.xlsx', 'MP', '1', 'Tahun', 3000000000, 0, 0, 0, 0, '0', '', '2023-08-14 14:32:23'),
	(9, 'IT/COA/0814-00009/2023', 5, 10, 10, 'Project FO Median Cikedung - Kertajati', 'bo', '2023', 'Form_Analisa_Budget.xlsx', 'MP', '1', 'Tahun', 2744000000, 0, 0, 0, 0, '0', '', '2023-08-14 14:34:29'),
	(10, 'IT/COA/0814-00010/2023', 3, 10, 10, 'Server Analitic', 'bo', '2023', 'Form_Analisa_Budget.xlsx', 'MP', '1', 'Tahun', 400000000, 0, 0, 0, 0, '0', '', '2023-08-14 14:38:28'),
	(11, 'IT/COA/0814-00011/2023', 3, 10, 10, 'PC Desktop TMC', 'bo', '2023', 'Form_Analisa_Budget.xlsx', 'MP', '6', 'Unit', 57000000, 0, 0, 0, 0, '0', '', '2023-08-14 14:40:47'),
	(12, 'IT/COA/0814-00012/2023', 3, 10, 10, 'Laptop Employee', 'bo', '2023', 'Form_Analisa_Budget.xlsx', 'MP', '4', 'Unit', 220000000, 0, 0, 0, 0, '0', '', '2023-08-14 14:41:41'),
	(13, 'IT/COA/0814-00013/2023', 3, 10, 10, 'Server Cloud persiapan MLFF', 'bo', '2023', 'Form_Analisa_Budget.xlsx', 'MP', '1', 'Tahun', 111000000, 111000000, 111000000, 0, 15, '1', '', '2023-08-14 14:48:08'),
	(14, 'IT/COA/0814-00014/2023', 3, 10, 10, 'Application Development ( App &amp; Mobile)', 'bo', '2023', 'Form_Analisa_Budget.xlsx', 'MP', '1', 'Tahun', 715000000, 0, 0, 0, 0, '0', '', '2023-08-14 14:52:09'),
	(15, 'IT/COA/0814-00015/2023', 3, 10, 10, 'Cyber Security (Design &amp; Build)', 'bo', '2023', 'Form_Analisa_Budget.xlsx', 'MP', '1', 'Tahun', 551000000, 550000000, 550000000, 0, 12, '1', '', '2023-08-14 14:52:55'),
	(16, 'IT/COA/0814-00016/2023', 2, 10, 10, 'Google suite subscribement', 'ho', '2023', 'Form_Analisa_Budget.xlsx', 'MP', '12', 'Bulan', 124800000, 0, 0, 0, 0, '0', '', '2023-08-14 14:58:57'),
	(18, 'IT/COA/0814-00018/2023', 2, 10, 10, 'Sevices Manage Server Licence', 'ho', '2023', 'Form_Analisa_Budget.xlsx', 'MP', '5', 'Unit', 5356000, 5000000, 5000000, 0, 12, '1', '', '2023-08-14 15:02:26'),
	(19, 'IT/COA/0814-00019/2023', 2, 10, 10, 'Database Web LMS', 'ho', '2023', 'Form_Analisa_Budget.xlsx', 'MP', '1', 'Tahun', 1606800, 1606800, 1606800, 0, 12, '1', '', '2023-08-14 15:03:46');

-- Dumping structure for table wpu_login.t_mp_budget
DROP TABLE IF EXISTS `t_mp_budget`;
CREATE TABLE IF NOT EXISTS `t_mp_budget` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kode_mp` varchar(128) NOT NULL DEFAULT '',
  `departement_id` varchar(255) DEFAULT NULL,
  `name_mp` varchar(255) DEFAULT NULL,
  `tahun` enum('2022','2023','2024','2025','2026') DEFAULT NULL,
  `plan_usage` enum('0','1') NOT NULL DEFAULT '0',
  `hps` text DEFAULT NULL,
  `draft_mp` text DEFAULT NULL,
  `final_mp` enum('0','1') NOT NULL DEFAULT '0',
  `kak_proc` enum('0','1') NOT NULL DEFAULT '0',
  `legal` enum('0','1') NOT NULL DEFAULT '0',
  `si` enum('0','1') NOT NULL DEFAULT '0',
  `proses` enum('MP','KAK','LEGAL','POSTPONE','SI','DONE','NONE') NOT NULL DEFAULT 'NONE',
  `status` int(11) NOT NULL DEFAULT 0,
  `pic_user_id` int(11) NOT NULL DEFAULT 0,
  `directory_file` varchar(128) NOT NULL,
  `semester_id` int(11) NOT NULL,
  `created_date` datetime NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC;

-- Dumping data for table wpu_login.t_mp_budget: ~0 rows (approximately)
DELETE FROM `t_mp_budget`;

-- Dumping structure for table wpu_login.user
DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `departement_id` int(11) NOT NULL,
  `name` varchar(128) NOT NULL,
  `email` varchar(128) NOT NULL,
  `image` varchar(128) NOT NULL,
  `password` varchar(256) NOT NULL,
  `role_id` int(11) NOT NULL,
  `is_active` int(1) NOT NULL,
  `date_created` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;

-- Dumping data for table wpu_login.user: ~4 rows (approximately)
DELETE FROM `user`;
INSERT INTO `user` (`id`, `departement_id`, `name`, `email`, `image`, `password`, `role_id`, `is_active`, `date_created`) VALUES
	(5, 10, 'Ujang Sopiyan', 'ujangsp11@gmail.com', 'ilustrasi-jalan-tol_169.jpeg', '$2y$10$PSmXPwZLtBuiGVb39mTGP.4rlxOc.6Ira5z7i1pAQapAe/sqPQR4a', 1, 1, 1552120289),
	(11, 10, 'Sandhika Galih', 'sandhikagalih@gmail.com', 'default.jpg', '$2y$10$GIuq5moUMjOa.GSTa7W0qO80YoO.lb3/Cx7PdBZAenNuiNn7e/VEy', 4, 1, 1553151354),
	(12, 10, 'Iyus', 'iyus@lintasmarga.com', 'default.jpg', '$2y$10$GIuq5moUMjOa.GSTa7W0qO80YoO.lb3/Cx7PdBZAenNuiNn7e/VEy', 5, 1, 1553151354),
	(13, 10, 'Departement IT', 'it@lintasmarga.com', 'default.jpg', '$2y$10$bT2cD4FbsvDA.DZoKRYAMuML6vVaXU.v08h2ZwKgc9E5yQOPE3r7.', 4, 1, 1693368726),
	(14, 10, 'Dede Nurjanah', 'dede@lintasmarga.com', 'default.jpg', '$2y$10$QzB.tGxcDpVAdNQtu80za.zm2qpqKDdF3Nwfdcb/2GBCthjTwXCnG', 6, 1, 1693368767),
	(15, 10, 'Lilik', 'lilik@lintasmarga.com', 'default.jpg', '$2y$10$PbSqQfhByI3YrCcGkGjRvOKIZY/zK.J4HNM6dPJnAQco4W/XjO.FW', 5, 1, 1693413276);

-- Dumping structure for table wpu_login.user_access_menu
DROP TABLE IF EXISTS `user_access_menu`;
CREATE TABLE IF NOT EXISTS `user_access_menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;

-- Dumping data for table wpu_login.user_access_menu: ~11 rows (approximately)
DELETE FROM `user_access_menu`;
INSERT INTO `user_access_menu` (`id`, `role_id`, `menu_id`) VALUES
	(1, 1, 3),
	(3, 1, 1),
	(5, 5, 2),
	(7, 5, 8),
	(8, 6, 2),
	(9, 6, 9),
	(10, 6, 8),
	(11, 6, 10),
	(12, 5, 10),
	(13, 1, 2),
	(15, 5, 9),
	(17, 7, 2),
	(18, 7, 8),
	(19, 7, 9);

-- Dumping structure for table wpu_login.user_access_submenu
DROP TABLE IF EXISTS `user_access_submenu`;
CREATE TABLE IF NOT EXISTS `user_access_submenu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL,
  `sub_menu_id` int(11) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=utf8;

-- Dumping data for table wpu_login.user_access_submenu: ~23 rows (approximately)
DELETE FROM `user_access_submenu`;
INSERT INTO `user_access_submenu` (`id`, `role_id`, `menu_id`, `sub_menu_id`) VALUES
	(1, 1, 1, 7),
	(16, 1, 2, 2),
	(17, 1, 2, 3),
	(18, 1, 2, 8),
	(19, 1, 1, 1),
	(20, 1, 1, 18),
	(21, 5, 2, 2),
	(22, 5, 8, 14),
	(23, 1, 3, 4),
	(24, 1, 3, 5),
	(25, 5, 9, 15),
	(26, 5, 9, 19),
	(27, 5, 10, 17),
	(28, 5, 2, 3),
	(29, 5, 2, 8),
	(30, 5, 10, 16),
	(31, 6, 8, 14),
	(32, 6, 2, 2),
	(33, 6, 2, 3),
	(34, 6, 2, 8),
	(35, 6, 10, 16),
	(36, 6, 10, 17),
	(37, 6, 9, 15),
	(38, 7, 2, 2),
	(39, 7, 2, 3),
	(40, 7, 2, 8),
	(41, 7, 8, 14),
	(42, 7, 9, 15);

-- Dumping structure for table wpu_login.user_menu
DROP TABLE IF EXISTS `user_menu`;
CREATE TABLE IF NOT EXISTS `user_menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL,
  `menu` varchar(128) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

-- Dumping data for table wpu_login.user_menu: ~8 rows (approximately)
DELETE FROM `user_menu`;
INSERT INTO `user_menu` (`id`, `name`, `menu`) VALUES
	(1, 'Administrator', 'Admin'),
	(2, 'Setting Profile', 'User'),
	(3, 'Setting Menu', 'Menu'),
	(6, 'Setting Budget', 'Budget'),
	(7, 'Master Data', 'Master'),
	(8, 'General', 'Dashboard'),
	(9, 'Management Paper', 'Mp'),
	(10, 'Payment Method', 'Payment');

-- Dumping structure for table wpu_login.user_role
DROP TABLE IF EXISTS `user_role`;
CREATE TABLE IF NOT EXISTS `user_role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role` varchar(128) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- Dumping data for table wpu_login.user_role: ~6 rows (approximately)
DELETE FROM `user_role`;
INSERT INTO `user_role` (`id`, `role`) VALUES
	(1, 'administrator'),
	(4, 'departement'),
	(5, 'staff'),
	(6, 'tu'),
	(7, 'supervisor'),
	(8, 'manager');

-- Dumping structure for table wpu_login.user_sub_menu
DROP TABLE IF EXISTS `user_sub_menu`;
CREATE TABLE IF NOT EXISTS `user_sub_menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `menu_id` int(11) NOT NULL,
  `title` varchar(128) NOT NULL,
  `url` varchar(128) NOT NULL,
  `icon` varchar(128) NOT NULL,
  `is_active` int(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;

-- Dumping data for table wpu_login.user_sub_menu: ~16 rows (approximately)
DELETE FROM `user_sub_menu`;
INSERT INTO `user_sub_menu` (`id`, `menu_id`, `title`, `url`, `icon`, `is_active`) VALUES
	(1, 1, 'Dashboard', 'admin', 'fas fa-fw fa-tachometer-alt', 1),
	(2, 2, 'My Profile', 'user', 'fas fa-fw fa-user', 1),
	(3, 2, 'Edit Profile', 'user/edit', 'fas fa-fw fa-user-edit', 1),
	(4, 3, 'Menu Management', 'menu', 'fas fa-fw fa-folder', 1),
	(5, 3, 'Submenu Management', 'menu/submenu', 'fas fa-fw fa-folder-open', 1),
	(7, 1, 'Role', 'admin/role', 'fas fa-fw fa-user-tie', 1),
	(8, 2, 'Change Password', 'user/changepassword', 'fas fa-fw fa-key', 1),
	(11, 6, 'Budget', 'budget', 'fas fa-fw fa-folder', 1),
	(12, 6, 'Add Budget Proposal', 'budget/proposal', 'fas fa-fw fa-folder-plus', 1),
	(13, 7, 'CoA', 'coa', 'fas fa-fw fa-database', 1),
	(14, 8, 'Dashboard', 'dashboard', 'fas fa-fw fa-tachometer-alt', 1),
	(15, 9, 'MP', 'mp', 'fas fa-fw fa-folder', 1),
	(16, 10, 'PAF', 'payment/paf', 'fas fa-fw fa-folder-open', 1),
	(17, 10, 'Petty Cash', 'payment/pettycash', 'fas fa-fw fa-folder', 1),
	(18, 1, 'User Login', 'admin/userlogin', 'fas fa-fw fa-user-plus', 1),
	(19, 9, 'Add New MP', 'mp/add', 'fas fa-fw fa-folder-plus', 1);

-- Dumping structure for table wpu_login.user_token
DROP TABLE IF EXISTS `user_token`;
CREATE TABLE IF NOT EXISTS `user_token` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(128) NOT NULL,
  `token` varchar(128) NOT NULL,
  `date_created` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- Dumping data for table wpu_login.user_token: ~0 rows (approximately)
DELETE FROM `user_token`;

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
