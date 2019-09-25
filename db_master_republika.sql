-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 25 Sep 2019 pada 08.36
-- Versi Server: 10.1.28-MariaDB
-- PHP Version: 7.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `master_republika`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `menu`
--

CREATE TABLE `menu` (
  `id_menu` int(11) NOT NULL,
  `nama_menu` varchar(255) NOT NULL,
  `link_relasi` varchar(50) NOT NULL,
  `id_aplikasi` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `menu`
--

INSERT INTO `menu` (`id_menu`, `nama_menu`, `link_relasi`, `id_aplikasi`) VALUES
(1, '<i class=\"fas fa-flag\"></i>Komplain', 'Komplain/index', 1),
(2, '<i class=\"fas fa-clipboard\"></i>Laporan', 'laporan/index/', 1),
(4, '<i class=\"fas fa-home\"></i>Dashboard', 'Dashboard/index', 1),
(5, '<i class=\"fas fa-clipboard\"></i>Laporan', 'laporan_karyawan/index', 1),
(6, '<i class=\"fas fa-tasks\"></i>Tugas Anda', 'laporan_teknisi/index', 1),
(7, '<i class=\"fas fa-users\"></i>User', 'User/index', 1),
(8, '<i class=\"fas fa-boxes\"></i>Barang', 'Barang/index', 1),
(9, '<i class=\"fas fa-history\"></i> History', 'History/index', 1),
(10, '<i class=\"fas fa-pager\"></i>  Dashboard', 'Dashboard/index', 2),
(11, '<i class=\"far fa-clipboard\"></i> Form Kunjungan', 'Kunjungan/index', 2),
(12, '<i class=\"far fa-calendar-alt\"></i>  Acara', 'Event/index', 2),
(13, '<i class=\"fas fa-table\"></i>  Data Tamu', 'Tamu/index', 2),
(14, '<i class=\"fas fa-table\"></i>  Data Kunjungan', 'Kunjungan/data_kunjungan', 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id_menu`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `menu`
--
ALTER TABLE `menu`
  MODIFY `id_menu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
