-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 27-04-2025 a las 17:45:31
-- Versión del servidor: 8.3.0
-- Versión de PHP: 8.2.18

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
-- Estructura de tabla para la tabla `estudiantes`
--

DROP TABLE IF EXISTS `estudiantes`;
CREATE TABLE IF NOT EXISTS `estudiantes` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `pass` varchar(100) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `estudiantes`
--

INSERT INTO `estudiantes` (`ID`, `nombre`, `email`, `pass`) VALUES
(1, 'm', 'm@gmail.com', '$2y$10$btC8lJFxCILeV42ZBnyOReZ6h7trN6hQlFCFmAOG1CfOOm4bPl40m'),
(16, 'manux', 'manux@gmail.com', '$2y$10$PQe7vdlnfbPdmGuF4DFU/O4Vz8RfCS8iZldlWshSNdONh3WdbsWLW'),
(13, 'gabo', 'gabo@gmail.com', '$2y$10$9tGgkRCuV6pY2WlPRBERUu/zyuoPTSjXOkaPfR0iirdMxRQ48Xo.G'),
(15, 'z', 'z@gmail.com', '$2y$10$c9tXOfngwTbS8C94C.Qnl.iPNPuqGUd/llJLXBUlrBgGQsSyOOZLa'),
(6, 'a', 'a@gmail.com', '$2y$10$o3Kv9I6.OLIimimEkXjSw.e7CeFquh5ZzK7wo4gGoyfhk1i5R0.YW'),
(12, 'o', 'o@gmail.com', '$2y$10$drY8EP.8G5M6p2T507p9MuMMSWOR4qAK/GIuPVKj6wdUYvO8sG1ey'),
(11, 'i', 'i@gmail.com', '$2y$10$lCp7eW707P.UhVdqJboE3.EmvkxDSedkB067WnQa0mcjjb4.291eG'),
(19, 'cris', 'cris@gmail.com', '$2y$10$RVz5GLCdKvQcSqB3jwOJX.oxEfl823s3vRmGcX0PZS1ILPsuiH/SK'),
(17, 'victor', 'victor@gmail.com', '$2y$10$9uw7ibjFbt1jYhBrqe1klueZIq.38aPH3Ns8vVbKo2yPkcSasyCKG'),
(18, 'aron', 'aron@gmail.com', '$2y$10$fBk6FkXSfHslS7esgMmuHOkqEvG2AbNxAM2WrmtFYQskWQAws0XOK'),
(20, 'neetozz', 'netozzz@gmail.com', '$2y$10$SaYzePAIW3l6MX3nvrDY3OSw.N9z7rrCk70HRjbfrGpJrbqOSs7k6'),
(21, 'carlitos', 'carlitos@gmail.com', '$2y$10$2bR8cNQH1wjdFmryvSVnSu5FQN5DSguMappvZ5.S.dor4am9yrRHy'),
(22, 'uron', 'uron@gmail.com', '$2y$10$cwbDEuEKPfWSpU.svfyBnOrTyQB5IeXqwngT7I2Kh5365wucsvVQ2'),
(23, 'kiki', 'kiki@gmail.com', '$2y$10$K.nZv5xUPXTB68SHEsOq8upUy9/C9X9RAUXErss.ZHnXMFMsFDRtS');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `profesores`
--

DROP TABLE IF EXISTS `profesores`;
CREATE TABLE IF NOT EXISTS `profesores` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `pass` varchar(100) NOT NULL,
  `tel` int NOT NULL,
  `dui` varchar(9) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `profesores`
--

INSERT INTO `profesores` (`id`, `nombre`, `email`, `pass`, `tel`, `dui`) VALUES
(1, 'shots', 'shots@gmail.com', '$2y$10$pE5cYncJf4Lz5kAquLWHM.VukA3R75q8t692nRtVC580Wuowvmopm', 22345678, '12345678-');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
