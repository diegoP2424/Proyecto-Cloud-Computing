-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Nov 26, 2025 at 03:32 PM
-- Server version: 8.4.7
-- PHP Version: 8.3.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `proyecto_cc`
--

-- --------------------------------------------------------

--
-- Table structure for table `personajes`
--

DROP TABLE IF EXISTS `personajes`;
CREATE TABLE IF NOT EXISTS `personajes` (
  `idPersonaje` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `descripcion` varchar(500) NOT NULL,
  `rol` varchar(100) NOT NULL,
  `imagen` varchar(1000) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  PRIMARY KEY (`idPersonaje`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `personajes`
--

INSERT INTO `personajes` (`idPersonaje`, `nombre`, `descripcion`, `rol`, `imagen`) VALUES
(6, 'pedrito sola', 'le gusta la mayonesa makorni no jelmas', 'Support', 'pedritosola.jpg'),
(7, 'Moira', 'No requiere ningún tipo de skill', 'Dps', 'moira.jpg'),
(8, 'Doomfist', 'Es el líder calculador de la organización terrorista Talon y el tercero en llevar el título de Doomfist. Solo gente habilidosa sabe usarlo...', 'Tanque', 'doomfist.jpg'),
(9, 'Babo', 'El loco más loco de todos los locos', 'Tanque', '6926a0f1565c9.jpg'),
(10, 'Anakin el caminacielos', 'el elegido de la fuerza', 'DPS', '6926a4d80bd5f.jpg'),
(11, 'benito', 'chiquito pero peligroso', 'Support', '6926a539bb5a6.jpg'),
(12, 'Esteban', 'Esteban', 'DPS', '6926ac4ed5868.jpeg'),
(13, 'Juan Gabriel', 'Bailando el noa noa nunca será derrotado... Su ultimate te hace mover el cuerpo', 'Support', '69271c02c5ca5.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE IF NOT EXISTS `usuarios` (
  `idUsuario` int NOT NULL AUTO_INCREMENT,
  `usuario` varchar(100) NOT NULL,
  `pass` varchar(100) NOT NULL,
  PRIMARY KEY (`idUsuario`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `usuarios`
--

INSERT INTO `usuarios` (`idUsuario`, `usuario`, `pass`) VALUES
(1, 'admin', 'elpepe123');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
