SET NAMES utf8mb4;

CREATE TABLE `pdpr_wil_kel` (
  `id` int(11) NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pro_id` int(11) NOT NULL,
  `dapil_id` int(11) NOT NULL,
  `kab_id` int(11) NOT NULL,
  `kec_id` int(11) NOT NULL,
  `kel_id` int(11) DEFAULT NULL,
  `tps_id` int(11) DEFAULT NULL,
  `pro_kode` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dapil_kode` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kab_kode` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kec_kode` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kel_kode` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tps_kode` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pro_nama` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dapil_nama` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kab_nama` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kec_nama` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kel_nama` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tps_nama` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tingkat` int(11) DEFAULT NULL,
  `url` mediumtext COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`,`pro_id`,`dapil_id`,`kab_id`,`kec_id`),
  KEY `namaPro` (`pro_nama`),
  KEY `namaKab` (`kab_nama`),
  KEY `namaKec` (`kec_nama`),
  KEY `namaKel` (`kel_nama`),
  KEY `idKel` (`kel_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


INSERT INTO `pdpr_wil_kel` (`id`, `nama`, `pro_id`, `dapil_id`, `kab_id`, `kec_id`, `kel_id`, `tps_id`, `pro_kode`, `dapil_kode`, `kab_kode`, `kec_kode`, `kel_kode`, `tps_kode`, `pro_nama`, `dapil_nama`, `kab_nama`, `kec_nama`, `kel_nama`, `tps_nama`, `tingkat`, `url`, `created_at`, `updated_at`) VALUES
(150061,	'LUWIHAJI',	191099,	7676,	191351,	150060,	150061,	0,	'35',	'3509',	'3522',	'352201',	'3522012001',	'',	'JAWA TIMUR',	'JAWA TIMUR IX',	'BOJONEGORO',	'NGRAHO',	'LUWIHAJI',	'',	4,	'https://sirekap-obj-data.kpu.go.id/wilayah/pemilu/pdpr/35/3509/3522/352201.json',	'2024-03-27 18:37:33',	NULL);
