-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 08-09-2025 a las 01:23:13
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
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `avisos`
--

INSERT INTO `avisos` (`id`, `id_clase`, `titulo`, `descripcion`, `fecha_subida`) VALUES
(1, 8, 'Integradora', 'Recordar que el dia 30 de agosto se realizara la integradora de matematicas, llevar regla, calculadora y lapiz solamente.', '2025-08-21'),
(2, 7, 'Escuela de padres', 'se cita a los padres de familia a asistir a la reunión', '2025-08-22');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `calificaciones_rubrica`
--

DROP TABLE IF EXISTS `calificaciones_rubrica`;
CREATE TABLE IF NOT EXISTS `calificaciones_rubrica` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_tarea` int NOT NULL,
  `id_estudiante` int NOT NULL,
  `calificacion_final` decimal(5,2) NOT NULL,
  `criterios_calificados_json` text NOT NULL,
  `retroalimentacion` text,
  `fecha_calificacion` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `citas`
--

INSERT INTO `citas` (`id`, `title`, `start`, `end`) VALUES
(3, 'tarea lenguaje', '2025-08-14 21:01:00', '2025-08-15 21:01:00');

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
  `imagen_materia` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `codigo_clase` (`codigo_clase`),
  KEY `profesor_id` (`profesor_id`)
) ENGINE=MyISAM AUTO_INCREMENT=26 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `clases`
--

INSERT INTO `clases` (`id`, `nombre_clase`, `materia`, `descripcion`, `codigo_clase`, `profesor_id`, `imagen_materia`) VALUES
(1, 'Biologia 3B', 'biologia', 'hola', NULL, 5, NULL),
(2, 'Matemática 2B', 'matematica', 'Curso de matemática', NULL, 5, NULL),
(7, 'lenguaje2a', 'lenguaje', 'clase', 'TGA4CC', 6, 'https://www.babidibulibros.com/wp-content/uploads/2024/11/que-es-el-lenguaje-literario.jpg'),
(8, 'Matematica 2B', 'matematica', '', 'N3N9KO', 7, NULL),
(9, 'Biologia 3A', 'biologia', 'holaa', '6SOX1Z', 7, NULL),
(10, 'Sociales 1A', 'sociales', '', '85P5C0', 7, NULL),
(11, 'Lenguaje 1C', 'lenguaje', '', 'BJ46ZM', 7, NULL),
(12, 'Biologia 2', 'biologia', 'Bilogia para todos', 'U5YGO3', 8, NULL),
(13, 'matematicas2b', 'matematica', 'victorrr', 'SVTS3Y', 8, NULL),
(14, 'matematicas2a', 'matematica', 'clases', 'F51L6E', 6, NULL),
(15, 'biology', 'biologia', 'interactive class', '4LLS82', 6, NULL),
(16, 'sociales 1c', 'sociales', 'chicos chicos', 'IIGC9T', 6, NULL),
(17, 'ciencias 3 d', 'ciencia', 'mas sin embargo', '2DSFHC', 6, NULL),
(18, 'quimica 3e', 'quimica', 'detalles', 'I5BTAJ', 6, NULL),
(19, 'Ingles IA9', 'ingles', 'Crea j', '5K75EN', 6, NULL),
(20, 'lenguaje 2b', 'lenguaje', 'hola', 'FT5BL3', 6, NULL),
(21, 'Ingles IA6', 'ingles', 'Interactive class', '966H4E', 10, NULL),
(22, 'biologia 2a', 'biologia', 'CLASE', 'M6CJVF', 10, NULL),
(23, 'Educación fisica 2a', 'deporte', 'ejercicios', 'UZUMQF', 6, NULL),
(24, 'debate 2c', 'debate', 'preparense', 'H73EC4', 6, NULL);

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
) ENGINE=MyISAM AUTO_INCREMENT=22 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `clases_estudiantes`
--

INSERT INTO `clases_estudiantes` (`id`, `id_clase`, `id_estudiante`, `fecha_union`) VALUES
(5, 14, 31, '2025-08-08 11:57:19'),
(4, 7, 31, '2025-08-08 11:43:42'),
(16, 15, 31, '2025-08-24 03:35:01'),
(7, 7, 32, '2025-08-22 21:19:58'),
(8, 15, 32, '2025-08-22 21:23:06'),
(14, 16, 31, '2025-08-23 01:45:40'),
(13, 17, 31, '2025-08-23 01:37:05'),
(11, 18, 31, '2025-08-23 01:29:01'),
(12, 19, 31, '2025-08-23 01:29:15'),
(17, 23, 31, '2025-08-25 23:34:20'),
(18, 24, 31, '2025-08-25 23:46:39'),
(20, 8, 30, '2025-08-30 19:55:31'),
(21, 8, 31, '2025-09-07 12:47:33');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comentarios_clase`
--

DROP TABLE IF EXISTS `comentarios_clase`;
CREATE TABLE IF NOT EXISTS `comentarios_clase` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_clase` int NOT NULL,
  `id_estudiante` int DEFAULT NULL,
  `id_profesor` int DEFAULT NULL,
  `comentario` text NOT NULL,
  `respuesta` text,
  `fecha` datetime DEFAULT CURRENT_TIMESTAMP,
  `fecha_respuesta` datetime DEFAULT NULL,
  `estado` enum('pendiente','respondido') DEFAULT 'pendiente',
  PRIMARY KEY (`id`),
  KEY `id_clase` (`id_clase`),
  KEY `id_estudiante` (`id_estudiante`),
  KEY `id_profesor` (`id_profesor`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `comentarios_clase`
--

INSERT INTO `comentarios_clase` (`id`, `id_clase`, `id_estudiante`, `id_profesor`, `comentario`, `respuesta`, `fecha`, `fecha_respuesta`, `estado`) VALUES
(1, 12, 30, 7, 'Tengo una pequeña duda con la tarea jeje soy victor', 'cual es tu pregunta vectorrr', '2025-08-23 13:07:31', '2025-08-23 18:01:00', 'respondido'),
(2, 12, 30, NULL, 'soy vector jeje', NULL, '2025-08-23 18:03:21', NULL, 'pendiente'),
(3, 15, 31, NULL, 'que pasa', NULL, '2025-08-24 01:55:40', NULL, 'pendiente');

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
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `contacto`
--

INSERT INTO `contacto` (`id`, `nombre`, `email`, `asunto`, `msj`) VALUES
(1, 'Gabriel Alvarado', 'gabrielguidos@gmail.com', 'Si agarro jeje', 'No es secreto tu me tienes loco, me siento en LSD cuando te toco, soy un tonto y mil veces me equivoco, te quiero siempre a mi ladito como YOKO'),
(6, 'sdfasdfasdf', 'adsfasfasdf@dasd', 'dsafasfd', 'sdfsadfasfdasdf'),
(7, 'nelson', 'cr@gmail.com', 'biology', 'observations of project'),
(8, 'julia hernandez', 'jhernandez@gmail.com', 'vacaciones', 'adios a todos y felices vacaciones cuidense ucho');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `descripciones_rubros`
--

DROP TABLE IF EXISTS `descripciones_rubros`;
CREATE TABLE IF NOT EXISTS `descripciones_rubros` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_clase` int NOT NULL,
  `periodo` int NOT NULL,
  `rubro` varchar(32) NOT NULL,
  `descripcion` text NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_clase_periodo_rubro` (`id_clase`,`periodo`,`rubro`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `descripciones_rubros`
--

INSERT INTO `descripciones_rubros` (`id`, `id_clase`, `periodo`, `rubro`, `descripcion`) VALUES
(1, 8, 1, 'aula', 'La tarea de aula consiste en resolver los ejercicios trabajados durante la clase, aplicando los procedimientos y fórmulas vistos en el tema para reforzar la comprensión y asegurar el dominio de los conceptos matemáticos.'),
(2, 8, 1, 'integradora', 'La tarea integradora busca aplicar los conocimientos adquiridos en distintas unidades de matemática para resolver un problema que combine varios enfoques, demostrando la capacidad de relacionar teoría con práctica y de explicar el procedimiento seguido.'),
(3, 8, 1, 'prueba_objetiva', 'La prueba objetiva evalúa de manera puntual los aprendizajes mediante preguntas de opción múltiple y enunciados breves, donde el estudiante debe seleccionar la respuesta correcta aplicando definiciones, propiedades y operaciones básicas de matemática.'),
(4, 8, 1, 'examen_trimestral', 'El examen de período es una evaluación integral que mide el dominio de todos los contenidos estudiados durante la unidad, presentando problemas de desarrollo y análisis que requieren justificar procedimientos y demostrar un manejo completo de los temas matemáticos.'),
(5, 8, 1, 'nota_formativa', 'La nota formativa corresponde a una actividad de evaluación continua que permite medir el progreso en el aprendizaje de los contenidos, priorizando el esfuerzo, la claridad en la resolución de ejercicios y el uso correcto de los procedimientos matemáticos.');

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
  `imagen` varchar(255) DEFAULT NULL,
  `modo_oscuro` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=33 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `estudiantes`
--

INSERT INTO `estudiantes` (`ID`, `nombre`, `email`, `pass`, `imagen`, `modo_oscuro`) VALUES
(24, 'manuel33', 'manucampos607@gmail.com', '$2y$10$H12vSGJ/orWWhMFvUqrkg.9gSwILHwszK7sPvhueEgqPy9k2JHMAm', NULL, 0),
(25, 'aldair', 'aldair@cgmail.com', '$2y$10$30bQhxsl8ARGJrbVlL6gw.f6JyVyUapypxNKBNFsRvxTr7R8iq3o.', NULL, 0),
(26, 'Ulises', 'ulises@gmail.com', '$2y$10$tSF57FJj03cW9j8Mrf/g..h44HnhykaP81vYiZ/NVsGc7j4abbFXO', NULL, 0),
(28, 'Oscar', 'a@gmail.com', '$2y$10$SStmbssIecQJcCs5DC.kVOxJtMJ6aDbLustvLVf39oiNkIuqnZAGG', NULL, 0),
(29, 'victor', 'victor@gmail.com', '$2y$10$8da2Qok4BX29iQ/vMv.4QO/aK1PkidQuGZtylCHSxdj0PMDa6Ue82', NULL, 0),
(30, 'wemba', 'wemba@gmail.com', '$2y$10$Fmg5twKDGFaRVDAbTHlcxeTKvsCjSoAb60GF2BD/Ph3.dnkTVQHrG', NULL, 0),
(31, 'eladio', 'eladio@gmail.com', '$2y$10$Xrw0a8AVzpxegnDYbxHGbu27y3yAaci22Tl/gzYQlm4G8AxV6ApVW', 'https://assets.goal.com/images/v3/getty-2215750594/crop/MM5DGOJTGY5DEMRRGQ5G433XMU5DMNZVHI4DI===/GettyImages-2215750594.jpg?auto=webp&format=pjpg&width=3840&quality=60', 0),
(32, 'Maria Jose Quintanilla', 'Mariajose@gmail.com', '$2y$10$rtq4MZ9ePlCnelvPA2/izei3Jv6eVnCjNZ4XGcyySd6vgwMPvB93u', NULL, 0);

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
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `materiales_estudio`
--

INSERT INTO `materiales_estudio` (`id`, `id_clase`, `titulo`, `descripcion`, `archivo`, `ruta_archivo`, `fecha_subida`) VALUES
(11, 8, 'Llori pari 2', 'es que me gustas pero no se na de ti, yo me estaba preguntando si todavia piensas en mi.', 'materiales_estudio.sql', '../materiales_subidos/materiales_estudio.sql', '2025-08-08 01:39:31'),
(13, 9, 'Sayonara ', 'hehe', 'edusoft.sql', '../materiales_subidos/edusoft.sql', '2025-08-08 01:56:31'),
(14, 10, 'Felicilandia:)', 'donde los niños tristes, dejan de ser como chester', 'curriculum V2.0 DAG.docx', '../materiales_subidos/curriculum V2.0 DAG.docx', '2025-08-08 02:30:42'),
(15, 12, 'VECTOR', 'victor vbicprt', 'mexico.png', '../materiales_subidos/mexico.png', '2025-08-08 07:48:06'),
(17, 7, 'VECTOR1111', 'a', '5 spidy (1).jpeg', '../materiales_subidos/5 spidy (1).jpeg', '2025-08-08 08:32:19'),
(18, 14, 'vector', 'calses', 'mexico.png', '../materiales_subidos/mexico.png', '2025-08-08 11:43:12'),
(19, 15, 'shots', 'shotsn3', 'estados unidos.png', '../materiales_subidos/estados unidos.png', '2025-08-20 14:12:11');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `notas_periodos`
--

DROP TABLE IF EXISTS `notas_periodos`;
CREATE TABLE IF NOT EXISTS `notas_periodos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_alumno` int NOT NULL,
  `id_clase` int NOT NULL,
  `materia` varchar(80) NOT NULL,
  `periodo` int NOT NULL,
  `aula` float DEFAULT NULL,
  `integradora` float DEFAULT NULL,
  `prueba_objetiva` float DEFAULT NULL,
  `examen_trimestral` float DEFAULT NULL,
  `nota_formativa` float DEFAULT NULL,
  `promedio_final` float DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_alumno` (`id_alumno`),
  KEY `id_clase` (`id_clase`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `notas_periodos`
--

INSERT INTO `notas_periodos` (`id`, `id_alumno`, `id_clase`, `materia`, `periodo`, `aula`, `integradora`, `prueba_objetiva`, `examen_trimestral`, `nota_formativa`, `promedio_final`) VALUES
(1, 30, 8, 'matematica', 1, 6.5, 9, 10, 6, 10, 8.15);

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
  `foto` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `profesores`
--

INSERT INTO `profesores` (`id`, `nombre`, `email`, `pass`, `tel`, `dui`, `foto`) VALUES
(1, 'shots', 'shots@gmail.com', '$2y$10$pE5cYncJf4Lz5kAquLWHM.VukA3R75q8t692nRtVC580Wuowvmopm', 22345678, '12345678-', NULL),
(2, 'manuel32', 'manucampos607@gmail.com', '$2y$10$U0Jex3VOuSiGuZtHsP7gN.LOGumbl1KmDFM89CUuQVp8nHkD4p2m.', 78002012, '23232323-', NULL),
(3, 'luis25', 'luis23@gmail.com', '$2y$10$z/V8Vvg/WUqwr0KSYdTmGOJjctaMBHaPNIe1BYb0./T4p2WbTQodm', 78002012, '12345678-', NULL),
(4, 'aron', 'aron@gmail.com', '$2y$10$dnyI.TziwMLgq5xJdCyYUuE9E7bXSzgQwV0wbynmmqtwyg/Ydkn/y', 23456781, '12345564-', NULL),
(5, 'chele', 'chele@gmail.com', '$2y$10$9R.zn8shf.wdjChRaHitkeJ1Wp/2Eglir..1XFfFEAc2WrVig7uQS', 61040323, '12345678-', NULL),
(6, 'chelillo', 'chelillo@gmail.com', '$2y$10$7e7K8JmY/nKae6xPMdnkDuV88RivOgs61EPv.8Y/Wp.gNRcpkwVDq', 27654312, '12345678-', 'https://upload.wikimedia.org/wikipedia/commons/thumb/3/3d/Lionel_Messi_NE_Revolution_Inter_Miami_7.9.25-055.jpg/1200px-Lionel_Messi_NE_Revolution_Inter_Miami_7.9.25-055.jpg'),
(7, 'Gabo', 'gabo@gmail.com', '$2y$10$Zm5YkLjihjz.5.JCW8jQguIfcrpA73D2/r5ZzgA.pZ28oOu11Bv8y', 61040323, '12345678-', NULL),
(8, 'manux12', 'manux12@gmail.com', '$2y$10$/Y5Gp2X6sbbsZlP/oidSO.xbloqcBjeCioDN6mRcCsxSPmuy8Y4aq', 78002012, '12345678-', NULL),
(9, 'xaron', 'xaron@gmail.com', '$2y$10$Fde11ictttHITGz7PBZ7tuUnvbfwUODRym1k0Kq8exAYDJxXvv2lm', 27654321, '12345678-', NULL),
(10, 'angela', 'angela@gmail.com', '$2y$10$Tl4tM45rYNEK6OXLcu4K2.CIRVX.OyEtaqLumGVQg2LnBVu.CbrCy', 23335465, '12345678-', 'https://upload.wikimedia.org/wikipedia/commons/thumb/3/3d/Lionel_Messi_NE_Revolution_Inter_Miami_7.9.25-055.jpg/1200px-Lionel_Messi_NE_Revolution_Inter_Miami_7.9.25-055.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `respuestas_comentario`
--

DROP TABLE IF EXISTS `respuestas_comentario`;
CREATE TABLE IF NOT EXISTS `respuestas_comentario` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_comentario` int NOT NULL,
  `id_usuario` int DEFAULT NULL,
  `tipo_usuario` enum('profesor','alumno') NOT NULL,
  `respuesta` text NOT NULL,
  `fecha` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `id_comentario` (`id_comentario`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `respuestas_comentario`
--

INSERT INTO `respuestas_comentario` (`id`, `id_comentario`, `id_usuario`, `tipo_usuario`, `respuesta`, `fecha`) VALUES
(1, 1, 7, 'profesor', 'cual es pues negro', '2025-08-23 18:19:29'),
(2, 2, 7, 'profesor', 'vectooor', '2025-08-23 19:02:11'),
(3, 1, 7, 'alumno', 'nada nada, perdon', '2025-08-23 20:53:48');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rubricas`
--

DROP TABLE IF EXISTS `rubricas`;
CREATE TABLE IF NOT EXISTS `rubricas` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_tarea` int NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `descripcion` text,
  `criterios_json` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `rubricas`
--

INSERT INTO `rubricas` (`id`, `id_tarea`, `titulo`, `descripcion`, `criterios_json`) VALUES
(1, 14, 'papspas', 'asasassa', '[{\"nombre\":\"asaasa\",\"porcentaje\":50},{\"nombre\":\"22dege\",\"porcentaje\":50}]'),
(2, 15, 'wmeba', 'dsdsadd', '[{\"nombre\":\"123\",\"porcentaje\":50},{\"nombre\":\"145\",\"porcentaje\":50}]'),
(3, 16, 'papspas', 'fdsfsfs', '[{\"nombre\":\"123\",\"porcentaje\":50},{\"nombre\":\"321\",\"porcentaje\":50}]');

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
  `calificacion` int DEFAULT NULL,
  `retroalimentacion` text,
  `id_tarea_profesor` int DEFAULT NULL,
  `id_clase` int DEFAULT NULL,
  `fecha_limite` datetime NOT NULL,
  `estado_entrega` enum('abierta','cerrada') DEFAULT 'abierta',
  `calificacion_rubrica` text,
  PRIMARY KEY (`id`),
  KEY `id_estudiante` (`id_estudiante`)
) ENGINE=MyISAM AUTO_INCREMENT=77 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tareas`
--

INSERT INTO `tareas` (`id`, `id_estudiante`, `materia`, `nombre_archivo`, `ruta_archivo`, `fecha_subida`, `calificacion`, `retroalimentacion`, `id_tarea_profesor`, `id_clase`, `fecha_limite`, `estado_entrega`, `calificacion_rubrica`) VALUES
(1, 25, 'biologia', 'edusoft.sql', '../uploads/686c002905ae1_edusoft.sql', '2025-07-07 17:13:13', NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', 'abierta', NULL),
(2, 25, 'biologia', 'edusoft.sql', '../uploads/686c017da63cd_edusoft.sql', '2025-07-07 17:18:53', NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', 'abierta', NULL),
(3, 25, 'biologia', 'edusoft.sql', '../uploads/686c03a28efcf_edusoft.sql', '2025-07-07 17:28:02', NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', 'abierta', NULL),
(4, 25, 'biologia', 'edusoft.sql', '../uploads/686c03b36864c_edusoft.sql', '2025-07-07 17:28:19', NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', 'abierta', NULL),
(5, 29, 'biologia', 'Tipología de redes.pdf', '../uploads/687e4c09b9b18_Tipología de redes.pdf', '2025-07-21 14:17:45', NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', 'abierta', NULL),
(6, 25, 'biologia', 'chino.jpeg', '../uploads/6890398396576_chino.jpeg', '2025-08-04 04:39:31', NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', 'abierta', NULL),
(64, 31, 'biologia', 'mexico.png', 'tareas_subidas/biologia/1755721235_mexico.png', '2025-08-20 14:20:35', NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', 'abierta', NULL),
(55, 31, 'biologia', 'Captura de pantalla 2024-03-07 232752.png', 'tareas_subidas/biologia/1754362403_Captura_de_pantalla_2024_03_07_232752.png', '2025-08-04 20:53:23', NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', 'abierta', NULL),
(59, 31, 'biologia', 'Captura de pantalla 2023-10-05 002935.png', 'tareas_subidas/biologia/1754366767_Captura_de_pantalla_2023_10_05_002935.png', '2025-08-04 22:06:07', NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', 'abierta', NULL),
(63, 31, 'biologia', 'estados unidos.png', 'tareas_subidas/biologia/1754674815_estados_unidos.png', '2025-08-08 11:40:15', NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', 'abierta', NULL),
(66, 32, 'lenguaje', 'Captura de pantalla 2023-10-05 002935.png', 'tareas_subidas/lenguaje/1755919283_Captura_de_pantalla_2023_10_05_002935.png', '2025-08-22 21:21:23', NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', 'abierta', NULL),
(69, 31, 'lenguaje', NULL, NULL, '2025-08-22 23:14:51', NULL, NULL, 10, 7, '0000-00-00 00:00:00', 'abierta', NULL),
(70, 31, 'lenguaje', NULL, NULL, '2025-08-22 23:43:30', NULL, NULL, 11, 7, '0000-00-00 00:00:00', 'abierta', NULL),
(71, 31, 'lenguaje', NULL, NULL, '2025-08-23 00:22:19', 9, 'casi casi', 12, 7, '0000-00-00 00:00:00', 'abierta', NULL),
(72, 31, 'lenguaje', NULL, NULL, '2025-08-24 01:00:16', NULL, NULL, 8, 14, '0000-00-00 00:00:00', 'abierta', NULL),
(73, 30, 'lenguaje', NULL, NULL, '2025-08-24 18:18:24', 8, 'xd', 1, 8, '0000-00-00 00:00:00', 'abierta', NULL),
(74, 30, 'lenguaje', NULL, NULL, '2025-08-30 21:33:41', 4, '', 13, 8, '0000-00-00 00:00:00', 'abierta', NULL),
(75, 30, 'matematica', NULL, NULL, '2025-09-03 11:10:31', NULL, NULL, 13, 8, '0000-00-00 00:00:00', 'abierta', NULL),
(76, 30, 'matematica', NULL, NULL, '2025-09-03 19:22:09', 9, 'muy buen trabajo wemba', 16, 8, '0000-00-00 00:00:00', 'abierta', '[{\"nombre\":\"123\",\"porcentaje\":50,\"puntaje\":7.5},{\"nombre\":\"321\",\"porcentaje\":50,\"puntaje\":10}]');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tareas_archivos`
--

DROP TABLE IF EXISTS `tareas_archivos`;
CREATE TABLE IF NOT EXISTS `tareas_archivos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_tarea` int NOT NULL,
  `nombre_archivo` varchar(255) NOT NULL,
  `ruta_archivo` varchar(255) NOT NULL,
  `fecha_subida` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `id_tarea` (`id_tarea`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `tareas_archivos`
--

INSERT INTO `tareas_archivos` (`id`, `id_tarea`, `nombre_archivo`, `ruta_archivo`, `fecha_subida`) VALUES
(8, 69, 'Captura de pantalla 2023-12-16 100847.png', '../uploads/68a9521bab08b_Captura de pantalla 2023-12-16 100847.png', '2025-08-22 23:31:07'),
(12, 70, 'Captura de pantalla 2024-03-07 232752.png', '../uploads/68a95502cc469_Captura de pantalla 2024-03-07 232752.png', '2025-08-22 23:43:30'),
(14, 71, 'aron.png', '../uploads/68a960688db20_aron.png', '2025-08-23 00:32:08'),
(17, 73, 'crear_curso.php', '../uploads/68b3aba95bbbf_crear_curso.php', '2025-08-30 19:55:53'),
(18, 74, 'debate.php', '../uploads/68b3c295280cb_debate.php', '2025-08-30 21:33:41'),
(19, 75, 'deportes.php', '../uploads/68b87687e9531_deportes.php', '2025-09-03 11:10:31'),
(20, 76, 'eliminar_tarea.php', '../uploads/68b8e9c1e65e6_eliminar_tarea.php', '2025-09-03 19:22:09');

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
  `fecha_limite` datetime NOT NULL,
  `tema` varchar(100) DEFAULT NULL,
  `estado_entrega` varchar(20) NOT NULL DEFAULT 'abierta',
  `categoria_tarea` varchar(32) DEFAULT 'normal',
  `puntos` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `clase_id` (`id_clase`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tareas_profesor`
--

INSERT INTO `tareas_profesor` (`id`, `id_clase`, `titulo`, `descripcion`, `archivo_adjunto`, `fecha_creacion`, `fecha_limite`, `tema`, `estado_entrega`, `categoria_tarea`, `puntos`) VALUES
(2, 9, 'Sayonara ', 'Alvarito dias, ALBUM SAYONARA', NULL, '2025-08-08 01:52:37', '0000-00-00 00:00:00', 'Alvaro', 'abierta', 'normal', NULL),
(3, 10, 'Quien te quiere como el nene', 'Nadie te quiere como el nene wemba', '../archivos_tareas/1754641788_edusoft.sql', '2025-08-08 02:29:48', '0000-00-00 00:00:00', 'Alvaro', 'abierta', 'normal', NULL),
(4, 12, 'VECTOR', 'hola soy vicotr', '../archivos_tareas/1754660984_estados unidos.png', '2025-08-08 07:49:44', '0000-00-00 00:00:00', 'chisto', 'abierta', 'normal', NULL),
(5, 12, 'VECTOR', 'hola soy vicotr', '../archivos_tareas/1754661061_estados unidos.png', '2025-08-08 07:51:01', '0000-00-00 00:00:00', 'chisto', 'abierta', 'normal', NULL),
(6, 12, 'VECTOR11', 'vectorillo', '../archivos_tareas/1754662683_estados unidos.png', '2025-08-08 08:18:03', '0000-00-00 00:00:00', 'Tarea de vectors', 'abierta', 'normal', NULL),
(7, 13, 'VECTOR222', 'calse de vector', '../archivos_tareas/1754662887_estados unidos.png', '2025-08-08 08:21:27', '0000-00-00 00:00:00', 'Tarea de vectors222', 'abierta', 'normal', NULL),
(8, 14, 'VECTOR', 'clases', '../archivos_tareas/1754674950_estados unidos.png', '2025-08-08 11:42:30', '0000-00-00 00:00:00', 'Tarea', 'abierta', 'normal', NULL),
(9, 15, 'putyxo', 'putyxo 1223', '../archivos_tareas/1755720628_mexico.png', '2025-08-20 14:10:28', '0000-00-00 00:00:00', 'homwerok biology', 'abierta', 'normal', NULL),
(10, 7, 'Obra', 'Leer obra para luego una dramatizacion', '../archivos_tareas/1755918703_Captura de pantalla 2024-03-10 153722.png', '2025-08-22 21:11:43', '0000-00-00 00:00:00', 'actividad aula', 'abierta', 'normal', NULL),
(11, 7, 'Obra 2', 'Leer obra', '../archivos_tareas/1755927771_Captura de pantalla 2024-08-28 231957.png', '2025-08-22 23:42:51', '0000-00-00 00:00:00', 'actividad', 'abierta', 'normal', NULL),
(12, 7, 'Obra 3', 'realizar resumen de obra', NULL, '2025-08-23 00:17:53', '0000-00-00 00:00:00', 'actividad', 'abierta', 'normal', NULL),
(16, 8, 'Ejercicios de trigonometria', 'qwerqrt', NULL, '2025-09-03 18:59:41', '2025-09-18 22:02:00', 'wembaa', 'abierta', 'normal', NULL);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
