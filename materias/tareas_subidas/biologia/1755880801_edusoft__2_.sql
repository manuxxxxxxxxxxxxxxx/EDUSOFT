-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 21-08-2025 a las 05:15:38
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
-- Estructura de tabla para la tabla `avisos`
--

DROP TABLE IF EXISTS `avisos`;
CREATE TABLE IF NOT EXISTS `avisos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_clase` int NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `descripcion` text NOT NULL,
  `fecha_subida` date NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_clase` (`id_clase`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `avisos`
--

INSERT INTO `avisos` (`id`, `id_clase`, `titulo`, `descripcion`, `fecha_subida`) VALUES
(1, 8, 'Integradora', 'Recordar que el dia 30 de agosto se realizara la integradora de matematicas, llevar regla, calculadora y lapiz solamente.', '2025-08-21');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `citas`
--

DROP TABLE IF EXISTS `citas`;
CREATE TABLE IF NOT EXISTS `citas` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `start` datetime NOT NULL,
  `end` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clases`
--

DROP TABLE IF EXISTS `clases`;
CREATE TABLE IF NOT EXISTS `clases` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre_clase` varchar(100) NOT NULL,
  `materia` varchar(50) NOT NULL,
  `descripcion` text,
  `codigo_clase` varchar(6) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `profesor_id` int NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `codigo_clase` (`codigo_clase`),
  KEY `profesor_id` (`profesor_id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `clases`
--

INSERT INTO `clases` (`id`, `nombre_clase`, `materia`, `descripcion`, `codigo_clase`, `profesor_id`) VALUES
(1, 'Biologia 3B', 'biologia', 'hola', NULL, 5),
(2, 'Matemática 2B', 'matematica', 'Curso de matemática', NULL, 5),
(7, 'lenguaje2a', 'lenguaje', 'clase', 'TGA4CC', 6),
(8, 'Matematica 2B', 'matematica', '', 'N3N9KO', 7),
(9, 'Biologia 3A', 'biologia', 'holaa', '6SOX1Z', 7),
(10, 'Sociales 1A', 'sociales', '', '85P5C0', 7),
(11, 'Lenguaje 1C', 'lenguaje', '', 'BJ46ZM', 7);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clases_estudiantes`
--

DROP TABLE IF EXISTS `clases_estudiantes`;
CREATE TABLE IF NOT EXISTS `clases_estudiantes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_clase` int NOT NULL,
  `id_estudiante` int NOT NULL,
  `fecha_union` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `id_clase` (`id_clase`),
  KEY `id_estudiante` (`id_estudiante`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `clases_estudiantes`
--

INSERT INTO `clases_estudiantes` (`id`, `id_clase`, `id_estudiante`, `fecha_union`) VALUES
(2, 7, 6, '2025-08-05 02:29:23');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contacto`
--

DROP TABLE IF EXISTS `contacto`;
CREATE TABLE IF NOT EXISTS `contacto` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `asunto` varchar(100) DEFAULT NULL,
  `msj` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `contacto`
--

INSERT INTO `contacto` (`id`, `nombre`, `email`, `asunto`, `msj`) VALUES
(1, 'Gabriel Alvarado', 'gabrielguidos@gmail.com', 'Si agarro jeje', 'No es secreto tu me tienes loco, me siento en LSD cuando te toco, soy un tonto y mil veces me equivoco, te quiero siempre a mi ladito como YOKO'),
(6, 'sdfasdfasdf', 'adsfasfasdf@dasd', 'dsafasfd', 'sdfsadfasfdasdf');

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
) ENGINE=MyISAM AUTO_INCREMENT=32 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `estudiantes`
--

INSERT INTO `estudiantes` (`ID`, `nombre`, `email`, `pass`) VALUES
(24, 'manuel33', 'manucampos607@gmail.com', '$2y$10$H12vSGJ/orWWhMFvUqrkg.9gSwILHwszK7sPvhueEgqPy9k2JHMAm'),
(25, 'aldair', 'aldair@cgmail.com', '$2y$10$30bQhxsl8ARGJrbVlL6gw.f6JyVyUapypxNKBNFsRvxTr7R8iq3o.'),
(26, 'Ulises', 'ulises@gmail.com', '$2y$10$tSF57FJj03cW9j8Mrf/g..h44HnhykaP81vYiZ/NVsGc7j4abbFXO'),
(28, 'Oscar', 'a@gmail.com', '$2y$10$SStmbssIecQJcCs5DC.kVOxJtMJ6aDbLustvLVf39oiNkIuqnZAGG'),
(29, 'victor', 'victor@gmail.com', '$2y$10$8da2Qok4BX29iQ/vMv.4QO/aK1PkidQuGZtylCHSxdj0PMDa6Ue82'),
(30, 'wemba', 'wemba@gmail.com', '$2y$10$Fmg5twKDGFaRVDAbTHlcxeTKvsCjSoAb60GF2BD/Ph3.dnkTVQHrG'),
(31, 'eladio', 'eladio@gmail.com', '$2y$10$Xrw0a8AVzpxegnDYbxHGbu27y3yAaci22Tl/gzYQlm4G8AxV6ApVW');

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
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `materiales_estudio`
--

INSERT INTO `materiales_estudio` (`id`, `id_clase`, `titulo`, `descripcion`, `archivo`, `ruta_archivo`, `fecha_subida`) VALUES
(12, 8, 'Llori pariii', 'jeje', 'edusoft.sql', '../materiales_subidos/edusoft.sql', '2025-08-08 01:56:12'),
(13, 9, 'Sayonara ', 'hehe', 'edusoft.sql', '../materiales_subidos/edusoft.sql', '2025-08-08 01:56:31'),
(14, 10, 'Felicilandia:)', 'donde los niños tristes, dejan de ser como chester', 'curriculum V2.0 DAG.docx', '../materiales_subidos/curriculum V2.0 DAG.docx', '2025-08-08 02:30:42');

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
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

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
(7, 'Gabo', 'gabo@gmail.com', '$2y$10$Zm5YkLjihjz.5.JCW8jQguIfcrpA73D2/r5ZzgA.pZ28oOu11Bv8y', 61040323, '12345678-');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tareas`
--

DROP TABLE IF EXISTS `tareas`;
CREATE TABLE IF NOT EXISTS `tareas` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_estudiante` int NOT NULL,
  `materia` varchar(100) DEFAULT NULL,
  `nombre_archivo` varchar(255) DEFAULT NULL,
  `ruta_archivo` varchar(255) DEFAULT NULL,
  `fecha_subida` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_estudiante` (`id_estudiante`)
) ENGINE=MyISAM AUTO_INCREMENT=60 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tareas`
--

INSERT INTO `tareas` (`id`, `id_estudiante`, `materia`, `nombre_archivo`, `ruta_archivo`, `fecha_subida`) VALUES
(1, 25, 'biologia', 'edusoft.sql', '../uploads/686c002905ae1_edusoft.sql', '2025-07-07 17:13:13'),
(2, 25, 'biologia', 'edusoft.sql', '../uploads/686c017da63cd_edusoft.sql', '2025-07-07 17:18:53'),
(3, 25, 'biologia', 'edusoft.sql', '../uploads/686c03a28efcf_edusoft.sql', '2025-07-07 17:28:02'),
(4, 25, 'biologia', 'edusoft.sql', '../uploads/686c03b36864c_edusoft.sql', '2025-07-07 17:28:19'),
(5, 29, 'biologia', 'Tipología de redes.pdf', '../uploads/687e4c09b9b18_Tipología de redes.pdf', '2025-07-21 14:17:45'),
(6, 25, 'biologia', 'chino.jpeg', '../uploads/6890398396576_chino.jpeg', '2025-08-04 04:39:31'),
(34, 31, 'biologia', 'Sistema de becas.png', 'tareas_subidas/biologia/1754354720_Sistema_de_becas.png', '2025-08-05 00:45:20'),
(55, 31, 'biologia', 'Captura de pantalla 2024-03-07 232752.png', 'tareas_subidas/biologia/1754362403_Captura_de_pantalla_2024_03_07_232752.png', '2025-08-04 20:53:23'),
(59, 31, 'biologia', 'Captura de pantalla 2023-10-05 002935.png', 'tareas_subidas/biologia/1754366767_Captura_de_pantalla_2023_10_05_002935.png', '2025-08-04 22:06:07');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tareas_profesor`
--

DROP TABLE IF EXISTS `tareas_profesor`;
CREATE TABLE IF NOT EXISTS `tareas_profesor` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_clase` int NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `descripcion` text,
  `archivo_adjunto` varchar(255) DEFAULT NULL,
  `fecha_creacion` datetime DEFAULT CURRENT_TIMESTAMP,
  `fecha_entrega` date DEFAULT NULL,
  `puntos` int DEFAULT '0',
  `tema` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `clase_id` (`id_clase`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tareas_profesor`
--

INSERT INTO `tareas_profesor` (`id`, `id_clase`, `titulo`, `descripcion`, `archivo_adjunto`, `fecha_creacion`, `fecha_entrega`, `puntos`, `tema`) VALUES
(1, 8, 'Llori pari', 'alvarito dayssss', NULL, '2025-08-08 00:28:18', '2025-08-28', 20, 'Alvaro'),
(2, 9, 'Sayonara ', 'Alvarito dias, ALBUM SAYONARA', NULL, '2025-08-08 01:52:37', '2025-08-19', 20, 'Alvaro'),
(3, 10, 'Quien te quiere como el nene', 'Nadie te quiere como el nene wemba', '../archivos_tareas/1754641788_edusoft.sql', '2025-08-08 02:29:48', '2025-08-20', 20, 'Alvaro');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
