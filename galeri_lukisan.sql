-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 03, 2026 at 12:34 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `galeri_lukisan`
--

-- --------------------------------------------------------

--
-- Table structure for table `lukisan`
--

CREATE TABLE `lukisan` (
  `id_lukisan` int(11) NOT NULL,
  `nama_lukisan` varchar(100) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `tahun_dibuat` int(11) DEFAULT NULL,
  `harga` decimal(15,2) DEFAULT NULL,
  `id_pelukis` int(11) DEFAULT NULL,
  `gambar` varchar(255) NOT NULL,
  `status` enum('tersedia','terjual') NOT NULL DEFAULT 'tersedia'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lukisan`
--

INSERT INTO `lukisan` (`id_lukisan`, `nama_lukisan`, `deskripsi`, `tahun_dibuat`, `harga`, `id_pelukis`, `gambar`, `status`) VALUES
(4, 'Small World', 'Sempit banget dunia woi', 2025, 3000000.00, 1, 'smallworld.jpeg', 'tersedia'),
(5, 'New Person', 'Ga berubah, cuma jujur', 2026, 3000000.00, 1, 'newperson.jpeg', 'tersedia'),
(6, 'The Scream', 'Gambar orang teriak', 1893, 15000000.00, 4, '960px-The_Scream.jpg', 'terjual'),
(14, 'まぼろは', 'Two sides', 2026, 7000000.00, 6, 'maboroha.jpeg', 'terjual');

-- --------------------------------------------------------

--
-- Table structure for table `pelukis`
--

CREATE TABLE `pelukis` (
  `id_pelukis` int(11) NOT NULL,
  `nama_pelukis` varchar(50) NOT NULL,
  `tahun_lahir` int(11) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pelukis`
--

INSERT INTO `pelukis` (`id_pelukis`, `nama_pelukis`, `tahun_lahir`, `email`) VALUES
(1, 'Silka Salsa', 2007, 'Silka067@gmail.com'),
(2, 'Kayla Z.', 2007, 'KZA@gmail.com'),
(3, 'Chloe Hope', 2007, 'Chloe123@gmail.com'),
(4, 'Edward Munch', 1863, 'munch95@gmail.com'),
(6, 'Copbyo', 2008, 'peacetimeinvestigate@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `pembelian`
--

CREATE TABLE `pembelian` (
  `id_pembelian` int(11) NOT NULL,
  `tgl_beli` date DEFAULT NULL,
  `id_lukisan` int(11) DEFAULT NULL,
  `metode` varchar(50) DEFAULT NULL,
  `id_user` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pembelian`
--

INSERT INTO `pembelian` (`id_pembelian`, `tgl_beli`, `id_lukisan`, `metode`, `id_user`) VALUES
(1, '2026-05-16', 6, 'Transfer Bank', 2),
(7, '2026-05-31', 14, 'Transfer Bank', 7);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `username` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `nama` varchar(30) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` enum('admin','member') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `username`, `email`, `nama`, `password`, `role`) VALUES
(1, 'admin123', NULL, NULL, '4567', 'admin'),
(2, 'chlo333', NULL, 'Chloe', '3333', 'member'),
(3, 'sarrah08', NULL, 'Sarrah M', '1234', 'member'),
(4, 'thoriq1000', NULL, 'Thoriq', '2345', 'member'),
(5, 'shanaraa', NULL, 'Nara', '3456', 'member'),
(6, 'naurrra28', NULL, 'Naura', '4567', 'member'),
(7, 'fufufafa', NULL, 'Gibran', '5678', 'member'),
(8, 'kenzo3771', NULL, 'Kenzo', '5678', 'member');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `lukisan`
--
ALTER TABLE `lukisan`
  ADD PRIMARY KEY (`id_lukisan`),
  ADD KEY `id_pelukis` (`id_pelukis`);

--
-- Indexes for table `pelukis`
--
ALTER TABLE `pelukis`
  ADD PRIMARY KEY (`id_pelukis`);

--
-- Indexes for table `pembelian`
--
ALTER TABLE `pembelian`
  ADD PRIMARY KEY (`id_pembelian`),
  ADD KEY `id_user` (`id_user`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `lukisan`
--
ALTER TABLE `lukisan`
  MODIFY `id_lukisan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `pelukis`
--
ALTER TABLE `pelukis`
  MODIFY `id_pelukis` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `pembelian`
--
ALTER TABLE `pembelian`
  MODIFY `id_pembelian` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1234569;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `lukisan`
--
ALTER TABLE `lukisan`
  ADD CONSTRAINT `lukisan_ibfk_1` FOREIGN KEY (`id_pelukis`) REFERENCES `pelukis` (`id_pelukis`);

--
-- Constraints for table `pembelian`
--
ALTER TABLE `pembelian`
  ADD CONSTRAINT `pembelian_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
