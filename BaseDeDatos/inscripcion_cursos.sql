-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3307
-- Tiempo de generación: 01-12-2024 a las 05:42:39
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
-- Base de datos: `inscripcion_cursos`
--
-- CREATE DATABASE inscripcion_cursos;
-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alumnos`
--

CREATE TABLE `alumnos` (
  `id_alumnos` int(11) NOT NULL,
  `nombre_alumno` varchar(100) NOT NULL,
  `cedula` varchar(20) NOT NULL,
  `edad` int(11) DEFAULT NULL,
  `direccion` varchar(1000) DEFAULT NULL,
  `correo` varchar(100) NOT NULL,
  `telefono` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `alumnos`
--

INSERT INTO `alumnos` (`id_alumnos`, `nombre_alumno`, `cedula`, `edad`, `direccion`, `correo`, `telefono`) VALUES
(1, 'David Jefferson Yanqui Condor', '1722497649', 29, 'Cutuglagua', 'jrdaved@gmail.com', '0983583176');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `curso`
--

CREATE TABLE `curso` (
  `id_curso` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `descripcion` varchar(2000) NOT NULL,
  `fecha_inicio` date NOT NULL,
  `fecha_fin` date NOT NULL,
  `profesor_id_profesor` int(11) NOT NULL,
  `alumnos_id_alumnos` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `curso`
--

INSERT INTO `curso` (`id_curso`, `nombre`, `descripcion`, `fecha_inicio`, `fecha_fin`, `profesor_id_profesor`, `alumnos_id_alumnos`) VALUES
(1, 'Programación', 'Este curso te enseñara a desarrollar aplicaciones web.', '2024-11-30', '2024-12-30', 1, 1),
(3, 'Desarrollo web', 'Es un proceso de creación de un sitio web, una aplicación o un software.', '2024-12-06', '2024-12-26', 1, 1),
(10, 'PHP curso web', 'PHP es un lenguaje de programación para desarrollar aplicaciones y crear sitios web que conquista cada día más seguidores.', '2024-11-30', '2024-12-14', 1, 1),
(11, 'Programación en JAVA Scrip', 'Es un lenguaje de programación que los desarrolladores utilizan para hacer páginas web interactivas, curso web.', '2024-12-11', '2024-12-25', 1, 1),
(12, 'Mantenimiento de Software', 'Te enseñaremos a realizar mantenimientos correctivos y preventivos.', '2024-11-30', '2024-12-14', 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_curso`
--

CREATE TABLE `detalle_curso` (
  `id_detalle` int(11) NOT NULL,
  `tipo_detalle` int(11) DEFAULT NULL,
  `descripcion` varchar(100) DEFAULT NULL,
  `fecha_creacion` date DEFAULT NULL,
  `curso_id_curso` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `detalle_curso`
--

INSERT INTO `detalle_curso` (`id_detalle`, `tipo_detalle`, `descripcion`, `fecha_creacion`, `curso_id_curso`) VALUES
(1, 1, 'Este curso nos ayuda a experimentar el mundo de la programacion en el estado web, que utilizan hoy e', '2024-11-30', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inscripcion`
--

CREATE TABLE `inscripcion` (
  `id_inscripcion` int(11) NOT NULL,
  `fecha_inscripcion` date DEFAULT NULL,
  `estado` int(11) DEFAULT NULL,
  `id_alumnos` int(11) NOT NULL,
  `id_curso` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `inscripcion`
--

INSERT INTO `inscripcion` (`id_inscripcion`, `fecha_inscripcion`, `estado`, `id_alumnos`, `id_curso`) VALUES
(1, '2024-11-30', 1, 1, 1),
(2, '2024-12-01', 1, 1, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `profesor`
--

CREATE TABLE `profesor` (
  `id_profesor` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `direccion` varchar(1000) DEFAULT NULL,
  `cedula` varchar(10) NOT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `correo` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `profesor`
--

INSERT INTO `profesor` (`id_profesor`, `nombre`, `direccion`, `cedula`, `telefono`, `correo`) VALUES
(1, 'Jose David Yanqui Oña', 'Santa Maria de Cutuglagua', '1722497649', '0997094556', 'jose@gmail.com');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roll`
--

CREATE TABLE `roll` (
  `id_roll` int(11) NOT NULL,
  `nombre_rol` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `roll`
--

INSERT INTO `roll` (`id_roll`, `nombre_rol`) VALUES
(1, 'Estudiante'),
(2, 'Profesor');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `Id_usuario` int(11) NOT NULL,
  `nombres` varchar(50) NOT NULL,
  `apellidos` varchar(50) NOT NULL,
  `username` varchar(100) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `id_roll` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`Id_usuario`, `nombres`, `apellidos`, `username`, `password`, `id_roll`) VALUES
(1, 'David', 'Yanqui', 'dyanqui1', '123', 1),
(3, 'Jose', 'Yanqui', 'Jyanqui1', '1234', 2);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `alumnos`
--
ALTER TABLE `alumnos`
  ADD PRIMARY KEY (`id_alumnos`),
  ADD UNIQUE KEY `id_alumnos_UNIQUE` (`id_alumnos`),
  ADD UNIQUE KEY `cedula_UNIQUE` (`cedula`),
  ADD UNIQUE KEY `correo_UNIQUE` (`correo`);

--
-- Indices de la tabla `curso`
--
ALTER TABLE `curso`
  ADD PRIMARY KEY (`id_curso`),
  ADD UNIQUE KEY `id_curso_UNIQUE` (`id_curso`),
  ADD KEY `fk_curso_profesor1_idx` (`profesor_id_profesor`),
  ADD KEY `fk_curso_alumnos1_idx` (`alumnos_id_alumnos`);

--
-- Indices de la tabla `detalle_curso`
--
ALTER TABLE `detalle_curso`
  ADD PRIMARY KEY (`id_detalle`),
  ADD UNIQUE KEY `id_detalle_UNIQUE` (`id_detalle`),
  ADD KEY `fk_detalle_curso_curso1_idx` (`curso_id_curso`);

--
-- Indices de la tabla `inscripcion`
--
ALTER TABLE `inscripcion`
  ADD PRIMARY KEY (`id_inscripcion`),
  ADD UNIQUE KEY `id_inscripcion_UNIQUE` (`id_inscripcion`),
  ADD KEY `fk_inscripcion_alumnos1_idx` (`id_alumnos`),
  ADD KEY `fk_inscripcion_curso1_idx` (`id_curso`);

--
-- Indices de la tabla `profesor`
--
ALTER TABLE `profesor`
  ADD PRIMARY KEY (`id_profesor`),
  ADD UNIQUE KEY `id_profesor_UNIQUE` (`id_profesor`),
  ADD UNIQUE KEY `cedula_UNIQUE` (`cedula`),
  ADD UNIQUE KEY `correo_UNIQUE` (`correo`);

--
-- Indices de la tabla `roll`
--
ALTER TABLE `roll`
  ADD PRIMARY KEY (`id_roll`),
  ADD UNIQUE KEY `id_roll_UNIQUE` (`id_roll`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`Id_usuario`),
  ADD UNIQUE KEY `Id_usuario_UNIQUE` (`Id_usuario`),
  ADD UNIQUE KEY `usuario_UNIQUE` (`username`),
  ADD UNIQUE KEY `contrasena_UNIQUE` (`password`),
  ADD KEY `fk_usuario_roll_idx` (`id_roll`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `alumnos`
--
ALTER TABLE `alumnos`
  MODIFY `id_alumnos` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `curso`
--
ALTER TABLE `curso`
  MODIFY `id_curso` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `detalle_curso`
--
ALTER TABLE `detalle_curso`
  MODIFY `id_detalle` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `inscripcion`
--
ALTER TABLE `inscripcion`
  MODIFY `id_inscripcion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `profesor`
--
ALTER TABLE `profesor`
  MODIFY `id_profesor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `roll`
--
ALTER TABLE `roll`
  MODIFY `id_roll` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `Id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `curso`
--
ALTER TABLE `curso`
  ADD CONSTRAINT `fk_curso_alumnos1` FOREIGN KEY (`alumnos_id_alumnos`) REFERENCES `alumnos` (`id_alumnos`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_curso_profesor1` FOREIGN KEY (`profesor_id_profesor`) REFERENCES `profesor` (`id_profesor`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `detalle_curso`
--
ALTER TABLE `detalle_curso`
  ADD CONSTRAINT `fk_detalle_curso_curso1` FOREIGN KEY (`curso_id_curso`) REFERENCES `curso` (`id_curso`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `inscripcion`
--
ALTER TABLE `inscripcion`
  ADD CONSTRAINT `fk_inscripcion_alumnos1` FOREIGN KEY (`id_alumnos`) REFERENCES `alumnos` (`id_alumnos`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_inscripcion_curso1` FOREIGN KEY (`id_curso`) REFERENCES `curso` (`id_curso`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `fk_usuario_roll` FOREIGN KEY (`id_roll`) REFERENCES `roll` (`id_roll`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
