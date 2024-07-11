-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 11, 2024 at 03:41 PM
-- Server version: 8.0.37
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `maintenance_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `areas`
--

CREATE TABLE `areas` (
  `id` int NOT NULL,
  `area_name` varchar(200) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `collaborators`
--

CREATE TABLE `collaborators` (
  `id` int NOT NULL,
  `nickname` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `name` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `surname` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `job-title` varchar(150) COLLATE utf8mb4_general_ci NOT NULL,
  `type-user` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `state` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `profile-photo` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `password` text COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `collaborators`
--

INSERT INTO `collaborators` (`id`, `nickname`, `name`, `surname`, `job-title`, `type-user`, `state`, `profile-photo`, `password`) VALUES
(1, 'admin', 'admin', '', 'Ingeniero', 'admin', 'active', NULL, '$2y$10$Li4SRPsoLCFPFMG0VYRcIuSt6Ge2.0hHnXiqggpPXwgMCVN1oxtA2');

-- --------------------------------------------------------

--
-- Table structure for table `machines`
--

CREATE TABLE `machines` (
  `id` int NOT NULL,
  `state` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `brand` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `model` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `serial_number` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `machine_number` int DEFAULT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `image_path` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `datasheet_url` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `id_area` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE `tasks` (
  `id` int NOT NULL,
  `state` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `priority` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `id_area` int DEFAULT NULL,
  `id_machine` int DEFAULT NULL,
  `id_collaborator` int DEFAULT NULL,
  `creation_task` datetime NOT NULL,
  `date_task` date DEFAULT NULL,
  `finalization_task` datetime DEFAULT NULL,
  `maintenance_type` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `description_task` text COLLATE utf8mb4_general_ci NOT NULL,
  `job_description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `result_task` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `images_job` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `images_task` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `areas`
--
ALTER TABLE `areas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `collaborators`
--
ALTER TABLE `collaborators`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `machines`
--
ALTER TABLE `machines`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_machines_areas` (`id_area`);

--
-- Indexes for table `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_machine` (`id_machine`),
  ADD KEY `id_collaborator` (`id_collaborator`),
  ADD KEY `fk_tasks_areas` (`id_area`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `areas`
--
ALTER TABLE `areas`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `collaborators`
--
ALTER TABLE `collaborators`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `machines`
--
ALTER TABLE `machines`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `machines`
--
ALTER TABLE `machines`
  ADD CONSTRAINT `fk_machines_areas` FOREIGN KEY (`id_area`) REFERENCES `areas` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `tasks`
--
ALTER TABLE `tasks`
  ADD CONSTRAINT `fk_tasks_areas` FOREIGN KEY (`id_area`) REFERENCES `areas` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_tasks_collaborators` FOREIGN KEY (`id_collaborator`) REFERENCES `collaborators` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_tasks_machines` FOREIGN KEY (`id_machine`) REFERENCES `machines` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
