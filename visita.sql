-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 16-04-2026 a las 05:01:52
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
-- Base de datos: `visitantes`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `visita`
--

CREATE TABLE `visita` (
  `id_visita` int(11) NOT NULL,
  `id_persona` int(11) DEFAULT NULL,
  `id_despacho` int(11) DEFAULT NULL,
  `persona_visitada` varchar(100) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `hora_entrada` time DEFAULT NULL,
  `hora_salida` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `visita`
--

INSERT INTO `visita` (`id_visita`, `id_persona`, `id_despacho`, `persona_visitada`, `fecha`, `hora_entrada`, `hora_salida`) VALUES
(4, 4, 4, 'dwada', '2026-04-15', '20:30:03', '20:31:13'),
(5, 5, 5, 'edith ', '2026-04-15', '20:59:07', '21:04:10'),
(6, 6, 6, 'dwa', '2026-04-15', '21:01:42', '21:14:26'),
(7, 7, 6, 'oscar', '2026-04-15', '21:03:43', '21:14:27'),
(8, 8, 7, 'msada', '2026-04-15', '21:13:00', '21:28:35'),
(9, 9, 8, 'da', '2026-04-15', '21:14:23', '21:40:28'),
(10, 8, 9, 'edtih', '2026-04-15', '21:55:18', '21:55:39'),
(11, 10, 10, 'wada', '2026-04-15', '21:56:59', NULL);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `visita`
--
ALTER TABLE `visita`
  ADD PRIMARY KEY (`id_visita`),
  ADD KEY `id_persona` (`id_persona`),
  ADD KEY `id_despacho` (`id_despacho`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `visita`
--
ALTER TABLE `visita`
  MODIFY `id_visita` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `visita`
--
ALTER TABLE `visita`
  ADD CONSTRAINT `visita_ibfk_1` FOREIGN KEY (`id_persona`) REFERENCES `persona` (`id_persona`),
  ADD CONSTRAINT `visita_ibfk_2` FOREIGN KEY (`id_despacho`) REFERENCES `despacho` (`id_despacho`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
