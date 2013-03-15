-- phpMyAdmin SQL Dump
-- version 3.5.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 15, 2013 at 08:51 PM
-- Server version: 5.5.24-log
-- PHP Version: 5.4.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `_datos`
--

-- --------------------------------------------------------

--
-- Table structure for table `categoria`
--

CREATE TABLE IF NOT EXISTS `categoria` (
  `idCategoria` int(11) NOT NULL,
  `cate_nomb` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`idCategoria`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `categoria`
--

INSERT INTO `categoria` (`idCategoria`, `cate_nomb`) VALUES
(1, 'Frutas'),
(2, 'Verduras'),
(3, 'Dulces'),
(4, 'Bebidas');

-- --------------------------------------------------------

--
-- Table structure for table `pedido`
--

CREATE TABLE IF NOT EXISTS `pedido` (
  `idPedido` int(11) NOT NULL,
  `pedi_fech` timestamp NULL DEFAULT NULL,
  `pedi_cant` varchar(45) DEFAULT NULL,
  `Personas_idPersona` int(11) NOT NULL,
  `idProducto` int(11) DEFAULT NULL,
  PRIMARY KEY (`idPedido`,`Personas_idPersona`),
  KEY `fk_Pedido_Personas1_idx` (`Personas_idPersona`),
  KEY `idProducto` (`idProducto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `pedido`
--

INSERT INTO `pedido` (`idPedido`, `pedi_fech`, `pedi_cant`, `Personas_idPersona`, `idProducto`) VALUES
(1, '2013-03-10 17:46:22', '5\r\n', 2, 1),
(2, '2013-03-11 05:30:33', '22', 2, 2),
(3, '2013-03-11 08:08:14', '55', 1, 1),
(5, '2013-03-11 08:16:20', '5', 1, 1),
(6, '2013-03-11 08:16:28', '5', 2, 2),
(7, '2013-03-11 08:16:40', '5', 1, 2);

-- --------------------------------------------------------

--
-- Table structure for table `persona`
--

CREATE TABLE IF NOT EXISTS `persona` (
  `idPersona` int(11) NOT NULL,
  `pers_nomb` varchar(45) DEFAULT NULL,
  `pers_apel` varchar(45) DEFAULT NULL,
  `pers_tele` varchar(45) DEFAULT NULL,
  `pers_dire` varchar(45) DEFAULT NULL,
  `TipoPersona_idTipoPersona` int(11) NOT NULL,
  PRIMARY KEY (`idPersona`,`TipoPersona_idTipoPersona`),
  KEY `fk_Personas_TipoPersona1_idx` (`TipoPersona_idTipoPersona`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `persona`
--

INSERT INTO `persona` (`idPersona`, `pers_nomb`, `pers_apel`, `pers_tele`, `pers_dire`, `TipoPersona_idTipoPersona`) VALUES
(1, 'David', 'Quintero', '2646464', 'calle 10 ', 2),
(2, 'Sara', 'Cubides', '2656565', 'Calle 11', 1),
(3, 'Juliana', 'Rojas', '2686868', 'Calle 12', 1),
(4, 'Maria', 'Terres', '2545454', 'Calle 13', 3),
(5, 'Mariana', 'Hurtado', '2858585', 'Calle 14', 2),
(7, 'Andrea', 'Isaza', '2656864', 'Calle 15', 1);

-- --------------------------------------------------------

--
-- Table structure for table `producto`
--

CREATE TABLE IF NOT EXISTS `producto` (
  `idProducto` int(11) NOT NULL,
  `prod_nomb` varchar(45) DEFAULT NULL,
  `prod_desc` varchar(45) DEFAULT NULL,
  `prod_prec_comp` int(11) DEFAULT NULL,
  `prod_prec_vent` int(11) DEFAULT NULL,
  `prod_ruta_imag` varchar(45) DEFAULT NULL,
  `categoria_idCategoria` int(11) NOT NULL,
  PRIMARY KEY (`idProducto`,`categoria_idCategoria`),
  KEY `fk_producto_categoria_idx` (`categoria_idCategoria`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `producto`
--

INSERT INTO `producto` (`idProducto`, `prod_nomb`, `prod_desc`, `prod_prec_comp`, `prod_prec_vent`, `prod_ruta_imag`, `categoria_idCategoria`) VALUES
(1, 'Manzanas', 'Manzana Fruta Saludable', 5000, 10000, '/img/manzana.jpg', 1),
(2, 'Espinaca', 'Espinaca Verdura Saludable', 1000, 2000, '/img/espinaca.jpg', 2),
(3, 'Yogo Yogo', 'Bebida Saludable', 200, 400, '/img/yoyo.jpg', 4);

-- --------------------------------------------------------

--
-- Table structure for table `producto_has_pedido`
--

CREATE TABLE IF NOT EXISTS `producto_has_pedido` (
  `Producto_idProducto` int(11) NOT NULL,
  `Pedido_idPedido` int(11) NOT NULL,
  PRIMARY KEY (`Producto_idProducto`,`Pedido_idPedido`),
  KEY `fk_Producto_has_Pedido_Pedido1_idx` (`Pedido_idPedido`),
  KEY `fk_Producto_has_Pedido_Producto1_idx` (`Producto_idProducto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tipopersona`
--

CREATE TABLE IF NOT EXISTS `tipopersona` (
  `idTipoPersona` int(11) NOT NULL,
  `tipo_pers` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`idTipoPersona`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tipopersona`
--

INSERT INTO `tipopersona` (`idTipoPersona`, `tipo_pers`) VALUES
(1, 'Cliente'),
(2, 'Empleado'),
(3, 'Prooverdor');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `user_id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT 'auto incrementing user_id of each user, unique index',
  `user_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL COMMENT 'user''s name',
  `user_password_hash` text COLLATE utf8_unicode_ci NOT NULL COMMENT 'user''s password in salted and hashed format',
  `user_email` text COLLATE utf8_unicode_ci COMMENT 'user''s email',
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `user_name` (`user_name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='user data' AUTO_INCREMENT=2 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_name`, `user_password_hash`, `user_email`) VALUES
(1, 'admin', '$2a$10$A1JQ7oHZcMgPBTbbLp0o3OTTL5Tav4aVDAHqola0TWqXsldLrenPe', 'admin@admin.com');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `pedido`
--
ALTER TABLE `pedido`
  ADD CONSTRAINT `fk_Pedido_Personas1` FOREIGN KEY (`Personas_idPersona`) REFERENCES `persona` (`idPersona`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `idProducto` FOREIGN KEY (`idProducto`) REFERENCES `producto` (`idProducto`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `persona`
--
ALTER TABLE `persona`
  ADD CONSTRAINT `fk_Personas_TipoPersona1` FOREIGN KEY (`TipoPersona_idTipoPersona`) REFERENCES `tipopersona` (`idTipoPersona`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `producto`
--
ALTER TABLE `producto`
  ADD CONSTRAINT `fk_producto_categoria` FOREIGN KEY (`categoria_idCategoria`) REFERENCES `categoria` (`idCategoria`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `producto_has_pedido`
--
ALTER TABLE `producto_has_pedido`
  ADD CONSTRAINT `fk_Producto_has_Pedido_Pedido1` FOREIGN KEY (`Pedido_idPedido`) REFERENCES `pedido` (`idPedido`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Producto_has_Pedido_Producto1` FOREIGN KEY (`Producto_idProducto`) REFERENCES `producto` (`idProducto`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
