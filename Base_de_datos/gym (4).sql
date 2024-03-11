-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 18-02-2024 a las 22:14:09
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `gym`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `acceso`
--

CREATE TABLE `acceso` (
  `id_acceso` int(11) NOT NULL,
  `cliente_acceso` int(11) NOT NULL,
  `fecha_acceso` datetime NOT NULL,
  `ubicacion_acceso` varchar(255) NOT NULL,
  `admin_acceso` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `acceso`
--

INSERT INTO `acceso` (`id_acceso`, `cliente_acceso`, `fecha_acceso`, `ubicacion_acceso`, `admin_acceso`) VALUES
(1, 43576063, '2023-12-06 00:00:00', '3 de febrero', 1),
(2, 43576063, '2023-12-06 00:00:00', '3 de febrero', 1),
(3, 43576063, '2023-12-06 23:49:00', '3 de febrero', 1),
(4, 43576063, '2023-12-06 23:49:04', '3 de febrero', 1),
(5, 43576063, '2023-12-06 23:49:41', '3 de febrero', 1),
(6, 43576063, '2023-12-06 23:49:46', '3 de febrero', 1),
(7, 43576063, '2023-12-06 23:49:49', '3 de febrero', 1),
(8, 43576063, '2023-12-06 23:49:58', '3 de febrero', 1),
(9, 43576063, '2023-12-06 23:51:19', '3 de febrero', 1),
(10, 43576063, '2023-12-07 01:22:00', '3 de febrero', 1),
(11, 43576063, '2023-12-07 01:44:21', '3 de febrero', 1),
(12, 12345671, '2023-12-07 01:44:49', '3 de febrero', 1),
(13, 12345671, '2023-12-07 02:25:04', '3 de febrero', 1),
(14, 12345671, '2023-12-07 03:32:19', '3 de febrero', 1),
(15, 12345671, '2023-12-07 03:33:37', '3 de febrero', 1),
(16, 12345671, '2023-12-07 03:38:24', '3 de febrero', 1),
(17, 12345671, '2023-12-07 03:40:43', '3 de febrero', 1),
(18, 12345671, '2023-12-07 04:41:01', '3 de febrero', 1),
(19, 12345671, '2023-12-07 04:42:16', '3 de febrero', 1),
(20, 12345671, '2023-12-07 04:42:35', '3 de febrero', 1),
(21, 12345671, '2023-12-07 05:11:12', '3 de febrero', 1),
(22, 43576063, '2023-12-07 05:22:41', '3 de febrero', 1),
(23, 43576063, '2023-12-07 05:24:44', '3 de febrero', 1),
(27, 43576063, '2023-12-07 05:52:21', '3 de febrero', 1),
(28, 43576063, '2023-12-07 05:52:25', '3 de febrero', 1),
(29, 43576063, '2023-12-07 05:52:29', '3 de febrero', 1),
(30, 43576063, '2023-12-07 05:52:33', '3 de febrero', 1),
(31, 43576063, '2023-12-07 06:16:11', '3 de febrero', 1),
(32, 43576063, '2023-12-07 06:16:38', '3 de febrero', 1),
(33, 43576063, '2023-12-07 06:19:39', '3 de febrero', 1),
(34, 43576063, '2023-12-07 06:19:49', '3 de febrero', 1),
(35, 43576063, '2023-12-07 06:32:13', '3 de febrero', 1),
(36, 43576063, '2023-12-07 06:34:19', '3 de febrero', 1),
(37, 43576063, '2023-12-07 06:38:50', '3 de febrero', 1),
(38, 43576063, '2023-12-07 06:42:37', '3 de febrero', 1),
(39, 43576063, '2023-12-07 06:48:48', '3 de febrero', 1),
(40, 43576063, '2023-12-07 06:59:37', '3 de febrero', 1),
(41, 43576063, '2023-12-07 07:00:38', '3 de febrero', 1),
(42, 43576063, '2023-12-07 07:01:54', '3 de febrero', 1),
(43, 43576063, '2023-12-07 07:01:58', '3 de febrero', 1),
(44, 43576063, '2023-12-07 07:03:51', '3 de febrero', 1),
(45, 43576063, '2023-12-07 07:04:48', '3 de febrero', 1),
(46, 43576063, '2023-12-07 19:39:18', '3 de febrero', 1),
(47, 43576063, '2023-12-07 19:44:36', '3 de febrero', 1),
(48, 43576063, '2023-12-07 19:46:06', '3 de febrero', 1),
(49, 43576063, '2023-12-07 20:18:28', '3 de febrero', 1),
(50, 43576063, '2023-12-07 20:18:51', '3 de febrero', 1),
(51, 43576063, '2023-12-13 16:23:00', '3 de febrero 2333', 1),
(52, 43576063, '2023-12-14 06:31:48', '3 de febrero 2333', 1),
(53, 12345555, '2023-12-15 05:16:27', 'Yrigoyen 1234', 7),
(54, 12345555, '2023-12-15 05:19:47', 'Yrigoyen 1234', 7),
(55, 12345671, '2024-02-14 22:33:27', '3 de febrero 2333', 1),
(56, 43576064, '2024-02-14 22:43:05', '3 de febrero 2333', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `administrador`
--

CREATE TABLE `administrador` (
  `cod_admin` int(11) NOT NULL,
  `nombre_u` varchar(255) NOT NULL,
  `nombre_admin` varchar(255) NOT NULL,
  `apellido_admin` varchar(255) NOT NULL,
  `email_admin` text NOT NULL,
  `direccion_admin` text NOT NULL,
  `num_admin` int(11) NOT NULL,
  `gym_admin` int(11) NOT NULL,
  `dni_admin` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `administrador`
--

INSERT INTO `administrador` (`cod_admin`, `nombre_u`, `nombre_admin`, `apellido_admin`, `email_admin`, `direccion_admin`, `num_admin`, `gym_admin`, `dni_admin`) VALUES
(1, 'Ignacio', 'Ignacio', 'Vendrell', 'nachove24@gmail.com', '3 de febrero', 9, 4, 0),
(4, 'ivan1805', 'Ivan', 'De Leon', 'ivanponce1805@gmail.com', '3 de febrero', 965878, 5, 12345678),
(7, 'profe', 'Silver', 'Guzman', 'nachove24@gmail.com', '3 de febrero 2333', 364787989, 7, 34656768),
(9, 'ignacio_03', 'Ignacio', 'Perez', 'ivanponce1805@gmail.com', 'Yrigoyen 1234', 679800, 8, 46879909);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clase`
--

CREATE TABLE `clase` (
  `id_clase` int(11) NOT NULL,
  `nombre_clase` varchar(255) NOT NULL,
  `descripcion_clase` varchar(255) NOT NULL DEFAULT 'Sin Informción',
  `cant_alumnos` int(11) NOT NULL DEFAULT 0,
  `duracion_clase` varchar(255) NOT NULL,
  `instructor_clase` varchar(255) NOT NULL DEFAULT 'Sin Información',
  `gym_clase` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `clase`
--

INSERT INTO `clase` (`id_clase`, `nombre_clase`, `descripcion_clase`, `cant_alumnos`, `duracion_clase`, `instructor_clase`, `gym_clase`) VALUES
(0, 'Ninguna', 'Sin Informción', 0, '0', 'Sin Información', 1),
(1, 'Crossfit', 'Martes y Jueves a las 15hs', 2, '1hs', 'Profe Pedro', 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente`
--

CREATE TABLE `cliente` (
  `dni` int(11) NOT NULL,
  `nombre_c` varchar(255) NOT NULL,
  `apellido_c` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `genero` varchar(255) NOT NULL,
  `direccion` varchar(255) NOT NULL,
  `telefono` int(25) NOT NULL,
  `nacimiento` date NOT NULL,
  `peso` int(11) NOT NULL DEFAULT 0,
  `altura` int(11) NOT NULL DEFAULT 0,
  `gym_cliente` int(11) NOT NULL,
  `clase_cliente` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `cliente`
--

INSERT INTO `cliente` (`dni`, `nombre_c`, `apellido_c`, `email`, `genero`, `direccion`, `telefono`, `nacimiento`, `peso`, `altura`, `gym_cliente`, `clase_cliente`) VALUES
(12345555, 'Pedro', 'Mujica', 'nachove24@gmail.com', 'Masculino', 'San Martin 4535', 54789780, '1988-09-09', 0, 0, 7, 0),
(12345671, 'María', 'Suarez Hernández', 'nachove24@gmail.com', 'Femenino', 'San Martin 4535', 2908534, '2023-11-06', 59, 167, 4, 0),
(43576063, 'Ignacio', 'Sanchez', 'nachove24@gmail.com', 'Masculino', '3 de febrero', 9865755, '2023-11-14', 80, 187, 4, 0),
(43576064, 'Ignacio', 'Vendrell', 'nachove24@gmail.com', 'Masculino', 'San Martin 4535', 9865755, '2023-11-25', 75, 191, 4, 0),
(46767577, 'Mario', 'Lopez', 'ivanponce1805@gmail.com', 'Masculino', 'San Martin 4535', 9865755, '2000-09-01', 0, 0, 4, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cursado`
--

CREATE TABLE `cursado` (
  `id_cursado` int(11) NOT NULL,
  `clase_cursado` int(11) NOT NULL,
  `cliente_cursado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `duracion`
--

CREATE TABLE `duracion` (
  `id_duracion` int(11) NOT NULL,
  `nombre_duracion` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `duracion`
--

INSERT INTO `duracion` (`id_duracion`, `nombre_duracion`) VALUES
(1, 'Semana'),
(2, 'Quincena'),
(3, 'Mes'),
(4, 'Año'),
(5, 'Trimestre'),
(6, 'Semestre'),
(9, 'Día'),
(10, 'Al Contado'),
(11, 'Semanal'),
(12, 'Mensual');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estado`
--

CREATE TABLE `estado` (
  `id_estado` int(11) NOT NULL,
  `nombre_estado` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `estado`
--

INSERT INTO `estado` (`id_estado`, `nombre_estado`) VALUES
(1, 'Expirada'),
(2, 'Activa'),
(3, 'Inactiva'),
(4, 'Cancelada');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estado_membresia`
--

CREATE TABLE `estado_membresia` (
  `id_estado` int(11) NOT NULL,
  `membresia_estado` int(11) NOT NULL,
  `nombre_estado` int(11) NOT NULL DEFAULT 3,
  `fecha_alta` date NOT NULL,
  `fecha_baja` date NOT NULL,
  `tipo_pago` varchar(255) NOT NULL,
  `abonado` int(11) NOT NULL DEFAULT 0,
  `cliente_estado` int(11) NOT NULL,
  `precio_estado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `estado_membresia`
--

INSERT INTO `estado_membresia` (`id_estado`, `membresia_estado`, `nombre_estado`, `fecha_alta`, `fecha_baja`, `tipo_pago`, `abonado`, `cliente_estado`, `precio_estado`) VALUES
(7, 16, 2, '2024-02-14', '2024-03-14', '10', 2000, 12345671, 2000),
(8, 9, 2, '2024-02-16', '2024-02-17', '10', 500, 43576064, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gimnasio`
--

CREATE TABLE `gimnasio` (
  `cod_gym` int(11) NOT NULL,
  `nombre_gym` varchar(255) NOT NULL,
  `contrasena_gym` varchar(255) NOT NULL,
  `email_gym` varchar(255) NOT NULL,
  `direccion_gym` varchar(255) NOT NULL,
  `imagen_gym` varchar(1000) NOT NULL,
  `num_gym` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `gimnasio`
--

INSERT INTO `gimnasio` (`cod_gym`, `nombre_gym`, `contrasena_gym`, `email_gym`, `direccion_gym`, `imagen_gym`, `num_gym`) VALUES
(1, 'Gimnasio Hercules', '123', 'nachove24@gmail.com', '3 de febrero', 'img-u/6556f56e762d0_logo-gimnasio-prueba.jpg', 21453463),
(2, 'Ignacio', '1234', 'nachove24@gmail.com', '3 de febrero', 'img-u/65584025615bf_logo-gimnasio-prueba.jpg', 9),
(3, 'Gym', '123', 'nachove24@gmail.com', '3 de febrero', 'img-u/6559006e98b1e_logo-gimnasio-prueba.jpg', 1344),
(4, 'Gym2', '123', 'nachove24@gmail.com', '3 de febrero 2333', 'img-u/6579013d5f971_Captura de pantalla 2023-11-25 154153.png', 349067356),
(5, 'ivan_gym', '123', 'ivanponce1805@gmail.com', '3 de febrero', 'img-u/655e6b05db1ce_logo-gimnasio-prueba.jpg', 125465),
(7, 'FitGym', '123', 'nachove24@gmail.com', 'Yrigoyen 1234', 'img-u/657bcfb488efc_Captura de pantalla 2023-11-25 154153.png', 2464799),
(8, 'gym3', '12345678', 'nachove24@gmail.com', 'San Martin 4535', 'img-u/65cfd7f875e35_eric-cartman.png', 44377586);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `membresia`
--

CREATE TABLE `membresia` (
  `id_membresia` int(11) NOT NULL,
  `nombre_membresia` varchar(255) NOT NULL,
  `duracion_membresia` int(11) NOT NULL,
  `precio_membresia` int(11) NOT NULL,
  `servicio_membresia` varchar(2300) NOT NULL DEFAULT 'Sin Información',
  `politica_membresia` varchar(2300) NOT NULL DEFAULT 'Sin Información',
  `color_membresia` varchar(255) NOT NULL DEFAULT 'white',
  `gym_membresia` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `membresia`
--

INSERT INTO `membresia` (`id_membresia`, `nombre_membresia`, `duracion_membresia`, `precio_membresia`, `servicio_membresia`, `politica_membresia`, `color_membresia`, `gym_membresia`) VALUES
(9, 'Un día', 9, 0, 'Valido para actividades que se hagan en el día.', 'Sin Información.', 'white', 0),
(16, 'Pase Libre', 3, 2000, '', '', 'red', 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `recuperar`
--

CREATE TABLE `recuperar` (
  `id_solicitud` int(11) NOT NULL,
  `fecha_solicitud` datetime NOT NULL,
  `cambio_contrasena` tinyint(1) NOT NULL,
  `admin_solicitud` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `recuperar`
--

INSERT INTO `recuperar` (`id_solicitud`, `fecha_solicitud`, `cambio_contrasena`, `admin_solicitud`) VALUES
(1, '2023-11-22 21:48:11', 1, 1),
(2, '2023-11-22 22:01:33', 0, 4),
(3, '2023-11-22 23:02:33', 1, 1),
(4, '2023-11-22 23:19:42', 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `registro`
--

CREATE TABLE `registro` (
  `id_registro` int(11) NOT NULL,
  `cliente_registro` int(11) NOT NULL,
  `admin_registro` int(11) DEFAULT NULL,
  `gym_registro` int(11) NOT NULL,
  `fecha_registro` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `registro`
--

INSERT INTO `registro` (`id_registro`, `cliente_registro`, `admin_registro`, `gym_registro`, `fecha_registro`) VALUES
(2, 43576063, 1, 4, '2023-11-24 19:57:05'),
(4, 12345671, 1, 4, '2023-11-25 20:23:32'),
(5, 43576064, 1, 4, '2023-11-25 20:25:03'),
(6, 12345555, 7, 7, '2023-12-15 05:15:27'),
(7, 46767577, NULL, 4, '2024-02-16 21:47:43');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `acceso`
--
ALTER TABLE `acceso`
  ADD PRIMARY KEY (`id_acceso`),
  ADD KEY `fkcliente_acceso` (`cliente_acceso`),
  ADD KEY `fkadmin_acceso` (`admin_acceso`);

--
-- Indices de la tabla `administrador`
--
ALTER TABLE `administrador`
  ADD PRIMARY KEY (`cod_admin`),
  ADD KEY `fkgym_admin` (`gym_admin`);

--
-- Indices de la tabla `clase`
--
ALTER TABLE `clase`
  ADD PRIMARY KEY (`id_clase`),
  ADD KEY `fkgym_clase` (`gym_clase`);

--
-- Indices de la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`dni`),
  ADD KEY `fkgym_cliente` (`gym_cliente`),
  ADD KEY `fkclase_cliente` (`clase_cliente`);

--
-- Indices de la tabla `cursado`
--
ALTER TABLE `cursado`
  ADD KEY `fkclase_cursado` (`clase_cursado`),
  ADD KEY `fkcliente_cursado` (`cliente_cursado`);

--
-- Indices de la tabla `duracion`
--
ALTER TABLE `duracion`
  ADD PRIMARY KEY (`id_duracion`);

--
-- Indices de la tabla `estado`
--
ALTER TABLE `estado`
  ADD PRIMARY KEY (`id_estado`);

--
-- Indices de la tabla `estado_membresia`
--
ALTER TABLE `estado_membresia`
  ADD PRIMARY KEY (`id_estado`),
  ADD KEY `fkestado_membresia` (`membresia_estado`),
  ADD KEY `fkcliente_estado` (`cliente_estado`),
  ADD KEY `fkprecio_estado` (`precio_estado`),
  ADD KEY `fkestados` (`nombre_estado`);

--
-- Indices de la tabla `gimnasio`
--
ALTER TABLE `gimnasio`
  ADD PRIMARY KEY (`cod_gym`);

--
-- Indices de la tabla `membresia`
--
ALTER TABLE `membresia`
  ADD PRIMARY KEY (`id_membresia`),
  ADD KEY `fkduracion_membresia` (`duracion_membresia`),
  ADD KEY `fkgym_membresia` (`gym_membresia`);

--
-- Indices de la tabla `recuperar`
--
ALTER TABLE `recuperar`
  ADD PRIMARY KEY (`id_solicitud`),
  ADD KEY `fkadmin_solicitud` (`admin_solicitud`);

--
-- Indices de la tabla `registro`
--
ALTER TABLE `registro`
  ADD PRIMARY KEY (`id_registro`),
  ADD KEY `fkcliente_registro` (`cliente_registro`),
  ADD KEY `fkadmin_registro` (`admin_registro`),
  ADD KEY `fkgym_registro` (`gym_registro`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `acceso`
--
ALTER TABLE `acceso`
  MODIFY `id_acceso` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT de la tabla `administrador`
--
ALTER TABLE `administrador`
  MODIFY `cod_admin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `clase`
--
ALTER TABLE `clase`
  MODIFY `id_clase` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `duracion`
--
ALTER TABLE `duracion`
  MODIFY `id_duracion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `estado`
--
ALTER TABLE `estado`
  MODIFY `id_estado` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `estado_membresia`
--
ALTER TABLE `estado_membresia`
  MODIFY `id_estado` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `gimnasio`
--
ALTER TABLE `gimnasio`
  MODIFY `cod_gym` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `membresia`
--
ALTER TABLE `membresia`
  MODIFY `id_membresia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `recuperar`
--
ALTER TABLE `recuperar`
  MODIFY `id_solicitud` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `registro`
--
ALTER TABLE `registro`
  MODIFY `id_registro` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `acceso`
--
ALTER TABLE `acceso`
  ADD CONSTRAINT `acceso_ibfk_2` FOREIGN KEY (`admin_acceso`) REFERENCES `administrador` (`cod_admin`),
  ADD CONSTRAINT `acceso_ibfk_3` FOREIGN KEY (`cliente_acceso`) REFERENCES `cliente` (`dni`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `administrador`
--
ALTER TABLE `administrador`
  ADD CONSTRAINT `administrador_ibfk_1` FOREIGN KEY (`gym_admin`) REFERENCES `gimnasio` (`cod_gym`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `clase`
--
ALTER TABLE `clase`
  ADD CONSTRAINT `clase_ibfk_1` FOREIGN KEY (`gym_clase`) REFERENCES `gimnasio` (`cod_gym`);

--
-- Filtros para la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD CONSTRAINT `cliente_ibfk_1` FOREIGN KEY (`gym_cliente`) REFERENCES `gimnasio` (`cod_gym`),
  ADD CONSTRAINT `cliente_ibfk_2` FOREIGN KEY (`clase_cliente`) REFERENCES `clase` (`id_clase`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Filtros para la tabla `estado_membresia`
--
ALTER TABLE `estado_membresia`
  ADD CONSTRAINT `estado_membresia_ibfk_1` FOREIGN KEY (`membresia_estado`) REFERENCES `membresia` (`id_membresia`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `membresia`
--
ALTER TABLE `membresia`
  ADD CONSTRAINT `membresia_ibfk_1` FOREIGN KEY (`duracion_membresia`) REFERENCES `duracion` (`id_duracion`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `recuperar`
--
ALTER TABLE `recuperar`
  ADD CONSTRAINT `recuperar_ibfk_1` FOREIGN KEY (`admin_solicitud`) REFERENCES `administrador` (`cod_admin`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `registro`
--
ALTER TABLE `registro`
  ADD CONSTRAINT `registro_ibfk_1` FOREIGN KEY (`gym_registro`) REFERENCES `gimnasio` (`cod_gym`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `registro_ibfk_3` FOREIGN KEY (`cliente_registro`) REFERENCES `cliente` (`dni`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `registro_ibfk_4` FOREIGN KEY (`admin_registro`) REFERENCES `administrador` (`cod_admin`) ON DELETE SET NULL ON UPDATE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
