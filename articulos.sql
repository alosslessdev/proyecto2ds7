-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jul 10, 2025 at 05:12 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `articulos`
--

-- --------------------------------------------------------

--
-- Table structure for table `articulos`
--

CREATE TABLE `articulos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `contenido` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `articulos`
--

INSERT INTO `articulos` (`id`, `nombre`, `precio`, `contenido`) VALUES
(1, 'Libro Yuji Naka: Legado Sonic', 19.99, 'Libro Yuji Naka: Legado Sonic. \r\n\r\n---\r\n\r\n## Capitulo 1: *El Nino que Escuchaba Bits*\r\n\r\nEn una tranquila tarde de otono de 1965, en la ciudad de Osaka, Japon, nacio un nino que cambiaria el curso de la historia de los videojuegos: **Yuji Naka**. Desde pequeno, Yuji no jugaba con carritos ni con espadas de plastico. En su lugar, desmontaba radios viejas que encontraba en la casa de su abuelo, tratando de descubrir como viajaban los sonidos por cables diminutos.\r\n\r\nA los siete anos, algo cambio en su vida: su padre trajo a casa una calculadora programable Sharp. Mientras otros ninos veian dibujos animados, Yuji pasaba las tardes escribiendo formulas simples, sorprendiendose de que una maquina pudiera seguir sus ordenes.\r\n\r\nCuando cumplio 14, programo su primer juego: **\"Salto del Mono Cosmico\"**, una aventura rudimentaria que hizo en BASIC para una computadora NEC PC-8001 de segunda mano. Nadie lo jugo, excepto su hermana menor, que decia que el mono parecia un fantasma con patas. Pero a Yuji no le importaba. Para el, cada linea de codigo era musica. Literalmente. En su mente, el \"beep\" de cada error tenia una nota particular, y con el tiempo, aprendio a componer \"melodias de codigo\" que solo el podia entender.\r\n\r\nDurante sus anos de secundaria, mientras otros sonaban con ser doctores o ingenieros, el sonaba con mundos imposibles: bosques infinitos generados por algoritmos, ciudades flotantes controladas por inteligencia artificial, y criaturas que se movieran con la fluidez del viento. Su obsesion no era solo crear juegos, sino hacer que los juegos *sintieran*.\r\n\r\nEn 1984, justo al terminar el colegio, Yuji tomo una decision impulsiva: viajo a Tokio con apenas 20.000 yenes en el bolsillo y una carpeta llena de bocetos y disquetes. Su destino: las oficinas de una empresa emergente llamada **SEGA**. Nadie lo habia invitado. Toco la puerta de Recursos Humanos con la inocencia de quien no conoce el \"no\" como respuesta.\r\n\r\nLa leyenda cuenta que el ingeniero que lo entrevisto, Hiroshi Kawaguchi, se rio cuando Yuji le mostro un prototipo de un juego de carreras hecho en ensamblador. \"Esto no tiene graficos\", le dijo. \"Pero va a 60 cuadros por segundo\", respondio Yuji. Kawaguchi levanto una ceja. No contrataban genios todos los dias.\r\n\r\nY asi, sin diploma, sin experiencia profesional, pero con una mente que funcionaba como un procesador cuantico, **Yuji Naka entro al corazon de SEGA**. Lo que nadie sabia entonces era que este joven silencioso seria, anos despues, el padre espiritual del erizo mas veloz del planeta: **Sonic the Hedgehog**.\r\n\r\nPero esa historia... apenas comenzaba.\r\n\r\n---\r\n');

-- --------------------------------------------------------

--
-- Table structure for table `articulos_comprados`
--

CREATE TABLE `articulos_comprados` (
  `id` int(11) NOT NULL,
  `articulo_id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `fecha_compra` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `articulos_comprados`
--

INSERT INTO `articulos_comprados` (`id`, `articulo_id`, `usuario_id`, `fecha_compra`) VALUES
(1, 1, 1, '2025-07-10 00:09:59');

-- --------------------------------------------------------

--
-- Table structure for table `transacciones`
--

CREATE TABLE `transacciones` (
  `id` int(11) NOT NULL,
  `articulo_comprado_id` int(11) DEFAULT NULL,
  `nombre_completo` varchar(255) NOT NULL,
  `numero_tarjeta` varchar(255) NOT NULL,
  `vencimiento` varchar(10) NOT NULL,
  `cvv` varchar(5) NOT NULL,
  `metodo_pago` varchar(50) DEFAULT NULL,
  `monto_total` decimal(10,2) NOT NULL,
  `fecha_transaccion` timestamp NOT NULL DEFAULT current_timestamp(),
  `estado_transaccion` varchar(50) DEFAULT 'Pendiente'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre_usuario` varchar(100) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre_usuario`, `password_hash`, `fecha_registro`) VALUES
(1, 'francisco278herrera@gmail.com', '$2a$12$WwmKnu9A5.aQ73ltZesaxe/sLpLhNHphQarXAhBncNiaoB5l4lQ.C', '2025-07-09 21:28:41');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `articulos`
--
ALTER TABLE `articulos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre` (`nombre`);

--
-- Indexes for table `articulos_comprados`
--
ALTER TABLE `articulos_comprados`
  ADD PRIMARY KEY (`id`),
  ADD KEY `articulo_id` (`articulo_id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Indexes for table `transacciones`
--
ALTER TABLE `transacciones`
  ADD PRIMARY KEY (`id`),
  ADD KEY `articulo_comprado_id` (`articulo_comprado_id`);

--
-- Indexes for table `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre_usuario` (`nombre_usuario`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `articulos`
--
ALTER TABLE `articulos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `articulos_comprados`
--
ALTER TABLE `articulos_comprados`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `transacciones`
--
ALTER TABLE `transacciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `articulos_comprados`
--
ALTER TABLE `articulos_comprados`
  ADD CONSTRAINT `articulos_comprados_ibfk_1` FOREIGN KEY (`articulo_id`) REFERENCES `articulos` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `articulos_comprados_ibfk_2` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `transacciones`
--
ALTER TABLE `transacciones`
  ADD CONSTRAINT `transacciones_ibfk_1` FOREIGN KEY (`articulo_comprado_id`) REFERENCES `articulos_comprados` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- Procedimiento almacenado para obtener los artículos comprados por un usuario
DELIMITER //
CREATE PROCEDURE ObtenerArticulosCompradosPorUsuario(IN p_usuario_id INT)
BEGIN
    SELECT a.id, a.nombre, a.precio, a.contenido, ac.fecha_compra
    FROM articulos_comprados ac
    JOIN articulos a ON ac.articulo_id = a.id
    WHERE ac.usuario_id = p_usuario_id;
END //
DELIMITER ;
