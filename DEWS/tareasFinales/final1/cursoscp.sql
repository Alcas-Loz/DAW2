-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 08-02-2026 a las 14:52:28
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
-- Base de datos: `cursoscp`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `administradores`
--

CREATE TABLE `administradores` (
  `usuario` varchar(30) NOT NULL,
  `contraseña` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `administradores`
--

INSERT INTO `administradores` (`usuario`, `contraseña`) VALUES
('admin', '1234');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cursos`
--

CREATE TABLE `cursos` (
  `codigo` smallint(6) NOT NULL DEFAULT 0,
  `nombre` varchar(50) NOT NULL DEFAULT '',
  `abierto` tinyint(1) NOT NULL DEFAULT 1,
  `numeroplazas` smallint(2) NOT NULL DEFAULT 20,
  `plazoinscripcion` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `cursos`
--

INSERT INTO `cursos` (`codigo`, `nombre`, `abierto`, `numeroplazas`, `plazoinscripcion`) VALUES
(1, 'Instalacion y uso de Apache', 1, 20, '2015-05-20'),
(2, 'Administracion avanzada de Apache', 1, 30, '2015-05-20'),
(3, 'Elaboracion de recursos didacticos', 1, 20, '2015-05-20'),
(4, 'Uso didactico de Moodle en primaria', 1, 10, '2015-05-20'),
(5, 'Uso didactico de Moodle en secundaria', 0, 20, '2015-01-20'),
(6, 'Moodle y el aula de musica', 1, 20, '2015-05-25'),
(7, 'Tratamiento de imagenes', 1, 20, '2015-02-20');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `solicitantes`
--

CREATE TABLE `solicitantes` (
  `dni` varchar(9) NOT NULL DEFAULT '',
  `apellidos` varchar(40) NOT NULL DEFAULT '',
  `nombre` varchar(20) NOT NULL DEFAULT '',
  `telefono` varchar(12) NOT NULL DEFAULT '',
  `correo` varchar(50) NOT NULL DEFAULT '',
  `codcen` varchar(8) NOT NULL DEFAULT '',
  `coordinadortic` tinyint(1) NOT NULL DEFAULT 0,
  `grupotic` tinyint(1) NOT NULL DEFAULT 0,
  `nomgrupo` varchar(25) NOT NULL DEFAULT '',
  `pbilin` tinyint(1) NOT NULL DEFAULT 0,
  `cargo` tinyint(1) NOT NULL DEFAULT 0,
  `nombrecargo` varchar(15) NOT NULL DEFAULT '',
  `situacion` enum('activo','inactivo') NOT NULL DEFAULT 'activo',
  `fechanac` date DEFAULT NULL,
  `especialidad` varchar(50) NOT NULL DEFAULT '',
  `puntos` tinyint(3) UNSIGNED DEFAULT 0,
  `contrasena` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `solicitantes`
--

INSERT INTO `solicitantes` (`dni`, `apellidos`, `nombre`, `telefono`, `correo`, `codcen`, `coordinadortic`, `grupotic`, `nomgrupo`, `pbilin`, `cargo`, `nombrecargo`, `situacion`, `fechanac`, `especialidad`, `puntos`, `contrasena`) VALUES
('81819271A', 'Casero', 'Alberto', '816212171868', 'luciavega@scarlati.es', '1212', 0, 1, 'Bro2', 1, 0, 'Jefe de Estudio', 'activo', '2026-02-26', 'sjaush', 9, '1234');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `solicitudes`
--

CREATE TABLE `solicitudes` (
  `dni` varchar(9) NOT NULL DEFAULT '',
  `codigocurso` smallint(6) NOT NULL DEFAULT 0,
  `fechasolicitud` date NOT NULL,
  `admitido` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `solicitudes`
--

INSERT INTO `solicitudes` (`dni`, `codigocurso`, `fechasolicitud`, `admitido`) VALUES
('81819271A', 7, '2026-02-08', 0);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `cursos`
--
ALTER TABLE `cursos`
  ADD PRIMARY KEY (`codigo`);

--
-- Indices de la tabla `solicitantes`
--
ALTER TABLE `solicitantes`
  ADD PRIMARY KEY (`dni`);

--
-- Indices de la tabla `solicitudes`
--
ALTER TABLE `solicitudes`
  ADD PRIMARY KEY (`dni`,`codigocurso`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
