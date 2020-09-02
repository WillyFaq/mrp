-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.4.11-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win64
-- HeidiSQL Version:             11.0.0.5919
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Dumping structure for table dbmrp.bahan
CREATE TABLE IF NOT EXISTS `bahan` (
  `id_bahan` int(11) NOT NULL AUTO_INCREMENT,
  `nama_bahan` varchar(200) DEFAULT NULL,
  `satuan` varchar(200) DEFAULT NULL,
  `jumlah` double DEFAULT NULL,
  `ss` double(22,0) DEFAULT NULL,
  `rop` double(22,0) DEFAULT NULL,
  `LT` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_bahan`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table dbmrp.bahan: ~7 rows (approximately)
/*!40000 ALTER TABLE `bahan` DISABLE KEYS */;
INSERT INTO `bahan` (`id_bahan`, `nama_bahan`, `satuan`, `jumlah`, `ss`, `rop`, `LT`) VALUES
	(1, 'Frit Mentah tipe A Q1', 'Kg', 0, 10807, 20200, 2),
	(3, 'Frit Mentah tipe B Q2', 'Kg', 5757, 9668, 18180, 3),
	(4, 'Kaolin Q3', 'Kg', 0, 1074, 2020, 1),
	(5, 'Larutan Pencampur Q4', 'Liter', 0, 1074, 2020, 1),
	(6, 'Air Q5', 'Liter', 0, 85850, 161600, 1),
	(7, 'CMC Q6', 'Kg', 0, 10651, 20200, 1),
	(8, 'STPP Q7', 'Kg', 0, 10651, 20200, 1),
	(22, 'FM 001', 'Kg', 100000, 0, 4040, 1),
	(23, 'FM 003', 'Kg', 100000, 0, 2020, 2);
/*!40000 ALTER TABLE `bahan` ENABLE KEYS */;

-- Dumping structure for table dbmrp.bom
CREATE TABLE IF NOT EXISTS `bom` (
  `id_bom` int(11) NOT NULL AUTO_INCREMENT,
  `nama_bom` varchar(200) DEFAULT NULL,
  `satuan` varchar(50) DEFAULT NULL,
  `jumlah` double DEFAULT NULL,
  `LT` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_bom`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table dbmrp.bom: ~0 rows (approximately)
/*!40000 ALTER TABLE `bom` DISABLE KEYS */;
INSERT INTO `bom` (`id_bom`, `nama_bom`, `satuan`, `jumlah`, `LT`) VALUES
	(8, 'Chemical Frit ', 'Ton', 1, 1),
	(9, 'CF 002', 'Ton', 20, 2),
	(10, 'CF 001', 'Ton', 1, 1),
	(11, 'CF 003', 'Ton', 50, 2);
/*!40000 ALTER TABLE `bom` ENABLE KEYS */;

-- Dumping structure for table dbmrp.bom_detail
CREATE TABLE IF NOT EXISTS `bom_detail` (
  `id_bom_detail` int(11) NOT NULL AUTO_INCREMENT,
  `id_bom` int(11) DEFAULT NULL,
  `id_bahan` int(11) DEFAULT NULL,
  `jumlah` double DEFAULT NULL,
  `level` int(11) DEFAULT NULL,
  `parent` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_bom_detail`) USING BTREE,
  KEY `id_bahan` (`id_bahan`),
  KEY `id_menu` (`id_bom`) USING BTREE,
  CONSTRAINT `FK_bom_detail_bom` FOREIGN KEY (`id_bom`) REFERENCES `bom` (`id_bom`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_menu_detail_bahan` FOREIGN KEY (`id_bahan`) REFERENCES `bahan` (`id_bahan`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=137 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table dbmrp.bom_detail: ~7 rows (approximately)
/*!40000 ALTER TABLE `bom_detail` DISABLE KEYS */;
INSERT INTO `bom_detail` (`id_bom_detail`, `id_bom`, `id_bahan`, `jumlah`, `level`, `parent`) VALUES
	(34, 8, 1, 505, 1, 0),
	(35, 8, 3, 303, 1, 0),
	(36, 8, 4, 101, 1, 0),
	(37, 8, 5, 101, 1, 0),
	(38, 8, 6, 80, 2, 5),
	(39, 8, 7, 10, 2, 5),
	(40, 8, 8, 10, 2, 5),
	(85, 9, 22, 404, 1, 0),
	(86, 9, 3, 303, 1, 0),
	(87, 9, 23, 101, 1, 0),
	(88, 9, 4, 101, 1, 0),
	(89, 9, 5, 101, 1, 0),
	(90, 9, 6, 81, 2, 5),
	(91, 9, 7, 11, 2, 5),
	(92, 9, 8, 11, 2, 5),
	(124, 10, 22, 505, 1, 0),
	(125, 10, 3, 303, 1, 0),
	(126, 10, 4, 101, 1, 0),
	(127, 10, 5, 101, 1, 0),
	(128, 10, 6, 81, 2, 5),
	(129, 10, 7, 11, 2, 5),
	(130, 10, 8, 11, 2, 5),
	(131, 11, 3, 500, 1, 0),
	(132, 11, 4, 300, 1, 0),
	(133, 11, 5, 100, 1, 0),
	(134, 11, 6, 81, 2, 5),
	(135, 11, 7, 11, 2, 5),
	(136, 11, 8, 11, 2, 5);
/*!40000 ALTER TABLE `bom_detail` ENABLE KEYS */;

-- Dumping structure for table dbmrp.mps
CREATE TABLE IF NOT EXISTS `mps` (
  `id_mps` int(11) NOT NULL AUTO_INCREMENT,
  `id_bom` int(11) DEFAULT NULL,
  `bulan` date DEFAULT NULL,
  `M1` int(11) DEFAULT NULL,
  `M2` int(11) DEFAULT NULL,
  `M3` int(11) DEFAULT NULL,
  `M4` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_mps`),
  KEY `id_bom` (`id_bom`),
  CONSTRAINT `FK_mps_bom` FOREIGN KEY (`id_bom`) REFERENCES `bom` (`id_bom`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table dbmrp.mps: ~1 rows (approximately)
/*!40000 ALTER TABLE `mps` DISABLE KEYS */;
INSERT INTO `mps` (`id_mps`, `id_bom`, `bulan`, `M1`, `M2`, `M3`, `M4`) VALUES
	(6, 8, '2020-08-01', 15, 20, 11, 10),
	(7, 9, '2020-09-01', 0, 10, 0, 0),
	(8, 11, '2020-09-01', 0, 0, 0, 35);
/*!40000 ALTER TABLE `mps` ENABLE KEYS */;

-- Dumping structure for table dbmrp.mrp
CREATE TABLE IF NOT EXISTS `mrp` (
  `id_mrp` int(11) NOT NULL AUTO_INCREMENT,
  `id_bahan` int(11) DEFAULT NULL,
  `bulan` date DEFAULT NULL,
  `minggu` int(11) DEFAULT NULL,
  `GR` double DEFAULT NULL,
  `SR` double DEFAULT NULL,
  `OHI` double DEFAULT NULL,
  `NR` double DEFAULT NULL,
  `POR` double DEFAULT NULL,
  `POREL` double DEFAULT NULL,
  PRIMARY KEY (`id_mrp`),
  KEY `id_bahan` (`id_bahan`),
  CONSTRAINT `FK_mrp_bahan` FOREIGN KEY (`id_bahan`) REFERENCES `bahan` (`id_bahan`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=176 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table dbmrp.mrp: ~35 rows (approximately)
/*!40000 ALTER TABLE `mrp` DISABLE KEYS */;
INSERT INTO `mrp` (`id_mrp`, `id_bahan`, `bulan`, `minggu`, `GR`, `SR`, `OHI`, `NR`, `POR`, `POREL`) VALUES
	(141, 1, '2020-08-01', 0, 0, 0, 25250, 0, 0, 0),
	(142, 1, '2020-08-03', 1, 7575, 0, 25250, 0, 0, 0),
	(143, 1, '2020-08-10', 2, 10100, 0, 17675, 0, 0, 3030),
	(144, 1, '2020-08-17', 3, 5555, 0, 7575, 0, 0, 0),
	(145, 1, '2020-08-24', 4, 5050, 0, 2020, 3030, 3030, 0),
	(146, 3, '2020-08-01', 0, 0, 0, 22725, 0, 0, 0),
	(147, 3, '2020-08-03', 1, 4545, 0, 22725, 0, 0, 0),
	(148, 3, '2020-08-10', 2, 6060, 0, 18180, 0, 0, 0),
	(149, 3, '2020-08-17', 3, 3333, 0, 12120, 0, 0, 0),
	(150, 3, '2020-08-24', 4, 3030, 0, 8787, 0, 0, 0),
	(151, 4, '2020-08-01', 0, 0, 0, 2525, 0, 0, 0),
	(152, 4, '2020-08-03', 1, 1515, 0, 2525, 0, 0, 1010),
	(153, 4, '2020-08-10', 2, 2020, 0, 1010, 1010, 1010, 1111),
	(154, 4, '2020-08-17', 3, 1111, 0, 0, 1111, 1111, 1010),
	(155, 4, '2020-08-24', 4, 1010, 0, 0, 1010, 1010, 0),
	(156, 5, '2020-08-01', 0, 0, 0, 2525, 0, 0, 0),
	(157, 5, '2020-08-03', 1, 1515, 0, 2525, 0, 0, 1010),
	(158, 5, '2020-08-10', 2, 2020, 0, 1010, 1010, 1010, 1111),
	(159, 5, '2020-08-17', 3, 1111, 0, 0, 1111, 1111, 1010),
	(160, 5, '2020-08-24', 4, 1010, 0, 0, 1010, 1010, 0),
	(161, 6, '2020-08-01', 0, 0, 0, 206545, 0, 0, 0),
	(162, 6, '2020-08-03', 1, 121200, 0, 206545, 0, 0, 76255),
	(163, 6, '2020-08-10', 2, 161600, 0, 85345, 76255, 76255, 88880),
	(164, 6, '2020-08-17', 3, 88880, 0, 0, 88880, 88880, 80800),
	(165, 6, '2020-08-24', 4, 80800, 0, 0, 80800, 80800, 0),
	(166, 7, '2020-08-01', 0, 0, 0, 25502, 0, 0, 0),
	(167, 7, '2020-08-03', 1, 15150, 0, 25502, 0, 0, 9848),
	(168, 7, '2020-08-10', 2, 20200, 0, 10352, 9848, 9848, 11110),
	(169, 7, '2020-08-17', 3, 11110, 0, 0, 11110, 11110, 10100),
	(170, 7, '2020-08-24', 4, 10100, 0, 0, 10100, 10100, 0),
	(171, 8, '2020-08-01', 0, 0, 0, 25502, 0, 0, 0),
	(172, 8, '2020-08-03', 1, 15150, 0, 25502, 0, 0, 9848),
	(173, 8, '2020-08-10', 2, 20200, 0, 10352, 9848, 9848, 11110),
	(174, 8, '2020-08-17', 3, 11110, 0, 0, 11110, 11110, 10100),
	(175, 8, '2020-08-24', 4, 10100, 0, 0, 10100, 10100, 0);
/*!40000 ALTER TABLE `mrp` ENABLE KEYS */;

-- Dumping structure for table dbmrp.pengadaan
CREATE TABLE IF NOT EXISTS `pengadaan` (
  `id_pengadaan` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) DEFAULT NULL,
  `id_bahan` int(11) DEFAULT NULL,
  `tgl_pengadaan` date DEFAULT NULL,
  `tgl_penerimaan` date DEFAULT NULL,
  `jumlah` double DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `sts` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_pengadaan`),
  KEY `id_user` (`id_user`),
  KEY `id_bahan` (`id_bahan`),
  CONSTRAINT `FK_penerimaan_bahan` FOREIGN KEY (`id_bahan`) REFERENCES `bahan` (`id_bahan`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_penerimaan_user` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=115 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table dbmrp.pengadaan: ~23 rows (approximately)
/*!40000 ALTER TABLE `pengadaan` DISABLE KEYS */;
INSERT INTO `pengadaan` (`id_pengadaan`, `id_user`, `id_bahan`, `tgl_pengadaan`, `tgl_penerimaan`, `jumlah`, `keterangan`, `sts`) VALUES
	(25, 4, 1, '2020-06-01', '2020-09-01', 25250, 'Persediaan awal', 3),
	(26, 4, 3, '2020-06-01', '2020-09-01', 22725, 'Persediaan awal', 3),
	(27, 4, 4, '2020-06-01', '2020-09-01', 2525, 'Persediaan awal', 3),
	(28, 4, 5, '2020-06-01', '2020-09-01', 2525, 'Persediaan awal', 3),
	(29, 4, 6, '2020-06-01', '2020-09-01', 206545, 'Persediaan awal', 3),
	(30, 4, 7, '2020-06-01', '2020-09-01', 25502, 'Persediaan awal', 3),
	(31, 4, 8, '2020-06-01', '2020-09-01', 25502, 'Persediaan awal', 3),
	(99, 4, 1, '2020-08-10', '2020-09-01', 3030, 'MRP', 3),
	(100, 4, 4, '2020-08-03', '2020-09-01', 1010, 'MRP', 3),
	(101, 4, 4, '2020-08-10', '2020-09-01', 1111, 'MRP', 3),
	(102, 4, 4, '2020-08-17', '2020-09-01', 1010, 'MRP', 3),
	(103, 4, 5, '2020-08-03', '2020-09-01', 1010, 'MRP', 3),
	(104, 4, 5, '2020-08-10', '2020-09-01', 1111, 'MRP', 3),
	(105, 4, 5, '2020-08-17', '2020-09-01', 1010, 'MRP', 3),
	(106, 4, 6, '2020-08-03', '2020-09-01', 76255, 'MRP', 3),
	(107, 4, 6, '2020-08-10', '2020-09-01', 88880, 'MRP', 3),
	(108, 4, 6, '2020-08-17', '2020-09-01', 80800, 'MRP', 3),
	(109, 4, 7, '2020-08-03', '2020-09-01', 9848, 'MRP', 3),
	(110, 4, 7, '2020-08-10', '2020-09-01', 11110, 'MRP', 3),
	(111, 4, 7, '2020-08-17', '2020-09-01', 10100, 'MRP', 3),
	(112, 4, 8, '2020-08-03', '2020-09-01', 9848, 'MRP', 3),
	(113, 4, 8, '2020-08-10', '2020-09-01', 11110, 'MRP', 3),
	(114, 4, 8, '2020-08-17', '2020-09-01', 10100, 'MRP', 3);
/*!40000 ALTER TABLE `pengadaan` ENABLE KEYS */;

-- Dumping structure for table dbmrp.pengeluaran
CREATE TABLE IF NOT EXISTS `pengeluaran` (
  `id_pengeluaran` int(11) NOT NULL AUTO_INCREMENT,
  `id_bahan` int(11) DEFAULT NULL,
  `tgl_pengeluaran` date DEFAULT NULL,
  `jumlah` int(11) DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `sts` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_pengeluaran`),
  KEY `id_bahan` (`id_bahan`),
  CONSTRAINT `FK_pengeluaran_bahan` FOREIGN KEY (`id_bahan`) REFERENCES `bahan` (`id_bahan`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=141 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table dbmrp.pengeluaran: ~28 rows (approximately)
/*!40000 ALTER TABLE `pengeluaran` DISABLE KEYS */;
INSERT INTO `pengeluaran` (`id_pengeluaran`, `id_bahan`, `tgl_pengeluaran`, `jumlah`, `keterangan`, `sts`) VALUES
	(113, 1, '2020-08-03', 7575, 'Produksi', 1),
	(114, 1, '2020-08-10', 10100, 'Produksi', 1),
	(115, 1, '2020-08-17', 5555, 'Produksi', 1),
	(116, 1, '2020-08-24', 5050, 'Produksi', 1),
	(117, 3, '2020-08-03', 4545, 'Produksi', 1),
	(118, 3, '2020-08-10', 6060, 'Produksi', 1),
	(119, 3, '2020-08-17', 3333, 'Produksi', 1),
	(120, 3, '2020-08-24', 3030, 'Produksi', 1),
	(121, 4, '2020-08-03', 1515, 'Produksi', 1),
	(122, 4, '2020-08-10', 2020, 'Produksi', 1),
	(123, 4, '2020-08-17', 1111, 'Produksi', 1),
	(124, 4, '2020-08-24', 1010, 'Produksi', 1),
	(125, 5, '2020-08-03', 1515, 'Produksi', 1),
	(126, 5, '2020-08-10', 2020, 'Produksi', 1),
	(127, 5, '2020-08-17', 1111, 'Produksi', 1),
	(128, 5, '2020-08-24', 1010, 'Produksi', 1),
	(129, 6, '2020-08-03', 121200, 'Produksi', 1),
	(130, 6, '2020-08-10', 161600, 'Produksi', 1),
	(131, 6, '2020-08-17', 88880, 'Produksi', 1),
	(132, 6, '2020-08-24', 80800, 'Produksi', 1),
	(133, 7, '2020-08-03', 15150, 'Produksi', 1),
	(134, 7, '2020-08-10', 20200, 'Produksi', 1),
	(135, 7, '2020-08-17', 11110, 'Produksi', 1),
	(136, 7, '2020-08-24', 10100, 'Produksi', 1),
	(137, 8, '2020-08-03', 15150, 'Produksi', 1),
	(138, 8, '2020-08-10', 20200, 'Produksi', 1),
	(139, 8, '2020-08-17', 11110, 'Produksi', 1),
	(140, 8, '2020-08-24', 10100, 'Produksi', 1);
/*!40000 ALTER TABLE `pengeluaran` ENABLE KEYS */;

-- Dumping structure for table dbmrp.permintaan
CREATE TABLE IF NOT EXISTS `permintaan` (
  `id_permintaan` int(11) NOT NULL AUTO_INCREMENT,
  `id_bom` int(11) DEFAULT NULL,
  `jumlah` int(11) DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  PRIMARY KEY (`id_permintaan`) USING BTREE,
  KEY `id_bom` (`id_bom`),
  CONSTRAINT `FK_permintaan_bom` FOREIGN KEY (`id_bom`) REFERENCES `bom` (`id_bom`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table dbmrp.permintaan: ~11 rows (approximately)
/*!40000 ALTER TABLE `permintaan` DISABLE KEYS */;
INSERT INTO `permintaan` (`id_permintaan`, `id_bom`, `jumlah`, `tanggal`) VALUES
	(21, 8, 10, '2020-08-02'),
	(22, 8, 5, '2020-08-05'),
	(23, 8, 20, '2020-08-11'),
	(24, 8, 6, '2020-08-19'),
	(25, 8, 5, '2020-08-21'),
	(26, 8, 10, '2020-08-25'),
	(27, 8, 10, '2020-09-03'),
	(28, 8, 12, '2020-09-07'),
	(29, 8, 5, '2020-09-11'),
	(30, 8, 10, '2020-09-22'),
	(32, 9, 10, '2020-09-14'),
	(33, 10, 1, '2020-09-10'),
	(34, 11, 35, '2020-09-29'),
	(35, 11, 15, '2020-10-10');
/*!40000 ALTER TABLE `permintaan` ENABLE KEYS */;

-- Dumping structure for table dbmrp.user
CREATE TABLE IF NOT EXISTS `user` (
  `id_user` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL,
  `nama_user` varchar(200) DEFAULT NULL,
  `jabatan` char(1) DEFAULT NULL,
  PRIMARY KEY (`id_user`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table dbmrp.user: ~6 rows (approximately)
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` (`id_user`, `username`, `password`, `nama_user`, `jabatan`) VALUES
	(1, 'admin', 'admin', 'Admin', '5'),
	(3, 'gudang', 'gudang', 'Gudang', '2'),
	(4, 'ppic', 'ppic', 'PPIC', '1'),
	(5, 'pengadaan', 'pengadaan', 'Bagian Pengadaan', '3'),
	(6, 'produksi', 'produksi', 'Bagian Produksi', '4'),
	(7, 'pimpinan', 'pimpinan', 'Bos Besar', '0');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
