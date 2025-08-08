-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 08-08-2025 a las 06:52:08
-- Versión del servidor: 9.1.0
-- Versión de PHP: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `edusoft`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `materiales_estudio`
--

DROP TABLE IF EXISTS `materiales_estudio`;
CREATE TABLE IF NOT EXISTS `materiales_estudio` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_clase` int NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `descripcion` text,
  `archivo` varchar(255) DEFAULT NULL,
  `ruta_archivo` varchar(255) DEFAULT NULL,
  `fecha_subida` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `id_clase` (`id_clase`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `materiales_estudio`
--

INSERT INTO `materiales_estudio` (`id`, `id_clase`, `titulo`, `descripcion`, `archivo`, `ruta_archivo`, `fecha_subida`) VALUES
(1, 8, 'Llori pari 2', 'aprendamos sobre el llori pari', 'edusoft.sql', '../materiales_subidos/edusoft.sql', '2025-08-08 00:29:09');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
