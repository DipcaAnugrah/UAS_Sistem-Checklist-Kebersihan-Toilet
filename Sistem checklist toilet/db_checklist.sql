-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 05, 2024 at 12:11 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_checklist`
--

-- --------------------------------------------------------

--
-- Table structure for table `checklist`
--

CREATE TABLE `checklist` (
  `id` int(11) NOT NULL,
  `tanggal` datetime DEFAULT NULL,
  `toilet_id` int(11) NOT NULL,
  `kloset` tinyint(1) DEFAULT NULL,
  `wastafel` tinyint(1) DEFAULT NULL,
  `lantai` tinyint(1) DEFAULT NULL,
  `dinding` tinyint(1) DEFAULT NULL,
  `kaca` tinyint(1) DEFAULT NULL,
  `bau` tinyint(1) DEFAULT NULL,
  `sabun` tinyint(1) DEFAULT NULL,
  `users_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `checklist`
--

INSERT INTO `checklist` (`id`, `tanggal`, `toilet_id`, `kloset`, `wastafel`, `lantai`, `dinding`, `kaca`, `bau`, `sabun`, `users_id`) VALUES
(13, '2023-11-10 00:00:00', 54, 0, 0, 0, 0, 2, 1, 0, 1),
(15, '2023-01-04 00:00:00', 56, 0, 0, 0, 0, 0, 0, 0, 1),
(16, '2023-02-05 00:00:00', 56, 1, 1, 1, 1, 1, 2, 1, 2);

-- --------------------------------------------------------

--
-- Table structure for table `toilet`
--

CREATE TABLE `toilet` (
  `id` int(11) NOT NULL,
  `lokasi` varchar(45) DEFAULT NULL,
  `keterangan` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `toilet`
--

INSERT INTO `toilet` (`id`, `lokasi`, `keterangan`) VALUES
(54, 'Office', 'Belum'),
(56, 'kantor', 'sedang dalam proses');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(100) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `nama` varchar(200) DEFAULT NULL,
  `email` varchar(200) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `role` tinyint(1) DEFAULT 2 COMMENT '1:Admin\n2:User'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `nama`, `email`, `status`, `role`) VALUES
(1, 'anugrahdpc', '$2y$10$ShCSJ7IaXlSCC2qo7I9GYOyKVd4wdA7n6fiXaVEdP0wDhiQax7QJm', 'anugrahdpc', 'dipcaanugrah26@gmail.com', 0, 0),
(2, 'admin', '$2y$10$yzaamdB.A0jVqIlAk4DnBeu9DFMUFpkiHtqNmibrc8zjNs7iJ2nGu', 'admin', 'dipcaanugrah@gmil.com', 1, 2),
(3, 'dipca', '$2y$10$70B0n6aQfx2T4ASnVYONB.Y9l/IvMYqV5PuWhgUNK/g1UaquMg7AG', 'dipca anugrah', 'anugrahdpc@gmail.com', 1, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `checklist`
--
ALTER TABLE `checklist`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_checklist_toilet_idx` (`toilet_id`),
  ADD KEY `fk_checklist_users1_idx` (`users_id`);

--
-- Indexes for table `toilet`
--
ALTER TABLE `toilet`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username_UNIQUE` (`username`),
  ADD UNIQUE KEY `email_UNIQUE` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `checklist`
--
ALTER TABLE `checklist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `toilet`
--
ALTER TABLE `toilet`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `checklist`
--
ALTER TABLE `checklist`
  ADD CONSTRAINT `fk_checklist_toilet` FOREIGN KEY (`toilet_id`) REFERENCES `toilet` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_checklist_users1` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
