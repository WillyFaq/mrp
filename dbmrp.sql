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
  PRIMARY KEY (`id_bahan`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table dbmrp.bahan: ~7 rows (approximately)
/*!40000 ALTER TABLE `bahan` DISABLE KEYS */;
INSERT INTO `bahan` (`id_bahan`, `nama_bahan`, `satuan`, `jumlah`) VALUES
	(1, 'Frit Mentah tipe A Q1', 'Kg', 1515),
	(3, 'Frit Mentah tipe B Q2', 'Kg', 1515),
	(4, 'Kaolin Q3', 'Kg', 1515),
	(5, 'Larutan Pencampur Q4', 'Liter', 1414),
	(6, 'Air Q5', 'Liter', 0),
	(7, 'CMC Q6', 'Kg', 0),
	(8, 'STPP Q7', 'Kg', 0);
/*!40000 ALTER TABLE `bahan` ENABLE KEYS */;

-- Dumping structure for table dbmrp.bom
CREATE TABLE IF NOT EXISTS `bom` (
  `id_bom` int(11) NOT NULL AUTO_INCREMENT,
  `nama_bom` varchar(200) DEFAULT NULL,
  `satuan` varchar(50) DEFAULT NULL,
  `jumlah` double DEFAULT NULL,
  PRIMARY KEY (`id_bom`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table dbmrp.bom: ~1 rows (approximately)
/*!40000 ALTER TABLE `bom` DISABLE KEYS */;
INSERT INTO `bom` (`id_bom`, `nama_bom`, `satuan`, `jumlah`) VALUES
	(3, 'Chemical Frit ', 'Ton', 1);
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
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table dbmrp.bom_detail: ~7 rows (approximately)
/*!40000 ALTER TABLE `bom_detail` DISABLE KEYS */;
INSERT INTO `bom_detail` (`id_bom_detail`, `id_bom`, `id_bahan`, `jumlah`, `level`) VALUES
	(15, 3, 1, 505, 1),
	(16, 3, 3, 303, 1),
	(17, 3, 4, 101, 1),
	(18, 3, 5, 101, 1),
	(19, 3, 6, 81.8, 2),
	(20, 3, 7, 10.1, 2),
	(21, 3, 8, 10.1, 2);
/*!40000 ALTER TABLE `bom_detail` ENABLE KEYS */;

-- Dumping structure for table dbmrp.mps
CREATE TABLE IF NOT EXISTS `mps` (
  `id_mps` int(11) NOT NULL AUTO_INCREMENT,
  `id_bom` int(11) DEFAULT NULL,
  `jumlah` int(11) DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  PRIMARY KEY (`id_mps`),
  KEY `id_bom` (`id_bom`),
  CONSTRAINT `FK_mps_bom` FOREIGN KEY (`id_bom`) REFERENCES `bom` (`id_bom`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table dbmrp.mps: ~4 rows (approximately)
/*!40000 ALTER TABLE `mps` DISABLE KEYS */;
INSERT INTO `mps` (`id_mps`, `id_bom`, `jumlah`, `tanggal`) VALUES
	(1, 3, 20, '2020-07-12'),
	(3, 3, 10, '2020-07-15'),
	(4, 3, 30, '2020-07-19'),
	(5, 3, 40, '2020-07-30');
/*!40000 ALTER TABLE `mps` ENABLE KEYS */;

-- Dumping structure for table dbmrp.pengadaan
CREATE TABLE IF NOT EXISTS `pengadaan` (
  `id_pengadaan` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) DEFAULT NULL,
  `id_bahan` int(11) DEFAULT NULL,
  `tgl_pengadaan` date DEFAULT NULL,
  `jumlah` double DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  PRIMARY KEY (`id_pengadaan`),
  KEY `id_user` (`id_user`),
  KEY `id_bahan` (`id_bahan`),
  CONSTRAINT `FK_pengadaan_bahan` FOREIGN KEY (`id_bahan`) REFERENCES `bahan` (`id_bahan`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_pengadaan_user` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table dbmrp.pengadaan: ~4 rows (approximately)
/*!40000 ALTER TABLE `pengadaan` DISABLE KEYS */;
INSERT INTO `pengadaan` (`id_pengadaan`, `id_user`, `id_bahan`, `tgl_pengadaan`, `jumlah`, `keterangan`) VALUES
	(2, 3, 1, '2020-06-21', 1515, 'Masuk'),
	(3, 3, 3, '2020-06-21', 1515, 'Masuk'),
	(4, 3, 4, '2020-06-21', 1515, 'Masuk'),
	(6, 3, 5, '2020-06-21', 1414, '');
/*!40000 ALTER TABLE `pengadaan` ENABLE KEYS */;

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

-- Dumping structure for trigger dbmrp.t_add_pengadaan
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION';
DELIMITER //
CREATE TRIGGER `t_add_pengadaan` AFTER INSERT ON `pengadaan` FOR EACH ROW BEGIN
	UPDATE bahan SET jumlah = jumlah + NEW.jumlah
	WHERE id_bahan = NEW.id_bahan;
END//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

-- Dumping structure for trigger dbmrp.t_del_pengadaan
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION';
DELIMITER //
CREATE TRIGGER `t_del_pengadaan` AFTER DELETE ON `pengadaan` FOR EACH ROW BEGIN
	UPDATE bahan SET jumlah = jumlah-OLD.jumlah
	WHERE id_bahan = OLD.id_bahan;
END//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
