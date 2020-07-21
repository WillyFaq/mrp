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


-- Dumping database structure for dbmrp
CREATE DATABASE IF NOT EXISTS `dbmrp` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;
USE `dbmrp`;

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
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table dbmrp.bahan: ~7 rows (approximately)
/*!40000 ALTER TABLE `bahan` DISABLE KEYS */;
INSERT INTO `bahan` (`id_bahan`, `nama_bahan`, `satuan`, `jumlah`, `ss`, `rop`, `LT`) VALUES
	(1, 'Frit Mentah tipe A Q1', 'Kg', 25250, 14342, 25250, 2),
	(3, 'Frit Mentah tipe B Q2', 'Kg', 22725, 12908, 22725, 3),
	(4, 'Kaolin Q3', 'Kg', 2525, 1434, 2525, 1),
	(5, 'Larutan Pencampur Q4', 'Liter', 2525, 1434, 2525, 1),
	(6, 'Air Q5', 'Liter', 206545, 117318, 206545, 1),
	(7, 'CMC Q6', 'Kg', 25502, 14485, 25502, 1),
	(8, 'STPP Q7', 'Kg', 25502, 14485, 25502, 1);
/*!40000 ALTER TABLE `bahan` ENABLE KEYS */;

-- Dumping structure for table dbmrp.bom
CREATE TABLE IF NOT EXISTS `bom` (
  `id_bom` int(11) NOT NULL AUTO_INCREMENT,
  `nama_bom` varchar(200) DEFAULT NULL,
  `satuan` varchar(50) DEFAULT NULL,
  `jumlah` double DEFAULT NULL,
  `LT` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_bom`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table dbmrp.bom: ~1 rows (approximately)
/*!40000 ALTER TABLE `bom` DISABLE KEYS */;
INSERT INTO `bom` (`id_bom`, `nama_bom`, `satuan`, `jumlah`, `LT`) VALUES
	(8, 'Chemical Frit ', 'Ton', 1, 1);
/*!40000 ALTER TABLE `bom` ENABLE KEYS */;

-- Dumping structure for table dbmrp.bom_detail
CREATE TABLE IF NOT EXISTS `bom_detail` (
  `id_bom_detail` int(11) NOT NULL AUTO_INCREMENT,
  `id_bom` int(11) DEFAULT NULL,
  `id_bahan` int(11) DEFAULT NULL,
  `jumlah` double DEFAULT NULL,
  `level` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_bom_detail`) USING BTREE,
  KEY `id_bahan` (`id_bahan`),
  KEY `id_menu` (`id_bom`) USING BTREE,
  CONSTRAINT `FK_bom_detail_bom` FOREIGN KEY (`id_bom`) REFERENCES `bom` (`id_bom`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_menu_detail_bahan` FOREIGN KEY (`id_bahan`) REFERENCES `bahan` (`id_bahan`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table dbmrp.bom_detail: ~7 rows (approximately)
/*!40000 ALTER TABLE `bom_detail` DISABLE KEYS */;
INSERT INTO `bom_detail` (`id_bom_detail`, `id_bom`, `id_bahan`, `jumlah`, `level`) VALUES
	(34, 8, 1, 505, 1),
	(35, 8, 3, 303, 1),
	(36, 8, 4, 101, 1),
	(37, 8, 5, 101, 1),
	(38, 8, 6, 81.8, 2),
	(39, 8, 7, 10.1, 2),
	(40, 8, 8, 10.1, 2);
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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table dbmrp.mps: ~0 rows (approximately)
/*!40000 ALTER TABLE `mps` DISABLE KEYS */;
INSERT INTO `mps` (`id_mps`, `id_bom`, `bulan`, `M1`, `M2`, `M3`, `M4`) VALUES
	(3, 8, '2020-08-01', 15, 20, 11, 10);
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
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table dbmrp.mrp: ~35 rows (approximately)
/*!40000 ALTER TABLE `mrp` DISABLE KEYS */;
INSERT INTO `mrp` (`id_mrp`, `id_bahan`, `bulan`, `minggu`, `GR`, `SR`, `OHI`, `NR`, `POR`, `POREL`) VALUES
	(1, 1, '2020-08-01', 0, 0, 0, 25250, 0, 0, 0),
	(2, 1, '2020-08-03', 1, 7575, 0, 25250, 0, 0, 0),
	(3, 1, '2020-08-10', 2, 10100, 0, 17675, 0, 0, 5050),
	(4, 1, '2020-08-17', 3, 5555, 0, 7575, 0, 0, 0),
	(5, 1, '2020-08-24', 4, 5050, 0, 0, 5050, 5050, 0),
	(6, 3, '2020-08-01', 0, 0, 0, 22725, 0, 0, 0),
	(7, 3, '2020-08-03', 1, 4545, 0, 22725, 0, 0, 3030),
	(8, 3, '2020-08-10', 2, 6060, 0, 18180, 0, 0, 0),
	(9, 3, '2020-08-17', 3, 3333, 0, 12120, 0, 0, 0),
	(10, 3, '2020-08-24', 4, 3030, 0, 0, 3030, 3030, 0),
	(11, 4, '2020-08-01', 0, 0, 0, 2525, 0, 0, 0),
	(12, 4, '2020-08-03', 1, 1515, 0, 2525, 0, 0, 1010),
	(13, 4, '2020-08-10', 2, 2020, 0, 1010, 1010, 1010, 1111),
	(14, 4, '2020-08-17', 3, 1111, 0, 0, 1111, 1111, 1010),
	(15, 4, '2020-08-24', 4, 1010, 0, 0, 1010, 1010, 0),
	(16, 5, '2020-08-01', 0, 0, 0, 2525, 0, 0, 0),
	(17, 5, '2020-08-03', 1, 1515, 0, 2525, 0, 0, 1010),
	(18, 5, '2020-08-10', 2, 2020, 0, 1010, 1010, 1010, 1111),
	(19, 5, '2020-08-17', 3, 1111, 0, 0, 1111, 1111, 1010),
	(20, 5, '2020-08-24', 4, 1010, 0, 0, 1010, 1010, 0),
	(21, 6, '2020-08-01', 0, 0, 0, 206545, 0, 0, 0),
	(22, 6, '2020-08-03', 1, 123927, 0, 206545, 0, 0, 82618),
	(23, 6, '2020-08-10', 2, 165236, 0, 82618, 82618, 82618, 90879.8),
	(24, 6, '2020-08-17', 3, 90879.8, 0, 0, 90879.8, 90879.8, 82618),
	(25, 6, '2020-08-24', 4, 82618, 0, 0, 82618, 82618, 0),
	(26, 7, '2020-08-01', 0, 0, 0, 25502, 0, 0, 0),
	(27, 7, '2020-08-03', 1, 15301.5, 0, 25502, 0, 0, 10201.5),
	(28, 7, '2020-08-10', 2, 20402, 0, 10200.5, 10201.5, 10201.5, 11221.1),
	(29, 7, '2020-08-17', 3, 11221.1, 0, 0, 11221.1, 11221.1, 10201),
	(30, 7, '2020-08-24', 4, 10201, 0, 0, 10201, 10201, 0),
	(31, 8, '2020-08-01', 0, 0, 0, 25502, 0, 0, 0),
	(32, 8, '2020-08-03', 1, 15301.5, 0, 25502, 0, 0, 10201.5),
	(33, 8, '2020-08-10', 2, 20402, 0, 10200.5, 10201.5, 10201.5, 11221.1),
	(34, 8, '2020-08-17', 3, 11221.1, 0, 0, 11221.1, 11221.1, 10201),
	(35, 8, '2020-08-24', 4, 10201, 0, 0, 10201, 10201, 0);
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
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table dbmrp.pengadaan: ~24 rows (approximately)
/*!40000 ALTER TABLE `pengadaan` DISABLE KEYS */;
INSERT INTO `pengadaan` (`id_pengadaan`, `id_user`, `id_bahan`, `tgl_pengadaan`, `tgl_penerimaan`, `jumlah`, `keterangan`, `sts`) VALUES
	(25, 4, 1, '2020-06-01', '2020-06-14', 25250, 'Persediaan awal', 3),
	(26, 4, 3, '2020-06-01', '2020-06-14', 22725, 'Persediaan awal', 3),
	(27, 4, 4, '2020-06-01', '2020-06-14', 2525, 'Persediaan awal', 3),
	(28, 4, 5, '2020-06-01', '2020-06-14', 2525, 'Persediaan awal', 3),
	(29, 4, 6, '2020-06-01', '2020-06-14', 206545, 'Persediaan awal', 3),
	(30, 4, 7, '2020-06-01', '2020-06-14', 25502, 'Persediaan awal', 3),
	(31, 4, 8, '2020-06-01', '2020-06-14', 25502, 'Persediaan awal', 3),
	(32, 4, 1, '2020-08-10', NULL, 5050, 'MRP', 0),
	(33, 4, 3, '2020-08-03', NULL, 3030, 'MRP', 0),
	(34, 4, 4, '2020-08-03', NULL, 1010, 'MRP', 0),
	(35, 4, 4, '2020-08-10', NULL, 1111, 'MRP', 0),
	(36, 4, 4, '2020-08-17', NULL, 1010, 'MRP', 0),
	(37, 4, 5, '2020-08-03', NULL, 1010, 'MRP', 0),
	(38, 4, 5, '2020-08-10', NULL, 1111, 'MRP', 0),
	(39, 4, 5, '2020-08-17', NULL, 1010, 'MRP', 0),
	(40, 4, 6, '2020-08-03', NULL, 82618, 'MRP', 0),
	(41, 4, 6, '2020-08-10', NULL, 90879.8, 'MRP', 0),
	(42, 4, 6, '2020-08-17', NULL, 82618, 'MRP', 0),
	(43, 4, 7, '2020-08-03', NULL, 10201.5, 'MRP', 0),
	(44, 4, 7, '2020-08-10', NULL, 11221.1, 'MRP', 0),
	(45, 4, 7, '2020-08-17', NULL, 10201, 'MRP', 0),
	(46, 4, 8, '2020-08-03', NULL, 10201.5, 'MRP', 0),
	(47, 4, 8, '2020-08-10', NULL, 11221.1, 'MRP', 0),
	(48, 4, 8, '2020-08-17', NULL, 10201, 'MRP', 0);
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
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table dbmrp.pengeluaran: ~28 rows (approximately)
/*!40000 ALTER TABLE `pengeluaran` DISABLE KEYS */;
INSERT INTO `pengeluaran` (`id_pengeluaran`, `id_bahan`, `tgl_pengeluaran`, `jumlah`, `keterangan`, `sts`) VALUES
	(1, 1, '2020-08-03', 7575, 'Produksi', 0),
	(2, 1, '2020-08-10', 10100, 'Produksi', 0),
	(3, 1, '2020-08-17', 5555, 'Produksi', 0),
	(4, 1, '2020-08-24', 5050, 'Produksi', 0),
	(5, 3, '2020-08-03', 4545, 'Produksi', 0),
	(6, 3, '2020-08-10', 6060, 'Produksi', 0),
	(7, 3, '2020-08-17', 3333, 'Produksi', 0),
	(8, 3, '2020-08-24', 3030, 'Produksi', 0),
	(9, 4, '2020-08-03', 1515, 'Produksi', 0),
	(10, 4, '2020-08-10', 2020, 'Produksi', 0),
	(11, 4, '2020-08-17', 1111, 'Produksi', 0),
	(12, 4, '2020-08-24', 1010, 'Produksi', 0),
	(13, 5, '2020-08-03', 1515, 'Produksi', 0),
	(14, 5, '2020-08-10', 2020, 'Produksi', 0),
	(15, 5, '2020-08-17', 1111, 'Produksi', 0),
	(16, 5, '2020-08-24', 1010, 'Produksi', 0),
	(17, 6, '2020-08-03', 123927, 'Produksi', 0),
	(18, 6, '2020-08-10', 165236, 'Produksi', 0),
	(19, 6, '2020-08-17', 90880, 'Produksi', 0),
	(20, 6, '2020-08-24', 82618, 'Produksi', 0),
	(21, 7, '2020-08-03', 15302, 'Produksi', 0),
	(22, 7, '2020-08-10', 20402, 'Produksi', 0),
	(23, 7, '2020-08-17', 11221, 'Produksi', 0),
	(24, 7, '2020-08-24', 10201, 'Produksi', 0),
	(25, 8, '2020-08-03', 15302, 'Produksi', 0),
	(26, 8, '2020-08-10', 20402, 'Produksi', 0),
	(27, 8, '2020-08-17', 11221, 'Produksi', 0),
	(28, 8, '2020-08-24', 10201, 'Produksi', 0);
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
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table dbmrp.permintaan: ~8 rows (approximately)
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
	(30, 8, 25, '2020-09-14');
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
