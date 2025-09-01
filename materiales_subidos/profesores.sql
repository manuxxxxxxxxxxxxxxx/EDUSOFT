-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 08-08-2025 a las 16:04:30
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
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `profesores`
--

INSERT INTO `profesores` (`id`, `nombre`, `email`, `pass`, `tel`, `dui`) VALUES
(1, 'shots', 'shots@gmail.com', '$2y$10$pE5cYncJf4Lz5kAquLWHM.VukA3R75q8t692nRtVC580Wuowvmopm', 22345678, '12345678-'),
(2, 'manuel32', 'manucampos607@gmail.com', '$2y$10$U0Jex3VOuSiGuZtHsP7gN.LOGumbl1KmDFM89CUuQVp8nHkD4p2m.', 78002012, '23232323-'),
(3, 'luis25', 'luis23@gmail.com', '$2y$10$z/V8Vvg/WUqwr0KSYdTmGOJjctaMBHaPNIe1BYb0./T4p2WbTQodm', 78002012, '12345678-'),
(4, 'aron', 'aron@gmail.com', '$2y$10$dnyI.TziwMLgq5xJdCyYUuE9E7bXSzgQwV0wbynmmqtwyg/Ydkn/y', 23456781, '12345564-'),
(5, 'chele', 'chele@gmail.com', '$2y$10$9R.zn8shf.wdjChRaHitkeJ1Wp/2Eglir..1XFfFEAc2WrVig7uQS', 61040323, '12345678-'),
(6, 'chelillo', 'chelillo@gmail.com', '$2y$10$7e7K8JmY/nKae6xPMdnkDuV88RivOgs61EPv.8Y/Wp.gNRcpkwVDq', 27654312, '12345678-'),
(7, 'Gabo', 'gabo@gmail.com', '$2y$10$Zm5YkLjihjz.5.JCW8jQguIfcrpA73D2/r5ZzgA.pZ28oOu11Bv8y', 61040323, '12345678-'),
(8, 'manux12', 'manux12@gmail.com', '$2y$10$/Y5Gp2X6sbbsZlP/oidSO.xbloqcBjeCioDN6mRcCsxSPmuy8Y4aq', 78002012, '12345678-');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
