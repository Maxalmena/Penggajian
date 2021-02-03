-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 30, 2021 at 06:53 AM
-- Server version: 10.1.37-MariaDB
-- PHP Version: 7.3.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `apppenggajian`
--

-- --------------------------------------------------------

--
-- Table structure for table `jabatan`
--

CREATE TABLE `jabatan` (
  `kode_jabatan` varchar(10) NOT NULL,
  `nama_jabatan` varchar(50) NOT NULL,
  `gaji_pokok` int(15) NOT NULL,
  `uang_kehadiran` int(15) NOT NULL,
  `uang_makan` int(15) NOT NULL,
  `uang_transport` int(15) NOT NULL,
  `uang_pulsa` int(15) NOT NULL,
  `uang_lembur` int(15) NOT NULL,
  `tunjangan_simpanan_berencana` int(15) NOT NULL,
  `tunjangan_servis_kendaraan` int(15) NOT NULL,
  `insentive_pinjaman` int(15) NOT NULL,
  `insentive_simpanan` int(15) NOT NULL,
  `bonus_tahunan` int(15) NOT NULL,
  `thr` int(15) NOT NULL,
  `tunjangan_bpjs_kesehatan` int(15) NOT NULL,
  `tunjangan_bpjs_ketenagakerjaan` int(15) NOT NULL,
  `tunjangan_bpjs_jaminan_kematian` int(15) NOT NULL,
  `tunjangan_bpjs_kecelakaan_kerja` int(15) NOT NULL,
  `bonus_tunjangan_lain` int(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `jabatan`
--

INSERT INTO `jabatan` (`kode_jabatan`, `nama_jabatan`, `gaji_pokok`, `uang_kehadiran`, `uang_makan`, `uang_transport`, `uang_pulsa`, `uang_lembur`, `tunjangan_simpanan_berencana`, `tunjangan_servis_kendaraan`, `insentive_pinjaman`, `insentive_simpanan`, `bonus_tahunan`, `thr`, `tunjangan_bpjs_kesehatan`, `tunjangan_bpjs_ketenagakerjaan`, `tunjangan_bpjs_jaminan_kematian`, `tunjangan_bpjs_kecelakaan_kerja`, `bonus_tunjangan_lain`) VALUES
('D01', 'Admin', 5000000, 10000, 25000, 20000, 150000, 40000, 100000, 0, 500000, 0, 0, 0, 185000, 200000, 16000, 13000, 0),
('D02', 'a', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
('D03', 'Pegawai', 5000000, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `master_gaji`
--

CREATE TABLE `master_gaji` (
  `bulan` varchar(20) NOT NULL,
  `nip` varchar(20) NOT NULL,
  `masuk` int(5) NOT NULL,
  `sakit` int(5) NOT NULL,
  `izin` int(5) NOT NULL,
  `alpha` int(5) NOT NULL,
  `lembur` int(5) NOT NULL,
  `pinjaman` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pegawai`
--

CREATE TABLE `pegawai` (
  `nip` varchar(20) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(40) NOT NULL,
  `role` varchar(20) NOT NULL,
  `nama_pegawai` varchar(50) NOT NULL,
  `kode_jabatan` varchar(10) NOT NULL,
  `tempat_lahir` varchar(50) NOT NULL,
  `tanggal_lahir` varchar(20) NOT NULL,
  `alamat` varchar(200) NOT NULL,
  `no_telp` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pegawai`
--

INSERT INTO `pegawai` (`nip`, `username`, `password`, `role`, `nama_pegawai`, `kode_jabatan`, `tempat_lahir`, `tanggal_lahir`, `alamat`, `no_telp`) VALUES
('3890081219650002', 'naibaho', '079a255ae877beb15fef19c40f7f897f', 'manager', 'Tumbur Naibaho, MM, FSA', 'D02', 'Sumatra Utara', '', '', ''),
('3890190119990001', 'stefanus', 'c2672f6dd4910d3804d7e64741ecdcf0', 'admin', 'Stefanus Kharisma Wibawa Manalu', 'D01', 'Pemalang', '', '', '087887053670'),
('3890290119650003', 'munir', 'f3175a4a82ccdd5108be8d6730e30042', 'pegawai', 'Munir Said Thalib', 'D03', 'Malang', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `potongan`
--

CREATE TABLE `potongan` (
  `nip` varchar(20) NOT NULL,
  `iuran_bpjs_kesehatan` int(15) NOT NULL,
  `iuran_bpjs_ketenagakerjaan` int(15) NOT NULL,
  `iuran_bpjs_jaminan_kematian` int(15) NOT NULL,
  `iuran_bpjs_kecelakaan_kerja` int(15) NOT NULL,
  `dana_pensiun` int(15) NOT NULL,
  `pph21` int(15) NOT NULL,
  `uang_makan_digunakan` int(15) NOT NULL,
  `uang_transport_digunakan` int(15) NOT NULL,
  `simpanan_pokok` int(15) NOT NULL,
  `simpanan_wajib` int(15) NOT NULL,
  `simpanan_sukarela` int(15) NOT NULL,
  `simpanan_berencana` int(15) NOT NULL,
  `total_potongan` int(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `jabatan`
--
ALTER TABLE `jabatan`
  ADD PRIMARY KEY (`kode_jabatan`);

--
-- Indexes for table `master_gaji`
--
ALTER TABLE `master_gaji`
  ADD KEY `nip` (`nip`);

--
-- Indexes for table `pegawai`
--
ALTER TABLE `pegawai`
  ADD PRIMARY KEY (`nip`),
  ADD KEY `kode_jabatan` (`kode_jabatan`);

--
-- Indexes for table `potongan`
--
ALTER TABLE `potongan`
  ADD KEY `nip` (`nip`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `master_gaji`
--
ALTER TABLE `master_gaji`
  ADD CONSTRAINT `master_gaji_ibfk_1` FOREIGN KEY (`nip`) REFERENCES `pegawai` (`nip`);

--
-- Constraints for table `pegawai`
--
ALTER TABLE `pegawai`
  ADD CONSTRAINT `pegawai_ibfk_1` FOREIGN KEY (`kode_jabatan`) REFERENCES `jabatan` (`kode_jabatan`);

--
-- Constraints for table `potongan`
--
ALTER TABLE `potongan`
  ADD CONSTRAINT `potongan_ibfk_1` FOREIGN KEY (`nip`) REFERENCES `pegawai` (`nip`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
