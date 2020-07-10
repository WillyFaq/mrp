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
  PRIMARY KEY (`id_bahan`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table dbmrp.bahan: ~7 rows (approximately)
/*!40000 ALTER TABLE `bahan` DISABLE KEYS */;
INSERT INTO `bahan` (`id_bahan`, `nama_bahan`, `satuan`, `jumlah`, `ss`, `rop`) VALUES
	(1, 'Frit Mentah tipe A Q1', 'Kg', 51515, 23987, 50500),
	(3, 'Frit Mentah tipe B Q2', 'Kg', 31515, 14392, 30300),
	(4, 'Kaolin Q3', 'Kg', 11515, 4797, 10100),
	(5, 'Larutan Pencampur Q4', 'Liter', 101414, 4797, 10100),
	(6, 'Air Q5', 'Liter', 4400000, 392435, 826180),
	(7, 'CMC Q6', 'Kg', 100000, 48455, 102010),
	(8, 'STPP Q7', 'Kg', 100000, 48455, 102010);
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
  `parent` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_bom_detail`) USING BTREE,
  KEY `id_bahan` (`id_bahan`),
  KEY `id_menu` (`id_bom`) USING BTREE,
  CONSTRAINT `FK_bom_detail_bom` FOREIGN KEY (`id_bom`) REFERENCES `bom` (`id_bom`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_menu_detail_bahan` FOREIGN KEY (`id_bahan`) REFERENCES `bahan` (`id_bahan`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table dbmrp.bom_detail: ~7 rows (approximately)
/*!40000 ALTER TABLE `bom_detail` DISABLE KEYS */;
INSERT INTO `bom_detail` (`id_bom_detail`, `id_bom`, `id_bahan`, `jumlah`, `level`, `parent`) VALUES
	(34, 8, 1, 505, 1, NULL),
	(35, 8, 3, 303, 1, NULL),
	(36, 8, 4, 101, 1, NULL),
	(37, 8, 5, 101, 1, NULL),
	(38, 8, 6, 81.8, 2, NULL),
	(39, 8, 7, 10.1, 2, NULL),
	(40, 8, 8, 10.1, 2, NULL);
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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table dbmrp.mps: ~1 rows (approximately)
/*!40000 ALTER TABLE `mps` DISABLE KEYS */;
INSERT INTO `mps` (`id_mps`, `id_bom`, `bulan`, `M1`, `M2`, `M3`, `M4`) VALUES
	(1, 8, '2020-07-01', 12, 57, 90, 68);
/*!40000 ALTER TABLE `mps` ENABLE KEYS */;

-- Dumping structure for table dbmrp.penerimaan
CREATE TABLE IF NOT EXISTS `penerimaan` (
  `id_pengadaan` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) DEFAULT NULL,
  `id_bahan` int(11) DEFAULT NULL,
  `tgl_pengadaan` date DEFAULT NULL,
  `jumlah` double DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  PRIMARY KEY (`id_pengadaan`),
  KEY `id_user` (`id_user`),
  KEY `id_bahan` (`id_bahan`),
  CONSTRAINT `FK_penerimaan_bahan` FOREIGN KEY (`id_bahan`) REFERENCES `bahan` (`id_bahan`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_penerimaan_user` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table dbmrp.penerimaan: ~4 rows (approximately)
/*!40000 ALTER TABLE `penerimaan` DISABLE KEYS */;
INSERT INTO `penerimaan` (`id_pengadaan`, `id_user`, `id_bahan`, `tgl_pengadaan`, `jumlah`, `keterangan`) VALUES
	(2, 3, 1, '2020-06-21', 1515, 'Masuk'),
	(3, 3, 3, '2020-06-21', 1515, 'Masuk'),
	(4, 3, 4, '2020-06-21', 1515, 'Masuk'),
	(6, 3, 5, '2020-06-21', 1414, ''),
	(7, 3, 6, '2020-06-21', 400000, NULL),
	(8, 3, 7, '2020-06-21', 50000, NULL),
	(9, 3, 8, '2020-06-21', 50000, NULL),
	(18, 3, 1, '2020-07-01', 50000, NULL),
	(19, 3, 3, '2020-07-01', 30000, NULL),
	(20, 3, 4, '2020-07-01', 10000, NULL),
	(21, 3, 5, '2020-07-01', 100000, NULL),
	(22, 3, 6, '2020-07-01', 4000000, NULL),
	(23, 3, 7, '2020-07-01', 50000, NULL),
	(24, 3, 8, '2020-07-01', 50000, NULL);
/*!40000 ALTER TABLE `penerimaan` ENABLE KEYS */;

-- Dumping structure for table dbmrp.permintaan
CREATE TABLE IF NOT EXISTS `permintaan` (
  `id_permintaan` int(11) NOT NULL AUTO_INCREMENT,
  `id_bom` int(11) DEFAULT NULL,
  `jumlah` int(11) DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  PRIMARY KEY (`id_permintaan`) USING BTREE,
  KEY `id_bom` (`id_bom`),
  CONSTRAINT `FK_permintaan_bom` FOREIGN KEY (`id_bom`) REFERENCES `bom` (`id_bom`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table dbmrp.permintaan: ~5 rows (approximately)
/*!40000 ALTER TABLE `permintaan` DISABLE KEYS */;
INSERT INTO `permintaan` (`id_permintaan`, `id_bom`, `jumlah`, `tanggal`) VALUES
	(9, 8, 23, '2020-07-12'),
	(10, 8, 34, '2020-07-15'),
	(11, 8, 90, '2020-07-21'),
	(12, 8, 23, '2020-07-27'),
	(13, 8, 45, '2020-07-30'),
	(14, 8, 100, '2020-08-02');
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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table dbmrp.user: ~1 rows (approximately)
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` (`id_user`, `username`, `password`, `nama_user`, `jabatan`) VALUES
	(1, 'admin', 'admin', 'Admin', '1'),
	(3, 'gudang', 'gudang', 'Gudang', '2');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;

-- Dumping structure for trigger dbmrp.t_add_penerimaan
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION';
DELIMITER //
CREATE TRIGGER `t_add_penerimaan` AFTER INSERT ON `penerimaan` FOR EACH ROW BEGIN
	UPDATE bahan SET jumlah = jumlah + NEW.jumlah
	WHERE id_bahan = NEW.id_bahan;
END//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

-- Dumping structure for trigger dbmrp.t_del_penerimaan
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION';
DELIMITER //
CREATE TRIGGER `t_del_penerimaan` AFTER DELETE ON `penerimaan` FOR EACH ROW BEGIN
	UPDATE bahan SET jumlah = jumlah-OLD.jumlah
	WHERE id_bahan = OLD.id_bahan;
END//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
