-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 25 Sep 2019 pada 08.37
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
-- Database: `guestbook`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `event`
--

CREATE TABLE `event` (
  `id_event` int(50) NOT NULL,
  `nama_event` varchar(255) NOT NULL,
  `waktu` datetime NOT NULL,
  `lokasi` varchar(100) NOT NULL,
  `jenis` enum('Event','Meeting') NOT NULL,
  `detail` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `event`
--

INSERT INTO `event` (`id_event`, `nama_event`, `waktu`, `lokasi`, `jenis`, `detail`) VALUES
(1, 'Lomba', '2019-08-07 07:25:00', 'Jakarta', 'Event', 'Lomba mahasiswa Universitas Indonesia'),
(4, 'Festival ROL', '2019-08-25 12:00:00', 'Jogja', 'Event', 'Festival anak sehat'),
(5, 'Rapat Divisi IT', '2019-08-24 10:00:00', 'Kantor Republika', 'Meeting', 'Datang tepat waktu'),
(6, 'Makan bersama', '2019-01-01 00:00:00', 'PH Soekarno Hatta', 'Event', 'Yang mau datang boleh'),
(7, 'Fun Science', '2019-09-28 08:00:00', 'Republika Online', 'Event', 'Acara Fun Science anak SD'),
(8, 'Pelatihan Akuntansi Masjid', '2019-10-01 08:30:00', 'Republika Online', 'Event', 'Pelatihan takmir takmir masjid dari Republika'),
(9, 'Fun Science November', '2019-01-01 00:00:00', 'Malang', 'Event', 'asd');

-- --------------------------------------------------------

--
-- Struktur dari tabel `fun_science`
--

CREATE TABLE `fun_science` (
  `id_peserta` int(11) NOT NULL,
  `nama_peserta` varchar(200) NOT NULL,
  `asal_sekolah` varchar(200) NOT NULL,
  `jenis_kelamin` enum('Laki-laki','Perempuan') NOT NULL,
  `nama_ortu` varchar(200) NOT NULL,
  `no_telepon` int(15) NOT NULL,
  `status_kehadiran` enum('Belum Hadir','Sudah Hadir') NOT NULL,
  `alamat` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `fun_science`
--

INSERT INTO `fun_science` (`id_peserta`, `nama_peserta`, `asal_sekolah`, `jenis_kelamin`, `nama_ortu`, `no_telepon`, `status_kehadiran`, `alamat`) VALUES
(1, 'Sibro', 'SD Taman Harapan', 'Laki-laki', 'Bpk Anonim', 2147483647, 'Sudah Hadir', 'Malang'),
(3, 'Primus', 'SMK Telkom', 'Perempuan', 'Pak Samsul', 123467890, 'Belum Hadir', 'Sawojajar'),
(4, 'Berbi', 'SD Grogol Utara 2', 'Perempuan', 'Glen', 123456789, 'Sudah Hadir', 'Disneyland'),
(5, 'Andre', 'SD Pejaten 23', 'Laki-laki', 'Suyono', 2147483647, 'Belum Hadir', 'Jl. Pejaten Raya No.18'),
(6, 'Boy', 'SD Cendika', 'Laki-laki', 'Boy Father', 2147483647, 'Sudah Hadir', 'Jakarta');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kunjungan`
--

CREATE TABLE `kunjungan` (
  `id_kunjungan` int(40) NOT NULL,
  `id_tamu` int(40) NOT NULL,
  `id_karyawan` int(20) NOT NULL,
  `keperluan` varchar(255) NOT NULL,
  `waktu` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `kunjungan`
--

INSERT INTO `kunjungan` (`id_kunjungan`, `id_tamu`, `id_karyawan`, `keperluan`, `waktu`) VALUES
(3, 89, 19, 'Cuan cuan cuan', '2019-09-23 11:31:09');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tamu`
--

CREATE TABLE `tamu` (
  `id_tamu` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `no_telepon` varchar(15) NOT NULL,
  `jenis_kelamin` enum('Laki-laki','Perempuan') NOT NULL,
  `keterangan` varchar(255) NOT NULL,
  `deskripsi_tambahan` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tamu`
--

INSERT INTO `tamu` (`id_tamu`, `nama`, `email`, `no_telepon`, `jenis_kelamin`, `keterangan`, `deskripsi_tambahan`) VALUES
(51, 'Peserta Pelatihan Akuntansi Masjid', 'rijallur375@gmail.com', '08123122333', 'Laki-laki', 'Al-Hidayah', NULL),
(57, 'Sibromulis Nanda Karima', 'sibromulis_nanda_26rpl@student.smktelkom-mlg.sch.id', '083834590946', 'Laki-laki', 'Al-Imran', NULL),
(64, 'Narasumber Akuntansi Masjid', 'Tarjono10@gmail.co.id', '082131456855', 'Laki-laki', 'Al-Ibadah', NULL),
(71, 'Soleha', 'cba@gmail.com', '08123122333', 'Laki-laki', 'Al-Imrana', NULL),
(72, 'Primus', 'primus@gmail.com', '1234567888898', 'Laki-laki', 'Telkom', NULL),
(77, 'Percobaan', 'Takmir@gmail.com', '0987654321', 'Laki-laki', 'Al-Masjid', NULL),
(78, 'Sibromulis Nanda Karima', 'sibromulis_nanda_26rpl@student.smktelkom-mlg.sch', '09876543212', 'Laki-laki', 'Al-Kautsar', NULL),
(82, 'Syamsi Fir Daus', 'SyamsiFirDaus@gmail.com', '08963221289', 'Laki-laki', 'Al-Kautsar', NULL),
(89, 'Suya Jana', 'Surya374@gmail.com', '087566231518', 'Perempuan', 'PT Nabati Indonesia', NULL),
(90, 'Primus', 'primus@gmail.com', '0987654321', 'Laki-laki', 'Telkom', NULL),
(91, 'Soleha', 'cba@gmail.com', '08123122333', 'Laki-laki', 'Al-Imrana', NULL),
(92, 'Primus Nathan Orvala', 'primus_nathan_26rpl@student.smktelkom-mlg.sch.id', '081333351987', 'Laki-laki', 'Prakerin', NULL),
(93, 'Sibromulis Nanda Karima', 'sibromulis_nanda_26rpl@student.smktelkom-mlg.sch.id', '081334577071', 'Laki-laki', 'Prakerin', NULL),
(94, 'Dony Subagas', 'DonyBagas@gmail.com', '083819267108', 'Laki-laki', 'SMPN 45 Jakarta', NULL),
(95, 'primus', 'primus_nathan_26rpl@student.smktelkom-mlg.sch.id', '123', 'Laki-laki', 'telkom', NULL),
(97, 'Percobaan', 'percobaan@gmail.com', '12345600', 'Laki-laki', 'Percobaan', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `undangan`
--

CREATE TABLE `undangan` (
  `id_undangan` int(50) NOT NULL,
  `id_event` int(50) NOT NULL,
  `id_tamu` int(255) NOT NULL,
  `id_karyawan` int(11) NOT NULL,
  `status_kehadiran` enum('Belum Hadir','Sudah Hadir') NOT NULL,
  `jenis_tamu` enum('Internal','Eksternal') NOT NULL,
  `opsi1` varchar(255) NOT NULL,
  `opsi2` varchar(255) NOT NULL,
  `opsi3` varchar(255) NOT NULL,
  `opsi4` varchar(255) NOT NULL,
  `opsi5` varchar(255) NOT NULL,
  `opsi6` varchar(255) NOT NULL,
  `opsi7` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `undangan`
--

INSERT INTO `undangan` (`id_undangan`, `id_event`, `id_tamu`, `id_karyawan`, `status_kehadiran`, `jenis_tamu`, `opsi1`, `opsi2`, `opsi3`, `opsi4`, `opsi5`, `opsi6`, `opsi7`) VALUES
(52, 1, 0, 13, 'Sudah Hadir', 'Internal', '', '', '', '', '', '', ''),
(54, 6, 0, 12, 'Belum Hadir', 'Internal', '', '', '', '', '', '', ''),
(61, 8, 51, 0, 'Sudah Hadir', 'Eksternal', 'Ketua DKM', 'Jl. EE No.45. Sukabumi Utara', '', '', '', '', ''),
(80, 1, 0, 12, 'Sudah Hadir', 'Internal', '', '', '', '', '', '', ''),
(93, 8, 78, 0, 'Sudah Hadir', 'Eksternal', 'Takmir', 'Malang', '', '', '', '', ''),
(97, 8, 82, 0, 'Sudah Hadir', 'Eksternal', 'Pengurus', 'Jl. Kalibata Selatan No 89. Jakarta Timur', '', '', '', '', ''),
(102, 5, 92, 0, 'Belum Hadir', 'Eksternal', '', '', '', '', '', '', ''),
(105, 5, 0, 11, 'Sudah Hadir', 'Internal', '', '', '', '', '', '', ''),
(107, 7, 95, 0, 'Belum Hadir', 'Eksternal', 'asda', 'malang', '', '', '', '', ''),
(109, 8, 97, 0, 'Belum Hadir', 'Eksternal', 'percobaan', 'Percobaan', '', '', '', '', ''),
(119, 1, 0, 9, 'Sudah Hadir', 'Internal', '', '', '', '', '', '', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `event`
--
ALTER TABLE `event`
  ADD PRIMARY KEY (`id_event`),
  ADD KEY `jenis` (`jenis`);

--
-- Indexes for table `fun_science`
--
ALTER TABLE `fun_science`
  ADD PRIMARY KEY (`id_peserta`);

--
-- Indexes for table `kunjungan`
--
ALTER TABLE `kunjungan`
  ADD PRIMARY KEY (`id_kunjungan`),
  ADD KEY `id_tamu` (`id_tamu`),
  ADD KEY `id_karyawan` (`id_karyawan`);

--
-- Indexes for table `tamu`
--
ALTER TABLE `tamu`
  ADD PRIMARY KEY (`id_tamu`);

--
-- Indexes for table `undangan`
--
ALTER TABLE `undangan`
  ADD PRIMARY KEY (`id_undangan`),
  ADD KEY `id_event` (`id_event`),
  ADD KEY `id_karyawan` (`id_karyawan`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `event`
--
ALTER TABLE `event`
  MODIFY `id_event` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `fun_science`
--
ALTER TABLE `fun_science`
  MODIFY `id_peserta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `kunjungan`
--
ALTER TABLE `kunjungan`
  MODIFY `id_kunjungan` int(40) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tamu`
--
ALTER TABLE `tamu`
  MODIFY `id_tamu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=98;

--
-- AUTO_INCREMENT for table `undangan`
--
ALTER TABLE `undangan`
  MODIFY `id_undangan` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=120;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
