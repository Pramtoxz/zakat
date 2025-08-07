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

insert  into `donasi`(`iddonasi`,`idprogram`,`id_donatur`,`online`,`nominal`,`buktibayar`,`tgltransfer`,`status`,`created_at`,`updated_at`,`deleted_at`) values 
('DN0001','PR0002','DN0001',1,50000,NULL,NULL,'ditolak','2025-08-07 09:21:56','2025-08-07 11:10:29',NULL);

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

insert  into `donatur`(`id_donatur`,`nama`,`alamat`,`tgllahir`,`nohp`,`jenkel`,`foto`,`iduser`,`created_at`,`updated_at`,`deleted_at`) values 
('DN0001','Mega','aadad','2025-08-06','123123','L','foto-20250806-DN0001.jpeg',NULL,'2025-08-06 18:48:06','2025-08-06 18:48:06',NULL),
('DN0002','Wati','dsasddf','2025-08-07','868686','P','dfd',15,NULL,NULL,NULL);

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
  `version` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `class` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `group` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `namespace` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
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

insert  into `mustahik`(`id_mustahik`,`nama`,`alamat`,`tgllahir`,`nohp`,`jenkel`,`foto`,`iduser`,`created_at`,`updated_at`,`deleted_at`) values 
('M0001','adadadad','fsdfsfsdfdsfjjj','2008-08-06','+62734573457345375','L',NULL,25,'2025-08-07 13:52:27','2025-08-07 13:52:27',NULL),
('MS0001','Jokod','asdad','2025-08-06','12313','L','foto-20250806-MS0001.jpg',0,'2025-08-06 18:31:33','2025-08-06 19:31:48',NULL);

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
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `otp_codes` */

insert  into `otp_codes`(`id`,`email`,`otp_code`,`type`,`is_used`,`expires_at`,`created_at`,`updated_at`) values 
(13,'adminc@gmais.com','119022','register',0,'2025-08-07 13:09:35','2025-08-07 13:04:35','2025-08-07 13:04:35'),
(14,'cssdd@gmail.com','968278','register',1,'2025-08-07 13:10:13','2025-08-07 13:05:13','2025-08-07 13:05:35');

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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `penyaluran_dana` */

insert  into `penyaluran_dana`(`id`,`id_mustahik`,`jenisdana`,`idpermohonan`,`idprogram`,`nominal`,`tglpenyaluran`,`deskripsi`,`foto`,`status`) values 
(2,'MS0001','zakat','PM0001',NULL,50000,'2025-08-07','oke','penyaluran-20250807-1754520929.jpg',NULL),
(3,'MS0001','donasi',NULL,'PR0004',10000,'2025-08-07','kkk','penyaluran-20250807-1754535313.jpg',NULL);

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

insert  into `permohonan`(`idpermohonan`,`id_mustahik`,`kategoriasnaf`,`jenisbantuan`,`alasan`,`dokumen`,`status`,`tglpengajuan`,`tgldisetujui`) values 
('PM0001','MS0001','miskin','Materi','okeoke','dokumen-20250807-PM0001.pdf','selesai','2025-08-07','2025-08-07'),
('PM0002','MS0001','Fakir','Materi','tekk','dokumen-20250807-PM0002.pdf','diproses','2025-08-07',NULL),
('PM0003','M0001','Amil','150000','adadladladaldl','dokumen-20250807-PM0003.pdf','diterima','2025-08-09','2025-08-07');

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

insert  into `program`(`idprogram`,`namaprogram`,`idkategori`,`deskripsi`,`tglmulai`,`tglselesai`,`foto`,`status`) values 
('PR0002','zakat emas','2','oke wan','2025-08-01','2025-08-30','program-20250807-PR0002.jpg','biasa'),
('PR0003','zakat maal','2','asdad','2025-08-07','2025-08-30','program-20250807-PR0003.png','biasa'),
('PR0004','Yatimin aja','1','adasd','2025-08-30','2025-08-30','program-20250807-PR0004.jpg','urgent');

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
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `users` */

insert  into `users`(`id`,`username`,`email`,`password`,`role`,`status`,`last_login`,`remember_token`,`created_at`,`updated_at`,`deleted_at`) values 
(1,'admin','admin@example.com','$2y$10$hI1mC1S1wh2sz1NqPDgDl.I.ZM9sjbmqm4aiFI6lzzB7XgOvZgnhe','ketua','active','2025-08-07 14:10:47',NULL,'2025-06-14 21:50:56','2025-06-14 21:50:56',NULL),
(15,'donatur','dona','$2y$10$hTMBEzCXOxii8qr.u1WON.jVvn/uwxfFt/r76Iqm4HOZuQELYPvgC','donatur','active','2025-08-07 14:15:37',NULL,NULL,NULL,NULL),
(25,'albadc','cssdd@gmail.com','$2y$10$hTMBEzCXOxii8qr.u1WON.jVvn/uwxfFt/r76Iqm4HOZuQELYPvgC','mustahik','active','2025-08-07 13:52:15',NULL,'2025-08-07 13:05:35','2025-08-07 13:05:35',NULL);

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

insert  into `zakat`(`idzakat`,`id_donatur`,`nominal`,`online`,`buktibayar`,`tgltransfer`,`status`,`jeniszakat`,`created_at`,`update_at`,`deleted_at`) values 
('ZK0001','DN0001',50000,0,NULL,NULL,'diterima','PR0002','2025-08-07 08:38:42',NULL,NULL);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
