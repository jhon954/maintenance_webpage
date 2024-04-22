-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 22-04-2024 a las 14:30:03
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
  `id` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `collaborators`
--

CREATE TABLE `collaborators` (
  `id` int(11) NOT NULL,
  `nickname` varchar(30) NOT NULL,
  `name` varchar(30) NOT NULL,
  `surname` varchar(30) NOT NULL,
  `job-title` varchar(30) NOT NULL,
  `type-user` varchar(20) NOT NULL,
  `state` varchar(15) NOT NULL,
  `profile-photo` varchar(30) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `collaborators`
--

INSERT INTO `collaborators` (`id`, `nickname`, `name`, `surname`, `job-title`, `type-user`, `state`, `profile-photo`, `password`) VALUES
(1, 'admin', 'admin', '', 'Ingeniero', 'admin', 'active', '', '$2y$10$T.OoLxj43TpcaBiha581gu5WA0UL1myu0S2fCPEBl9HRxFDBACLDa');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `machines`
--

CREATE TABLE `machines` (
  `id` int(11) NOT NULL,
  `state` varchar(10) NOT NULL,
  `brand` varchar(30) NOT NULL,
  `model` varchar(30) NOT NULL,
  `serial_number` varchar(60) NOT NULL,
  `machine_number` int(10) NOT NULL,
  `description` text NOT NULL,
  `technical_sheet` varchar(60) NOT NULL,
  `image_path` varchar(50) NOT NULL,
  `id_area` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `on_site_tasks`
--

CREATE TABLE `on_site_tasks` (
  `id` int(11) NOT NULL,
  `state` varchar(10) NOT NULL,
  `description_task` varchar(60) NOT NULL,
  `creation_task` datetime NOT NULL,
  `finalization_task` datetime NOT NULL,
  `description_job` varchar(60) NOT NULL,
  `id_area` varchar(30) NOT NULL,
  `id_collaborator` int(11) NOT NULL,
  `images_task` varchar(60) NOT NULL,
  `images_job` varchar(60) NOT NULL,
  `assigned` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tasks`
--

CREATE TABLE `tasks` (
  `id` int(20) NOT NULL,
  `state` varchar(10) NOT NULL,
  `priority` varchar(10) NOT NULL,
  `id_area` varchar(20) NOT NULL,
  `id_machine` int(11) NOT NULL,
  `id_collaborator` int(11) NOT NULL,
  `creation_task` datetime NOT NULL,
  `date_task` date DEFAULT NULL,
  `finalization_task` datetime DEFAULT NULL,
  `maintenance_type` varchar(20) DEFAULT NULL,
  `description_task` text NOT NULL,
  `job_description` text NOT NULL,
  `result_task` varchar(20) DEFAULT NULL,
  `images_job` varchar(60) NOT NULL,
  `images_task` varchar(60) NOT NULL
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
  ADD KEY `fk_machines_areas` (`id_area`);

--
-- Indices de la tabla `on_site_tasks`
--
ALTER TABLE `on_site_tasks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_onsite_tasks_areas` (`id_area`),
  ADD KEY `fk_onsite_tasks_collaborators` (`id_collaborator`);

--
-- Indices de la tabla `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_tasks_machines` (`id_machine`),
  ADD KEY `fk_tasks_collaborators` (`id_collaborator`),
  ADD KEY `fk_tasks_areas` (`id_area`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `collaborators`
--
ALTER TABLE `collaborators`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `machines`
--
ALTER TABLE `machines`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `on_site_tasks`
--
ALTER TABLE `on_site_tasks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

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
  ADD CONSTRAINT `fk_machines_areas` FOREIGN KEY (`id_area`) REFERENCES `areas` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Filtros para la tabla `on_site_tasks`
--
ALTER TABLE `on_site_tasks`
  ADD CONSTRAINT `fk_onsite_tasks_areas` FOREIGN KEY (`id_area`) REFERENCES `areas` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_onsite_tasks_collaborators` FOREIGN KEY (`id_collaborator`) REFERENCES `collaborators` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Filtros para la tabla `tasks`
--
ALTER TABLE `tasks`
  ADD CONSTRAINT `fk_tasks_areas` FOREIGN KEY (`id_area`) REFERENCES `areas` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_tasks_collaborators` FOREIGN KEY (`id_collaborator`) REFERENCES `collaborators` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_tasks_machines` FOREIGN KEY (`id_machine`) REFERENCES `machines` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
