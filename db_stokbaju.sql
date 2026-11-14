-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Apr 25, 2020 at 07:53 AM
-- Server version: 5.6.20
-- PHP Version: 5.5.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `db_stokbaju`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE IF NOT EXISTS `admin` (
`Id_Admin` int(11) NOT NULL,
  `Username` varchar(20) NOT NULL,
  `Password` varchar(20) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`Id_Admin`, `Username`, `Password`) VALUES
(1, 'Ririn', '123'),
(2, 'Kristina', '456');

-- --------------------------------------------------------

--
-- Table structure for table `baju`
--

CREATE TABLE IF NOT EXISTS `baju` (
  `Kode_Baju` char(8) NOT NULL,
  `Nama_Baju` varchar(20) NOT NULL,
  `Ukuran` text NOT NULL,
  `Stok` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `baju`
--

INSERT INTO `baju` (`Kode_Baju`, `Nama_Baju`, `Ukuran`, `Stok`) VALUES
('3324', '32423', 'XL', 234),
('B001', 'Penjas', 'XL', 0),
('B002', 'Nasional', 'L', 0),
('B003', 'Korea', 'M', 0);

-- --------------------------------------------------------

--
-- Table structure for table `bajukeluar`
--

CREATE TABLE IF NOT EXISTS `bajukeluar` (
`Id_Bajukeluar` int(11) NOT NULL,
  `Kode_Baju` char(8) NOT NULL,
  `Id_Petugas` char(11) NOT NULL,
  `Tgl_Bajukeluar` date NOT NULL,
  `Jmlh_Bajukeluar` int(11) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `bajukeluar`
--

INSERT INTO `bajukeluar` (`Id_Bajukeluar`, `Kode_Baju`, `Id_Petugas`, `Tgl_Bajukeluar`, `Jmlh_Bajukeluar`) VALUES
(7, 'B002', '2002', '0000-00-00', 77),
(8, 'B002', '2002', '0000-00-00', 4),
(9, 'B003', '2002', '0000-00-00', 4),
(10, 'B002', '2001', '2020-04-06', 465);

-- --------------------------------------------------------

--
-- Table structure for table `bajumasuk`
--

CREATE TABLE IF NOT EXISTS `bajumasuk` (
`Id_Bajumasuk` int(11) NOT NULL,
  `Kode_Baju` char(8) NOT NULL,
  `Id_Petugas` char(11) NOT NULL,
  `Tgl_Bajumasuk` date NOT NULL,
  `Jmlh_Bajumasuk` int(10) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `bajumasuk`
--

INSERT INTO `bajumasuk` (`Id_Bajumasuk`, `Kode_Baju`, `Id_Petugas`, `Tgl_Bajumasuk`, `Jmlh_Bajumasuk`) VALUES
(2, 'B003', '2002', '2020-04-14', 33),
(3, 'B002', '2002', '2020-04-22', 4443),
(4, 'B002', '2002', '2020-04-22', 4443);

-- --------------------------------------------------------

--
-- Table structure for table `petugas`
--

CREATE TABLE IF NOT EXISTS `petugas` (
  `Id_Petugas` char(11) NOT NULL,
  `Nama_Petugas` varchar(50) NOT NULL,
  `Pendidikan` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `petugas`
--

INSERT INTO `petugas` (`Id_Petugas`, `Nama_Petugas`, `Pendidikan`) VALUES
('2001', 'Ririn', 'S1'),
('2002', 'Kristina', 'D3');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
 ADD PRIMARY KEY (`Id_Admin`);

--
-- Indexes for table `baju`
--
ALTER TABLE `baju`
 ADD PRIMARY KEY (`Kode_Baju`);

--
-- Indexes for table `bajukeluar`
--
ALTER TABLE `bajukeluar`
 ADD PRIMARY KEY (`Id_Bajukeluar`);

--
-- Indexes for table `bajumasuk`
--
ALTER TABLE `bajumasuk`
 ADD PRIMARY KEY (`Id_Bajumasuk`);

--
-- Indexes for table `petugas`
--
ALTER TABLE `petugas`
 ADD PRIMARY KEY (`Id_Petugas`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
MODIFY `Id_Admin` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `bajukeluar`
--
ALTER TABLE `bajukeluar`
MODIFY `Id_Bajukeluar` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `bajumasuk`
--
ALTER TABLE `bajumasuk`
MODIFY `Id_Bajumasuk` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
