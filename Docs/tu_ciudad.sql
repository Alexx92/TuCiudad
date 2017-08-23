-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 23-08-2017 a las 23:58:08
-- Versión del servidor: 10.1.24-MariaDB
-- Versión de PHP: 7.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `tu_ciudad`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `personal`
--

CREATE TABLE `personal` (
  `id` int(10) NOT NULL,
  `primer_nombre` char(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `segundo_nombre` char(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `apellido_paterno` char(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `apellido_materno` char(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `username` varchar(180) COLLATE utf8_unicode_ci DEFAULT NULL,
  `dni` char(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sexo` char(1) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fecha_nacimiento` date DEFAULT NULL,
  `comuna` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `provincia` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `region` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `dir_villa_pbla` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `dir_calle` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `dir_numero_casa` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `dir_numero_departamento` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `dir_numero_piso` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `telefono` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL,
  `celular` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL,
  `correo` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `skype` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `observacion` text COLLATE utf8_unicode_ci,
  `imagen` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fecha_ingreso` datetime DEFAULT NULL,
  `estado` int(2) DEFAULT NULL,
  `empresa_id` int(10) DEFAULT NULL,
  `estado_personal_id` int(11) DEFAULT NULL,
  `area_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `personal`
--

INSERT INTO `personal` (`id`, `primer_nombre`, `segundo_nombre`, `apellido_paterno`, `apellido_materno`, `username`, `dni`, `sexo`, `fecha_nacimiento`, `comuna`, `provincia`, `region`, `dir_villa_pbla`, `dir_calle`, `dir_numero_casa`, `dir_numero_departamento`, `dir_numero_piso`, `telefono`, `celular`, `correo`, `skype`, `observacion`, `imagen`, `fecha_ingreso`, `estado`, `empresa_id`, `estado_personal_id`, `area_id`) VALUES
(1, 'Hernán', 'Alexis', 'Castro', 'Rodriguez', 'admin', '182608831', '1', '1992-09-30', '165', '31', '9', 'Villa Galilea', 'Los Vicentinos', '260', '', '', '', '945921969', 'alexx92.04@gmail.com', '', 'Empleado peligroso XD, Muy Agresivo', NULL, '2017-07-26 09:54:57', 1, NULL, 2, 3);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `personal`
--
ALTER TABLE `personal`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_personal_empresa1_idx` (`empresa_id`),
  ADD KEY `fk_personal_estado_personal1_idx` (`estado_personal_id`),
  ADD KEY `fk_personal_area1_idx` (`area_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `personal`
--
ALTER TABLE `personal`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `personal`
--
ALTER TABLE `personal`
  ADD CONSTRAINT `fk_personal_area1` FOREIGN KEY (`area_id`) REFERENCES `area` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_personal_empresa1` FOREIGN KEY (`empresa_id`) REFERENCES `empresa` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_personal_estado_personal1` FOREIGN KEY (`estado_personal_id`) REFERENCES `estado_personal` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
