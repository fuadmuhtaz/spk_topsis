-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 09, 2017 at 03:44 PM
-- Server version: 10.1.10-MariaDB
-- PHP Version: 5.6.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `spk_topsis`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`) VALUES
(1, 'admin', '$2y$10$TR7tJBifQZWyvGpfTo4RDueN9ebAkyJG8T2kDo56yPyWZiCYh4dbe');

-- --------------------------------------------------------

--
-- Table structure for table `alternatif`
--

CREATE TABLE `alternatif` (
  `id_pemilihan` int(11) NOT NULL,
  `alternatif` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `alternatif`
--

INSERT INTO `alternatif` (`id_pemilihan`, `alternatif`) VALUES
(2, 'A'),
(2, 'B'),
(2, 'C'),
(2, 'D'),
(2, 'E');

-- --------------------------------------------------------

--
-- Table structure for table `bobot`
--

CREATE TABLE `bobot` (
  `id_pemilihan` int(11) NOT NULL,
  `c1` double NOT NULL,
  `c2` double NOT NULL,
  `c3` double NOT NULL,
  `c4` double NOT NULL,
  `c5` double NOT NULL,
  `c6` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bobot`
--

INSERT INTO `bobot` (`id_pemilihan`, `c1`, `c2`, `c3`, `c4`, `c5`, `c6`) VALUES
(2, 30, 20, 20, 10, 10, 10);

-- --------------------------------------------------------

--
-- Table structure for table `hasil`
--

CREATE TABLE `hasil` (
  `id_pemilihan` int(11) NOT NULL,
  `alternatif` varchar(255) NOT NULL,
  `v` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `hasil`
--

INSERT INTO `hasil` (`id_pemilihan`, `alternatif`, `v`) VALUES
(2, 'C', 0.8497);

-- --------------------------------------------------------

--
-- Table structure for table `jarak_solusi_ideal`
--

CREATE TABLE `jarak_solusi_ideal` (
  `id_pemilihan` int(11) NOT NULL,
  `positif` double NOT NULL,
  `negatif` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `jarak_solusi_ideal`
--

INSERT INTO `jarak_solusi_ideal` (`id_pemilihan`, `positif`, `negatif`) VALUES
(2, 5.6531, 10.3136),
(2, 10.7481, 6.1508),
(2, 2.7238, 15.4043),
(2, 14.9109, 3.0904),
(2, 8.5911, 7.4786);

-- --------------------------------------------------------

--
-- Table structure for table `matrik_r`
--

CREATE TABLE `matrik_r` (
  `id_pemilihan` int(11) NOT NULL,
  `c1` double NOT NULL,
  `c2` double NOT NULL,
  `c3` double NOT NULL,
  `c4` double NOT NULL,
  `c5` double NOT NULL,
  `c6` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `matrik_r`
--

INSERT INTO `matrik_r` (`id_pemilihan`, `c1`, `c2`, `c3`, `c4`, `c5`, `c6`) VALUES
(2, 0.4931, 0.5111, 0.4778, 0.5199, 0.4603, 0.4666),
(2, 0.3452, 0.3833, 0.3345, 0.3639, 0.3069, 0.4057),
(2, 0.6164, 0.6389, 0.5734, 0.5719, 0.2762, 0.4869),
(2, 0.2466, 0.1917, 0.3823, 0.3119, 0.491, 0.426),
(2, 0.4438, 0.3833, 0.43, 0.4159, 0.6137, 0.4463);

-- --------------------------------------------------------

--
-- Table structure for table `matrik_y`
--

CREATE TABLE `matrik_y` (
  `id_pemilihan` int(11) NOT NULL,
  `c1` double NOT NULL,
  `c2` double NOT NULL,
  `c3` double NOT NULL,
  `c4` double NOT NULL,
  `c5` double NOT NULL,
  `c6` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `matrik_y`
--

INSERT INTO `matrik_y` (`id_pemilihan`, `c1`, `c2`, `c3`, `c4`, `c5`, `c6`) VALUES
(2, 14.793, 10.222, 9.556, 5.199, 4.603, 4.666),
(2, 10.356, 7.666, 6.69, 3.639, 3.069, 4.057),
(2, 18.492, 12.778, 11.468, 5.719, 2.762, 4.869),
(2, 7.398, 3.834, 7.646, 3.119, 4.91, 4.26),
(2, 13.314, 7.666, 8.6, 4.159, 6.137, 4.463);

-- --------------------------------------------------------

--
-- Table structure for table `nilai`
--

CREATE TABLE `nilai` (
  `id_pemilihan` int(11) NOT NULL,
  `c1` double NOT NULL,
  `c2` double NOT NULL,
  `c3` double NOT NULL,
  `c4` double NOT NULL,
  `c5` double NOT NULL,
  `c6` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `nilai`
--

INSERT INTO `nilai` (`id_pemilihan`, `c1`, `c2`, `c3`, `c4`, `c5`, `c6`) VALUES
(2, 20, 16, 10, 10, 15, 23),
(2, 14, 12, 7, 7, 10, 20),
(2, 25, 20, 12, 11, 9, 24),
(2, 10, 6, 8, 6, 16, 21),
(2, 18, 12, 9, 8, 20, 22);

-- --------------------------------------------------------

--
-- Table structure for table `nilai_ideal`
--

CREATE TABLE `nilai_ideal` (
  `id_pemilihan` int(11) NOT NULL,
  `ideal` varchar(20) NOT NULL,
  `c1` double NOT NULL,
  `c2` double NOT NULL,
  `c3` double NOT NULL,
  `c4` double NOT NULL,
  `c5` double NOT NULL,
  `c6` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `nilai_ideal`
--

INSERT INTO `nilai_ideal` (`id_pemilihan`, `ideal`, `c1`, `c2`, `c3`, `c4`, `c5`, `c6`) VALUES
(2, 'positif', 18.492, 12.778, 11.468, 3.119, 2.762, 4.057),
(2, 'negatif', 7.398, 3.834, 6.69, 5.719, 6.137, 4.869);

-- --------------------------------------------------------

--
-- Table structure for table `pemilihan`
--

CREATE TABLE `pemilihan` (
  `id` int(11) NOT NULL,
  `keterangan` varchar(255) NOT NULL,
  `tanggal` date NOT NULL,
  `status` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pemilihan`
--

INSERT INTO `pemilihan` (`id`, `keterangan`, `tanggal`, `status`) VALUES
(2, 'Programmer 2018', '2017-01-08', 'selesai');

-- --------------------------------------------------------

--
-- Table structure for table `ranking`
--

CREATE TABLE `ranking` (
  `id_pemilihan` int(11) NOT NULL,
  `v` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ranking`
--

INSERT INTO `ranking` (`id_pemilihan`, `v`) VALUES
(2, 0.6459),
(2, 0.364),
(2, 0.8497),
(2, 0.1717),
(2, 0.4654);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `alternatif`
--
ALTER TABLE `alternatif`
  ADD KEY `id_pemilihan` (`id_pemilihan`);

--
-- Indexes for table `bobot`
--
ALTER TABLE `bobot`
  ADD KEY `id_pemilihan` (`id_pemilihan`);

--
-- Indexes for table `hasil`
--
ALTER TABLE `hasil`
  ADD KEY `id_pemilihan` (`id_pemilihan`);

--
-- Indexes for table `jarak_solusi_ideal`
--
ALTER TABLE `jarak_solusi_ideal`
  ADD KEY `id_pemilihan` (`id_pemilihan`);

--
-- Indexes for table `matrik_r`
--
ALTER TABLE `matrik_r`
  ADD KEY `id_pemilihan` (`id_pemilihan`);

--
-- Indexes for table `matrik_y`
--
ALTER TABLE `matrik_y`
  ADD KEY `id_pemilihan` (`id_pemilihan`);

--
-- Indexes for table `nilai`
--
ALTER TABLE `nilai`
  ADD KEY `id_pemilihan` (`id_pemilihan`);

--
-- Indexes for table `nilai_ideal`
--
ALTER TABLE `nilai_ideal`
  ADD KEY `id_pemilihan` (`id_pemilihan`);

--
-- Indexes for table `pemilihan`
--
ALTER TABLE `pemilihan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ranking`
--
ALTER TABLE `ranking`
  ADD KEY `id_pemilihan` (`id_pemilihan`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `pemilihan`
--
ALTER TABLE `pemilihan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `alternatif`
--
ALTER TABLE `alternatif`
  ADD CONSTRAINT `alternatif_ibfk_1` FOREIGN KEY (`id_pemilihan`) REFERENCES `pemilihan` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `bobot`
--
ALTER TABLE `bobot`
  ADD CONSTRAINT `bobot_ibfk_1` FOREIGN KEY (`id_pemilihan`) REFERENCES `pemilihan` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `hasil`
--
ALTER TABLE `hasil`
  ADD CONSTRAINT `hasil_ibfk_1` FOREIGN KEY (`id_pemilihan`) REFERENCES `pemilihan` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `jarak_solusi_ideal`
--
ALTER TABLE `jarak_solusi_ideal`
  ADD CONSTRAINT `jarak_solusi_ideal_ibfk_1` FOREIGN KEY (`id_pemilihan`) REFERENCES `pemilihan` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `matrik_r`
--
ALTER TABLE `matrik_r`
  ADD CONSTRAINT `matrik_r_ibfk_1` FOREIGN KEY (`id_pemilihan`) REFERENCES `pemilihan` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `matrik_y`
--
ALTER TABLE `matrik_y`
  ADD CONSTRAINT `matrik_y_ibfk_1` FOREIGN KEY (`id_pemilihan`) REFERENCES `pemilihan` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `nilai`
--
ALTER TABLE `nilai`
  ADD CONSTRAINT `nilai_ibfk_1` FOREIGN KEY (`id_pemilihan`) REFERENCES `pemilihan` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `nilai_ideal`
--
ALTER TABLE `nilai_ideal`
  ADD CONSTRAINT `nilai_ideal_ibfk_1` FOREIGN KEY (`id_pemilihan`) REFERENCES `pemilihan` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `ranking`
--
ALTER TABLE `ranking`
  ADD CONSTRAINT `ranking_ibfk_1` FOREIGN KEY (`id_pemilihan`) REFERENCES `pemilihan` (`id`) ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
