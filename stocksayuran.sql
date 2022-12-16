-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Aug 25, 2022 at 09:53 AM
-- Server version: 5.7.33
-- PHP Version: 7.4.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `stocksayuran`
--

-- --------------------------------------------------------

--
-- Stand-in structure for view `expired`
-- (See below for the actual view)
--
CREATE TABLE `expired` (
`namasayuran` varchar(25)
,`kode_msk` varchar(25)
,`tgl_exp` date
,`qty` int(11)
,`exp` bigint(10)
);

-- --------------------------------------------------------

--
-- Table structure for table `keluar`
--

CREATE TABLE `keluar` (
  `idkeluar` int(11) NOT NULL,
  `idbarang` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `penerima` varchar(25) NOT NULL,
  `kode_msk` varchar(250) NOT NULL,
  `qty` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `laporan_keluar`
--

CREATE TABLE `laporan_keluar` (
  `idkeluar` int(11) NOT NULL,
  `idbarang` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `penerima` varchar(25) NOT NULL,
  `kode_msk` varchar(250) NOT NULL,
  `qty` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `laporan_keluar`
--

INSERT INTO `laporan_keluar` (`idkeluar`, `idbarang`, `tanggal`, `penerima`, `kode_msk`, `qty`) VALUES
(2, 50, '2022-08-25', 'as', '', 10),
(3, 50, '2022-08-25', 'asd', '', 10),
(4, 50, '2022-08-25', 'w', '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `laporan_masuk`
--

CREATE TABLE `laporan_masuk` (
  `idmasuk` int(11) NOT NULL,
  `idbarang` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `keterangan` varchar(25) NOT NULL,
  `qty` int(11) NOT NULL,
  `tgl_exp` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `laporan_masuk`
--

INSERT INTO `laporan_masuk` (`idmasuk`, `idbarang`, `tanggal`, `keterangan`, `qty`, `tgl_exp`) VALUES
(6, 50, '2022-08-25', 'asd', 5, '2022-08-31'),
(7, 50, '2022-08-25', 'sada', 10, '2022-08-27');

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `iduser` int(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`iduser`, `email`, `password`) VALUES
(1, 'musa@gmail.com', 'musa12345');

-- --------------------------------------------------------

--
-- Table structure for table `masuk`
--

CREATE TABLE `masuk` (
  `idmasuk` int(11) NOT NULL,
  `idbarang` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `keterangan` varchar(25) NOT NULL,
  `qty` int(11) NOT NULL,
  `kode_msk` varchar(25) NOT NULL,
  `tgl_exp` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `masuk`
--

INSERT INTO `masuk` (`idmasuk`, `idbarang`, `tanggal`, `keterangan`, `qty`, `kode_msk`, `tgl_exp`) VALUES
(32, 50, '2022-08-25', 'asd', 10, 'KD6zjQPc91CF', '2022-08-31');

-- --------------------------------------------------------

--
-- Table structure for table `stock`
--

CREATE TABLE `stock` (
  `idbarang` int(11) NOT NULL,
  `namasayuran` varchar(25) NOT NULL,
  `deskripsi` varchar(25) NOT NULL,
  `stock` int(11) NOT NULL,
  `satuan` varchar(25) NOT NULL,
  `harga` int(11) NOT NULL,
  `harga_jual` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `stock`
--

INSERT INTO `stock` (`idbarang`, `namasayuran`, `deskripsi`, `stock`, `satuan`, `harga`, `harga_jual`) VALUES
(50, 'kangkung', ' s', 20, 'kg', 1000, 2000),
(51, 'bayam', ' sada', 30, 'buah', 10000, 20000);

-- --------------------------------------------------------

--
-- Structure for view `expired`
--
DROP TABLE IF EXISTS `expired`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `expired`  AS SELECT `stock`.`namasayuran` AS `namasayuran`, `masuk`.`kode_msk` AS `kode_msk`, `masuk`.`tgl_exp` AS `tgl_exp`, `masuk`.`qty` AS `qty`, (cast(`masuk`.`tgl_exp` as date) - cast(curdate() as date)) AS `exp` FROM (`stock` join `masuk`) WHERE (`stock`.`idbarang` = `masuk`.`idbarang`) ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `keluar`
--
ALTER TABLE `keluar`
  ADD PRIMARY KEY (`idkeluar`);

--
-- Indexes for table `laporan_keluar`
--
ALTER TABLE `laporan_keluar`
  ADD PRIMARY KEY (`idkeluar`);

--
-- Indexes for table `laporan_masuk`
--
ALTER TABLE `laporan_masuk`
  ADD PRIMARY KEY (`idmasuk`);

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`iduser`);

--
-- Indexes for table `masuk`
--
ALTER TABLE `masuk`
  ADD PRIMARY KEY (`idmasuk`);

--
-- Indexes for table `stock`
--
ALTER TABLE `stock`
  ADD PRIMARY KEY (`idbarang`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `keluar`
--
ALTER TABLE `keluar`
  MODIFY `idkeluar` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `laporan_keluar`
--
ALTER TABLE `laporan_keluar`
  MODIFY `idkeluar` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `laporan_masuk`
--
ALTER TABLE `laporan_masuk`
  MODIFY `idmasuk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `login`
--
ALTER TABLE `login`
  MODIFY `iduser` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `masuk`
--
ALTER TABLE `masuk`
  MODIFY `idmasuk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `stock`
--
ALTER TABLE `stock`
  MODIFY `idbarang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
