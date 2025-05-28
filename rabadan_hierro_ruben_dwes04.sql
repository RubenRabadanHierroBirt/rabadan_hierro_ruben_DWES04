-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 28-05-2025 a las 22:38:34
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
-- Base de datos: `rabadan_hierro_ruben_dwes04`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `articulo`
--

CREATE TABLE `articulo` (
  `ID` int(11) NOT NULL,
  `NOMBRE` varchar(50) DEFAULT NULL,
  `DESCRIPCION` text NOT NULL,
  `PRECIO` decimal(10,2) NOT NULL,
  `STOCK` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `articulo`
--

INSERT INTO `articulo` (`ID`, `NOMBRE`, `DESCRIPCION`, `PRECIO`, `STOCK`) VALUES
(1, 'Ratón Inalámbrico', 'Ratón óptico ergonómico', 15.99, 100),
(2, '1 Duro Crucial BX500 1tb Disco SSD SATA3 540MB/S', 'descripcion', 12.99, 45),
(3, 'Pantalla 24\"', 'Monitor LED FullHD', 129.99, 30),
(4, 'Muestra', 'descripcion', 12.99, 45),
(5, 'DWES04', 'ARTICULO', 57.99, 45),
(6, 'DWES04', 'ARTICULO', 57.99, 45);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente`
--

CREATE TABLE `cliente` (
  `ID` int(11) NOT NULL,
  `NOMBRE` varchar(100) NOT NULL,
  `EMAIL` varchar(100) NOT NULL,
  `TELEFONO` int(10) NOT NULL,
  `DIRECCION` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `cliente`
--

INSERT INTO `cliente` (`ID`, `NOMBRE`, `EMAIL`, `TELEFONO`, `DIRECCION`) VALUES
(1, 'Pedro Martín', 'pedro@gmail.com', 698765432, 'Calle Falsa 123'),
(2, 'María Sánchez', 'maria@gmail.com', 687654321, 'Av. Siempre Viva 742'),
(3, 'Luis Gómez', 'luis@gmail.com', 676543210, 'Paseo del Prado 1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `linea_pedido`
--

CREATE TABLE `linea_pedido` (
  `ID` int(11) NOT NULL,
  `PEDIDO` int(11) DEFAULT NULL,
  `ARTICULO` int(11) NOT NULL,
  `CANTIDAD` int(11) NOT NULL,
  `PRECIO` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `linea_pedido`
--

INSERT INTO `linea_pedido` (`ID`, `PEDIDO`, `ARTICULO`, `CANTIDAD`, `PRECIO`) VALUES
(1, 1, 1, 2, 15.99),
(2, 1, 2, 1, 49.99),
(3, 2, 3, 1, 129.99),
(4, 3, 1, 1, 15.99);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedido`
--

CREATE TABLE `pedido` (
  `ID` int(11) NOT NULL,
  `CLIENTE` int(11) NOT NULL,
  `VENDEDOR` int(11) NOT NULL,
  `TOTAL` decimal(10,2) NOT NULL,
  `FECHA` date NOT NULL,
  `ESTADO` enum('pendiente','enviado','cancelado','') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pedido`
--

INSERT INTO `pedido` (`ID`, `CLIENTE`, `VENDEDOR`, `TOTAL`, `FECHA`, `ESTADO`) VALUES
(1, 1, 1, 65.98, '2025-05-20', 'enviado'),
(2, 2, 2, 129.99, '2025-05-21', 'pendiente'),
(3, 3, 3, 15.99, '2025-05-22', 'cancelado'),
(5, 1, 1, 0.00, '2024-12-12', 'pendiente');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vendedor`
--

CREATE TABLE `vendedor` (
  `ID` int(11) NOT NULL,
  `NOMBRE` varchar(100) NOT NULL,
  `EMAIL` varchar(100) NOT NULL,
  `TELEFONO` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `vendedor`
--

INSERT INTO `vendedor` (`ID`, `NOMBRE`, `EMAIL`, `TELEFONO`) VALUES
(1, 'Ana López', 'ana@empresa.com', 612345678),
(2, 'Carlos Ruiz', 'carlos@empresa.com', 623456789),
(3, 'Lucía Torres', 'lucia@empresa.com', 634567890);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `articulo`
--
ALTER TABLE `articulo`
  ADD PRIMARY KEY (`ID`);

--
-- Indices de la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`ID`);

--
-- Indices de la tabla `linea_pedido`
--
ALTER TABLE `linea_pedido`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `FK_PEDIDO` (`PEDIDO`),
  ADD KEY `FK_ARTICULO` (`ARTICULO`);

--
-- Indices de la tabla `pedido`
--
ALTER TABLE `pedido`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `FKcliente` (`CLIENTE`) USING BTREE,
  ADD KEY `FKvendedor` (`VENDEDOR`) USING BTREE;

--
-- Indices de la tabla `vendedor`
--
ALTER TABLE `vendedor`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `articulo`
--
ALTER TABLE `articulo`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `cliente`
--
ALTER TABLE `cliente`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `linea_pedido`
--
ALTER TABLE `linea_pedido`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `pedido`
--
ALTER TABLE `pedido`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `vendedor`
--
ALTER TABLE `vendedor`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `linea_pedido`
--
ALTER TABLE `linea_pedido`
  ADD CONSTRAINT `linea_pedido_ibfk_1` FOREIGN KEY (`PEDIDO`) REFERENCES `pedido` (`ID`) ON DELETE CASCADE,
  ADD CONSTRAINT `linea_pedido_ibfk_2` FOREIGN KEY (`ARTICULO`) REFERENCES `articulo` (`ID`);

--
-- Filtros para la tabla `pedido`
--
ALTER TABLE `pedido`
  ADD CONSTRAINT `pedido_ibfk_1` FOREIGN KEY (`CLIENTE`) REFERENCES `cliente` (`ID`),
  ADD CONSTRAINT `pedido_ibfk_2` FOREIGN KEY (`VENDEDOR`) REFERENCES `vendedor` (`ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
