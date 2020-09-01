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
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table dbmrp.bahan: ~7 rows (approximately)
/*!40000 ALTER TABLE `bahan` DISABLE KEYS */;
INSERT INTO `bahan` (`id_bahan`, `nama_bahan`, `satuan`, `jumlah`, `ss`, `rop`, `LT`) VALUES
	(1, 'Frit Mentah tipe A Q1', 'Kg', 25250, 10807, 20200, 2),
	(3, 'Frit Mentah tipe B Q2', 'Kg', 22725, 9726, 18180, 3),
	(4, 'Kaolin Q3', 'Kg', 2525, 1081, 2020, 1),
	(5, 'Larutan Pencampur Q4', 'Liter', 2525, 1081, 2020, 1),
	(6, 'Air Q5', 'Liter', 206545, 88401, 165236, 1),
	(7, 'CMC Q6', 'Kg', 25502, 10915, 20402, 1),
	(8, 'STPP Q7', 'Kg', 25502, 10915, 20402, 1);
/*!40000 ALTER TABLE `bahan` ENABLE KEYS */;

-- Dumping structure for table dbmrp.bom
CREATE TABLE IF NOT EXISTS `bom` (
  `id_bom` int(11) NOT NULL AUTO_INCREMENT,
  `nama_bom` varchar(200) DEFAULT NULL,
  `satuan` varchar(50) DEFAULT NULL,
  `jumlah` double DEFAULT NULL,
  `LT` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_bom`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table dbmrp.bom: ~1 rows (approximately)
/*!40000 ALTER TABLE `bom` DISABLE KEYS */;
INSERT INTO `bom` (`id_bom`, `nama_bom`, `satuan`, `jumlah`, `LT`) VALUES
	(8, 'Chemical Frit ', 'Ton', 1, 1),
	(12, 'CC', 'Ton', 1, 1);
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
) ENGINE=InnoDB AUTO_INCREMENT=61 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table dbmrp.bom_detail: ~9 rows (approximately)
/*!40000 ALTER TABLE `bom_detail` DISABLE KEYS */;
INSERT INTO `bom_detail` (`id_bom_detail`, `id_bom`, `id_bahan`, `jumlah`, `level`, `parent`) VALUES
	(34, 8, 1, 505, 1, 0),
	(35, 8, 3, 303, 1, 0),
	(36, 8, 4, 101, 1, 0),
	(37, 8, 5, 101, 1, 0),
	(38, 8, 6, 81.8, 2, 5),
	(39, 8, 7, 10.1, 2, 6),
	(40, 8, 8, 10.1, 2, 7);
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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table dbmrp.mps: ~1 rows (approximately)
/*!40000 ALTER TABLE `mps` DISABLE KEYS */;
INSERT INTO `mps` (`id_mps`, `id_bom`, `bulan`, `M1`, `M2`, `M3`, `M4`) VALUES
	(5, 8, '2020-08-01', 15, 20, 11, 10);
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
) ENGINE=InnoDB AUTO_INCREMENT=106 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table dbmrp.mrp: ~0 rows (approximately)
/*!40000 ALTER TABLE `mrp` DISABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=83 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table dbmrp.pengadaan: ~7 rows (approximately)
/*!40000 ALTER TABLE `pengadaan` DISABLE KEYS */;
INSERT INTO `pengadaan` (`id_pengadaan`, `id_user`, `id_bahan`, `tgl_pengadaan`, `tgl_penerimaan`, `jumlah`, `keterangan`, `sts`) VALUES
	(25, 4, 1, '2020-06-01', '2020-09-01', 25250, 'Persediaan awal', 3),
	(26, 4, 3, '2020-06-01', '2020-09-01', 22725, 'Persediaan awal', 3),
	(27, 4, 4, '2020-06-01', '2020-09-01', 2525, 'Persediaan awal', 3),
	(28, 4, 5, '2020-06-01', '2020-09-01', 2525, 'Persediaan awal', 3),
	(29, 4, 6, '2020-06-01', '2020-09-01', 206545, 'Persediaan awal', 3),
	(30, 4, 7, '2020-06-01', '2020-09-01', 25502, 'Persediaan awal', 3),
	(31, 4, 8, '2020-06-01', '2020-09-01', 25502, 'Persediaan awal', 3);
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
) ENGINE=InnoDB AUTO_INCREMENT=85 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table dbmrp.pengeluaran: ~0 rows (approximately)
/*!40000 ALTER TABLE `pengeluaran` DISABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8mb4;

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
	(30, 8, 10, '2020-09-22');
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
