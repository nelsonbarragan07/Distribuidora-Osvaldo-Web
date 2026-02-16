-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 02-05-2023 a las 21:49:51
-- Versión del servidor: 10.4.27-MariaDB
-- Versión de PHP: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `distribuidora-osvaldo`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `id` int(10) NOT NULL,
  `nombre` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id`, `nombre`) VALUES
(1, 'Refrescos'),
(2, 'Alcoholicas'),
(3, 'Energizantes'),
(4, 'Hidratantes');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `id` int(10) NOT NULL,
  `nombre` varchar(80) NOT NULL,
  `apellidos` varchar(100) NOT NULL,
  `email` varchar(50) NOT NULL,
  `telefono` varchar(15) NOT NULL,
  `comentario` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`id`, `nombre`, `apellidos`, `email`, `telefono`, `comentario`) VALUES
(1, 'Nelson', 'Barragan de Hoyos', 'nelson@gmail.com', '3128103165', ''),
(2, 'Luis', 'Fernandez Carvajal', 'luis@gmail.com', '778544', ''),
(3, 'Armando', 'Peñate Mora', 'armandope@hotmail.com', '3214678998', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_pedidos`
--

CREATE TABLE `detalle_pedidos` (
  `id` int(11) NOT NULL,
  `pedido_id` int(11) NOT NULL,
  `producto_id` int(11) NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `estado` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `detalle_pedidos`
--

INSERT INTO `detalle_pedidos` (`id`, `pedido_id`, `producto_id`, `precio`, `cantidad`, `estado`) VALUES
(1, 1, 10, '125000.00', 2, 1),
(2, 1, 13, '65000.00', 1, 1),
(3, 1, 8, '1500.00', 1, 1),
(4, 1, 9, '2500.00', 1, 1),
(5, 2, 8, '1500.00', 1, 1),
(6, 2, 14, '12500.00', 1, 1),
(7, 2, 2, '1500.00', 1, 1),
(8, 2, 12, '25000.00', 1, 1),
(9, 3, 13, '65000.00', 1, 1),
(10, 3, 14, '12500.00', 1, 1),
(11, 3, 8, '1500.00', 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos`
--

CREATE TABLE `pedidos` (
  `id` int(10) NOT NULL,
  `cliente_id` int(11) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `fecha` date NOT NULL,
  `estado` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `pedidos`
--

INSERT INTO `pedidos` (`id`, `cliente_id`, `total`, `fecha`, `estado`) VALUES
(1, 1, '319000.00', '2023-05-01', 1),
(2, 2, '40500.00', '2023-05-01', 1),
(3, 3, '79000.00', '2023-05-01', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id` int(11) NOT NULL,
  `titulo` varchar(80) NOT NULL,
  `descripcion` varchar(300) NOT NULL,
  `foto` varchar(100) NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `categoria_id` int(10) NOT NULL,
  `fecha` date NOT NULL,
  `estado` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `titulo`, `descripcion`, `foto`, `precio`, `categoria_id`, `fecha`, `estado`) VALUES
(2, 'POSTOBON PEP', 'Postobon pep 400 Ml', 'producto5.jpeg', '1500.00', 1, '2023-05-01', 1),
(6, 'TEQUILA JOSE CUERVO', 'Tequila Jose Cuervo 700 Ml', 'producto2.jpeg', '73000.00', 2, '2023-05-01', 1),
(8, 'CERVEZA NATIVA', 'Cerveza Nativa 330 Ml', 'producto3.jpeg', '1500.00', 2, '2023-05-01', 1),
(9, 'POKER LATA', 'Poker Lata 330 Ml', 'producto4.jpeg', '2500.00', 2, '2023-05-01', 1),
(10, 'OLD PARD', 'Old Pard 750 Ml', 'producto6.jpeg', '125000.00', 2, '2023-05-01', 1),
(12, 'SPORADE', 'Sporade 550 Ml x 12', 'producto9.jpeg', '25000.00', 4, '2023-05-01', 1),
(13, 'RED LABEL', 'Red Label 700 Ml', 'producto10.jpeg', '65000.00', 2, '2023-05-01', 1),
(14, 'SAVILOE', 'Saviloe 320 Ml x 6', 'producto11.jpeg', '12500.00', 1, '2023-05-01', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre_usuario` varchar(100) NOT NULL,
  `clave` varchar(150) NOT NULL,
  `estado` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre_usuario`, `clave`, `estado`) VALUES
(1, 'sa', '123', 1),
(2, 'admin', '1234', 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `detalle_pedidos`
--
ALTER TABLE `detalle_pedidos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `detalle_pedidos`
--
ALTER TABLE `detalle_pedidos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
