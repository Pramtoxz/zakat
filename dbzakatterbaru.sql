/*
SQLyog Ultimate v13.1.1 (64 bit)
MySQL - 8.0.30 : Database - dbzakat
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`dbzakat` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;

USE `dbzakat`;

/*Table structure for table `donasi` */

DROP TABLE IF EXISTS `donasi`;

CREATE TABLE `donasi` (
  `iddonasi` char(30) NOT NULL,
  `idprogram` char(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `id_donatur` char(30) DEFAULT NULL,
  `online` tinyint(1) DEFAULT '0',
  `nominal` double DEFAULT NULL,
  `buktibayar` varchar(255) DEFAULT NULL,
  `tgltransfer` date DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`iddonasi`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `donasi` */

/*Table structure for table `donatur` */

DROP TABLE IF EXISTS `donatur`;

CREATE TABLE `donatur` (
  `id_donatur` char(30) NOT NULL,
  `nama` varchar(50) DEFAULT NULL,
  `alamat` text,
  `tgllahir` date DEFAULT NULL,
  `nohp` char(30) DEFAULT NULL,
  `jenkel` enum('L','P') DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `iduser` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_donatur`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `donatur` */

/*Table structure for table `kategori` */

DROP TABLE IF EXISTS `kategori`;

CREATE TABLE `kategori` (
  `idkategori` int NOT NULL AUTO_INCREMENT,
  `namakategori` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`idkategori`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `kategori` */

insert  into `kategori`(`idkategori`,`namakategori`) values 
(1,'Yatim'),
(2,'zakat'),
(3,'bencana');

/*Table structure for table `migrations` */

DROP TABLE IF EXISTS `migrations`;

CREATE TABLE `migrations` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `version` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `class` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `group` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `namespace` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `time` int NOT NULL,
  `batch` int unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `migrations` */

/*Table structure for table `mustahik` */

DROP TABLE IF EXISTS `mustahik`;

CREATE TABLE `mustahik` (
  `id_mustahik` char(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `nama` varchar(50) DEFAULT NULL,
  `alamat` text,
  `tgllahir` date DEFAULT NULL,
  `nohp` char(30) DEFAULT NULL,
  `jenkel` enum('L','P') DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `iduser` int unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_mustahik`),
  KEY `fk_pasien_user` (`iduser`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `mustahik` */

/*Table structure for table `otp_codes` */

DROP TABLE IF EXISTS `otp_codes`;

CREATE TABLE `otp_codes` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `otp_code` varchar(6) NOT NULL,
  `type` enum('register','forgot_password') NOT NULL,
  `is_used` tinyint(1) NOT NULL DEFAULT '0',
  `expires_at` datetime NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_email` (`email`),
  KEY `idx_otp_code` (`otp_code`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `otp_codes` */

/*Table structure for table `penyaluran_dana` */

DROP TABLE IF EXISTS `penyaluran_dana`;

CREATE TABLE `penyaluran_dana` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_mustahik` char(30) DEFAULT NULL,
  `jenisdana` varchar(50) DEFAULT NULL,
  `idpermohonan` char(30) DEFAULT NULL,
  `idprogram` char(30) DEFAULT NULL,
  `nominal` double DEFAULT NULL,
  `tglpenyaluran` date DEFAULT NULL,
  `deskripsi` text,
  `foto` varchar(255) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `penyaluran_dana` */

/*Table structure for table `permohonan` */

DROP TABLE IF EXISTS `permohonan`;

CREATE TABLE `permohonan` (
  `idpermohonan` char(30) NOT NULL,
  `id_mustahik` char(30) DEFAULT NULL,
  `kategoriasnaf` varchar(50) DEFAULT NULL,
  `jenisbantuan` varchar(50) DEFAULT NULL,
  `alasan` text,
  `dokumen` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `tglpengajuan` date DEFAULT NULL,
  `tgldisetujui` date DEFAULT NULL,
  PRIMARY KEY (`idpermohonan`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `permohonan` */

/*Table structure for table `program` */

DROP TABLE IF EXISTS `program`;

CREATE TABLE `program` (
  `idprogram` char(30) NOT NULL,
  `namaprogram` varchar(50) DEFAULT NULL,
  `idkategori` char(30) DEFAULT NULL,
  `deskripsi` text,
  `tglmulai` date DEFAULT NULL,
  `tglselesai` date DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`idprogram`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `program` */

/*Table structure for table `syarat_bantuan` */

DROP TABLE IF EXISTS `syarat_bantuan`;

CREATE TABLE `syarat_bantuan` (
  `id_syarat` int NOT NULL AUTO_INCREMENT,
  `kategori_asnaf` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `isi_syarat` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_syarat`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `syarat_bantuan` */

insert  into `syarat_bantuan`(`id_syarat`,`kategori_asnaf`,`isi_syarat`,`created_at`) values 
(1,'Fakir','Surat keterangan tidak mampu dari RT/RW','2025-08-06 02:04:16'),
(2,'Miskin','Fotokopi KTP dan KK','2025-08-06 02:04:16'),
(3,'Amil','Surat tugas resmi sebagai amil','2025-08-06 02:04:16'),
(4,'Mualaf','Surat keterangan mualaf dari MUI atau ormas Islam','2025-08-06 02:04:16'),
(5,'Riqab','Surat keterangan pembebasan perbudakan','2025-08-06 02:04:16'),
(6,'Gharim','Dokumen hutang dan surat keterangan dari pemberi pinjaman','2025-08-06 02:04:16'),
(7,'Fi Sabilillah','Surat keterangan kegiatan dakwah atau pendidikan Islam','2025-08-06 02:04:16'),
(8,'Ibnu Sabil','Tiket perjalanan dan surat keterangan dari desa asal','2025-08-06 02:04:16');

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'active' COMMENT 'active, inactive',
  `last_login` datetime DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`),
  KEY `idx_users_role` (`role`),
  KEY `idx_users_status` (`status`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `users` */

insert  into `users`(`id`,`username`,`email`,`password`,`role`,`status`,`last_login`,`remember_token`,`created_at`,`updated_at`,`deleted_at`) values 
(1,'admin','admin@gmail.com','$2y$10$hI1mC1S1wh2sz1NqPDgDl.I.ZM9sjbmqm4aiFI6lzzB7XgOvZgnhe','admin','active','2025-09-02 10:13:55',NULL,'2025-06-14 21:50:56','2025-09-02 09:39:18',NULL),
(2,'ketua','ketua','$2y$10$hI1mC1S1wh2sz1NqPDgDl.I.ZM9sjbmqm4aiFI6lzzB7XgOvZgnhe','ketua','active',NULL,NULL,NULL,NULL,NULL),
(3,'keuangan','keuangan','$2y$10$hI1mC1S1wh2sz1NqPDgDl.I.ZM9sjbmqm4aiFI6lzzB7XgOvZgnhe','keuangan','active','2025-09-02 09:50:27',NULL,NULL,'2025-09-02 09:50:15',NULL),
(4,'program','program','$2y$10$hI1mC1S1wh2sz1NqPDgDl.I.ZM9sjbmqm4aiFI6lzzB7XgOvZgnhe','program','active','2025-09-02 10:14:48',NULL,NULL,NULL,NULL);

/*Table structure for table `zakat` */

DROP TABLE IF EXISTS `zakat`;

CREATE TABLE `zakat` (
  `idzakat` char(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `id_donatur` char(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `nominal` double DEFAULT NULL,
  `online` tinyint(1) DEFAULT '0',
  `buktibayar` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `tgltransfer` date DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `jeniszakat` varchar(50) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `update_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`idzakat`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `zakat` */

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
