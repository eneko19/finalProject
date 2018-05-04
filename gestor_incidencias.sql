-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 04-05-2018 a las 11:07:22
-- Versión del servidor: 5.7.21
-- Versión de PHP: 7.0.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `gestor_incidencias`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `archivo`
--

DROP TABLE IF EXISTS `archivo`;
CREATE TABLE IF NOT EXISTS `archivo` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `url` int(9) NOT NULL,
  `id_incidencia` int(9) DEFAULT NULL,
  `id_comentario` int(9) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_incidencia` (`id_incidencia`),
  KEY `id_comentario` (`id_comentario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria`
--

DROP TABLE IF EXISTS `categoria`;
CREATE TABLE IF NOT EXISTS `categoria` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `categoria`
--

INSERT INTO `categoria` (`id`, `nombre`) VALUES
(1, 'Administración'),
(2, 'Reservas');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comentario`
--

DROP TABLE IF EXISTS `comentario`;
CREATE TABLE IF NOT EXISTS `comentario` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(1024) COLLATE utf8_unicode_ci NOT NULL,
  `fechacreacion` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `id_incidencia` int(9) NOT NULL,
  `id_usuario` int(9) NOT NULL,
  `id_archivo` int(9) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_incidencia` (`id_incidencia`),
  KEY `id_usuario` (`id_usuario`),
  KEY `id_archivo` (`id_archivo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estado`
--

DROP TABLE IF EXISTS `estado`;
CREATE TABLE IF NOT EXISTS `estado` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `estado`
--

INSERT INTO `estado` (`id`, `nombre`) VALUES
(1, 'nueva'),
(2, 'se necesitas mas datos'),
(3, 'aceptada'),
(4, 'confirmada'),
(5, 'asignada'),
(6, 'resuelta'),
(7, 'cerrada');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `incidencia`
--

DROP TABLE IF EXISTS `incidencia`;
CREATE TABLE IF NOT EXISTS `incidencia` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `asunto` varchar(80) COLLATE utf8_unicode_ci NOT NULL,
  `descripcion` varchar(1024) COLLATE utf8_unicode_ci NOT NULL,
  `fechacreacion` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fechamodificacion` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `id_usucreacion` int(9) NOT NULL,
  `id_usuasignada` int(9) DEFAULT NULL,
  `id_categoria` int(9) NOT NULL,
  `id_prioridad` int(9) NOT NULL,
  `id_estado` int(9) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_usucreacion` (`id_usucreacion`),
  KEY `id_usuasignada` (`id_usuasignada`),
  KEY `id_categoria` (`id_categoria`),
  KEY `id_prioridad` (`id_prioridad`),
  KEY `id_estado` (`id_estado`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `incidencia`
--

INSERT INTO `incidencia` (`id`, `asunto`, `descripcion`, `fechacreacion`, `fechamodificacion`, `id_usucreacion`, `id_usuasignada`, `id_categoria`, `id_prioridad`, `id_estado`) VALUES
(1, '¿Cómo se hace una incidencia?', 'Es una pregunta bastante subnormala pero weno como conio se hase una incidencia, se que para preguntar estoy haciendo una, pero si me lo podriais explicar igualmente os lo agradeseria xd un saludo chavbales', '2018-04-29 01:56:57', '2018-04-29 01:56:57', 1, NULL, 1, 3, 6),
(2, 'Asignada', 'aefwddwfwqfwfwfewfewfe', '2018-04-30 13:38:57', '2018-04-30 13:38:57', 1, 1, 2, 5, 5),
(3, 'dede', 'dede', '2018-04-30 14:57:23', '2018-04-30 14:57:23', 1, NULL, 1, 4, 1),
(4, 'Prueba de reserva', 'Inserto esta reserva', '2018-05-02 15:19:37', '2018-05-02 15:19:37', 1, NULL, 1, 1, 1),
(5, 'Prioridad Alta', 'wddwfwfwf', '2018-05-02 17:15:15', '2018-05-02 17:15:15', 1, NULL, 2, 4, 1),
(6, 'Incidencia reportada por user', 'Esto es una incidencia reportada por el usuario user, mas que nada es una prueba xd', '2018-05-03 11:07:28', '2018-05-03 11:07:28', 2, NULL, 1, 3, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `prioridad`
--

DROP TABLE IF EXISTS `prioridad`;
CREATE TABLE IF NOT EXISTS `prioridad` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `prioridad`
--

INSERT INTO `prioridad` (`id`, `nombre`) VALUES
(1, 'ninguna'),
(2, 'baja'),
(3, 'normal'),
(4, 'alta'),
(5, 'urgente'),
(6, 'inmediata');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipousuario`
--

DROP TABLE IF EXISTS `tipousuario`;
CREATE TABLE IF NOT EXISTS `tipousuario` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `tipousuario`
--

INSERT INTO `tipousuario` (`id`, `nombre`) VALUES
(1, 'administrador'),
(2, 'informador');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

DROP TABLE IF EXISTS `usuario`;
CREATE TABLE IF NOT EXISTS `usuario` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `usuario` varchar(16) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(80) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `nombre` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `fechacreacion` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `id_tipousuario` int(9) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_tipousuario` (`id_tipousuario`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id`, `usuario`, `password`, `email`, `nombre`, `fechacreacion`, `id_tipousuario`) VALUES
(1, 'admin', 'admin', 'admin@admin.com', 'Eneko Gallego', '2018-04-28 17:31:44', 1),
(2, 'user', 'user', 'user@user.com', 'Usuario Registrado', '2018-05-03 10:57:17', 1);

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `archivo`
--
ALTER TABLE `archivo`
  ADD CONSTRAINT `arch_comentario` FOREIGN KEY (`id_comentario`) REFERENCES `comentario` (`id`),
  ADD CONSTRAINT `arch_incidencia` FOREIGN KEY (`id_incidencia`) REFERENCES `incidencia` (`id`);

--
-- Filtros para la tabla `comentario`
--
ALTER TABLE `comentario`
  ADD CONSTRAINT `com_archivo` FOREIGN KEY (`id_archivo`) REFERENCES `archivo` (`id`),
  ADD CONSTRAINT `com_incidencia` FOREIGN KEY (`id_incidencia`) REFERENCES `incidencia` (`id`),
  ADD CONSTRAINT `com_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id`);

--
-- Filtros para la tabla `incidencia`
--
ALTER TABLE `incidencia`
  ADD CONSTRAINT `inci_categoria` FOREIGN KEY (`id_categoria`) REFERENCES `categoria` (`id`),
  ADD CONSTRAINT `inci_estado` FOREIGN KEY (`id_estado`) REFERENCES `estado` (`id`),
  ADD CONSTRAINT `inci_prioridad` FOREIGN KEY (`id_prioridad`) REFERENCES `prioridad` (`id`),
  ADD CONSTRAINT `inci_usuasignado` FOREIGN KEY (`id_usuasignada`) REFERENCES `usuario` (`id`),
  ADD CONSTRAINT `inci_usucreacion` FOREIGN KEY (`id_usucreacion`) REFERENCES `usuario` (`id`);

--
-- Filtros para la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `usu_tipousuario` FOREIGN KEY (`id_tipousuario`) REFERENCES `tipousuario` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
