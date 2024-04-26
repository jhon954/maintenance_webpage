-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 26-04-2024 a las 21:16:34
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `db_maintenance_page`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `areas`
--

CREATE TABLE `areas` (
  `id` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `collaborators`
--

CREATE TABLE `collaborators` (
  `id` int(20) NOT NULL,
  `nickname` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `surname` varchar(100) NOT NULL,
  `job-title` varchar(150) NOT NULL,
  `type-user` varchar(30) NOT NULL,
  `state` varchar(20) NOT NULL,
  `profile-photo` text NOT NULL,
  `password` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `collaborators`
--

INSERT INTO `collaborators` (`id`, `nickname`, `name`, `surname`, `job-title`, `type-user`, `state`, `profile-photo`, `password`) VALUES
(1, 'admin', 'admin', '', 'Ingeniero', 'admin', 'active', '../img/profiles/1/profile.jpg', '$2y$10$rGqViEnjtv8JKBXpUmUWhO/HP5tQuGqNa2C6MpBG7bqjpDT86phse'),
(2, 'pedro2rojas', 'Pedro', 'Rojas', 'Colaborador', 'colab', 'active', '../img/profiles/2/profile.jpg', '$2y$10$8Lc6u4qjuHKXTrg6K/TTWOL4lUQDDS/R.oewhs5rcNbJkEEa87NHq');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `machines`
--

CREATE TABLE `machines` (
  `id` int(100) NOT NULL,
  `state` varchar(20) NOT NULL,
  `brand` varchar(200) NOT NULL,
  `model` varchar(200) NOT NULL,
  `serial_number` varchar(250) NOT NULL,
  `machine_number` int(50) NOT NULL,
  `description` text NOT NULL,
  `technical_sheet` text NOT NULL,
  `image_path` text NOT NULL,
  `id_area` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tasks`
--

CREATE TABLE `tasks` (
  `id` int(20) NOT NULL,
  `state` varchar(20) NOT NULL,
  `priority` varchar(20) NOT NULL,
  `id_area` varchar(100) DEFAULT NULL,
  `id_machine` int(100) DEFAULT NULL,
  `id_collaborator` int(20) DEFAULT NULL,
  `creation_task` datetime NOT NULL,
  `date_task` date NOT NULL,
  `finalization_task` datetime NOT NULL,
  `maintenance_type` varchar(50) NOT NULL,
  `description_task` text NOT NULL,
  `job_description` text NOT NULL,
  `result_task` varchar(50) NOT NULL,
  `images_job` text NOT NULL,
  `images_task` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `areas`
--
ALTER TABLE `areas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `collaborators`
--
ALTER TABLE `collaborators`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `machines`
--
ALTER TABLE `machines`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_area` (`id_area`);

--
-- Indices de la tabla `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_area` (`id_area`,`id_machine`,`id_collaborator`),
  ADD KEY `id_machine` (`id_machine`),
  ADD KEY `id_collaborator` (`id_collaborator`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `collaborators`
--
ALTER TABLE `collaborators`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `machines`
--
ALTER TABLE `machines`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tasks`
--
ALTER TABLE `tasks`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `machines`
--
ALTER TABLE `machines`
  ADD CONSTRAINT `fk_machines_areas` FOREIGN KEY (`id_area`) REFERENCES `areas` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Filtros para la tabla `tasks`
--
ALTER TABLE `tasks`
  ADD CONSTRAINT `fk_tasks_areas` FOREIGN KEY (`id_area`) REFERENCES `areas` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_tasks_collaborators` FOREIGN KEY (`id_collaborator`) REFERENCES `collaborators` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_tasks_machines` FOREIGN KEY (`id_machine`) REFERENCES `machines` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
