-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 09, 2026 at 06:15 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `smktunasharapan`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id_admin` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id_admin`, `username`, `password`) VALUES
(1, 'admin', '$2y$12$0wbc0r/tWRp23Lz6u2mdyuLYD5Sk8fDWp4BMqdGoRRZ52zHlxN6Xe'),
(2, 'operator', '$2y$12$fnD3U6PxkOVGXb5THg0N3.zbdqotuGWC1wCE5O1yonXMQoh0/.bVu');

-- --------------------------------------------------------

--
-- Table structure for table `agenda`
--

CREATE TABLE `agenda` (
  `id` int(11) NOT NULL,
  `judul` varchar(200) NOT NULL,
  `tanggal` date NOT NULL,
  `deskripsi` text NOT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `agenda`
--

INSERT INTO `agenda` (`id`, `judul`, `tanggal`, `deskripsi`, `foto`, `created_at`) VALUES
(1, 'Masa Pengenalan Lingkungan Sekolah', '2026-07-13', 'Pengenalan lingkungan, tata tertib, budaya sekolah, dan kegiatan peserta didik baru.', '1791959622_foto_sekolah_07.jpg', '2026-10-13 15:44:28'),
(2, 'Praktik Kompetensi Keahlian', '2026-08-18', 'Kegiatan praktik untuk meningkatkan keterampilan peserta didik sesuai bidang keahlian.', '1791959602_foto_sekolah_04.jpg', '2026-10-13 15:44:28'),
(3, 'Rapat Evaluasi Pembelajaran', '2026-09-05', 'Evaluasi pelaksanaan pembelajaran dan program sekolah.', '1791959592_foto_sekolah_03.jpg', '2026-10-13 15:44:28');

-- --------------------------------------------------------

--
-- Table structure for table `berita`
--

CREATE TABLE `berita` (
  `id` int(11) NOT NULL,
  `judul` varchar(255) NOT NULL,
  `isi` text NOT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `tanggal` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `berita`
--

INSERT INTO `berita` (`id`, `judul`, `isi`, `foto`, `tanggal`, `created_at`, `updated_at`) VALUES
(1, 'Pembukaan Tahun Ajaran Baru', 'SMK Tunas Harapan Batang Serangan menyambut peserta didik baru dengan semangat belajar dan berkarya.', '1791959723_6acf22ab895ec.jpg', '2026-07-13', '2026-10-13 15:44:28', '2026-10-14 06:35:23'),
(2, 'Praktik Siswa Berbasis Kompetensi', 'Peserta didik mengikuti kegiatan praktik untuk memperkuat keterampilan sesuai kompetensi keahlian.', 'komputer.jpg', '2026-08-18', '2026-10-13 15:44:28', '2026-10-13 15:44:28'),
(3, 'Kegiatan Pengembangan Bakat Siswa', 'Sekolah mendorong peserta didik aktif dalam kegiatan pengembangan bakat, kreativitas, dan prestasi.', '1791959710_6acf229ecedc5.jpg', '2026-09-10', '2026-10-13 15:44:28', '2026-10-14 06:35:10');

-- --------------------------------------------------------

--
-- Table structure for table `dataguru`
--

CREATE TABLE `dataguru` (
  `id_guru` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `mapel` varchar(100) NOT NULL,
  `nsm` varchar(30) NOT NULL,
  `alamat` text NOT NULL,
  `tanggal_lahir` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `dataguru`
--

INSERT INTO `dataguru` (`id_guru`, `nama`, `mapel`, `nsm`, `alamat`, `tanggal_lahir`) VALUES
(1, 'Andi Saputra, S.Pd', 'Bahasa Indonesia', 'SMK-TH-001', 'Batang Serangan', '1985-04-12'),
(2, 'Rina Wulandari, S.Pd', 'Matematika', 'SMK-TH-002', 'Batang Serangan', '1987-09-21'),
(3, 'Dedi Kurniawan, S.Kom', 'Informatika', 'SMK-TH-003', 'Batang Serangan', '1989-02-08'),
(4, 'Siti Rahma, S.Pd', 'Bahasa Inggris', 'SMK-TH-004', 'Batang Serangan', '1986-11-17'),
(5, 'Budi Hartono, S.Pd', 'Produktif Kejuruan', 'SMK-TH-005', 'Batang Serangan', '1984-06-05');

-- --------------------------------------------------------

--
-- Table structure for table `datamapel`
--

CREATE TABLE `datamapel` (
  `id_mapel` int(11) NOT NULL,
  `kode_mapel` varchar(20) NOT NULL,
  `nama_mapel` varchar(100) NOT NULL,
  `kelas` varchar(20) NOT NULL,
  `guru_pengampu` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `datamapel`
--

INSERT INTO `datamapel` (`id_mapel`, `kode_mapel`, `nama_mapel`, `kelas`, `guru_pengampu`) VALUES
(1, 'UM-001', 'Bahasa Indonesia', 'X', 'Andi Saputra, S.Pd'),
(2, 'UM-002', 'Matematika', 'X', 'Rina Wulandari, S.Pd'),
(3, 'INF-101', 'Dasar-Dasar Informatika', 'X', 'Dedi Kurniawan, S.Kom'),
(4, 'KJ-101', 'Dasar-Dasar Kejuruan', 'X', 'Budi Hartono, S.Pd');

-- --------------------------------------------------------

--
-- Table structure for table `fasilitas`
--

CREATE TABLE `fasilitas` (
  `id` int(11) NOT NULL,
  `nama` varchar(150) NOT NULL,
  `deskripsi` text NOT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `link` varchar(255) DEFAULT NULL,
  `urutan` int(11) DEFAULT 0,
  `status` enum('Aktif','Nonaktif') DEFAULT 'Aktif',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `fasilitas`
--

INSERT INTO `fasilitas` (`id`, `nama`, `deskripsi`, `foto`, `link`, `urutan`, `status`, `created_at`) VALUES
(1, 'Laboratorium Komputer', 'Ruang praktik untuk pembelajaran teknologi informasi dan keterampilan digital.', '1791959569_6acf2211197bd.jpg', '', 1, 'Aktif', '2026-10-13 15:44:28'),
(2, 'Ruang Praktik Jurusan MP', 'Ruang pembelajaran praktik untuk jurusan MP', '1791959531_6acf21eb41cf9.jpg', '', 2, 'Aktif', '2026-10-13 15:44:28'),
(3, 'Perpustakaan', 'Sumber belajar dan ruang baca untuk mendukung kegiatan akademik.', '1791959546_6acf21fa47c2a.jpg', '', 3, 'Aktif', '2026-10-13 15:44:28'),
(4, 'Lapangan Olahraga', 'Fasilitas kegiatan olahraga dan pengembangan minat siswa.', '1791959520_6acf21e0927bc.jpg', '', 4, 'Aktif', '2026-10-13 15:44:28'),
(5, 'Bengkel Praktik Jurusan TSM', 'Bengkel ini biasa di gunakan untuk praktik siswa TSM', '1791962849_6acf2ee10271e.jpg', '', 0, 'Aktif', '2026-10-14 07:27:29');

-- --------------------------------------------------------

--
-- Table structure for table `pesan_masuk`
--

CREATE TABLE `pesan_masuk` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `pesan` text NOT NULL,
  `tanggal` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `prestasi`
--

CREATE TABLE `prestasi` (
  `id` int(11) NOT NULL,
  `judul` varchar(255) NOT NULL,
  `deskripsi` text NOT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `tanggal` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `prestasi`
--

INSERT INTO `prestasi` (`id`, `judul`, `deskripsi`, `foto`, `tanggal`, `created_at`) VALUES
(1, 'Prestasi Nasyid', 'Tim siswa mengikuti kompetisi Nasyid tingkat daerah.', 'prestasi_6acf227c99cfa6.00445029.jpg', '2026-08-10', '2026-10-13 15:44:28'),
(2, 'Karya Kreatif Siswa', 'Peserta didik menampilkan karya kreatif dalam kegiatan sekolah.', 'prestasi_6acf225d2eb0d2.63172375.jpg', '2026-09-12', '2026-10-13 15:44:28');

-- --------------------------------------------------------

--
-- Table structure for table `site_features`
--

CREATE TABLE `site_features` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(150) NOT NULL,
  `description` text DEFAULT NULL,
  `icon` varchar(80) NOT NULL DEFAULT 'fa-star',
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `status` enum('Aktif','Nonaktif') NOT NULL DEFAULT 'Aktif',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `site_features`
--

INSERT INTO `site_features` (`id`, `title`, `description`, `icon`, `sort_order`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Pembelajaran Berbasis Kompetensi', 'Pembelajaran mengutamakan penguasaan pengetahuan, keterampilan, dan sikap sesuai bidang keahlian.', 'fa-screwdriver-wrench', 1, 'Aktif', '2026-10-13 15:44:28', '2026-10-13 15:44:28'),
(2, 'Karakter & Disiplin', 'Membangun budaya kerja, disiplin, tanggung jawab, dan etika profesional sejak di lingkungan sekolah.', 'fa-user-shield', 2, 'Aktif', '2026-10-13 15:44:28', '2026-10-13 15:44:28'),
(3, 'Kesiapan Dunia Kerja', 'Membekali siswa dengan keterampilan praktis, kreativitas, dan pengalaman yang relevan dengan kebutuhan industri.', 'fa-briefcase', 3, 'Aktif', '2026-10-13 15:44:28', '2026-10-13 15:44:28');

-- --------------------------------------------------------

--
-- Table structure for table `site_gallery`
--

CREATE TABLE `site_gallery` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(180) NOT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `category` varchar(100) NOT NULL DEFAULT 'Kegiatan',
  `event_date` date DEFAULT NULL,
  `status` enum('Aktif','Nonaktif') NOT NULL DEFAULT 'Aktif',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `site_gallery`
--

INSERT INTO `site_gallery` (`id`, `title`, `description`, `image`, `category`, `event_date`, `status`, `created_at`, `updated_at`) VALUES
(5, 'Perpustakaan Sekolah', 'Tampilan lingkungan dan halaman depan SMK Tunas Harapan.', 'uploads/site/foto_sekolah_02.jpg', 'Lingkungan Sekolah', NULL, 'Aktif', '2026-10-14 06:28:02', '2026-10-14 07:25:12'),
(6, 'Ruang Praktik Jurusan MP', 'Dokumentasi ruang kelas sebagai fasilitas pendukung pembelajaran.', 'uploads/site/foto_sekolah_03.jpg', 'Fasilitas', NULL, 'Aktif', '2026-10-14 06:28:02', '2026-10-14 07:23:48'),
(7, 'Bengkel Praktik Jurusan TSM', 'Tampilan gedung dan area depan sekolah.', 'uploads/site/foto_sekolah_04.jpg', 'Lingkungan Sekolah', NULL, 'Aktif', '2026-10-14 06:28:02', '2026-10-14 07:24:06'),
(8, 'Musholah Di Gedung 2 Sekolah', 'Dokumentasi bagian gedung sekolah dan halaman.', 'uploads/site/foto_sekolah_05.jpg', 'Lingkungan Sekolah', NULL, 'Aktif', '2026-10-14 06:28:02', '2026-10-14 07:22:28'),
(9, 'Gedung SMK Tunas Harapan', 'Tampilan gedung sekolah yang digunakan untuk kegiatan belajar.', 'uploads/site/foto_sekolah_06.jpg', 'Lingkungan Sekolah', NULL, 'Aktif', '2026-10-14 06:28:02', '2026-10-14 06:28:02'),
(10, 'Parkiran Area Sekolah', 'Area Parkir.', 'uploads/site/foto_sekolah_07.jpg', 'Lingkungan Sekolah', NULL, 'Aktif', '2026-10-14 06:28:02', '2026-10-14 07:10:11'),
(11, 'Bangunan Depan Lab TKJ', 'Dokumentasi bangunan dan area yang berada di sekitar sekolah.', 'uploads/site/foto_sekolah_08.jpg', 'Lingkungan Sekolah', NULL, 'Aktif', '2026-10-14 06:28:02', '2026-10-14 07:24:43'),
(12, 'Mengikuti Lomba Nasyid 3 Kecamatan Di Kantor KUA Batang Serangan', 'Dokumentasi lapangan dan area terbuka sekolah.', 'uploads/site/foto_sekolah_09.jpg', 'Fasilitas', NULL, 'Aktif', '2026-10-14 06:28:02', '2026-10-14 07:21:15'),
(14, 'Gedung 1 SMK Tunas harapan', 'Dokumentasi bangunan yang dapat digunakan untuk kegiatan sekolah.', 'uploads/site/foto_sekolah_11.jpg', 'Fasilitas', NULL, 'Aktif', '2026-10-14 06:28:02', '2026-10-14 07:21:44'),
(15, 'Kantin Sekolah', 'Dokumentasi bangunan yang berada di sekitar lingkungan sekolah.', 'uploads/site/foto_sekolah_12.jpg', 'Lingkungan Sekolah', NULL, 'Aktif', '2026-10-14 06:28:02', '2026-10-14 07:19:36'),
(17, 'Dokumentasi Sekolah 2', 'Foto tambahan dokumentasi SMK Tunas Harapan yang dapat dikelola melalui menu galeri administrator.', 'uploads/site/foto_sekolah_14.jpg', 'Fasilitas', NULL, 'Aktif', '2026-10-14 07:08:04', '2026-10-14 07:08:04'),
(23, 'Upacara Hari Guru', 'Foto tambahan dokumentasi SMK Tunas Harapan yang dapat dikelola melalui menu galeri administrator.', 'uploads/site/foto_sekolah_20.jpg', 'Kegiatan', NULL, 'Aktif', '2026-10-14 07:08:05', '2026-10-14 07:16:38'),
(24, 'Lingkungan Sekolah SMK Tunas Harapan Di Gedung 2', 'Foto tambahan dokumentasi SMK Tunas Harapan yang dapat dikelola melalui menu galeri administrator.', 'uploads/site/foto_sekolah_21.jpg', 'Lingkungan Sekolah', NULL, 'Aktif', '2026-10-14 07:08:05', '2026-10-14 07:16:04'),
(25, 'Mengikuti Turnamen Voli SMA/SMK Sederajat Sekabupaten Langkat', 'Foto tambahan dokumentasi SMK Tunas Harapan yang dapat dikelola melalui menu galeri administrator.', 'uploads/site/foto_sekolah_22.jpg', 'Kegiatan', NULL, 'Aktif', '2026-10-14 07:08:05', '2026-10-14 07:13:52'),
(26, 'Siswa/Siswi Mengikuti Paskib Kec.Batang Serangan', 'Foto tambahan dokumentasi SMK Tunas Harapan yang dapat dikelola melalui menu galeri administrator.', 'uploads/site/foto_sekolah_23.jpg', 'Kegiatan', NULL, 'Aktif', '2026-10-14 07:08:05', '2026-10-14 07:12:28'),
(27, 'Upacara Hari Pramuka', 'Foto tambahan dokumentasi SMK Tunas Harapan yang dapat dikelola melalui menu galeri administrator.', 'uploads/site/foto_sekolah_24.jpg', 'Kegiatan', NULL, 'Aktif', '2026-10-14 07:08:05', '2026-10-14 07:14:53');

-- --------------------------------------------------------

--
-- Table structure for table `site_programs`
--

CREATE TABLE `site_programs` (
  `id` int(10) UNSIGNED NOT NULL,
  `nama` varchar(180) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `kategori` varchar(120) NOT NULL DEFAULT 'Kompetensi Keahlian',
  `icon` varchar(80) NOT NULL DEFAULT 'fa-laptop-code',
  `gambar` varchar(255) DEFAULT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `status` enum('Aktif','Nonaktif') NOT NULL DEFAULT 'Aktif',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `site_programs`
--

INSERT INTO `site_programs` (`id`, `nama`, `deskripsi`, `kategori`, `icon`, `gambar`, `sort_order`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Teknik Komputer dan Jaringan', 'Mempelajari komputer, jaringan, perangkat keras, sistem operasi, dan layanan jaringan.', 'Teknologi & Infrastruktur', 'fa-network-wired', NULL, 1, 'Aktif', '2026-10-13 15:49:19', '2026-10-13 15:49:19'),
(2, 'Manajemen Perkantoran dan Layanan Bisnis', 'Mengembangkan keterampilan administrasi, dokumen, layanan pelanggan, dan komunikasi profesional.', 'Administrasi & Bisnis', 'fa-briefcase', NULL, 2, 'Aktif', '2026-10-13 15:49:19', '2026-10-13 15:49:19'),
(3, 'Akuntansi dan Keuangan Lembaga', 'Mengenal pencatatan transaksi, pengelolaan keuangan, dan administrasi akuntansi.', 'Keuangan & Administrasi', 'fa-calculator', NULL, 3, 'Aktif', '2026-10-13 15:49:19', '2026-10-13 15:49:19'),
(4, 'Teknik Bisnis Sepeda Motor', 'Mempelajari dasar perawatan, pemeriksaan, servis, dan pekerjaan kendaraan roda dua.', 'Teknik & Otomotif', 'fa-motorcycle', NULL, 4, 'Aktif', '2026-10-13 15:49:19', '2026-10-13 15:49:19');

-- --------------------------------------------------------

--
-- Table structure for table `site_sections`
--

CREATE TABLE `site_sections` (
  `id` int(10) UNSIGNED NOT NULL,
  `section_key` varchar(100) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` longtext DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `status` enum('Aktif','Nonaktif') NOT NULL DEFAULT 'Aktif',
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `site_sections`
--

INSERT INTO `site_sections` (`id`, `section_key`, `title`, `content`, `image`, `status`, `updated_at`) VALUES
(1, 'profile', 'Profil Sekolah', 'SMK Tunas Harapan Batang Serangan merupakan satuan pendidikan kejuruan yang berfokus pada pengembangan kompetensi, karakter, kreativitas, dan kesiapan kerja peserta didik.', 'uploads/site/site_20261014134017_3b033224.jpg', 'Aktif', '2026-10-14 06:40:17'),
(2, 'vision', 'Visi', 'Menjadi Lembaga diklat yang menghasilkan sumber daya manusia yang unggul dalam IPTEK,IMTAQ,siap mengisi dunia usaha/dunia industry dan siap mandiri.', '', 'Aktif', '2026-10-14 07:38:28'),
(3, 'mission', 'Misi', 'Mewujudkan lulusan yang terampil dalam teknologi\r\nMewujudkan lulusan berakhlaqul karimah\r\nMewujudkan lulusan yang siap mengisi dunia industri dan dunia usaha \r\nMewujudkan lulusan yang memiliki kemampuan mandiri', '', 'Aktif', '2026-10-14 07:39:28'),
(4, 'about_intro', 'Tentang SMK Tunas Harapan', 'Mewujudkan lingkungan belajar yang aman, aktif, produktif, dan mendukung pengembangan kompetensi peserta didik.', 'images/gerbang.jpg', 'Aktif', '2026-10-13 15:44:28');

-- --------------------------------------------------------

--
-- Table structure for table `site_settings`
--

CREATE TABLE `site_settings` (
  `id` int(10) UNSIGNED NOT NULL,
  `setting_key` varchar(100) NOT NULL,
  `setting_value` longtext DEFAULT NULL,
  `setting_type` varchar(20) NOT NULL DEFAULT 'text',
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `site_settings`
--

INSERT INTO `site_settings` (`id`, `setting_key`, `setting_value`, `setting_type`, `updated_at`) VALUES
(2463, 'school_name', 'SMK TUNAS HARAPAN', 'text', '2026-10-13 15:49:19'),
(2464, 'school_short', 'Batang Serangan, Langkat', 'text', '2026-10-13 15:49:19'),
(2465, 'school_tagline', 'Membangun Generasi Terampil, Berkarakter, Mandiri, dan Siap Menghadapi Dunia Kerja.', 'text', '2026-10-13 15:49:19'),
(2466, 'school_address', 'Batang Serangan, Kabupaten Langkat, Sumatera Utara', 'text', '2026-10-13 15:49:19'),
(2467, 'school_email', 'smktunashrpn@gmail.com', 'text', '2026-10-14 06:42:28'),
(2468, 'school_phone', '0812-3456-7890', 'text', '2026-10-13 15:49:19'),
(2469, 'school_whatsapp', '6281234567890', 'text', '2026-10-13 15:49:19'),
(2470, 'school_maps', 'https://www.google.com/maps?cid=1010218307982851036', 'url', '2026-10-14 06:39:27'),
(2471, 'school_instagram', 'https://instagram.com/osissmktunasharapan_?cplk=cHo1bGlzMXV5dDNj', 'url', '2026-10-14 06:37:01'),
(2472, 'school_facebook', 'https://www.facebook.com/share/1PMFVUgwJo/', 'url', '2026-10-14 06:37:01'),
(2473, 'school_tiktok', 'https://www.tiktok.com/@smk.tunas.harapan.batser?_r=1&_d=e2hha7hkl0ji94&sec_uid=MS4wLjABAAAApv2F3KbX0nfmieahnW_E4weq1i5yQV-WKAyAgTUctRIN1WnCDkZU71nJtcVUz0iQ&share_author_id=7483842874863551495&sharer_language=id&source=h5_t&u_code=e1ld6fa9kcghif&timestamp=1791958805&user_id=7098983258198148097&sec_user_id=MS4wLjABAAAA8adNQsyLVPE_ZS807Rp1ufZrLUr2TSyypu9YZBKVfaOSD3KsSCDseSKIHw-WtXPr&item_author_type=2&utm_source=copy&utm_campaign=client_share&utm_medium=android&share_iid=7688893243598194438&share_link_id=413c2b72-ac03-40cd-8722-32c8456c02e4&share_app_id=1180&ugbiz_name=ACCOUNT&ug_btm=b6880%2Cb5836&social_share_type=5&share_enter_from=others_homepage&item_author_type=2&enable_checksum=1', 'url', '2026-10-14 06:37:01'),
(2474, 'school_youtube', 'https://youtube.com/', 'url', '2026-10-13 15:49:19'),
(2475, 'school_logo', 'images/logo-smk-tunas-harapan.svg', 'image', '2026-10-13 15:49:19'),
(2476, 'hero_image', 'uploads/site/site_20261014133039_a24394a6.jpg', 'image', '2026-10-14 06:30:39'),
(2477, 'hero_title', 'SMK TUNAS HARAPAN', 'text', '2026-10-13 15:49:19'),
(2478, 'hero_subtitle', 'Batang Serangan • Langkat', 'text', '2026-10-13 15:49:19'),
(2479, 'hero_button1', 'Jelajahi Sekolah', 'text', '2026-10-13 15:49:19'),
(2480, 'hero_button2', 'Lihat Program Keahlian', 'text', '2026-10-13 15:49:19'),
(2481, 'running_text', 'Selamat datang di Sistem Informasi SMK Tunas Harapan Batang Serangan', 'text', '2026-10-13 15:49:19'),
(2482, 'running_text_highlight', 'INFORMASI & KEGIATAN SEKOLAH', 'text', '2026-10-13 15:49:19'),
(2483, 'intro_title', 'Sekolah Kejuruan untuk Generasi Siap Berkarya', 'text', '2026-10-13 15:49:19'),
(2484, 'intro_text', 'SMK Tunas Harapan Batang Serangan mengembangkan kompetensi akademik, keterampilan kejuruan, karakter, dan kesiapan peserta didik memasuki dunia kerja maupun pendidikan lanjutan.', 'textarea', '2026-10-13 15:49:19'),
(2485, 'home_quote', '\"Jangan pernah berhenti belajar, karena kehidupan tidak pernah berhenti mengajarkan.\"', 'textarea', '2026-10-13 15:49:19'),
(2486, 'footer_description', 'Sistem Informasi Sekolah Kejuruan', 'text', '2026-10-13 15:49:19'),
(2487, 'footer_copyright', 'Semua hak dilindungi.', 'text', '2026-10-13 15:49:19');

-- --------------------------------------------------------

--
-- Table structure for table `site_stats`
--

CREATE TABLE `site_stats` (
  `id` int(10) UNSIGNED NOT NULL,
  `stat_key` varchar(100) NOT NULL,
  `label` varchar(150) NOT NULL,
  `value` varchar(50) NOT NULL,
  `icon` varchar(80) NOT NULL DEFAULT 'fa-chart-column',
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `status` enum('Aktif','Nonaktif') NOT NULL DEFAULT 'Aktif',
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `site_stats`
--

INSERT INTO `site_stats` (`id`, `stat_key`, `label`, `value`, `icon`, `sort_order`, `status`, `updated_at`) VALUES
(369, 'students', 'Peserta Didik', '300+', 'fa-graduation-cap', 1, 'Aktif', '2026-10-13 15:49:19'),
(370, 'teachers', 'Tenaga Pendidik', '30+', 'fa-user-tie', 2, 'Aktif', '2026-10-14 07:36:04'),
(371, 'facilities', 'Fasilitas', '10+', 'fa-school', 3, 'Aktif', '2026-10-13 15:49:19'),
(372, 'partnership', 'Mitra & Kegiatan', '10+', 'fa-handshake', 4, 'Aktif', '2026-10-13 15:49:19');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id_admin`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `agenda`
--
ALTER TABLE `agenda`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `berita`
--
ALTER TABLE `berita`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dataguru`
--
ALTER TABLE `dataguru`
  ADD PRIMARY KEY (`id_guru`);

--
-- Indexes for table `datamapel`
--
ALTER TABLE `datamapel`
  ADD PRIMARY KEY (`id_mapel`);

--
-- Indexes for table `fasilitas`
--
ALTER TABLE `fasilitas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pesan_masuk`
--
ALTER TABLE `pesan_masuk`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `prestasi`
--
ALTER TABLE `prestasi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `site_features`
--
ALTER TABLE `site_features`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `site_gallery`
--
ALTER TABLE `site_gallery`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `site_programs`
--
ALTER TABLE `site_programs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `site_sections`
--
ALTER TABLE `site_sections`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `section_key` (`section_key`);

--
-- Indexes for table `site_settings`
--
ALTER TABLE `site_settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `setting_key` (`setting_key`);

--
-- Indexes for table `site_stats`
--
ALTER TABLE `site_stats`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `stat_key` (`stat_key`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id_admin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `agenda`
--
ALTER TABLE `agenda`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `berita`
--
ALTER TABLE `berita`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `dataguru`
--
ALTER TABLE `dataguru`
  MODIFY `id_guru` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `datamapel`
--
ALTER TABLE `datamapel`
  MODIFY `id_mapel` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `fasilitas`
--
ALTER TABLE `fasilitas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `pesan_masuk`
--
ALTER TABLE `pesan_masuk`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `prestasi`
--
ALTER TABLE `prestasi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `site_features`
--
ALTER TABLE `site_features`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `site_gallery`
--
ALTER TABLE `site_gallery`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `site_programs`
--
ALTER TABLE `site_programs`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `site_sections`
--
ALTER TABLE `site_sections`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1205;

--
-- AUTO_INCREMENT for table `site_settings`
--
ALTER TABLE `site_settings`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7763;

--
-- AUTO_INCREMENT for table `site_stats`
--
ALTER TABLE `site_stats`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1201;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
