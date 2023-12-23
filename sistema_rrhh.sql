-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 19-12-2023 a las 05:05:13
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
-- Base de datos: `sistema_rrhh`
--
CREATE DATABASE sistema_rhhh;
USE sistema_rrhh;
-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `auxiliares`
--

CREATE TABLE `auxiliares` (
  `id_auxiliar` int(11) NOT NULL,
  `nombre_completo` varchar(100) DEFAULT NULL,
  `dni` varchar(15) DEFAULT NULL,
  `fecha_nacimiento` date DEFAULT NULL,
  `lugar_nacimiento` varchar(100) DEFAULT NULL,
  `grado_academico` varchar(100) DEFAULT NULL,
  `cargo` varchar(50) DEFAULT NULL,
  `fuerza` enum('Ejército','Naval','Áerea') DEFAULT NULL,
  `fecha_ingreso_ffaa` datetime DEFAULT NULL,
  `fecha_ingreso_udh` datetime DEFAULT NULL,
  `estado_civil` enum('Soltero','Casado') DEFAULT NULL,
  `modalidad` enum('Permanente','Por Contrato') DEFAULT NULL,
  `ruta_carpeta` varchar(100) DEFAULT NULL,
  `registro_borrado` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bitacora`
--

CREATE TABLE `bitacora` (
  `id_bitacora` int(11) NOT NULL,
  `id_modulo` int(11) DEFAULT NULL,
  `fecha` datetime NOT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `accion` tinytext NOT NULL COMMENT 'accion realizada si es un ingreso nuevo, actualizacion. eliminacion o una consulta.',
  `descripcion` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `docentes`
--

CREATE TABLE `docentes` (
  `id_docente` int(11) NOT NULL,
  `nombre_completo` varchar(100) DEFAULT NULL,
  `dni` varchar(15) DEFAULT NULL,
  `fecha_nacimiento` date DEFAULT NULL,
  `lugar_nacimiento` varchar(100) DEFAULT NULL,
  `grado_academico` varchar(100) DEFAULT NULL,
  `cuenta_banco` varchar(150) DEFAULT NULL,
  `rtn` varchar(150) DEFAULT NULL,
  `fecha_ingreso_udh` datetime DEFAULT NULL,
  `estado_civil` enum('Soltero','Casado') DEFAULT NULL,
  `ruta_carpeta` varchar(100) DEFAULT NULL,
  `registro_borrado` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `docentes`
--

INSERT INTO `docentes` (`id_docente`, `nombre_completo`, `dni`, `fecha_nacimiento`, `lugar_nacimiento`, `grado_academico`, `cuenta_banco`, `rtn`, `fecha_ingreso_udh`, `estado_civil`, `ruta_carpeta`, `registro_borrado`) VALUES
(1, 'JOSE PEREZ', '111111111111', '2023-12-16', 'LAS LAJAS', 'MAESTRO', '343242342', '43243242342', '2023-12-16 14:59:57', 'Soltero', '/docentes/1', 0),
(2, 'LYNDA PARRA', '0000000000000', '2023-12-16', 'TEGUCIGALPA', 'MAESTRO', '34324324234', '345345345', '2023-12-16 15:00:44', 'Casado', '/docentes/2', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `modulos`
--

CREATE TABLE `modulos` (
  `id_modulo` int(11) NOT NULL,
  `modulo` varchar(100) NOT NULL,
  `descripcion` varchar(100) NOT NULL,
  `tipo_modulo` enum('Home','Dashboard','Empresas','Sorteos','Premios','Configuracion','Administracion','Ventas') NOT NULL,
  `creado_por` varchar(50) NOT NULL,
  `fecha_creacion` datetime NOT NULL,
  `modificado_por` varchar(50) DEFAULT NULL,
  `fecha_modificacion` datetime DEFAULT NULL,
  `registro_borrado` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `oficiales`
--

CREATE TABLE `oficiales` (
  `id_oficial` int(11) NOT NULL,
  `nombre_completo` varchar(100) DEFAULT NULL,
  `grado` varchar(50) DEFAULT NULL,
  `dni` varchar(15) DEFAULT NULL,
  `fecha_nacimiento` date DEFAULT NULL,
  `lugar_nacimiento` varchar(100) DEFAULT NULL,
  `grado_academico` varchar(100) DEFAULT NULL,
  `cargo` varchar(50) DEFAULT NULL,
  `serie` varchar(16) DEFAULT NULL,
  `fuerza` enum('Ejército','Naval','Áerea') DEFAULT NULL,
  `fecha_ingreso_ffaa` datetime DEFAULT NULL,
  `fecha_ingreso_udh` datetime DEFAULT NULL,
  `estado_civil` enum('Soltero','Casado') DEFAULT NULL,
  `ruta_carpeta` varchar(100) DEFAULT NULL,
  `registro_borrado` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `oficiales`
--

INSERT INTO `oficiales` (`id_oficial`, `nombre_completo`, `grado`, `dni`, `fecha_nacimiento`, `lugar_nacimiento`, `grado_academico`, `cargo`, `serie`, `fuerza`, `fecha_ingreso_ffaa`, `fecha_ingreso_udh`, `estado_civil`, `ruta_carpeta`, `registro_borrado`) VALUES
(1, 'JOSE LUIS MEJIA', 'CAPITAN', '0801199912092', '2023-12-16', 'SAN JOSE', 'INGENIERO', 'JEFE DE AREA', 'FAH1234', 'Ejército', '2023-12-16 13:23:34', '2023-12-16 13:23:36', 'Soltero', '/oficiales/1', 0),
(2, 'ANA ERAZO', 'TENIENTE', '12032000192811', '2023-12-16', 'LA LIMA', 'LICENCIADA', 'ASESORA DE SEGURIDAD', 'FAH1235', 'Áerea', '2023-12-16 13:24:50', '2023-12-16 13:24:51', 'Casado', '/oficiales/2', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `parametros`
--

CREATE TABLE `parametros` (
  `id_parametro` int(11) NOT NULL,
  `parametro` varchar(60) NOT NULL,
  `valor` varchar(100) NOT NULL,
  `creado_por` varchar(50) NOT NULL,
  `fecha_creacion` datetime NOT NULL,
  `modificado_por` varchar(50) DEFAULT NULL,
  `fecha_modificacion` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permisos`
--

CREATE TABLE `permisos` (
  `id_rol` int(11) NOT NULL,
  `id_modulo` int(11) NOT NULL,
  `tipo_modulo` enum('Home','Dashboard','Empresas','Sorteos','Premios','Configuración','Administración','Ventas') NOT NULL,
  `permiso_insercion` tinyint(4) NOT NULL DEFAULT 0,
  `permiso_actualizacion` tinyint(4) NOT NULL DEFAULT 0,
  `permiso_eliminacion` tinyint(4) NOT NULL DEFAULT 0,
  `permiso_consulta` tinyint(4) NOT NULL DEFAULT 0,
  `creado_por` varchar(50) NOT NULL,
  `fecha_creacion` datetime NOT NULL,
  `modificado_por` varchar(50) DEFAULT NULL,
  `fecha_modificacion` datetime DEFAULT NULL,
  `registro_borrado` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `personas`
--

CREATE TABLE `personas` (
  `id_persona` int(11) NOT NULL,
  `nombres` varchar(100) DEFAULT NULL,
  `apellidos` varchar(100) DEFAULT NULL,
  `dni` varchar(20) DEFAULT NULL,
  `fecha_nacimiento` date DEFAULT NULL,
  `edad` int(11) DEFAULT NULL,
  `foto_persona` varchar(200) DEFAULT NULL,
  `telefono` varchar(15) DEFAULT NULL,
  `sexo` enum('Masculino','Femenino') DEFAULT NULL,
  `departamento` enum('Atlántida','Colón','Comayagua','Cortés','Copán','Choluteca','El Paraíso','Francisco Morazán','Gracias a Dios','Intibucá','Islas de la Bahía','La Paz','Lempira','Ocotepeque','Olancho','Santa Bárbara','Valle','Yoro') DEFAULT NULL,
  `direccion` varchar(120) DEFAULT NULL,
  `creado_por` varchar(30) DEFAULT NULL,
  `fecha_creacion` datetime DEFAULT NULL,
  `modificado_por` varchar(30) DEFAULT NULL,
  `fecha_modificacion` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `restablece_clave_email`
--

CREATE TABLE `restablece_clave_email` (
  `id_restablecer` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `codigo` int(11) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id_rol` int(11) NOT NULL,
  `rol` varchar(50) NOT NULL,
  `descripcion` varchar(200) NOT NULL,
  `creado_por` varchar(50) NOT NULL,
  `fecha_creacion` datetime NOT NULL,
  `modificado_por` varchar(50) DEFAULT NULL,
  `fecha_modificacion` datetime DEFAULT NULL,
  `registro_borrado` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id_rol`, `rol`, `descripcion`, `creado_por`, `fecha_creacion`, `modificado_por`, `fecha_modificacion`, `registro_borrado`) VALUES
(1, 'ADMIN SISTEMA', 'Administrador del sistema', 'prueba', '2023-01-18 20:42:58', 'prueba', '2023-09-27 11:43:06', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL,
  `usuario` varchar(50) NOT NULL,
  `estado` enum('Activo','Inactivo','Bloqueado','Eliminado') NOT NULL,
  `contrasena` varchar(100) NOT NULL,
  `id_rol` int(11) DEFAULT NULL,
  `correo_electronico` varchar(50) NOT NULL,
  `creado_por` varchar(30) NOT NULL,
  `fecha_creacion` datetime NOT NULL,
  `modificado_por` varchar(30) DEFAULT NULL,
  `fecha_modificacion` datetime DEFAULT NULL,
  `registro_borrado` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `usuario`, `estado`, `contrasena`, `id_rol`, `correo_electronico`, `creado_por`, `fecha_creacion`, `modificado_por`, `fecha_modificacion`, `registro_borrado`) VALUES
(1, 'prueba', 'Activo', '$2y$12$JZuF8nYNy9bF3Oo3w1ujROM8i00XmIUBsljz2MAPLkwaWUuWZhc2q', 1, 'prueba@gmail.hn', 'prueba', '2023-05-29 16:03:30', 'prueba', '2023-09-30 16:08:41', 0);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `auxiliares`
--
ALTER TABLE `auxiliares`
  ADD PRIMARY KEY (`id_auxiliar`) USING BTREE;

--
-- Indices de la tabla `bitacora`
--
ALTER TABLE `bitacora`
  ADD PRIMARY KEY (`id_bitacora`) USING BTREE,
  ADD KEY `FK_bitacora_usuarios` (`id_usuario`) USING BTREE,
  ADD KEY `FK_bitacora_modulos` (`id_modulo`);

--
-- Indices de la tabla `docentes`
--
ALTER TABLE `docentes`
  ADD PRIMARY KEY (`id_docente`) USING BTREE;

--
-- Indices de la tabla `modulos`
--
ALTER TABLE `modulos`
  ADD PRIMARY KEY (`id_modulo`);

--
-- Indices de la tabla `oficiales`
--
ALTER TABLE `oficiales`
  ADD PRIMARY KEY (`id_oficial`);

--
-- Indices de la tabla `parametros`
--
ALTER TABLE `parametros`
  ADD PRIMARY KEY (`id_parametro`) USING BTREE;

--
-- Indices de la tabla `permisos`
--
ALTER TABLE `permisos`
  ADD KEY `Índice 1` (`id_rol`) USING BTREE,
  ADD KEY `Índice 2` (`id_modulo`) USING BTREE;

--
-- Indices de la tabla `personas`
--
ALTER TABLE `personas`
  ADD PRIMARY KEY (`id_persona`);

--
-- Indices de la tabla `restablece_clave_email`
--
ALTER TABLE `restablece_clave_email`
  ADD PRIMARY KEY (`id_restablecer`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id_rol`) USING BTREE;

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`) USING BTREE;

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `auxiliares`
--
ALTER TABLE `auxiliares`
  MODIFY `id_auxiliar` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `bitacora`
--
ALTER TABLE `bitacora`
  MODIFY `id_bitacora` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `docentes`
--
ALTER TABLE `docentes`
  MODIFY `id_docente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `modulos`
--
ALTER TABLE `modulos`
  MODIFY `id_modulo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `oficiales`
--
ALTER TABLE `oficiales`
  MODIFY `id_oficial` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `parametros`
--
ALTER TABLE `parametros`
  MODIFY `id_parametro` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `personas`
--
ALTER TABLE `personas`
  MODIFY `id_persona` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `restablece_clave_email`
--
ALTER TABLE `restablece_clave_email`
  MODIFY `id_restablecer` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id_rol` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
