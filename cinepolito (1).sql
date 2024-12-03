-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3308
-- Tiempo de generación: 29-11-2024 a las 21:48:21
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `cinepolito`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alimentos`
--

CREATE TABLE `alimentos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `categoria` enum('Snacks','Bebidas','Dulces','Helados') NOT NULL,
  `imagen` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `alimentos`
--

INSERT INTO `alimentos` (`id`, `nombre`, `precio`, `categoria`, `imagen`) VALUES
(1, 'Palomitas', 75.00, 'Snacks', 'img/palomitas.png'),
(2, 'Hot Dog Individual', 54.00, 'Snacks', 'img/hotdog.png'),
(3, 'Nachos', 70.00, 'Snacks', 'img/nachos.png'),
(4, 'Extra Queso', 18.00, 'Snacks', 'img/extraqueso.png'),
(5, 'Agua Embotellada', 35.00, 'Bebidas', 'img/agua.png'),
(6, 'Refresco', 65.00, 'Bebidas', 'img/refresco.png'),
(7, 'ICEE', 85.00, 'Bebidas', 'img/icee.png'),
(8, 'Skittles', 40.00, 'Dulces', 'img/skittles.png'),
(9, 'Skwinkles', 30.00, 'Dulces', 'img/skwinkles.png'),
(10, 'Panditas Enchilados', 35.00, 'Dulces', 'img/panditas.png'),
(11, 'Cornetto', 50.00, 'Helados', 'img/corneto.png'),
(12, 'Magnum', 60.00, 'Helados', 'img/magnum.png'),
(13, 'Helado Micha', 45.00, 'Helados', 'img/micha.png'),
(14, 'Mordisko Oreo', 55.00, 'Helados', 'img/mordisko.png');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente`
--

CREATE TABLE `cliente` (
  `ID` int(11) NOT NULL,
  `Nombre` varchar(100) NOT NULL,
  `Apellido` varchar(100) NOT NULL,
  `Correo` varchar(100) NOT NULL,
  `Telefono` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `cliente`
--

INSERT INTO `cliente` (`ID`, `Nombre`, `Apellido`, `Correo`, `Telefono`) VALUES
(1, 'Juan', 'Pérez', 'juanperez@example.com', '5551234567'),
(2, 'María', 'García', 'mariagarcia@example.com', '5552345678'),
(3, 'Carlos', 'López', 'carloslopez@example.com', '5553456789');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compras`
--

CREATE TABLE `compras` (
  `id` int(11) NOT NULL,
  `id_pelicula` int(11) DEFAULT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `apellido` varchar(100) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `asientos` varchar(255) DEFAULT NULL,
  `numero_asientos` int(11) DEFAULT NULL,
  `total_pagar` decimal(10,2) DEFAULT NULL,
  `metodo_pago` varchar(50) DEFAULT NULL,
  `fecha_compra` timestamp NOT NULL DEFAULT current_timestamp(),
  `asientos_array` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `compras`
--

INSERT INTO `compras` (`id`, `id_pelicula`, `nombre`, `apellido`, `email`, `asientos`, `numero_asientos`, `total_pagar`, `metodo_pago`, `fecha_compra`, `asientos_array`) VALUES
(5, 1, 'Victor', 'Gil', '220I0022@tecmartinez.edu.mx', 'F6,F7', 2, 112.00, '0', '2024-11-26 13:16:34', NULL),
(6, 4, 'Victor', 'Gil', '220I0022@tecmartinez.edu.mx', 'B4,B5', 2, 112.00, '0', '2024-11-26 14:53:38', NULL),
(7, 3, 'Casandra', 'Hernandez', '220I0032@tecmartinez.edu.mx', 'E1,E2', 2, 112.00, '0', '2024-11-26 14:57:15', NULL),
(8, 4, 'Victor', 'Gil', 'fran2004gil23@gmail.com', 'H9,H8', 2, 112.00, '0', '2024-11-26 15:06:15', NULL),
(9, 2, 'Francisco Eliezer', 'Gil Garcia', '250i0084@gmail.com', 'A1,A2,A3', 3, 168.00, '0', '2024-11-26 15:08:27', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `horarios`
--

CREATE TABLE `horarios` (
  `id` int(11) NOT NULL,
  `id_pelicula` int(11) NOT NULL,
  `horario` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `horarios`
--

INSERT INTO `horarios` (`id`, `id_pelicula`, `horario`) VALUES
(1, 1, '14:00:00'),
(2, 1, '17:00:00'),
(3, 2, '15:30:00'),
(4, 2, '19:00:00'),
(5, 3, '13:00:00'),
(6, 3, '18:00:00'),
(7, 4, '16:00:00'),
(8, 4, '20:30:00'),
(9, 5, '12:00:00'),
(10, 5, '21:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `peliculas`
--

CREATE TABLE `peliculas` (
  `ID` int(11) NOT NULL,
  `Pelicula` varchar(100) NOT NULL,
  `Estreno` date NOT NULL,
  `Clasificacion` varchar(50) NOT NULL,
  `Genero` varchar(50) NOT NULL,
  `Precio` float NOT NULL,
  `Duracion` int(11) NOT NULL,
  `Idioma` varchar(50) NOT NULL,
  `Sinopsis` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `peliculas`
--

INSERT INTO `peliculas` (`ID`, `Pelicula`, `Estreno`, `Clasificacion`, `Genero`, `Precio`, `Duracion`, `Idioma`, `Sinopsis`) VALUES
(1, 'Gladiador 2', '2024-12-15', 'B15', 'Acción', 56, 155, 'Español', 'Gladiador 2: La lucha por la justicia sigue en esta secuela, donde Maximus busca venganza contra los corruptos del Imperio Romano.'),
(2, 'Overlord El Reino Sagrado', '2024-11-22', 'C', 'Fantasia', 56, 130, 'Español', 'Overlord El Reino Sagrado: Un grupo de soldados luchan contra criaturas no-muertas en la Segunda Guerra Mundial, enfrentando horrores sobrenaturales.'),
(3, 'Robot Salvaje', '2024-12-01', 'A', 'Ciencia Ficción', 56, 120, 'Español', 'Robot Salvaje: Un robot desechado por la humanidad lucha por encontrar su propósito mientras se enfrenta a una sociedad que lo rechaza.'),
(4, 'Terrifier 3', '2024-10-31', 'D', 'Terror', 56, 95, 'Español', 'Terrifier 3: El asesino enmascarado Art the Clown regresa, desatando una ola de terror en una nueva ciudad.'),
(5, 'Wicked', '2024-11-25', 'A', 'Musical', 56, 105, 'Español', 'Wicked: Un musical basado en el mundo de Oz, que cuenta la historia de la bruja mala y su relación con la bruja buena.');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `alimentos`
--
ALTER TABLE `alimentos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`ID`);

--
-- Indices de la tabla `compras`
--
ALTER TABLE `compras`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_pelicula` (`id_pelicula`);

--
-- Indices de la tabla `horarios`
--
ALTER TABLE `horarios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_pelicula` (`id_pelicula`);

--
-- Indices de la tabla `peliculas`
--
ALTER TABLE `peliculas`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `alimentos`
--
ALTER TABLE `alimentos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `cliente`
--
ALTER TABLE `cliente`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `compras`
--
ALTER TABLE `compras`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `horarios`
--
ALTER TABLE `horarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `peliculas`
--
ALTER TABLE `peliculas`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `compras`
--
ALTER TABLE `compras`
  ADD CONSTRAINT `compras_ibfk_1` FOREIGN KEY (`id_pelicula`) REFERENCES `peliculas` (`ID`);

--
-- Filtros para la tabla `horarios`
--
ALTER TABLE `horarios`
  ADD CONSTRAINT `horarios_ibfk_1` FOREIGN KEY (`id_pelicula`) REFERENCES `peliculas` (`ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
