-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Apr 17, 2024 at 08:12 AM
-- Server version: 11.2.3-MariaDB
-- PHP Version: 8.3.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sagre`
--

-- --------------------------------------------------------

--
-- Table structure for table `comune`
--

CREATE TABLE `comune` (
  `id` int(11) NOT NULL,
  `nome` varchar(50) DEFAULT NULL,
  `cap` int(5) DEFAULT NULL,
  `id_prov` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Dumping data for table `comune`
--

INSERT INTO `comune` (`id`, `nome`, `cap`, `id_prov`) VALUES
(1, NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `evento`
--

CREATE TABLE `evento` (
  `id` int(11) NOT NULL,
  `denom` varchar(100) DEFAULT NULL,
  `id_tipo` int(11) NOT NULL,
  `n_ediz` varchar(10) DEFAULT NULL,
  `descrizione` varchar(500) DEFAULT NULL,
  `data_inizio` datetime DEFAULT NULL,
  `ora_inizio` varchar(5) DEFAULT NULL,
  `data_fine` datetime DEFAULT NULL,
  `ora_fine` varchar(5) DEFAULT NULL,
  `anno` year(4) DEFAULT NULL,
  `istat` int(6) DEFAULT NULL,
  `id_comune` int(11) NOT NULL,
  `id_toponimo` int(11) NOT NULL,
  `civico` int(6) DEFAULT NULL,
  `nome_org` varchar(100) DEFAULT NULL,
  `url` varchar(100) DEFAULT NULL,
  `geo_x` varchar(30) DEFAULT NULL,
  `geo_y` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

-- --------------------------------------------------------

--
-- Table structure for table `provincia`
--

CREATE TABLE `provincia` (
  `id` int(11) NOT NULL,
  `nome` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Dumping data for table `provincia`
--

INSERT INTO `provincia` (`id`, `nome`) VALUES
(1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tipo`
--

CREATE TABLE `tipo` (
  `id` int(11) NOT NULL,
  `nome` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Dumping data for table `tipo`
--

INSERT INTO `tipo` (`id`, `nome`) VALUES
(1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `toponimo`
--

CREATE TABLE `toponimo` (
  `id` int(11) NOT NULL,
  `nome` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Dumping data for table `toponimo`
--

INSERT INTO `toponimo` (`id`, `nome`) VALUES
(1, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comune`
--
ALTER TABLE `comune`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_prov` (`id_prov`);

--
-- Indexes for table `evento`
--
ALTER TABLE `evento`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_comune` (`id_comune`),
  ADD KEY `id_tipo` (`id_tipo`),
  ADD KEY `id_toponimo` (`id_toponimo`);
ALTER TABLE `evento` ADD FULLTEXT KEY `denom` (`denom`);

--
-- Indexes for table `provincia`
--
ALTER TABLE `provincia`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tipo`
--
ALTER TABLE `tipo`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `toponimo`
--
ALTER TABLE `toponimo`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comune`
--
ALTER TABLE `comune`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `evento`
--
ALTER TABLE `evento`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `provincia`
--
ALTER TABLE `provincia`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tipo`
--
ALTER TABLE `tipo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `toponimo`
--
ALTER TABLE `toponimo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comune`
--
ALTER TABLE `comune`
  ADD CONSTRAINT `comune_ibfk_1` FOREIGN KEY (`id_prov`) REFERENCES `provincia` (`id`);

--
-- Constraints for table `evento`
--
ALTER TABLE `evento`
  ADD CONSTRAINT `evento_ibfk_1` FOREIGN KEY (`id_comune`) REFERENCES `comune` (`id`),
  ADD CONSTRAINT `evento_ibfk_2` FOREIGN KEY (`id_tipo`) REFERENCES `tipo` (`id`),
  ADD CONSTRAINT `evento_ibfk_3` FOREIGN KEY (`id_toponimo`) REFERENCES `toponimo` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
