-- phpMyAdmin SQL Dump
-- version 3.5.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 08, 2013 at 02:41 AM
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
(1, 'Alimentos'),
(2, 'Bebidas'),
(3, 'Dulces');

-- --------------------------------------------------------

--
-- Table structure for table `pedido`
--

CREATE TABLE IF NOT EXISTS `pedido` (
  `idPedido` int(11) NOT NULL,
  `pedi_fech` datetime DEFAULT NULL,
  `pedi_cant` varchar(45) DEFAULT NULL,
  `Personas_idPersona` int(11) NOT NULL,
  PRIMARY KEY (`idPedido`),
  KEY `fk_Pedido_Personas1_idx` (`Personas_idPersona`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `persona`
--

CREATE TABLE IF NOT EXISTS `persona` (
  `idPersona` int(11) NOT NULL,
  `pers_nomb` varchar(45) DEFAULT NULL,
  `pers_apel` varchar(45) DEFAULT NULL,
  `pers_tele` varchar(45) DEFAULT NULL,
  `empl_dire` varchar(45) DEFAULT NULL,
  `TipoPersona_idTipoPersona` int(11) NOT NULL,
  PRIMARY KEY (`idPersona`),
  KEY `fk_Personas_TipoPersona1_idx` (`TipoPersona_idTipoPersona`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `persona`
--

INSERT INTO `persona` (`idPersona`, `pers_nomb`, `pers_apel`, `pers_tele`, `empl_dire`, `TipoPersona_idTipoPersona`) VALUES
(3, 'rtwer', 'dsdg', '3454', 'rter', 2),
(1111, 'asdfas', 'asdf', '3544', 'sfdg', 2),
(93397500, 'Pablo', 'Fernandez', '2646470', 'Calle 10 # 30-30', 1),
(93397501, 'Mauricio', 'Robledo', '2646471', 'Calle 10 # 30-31', 1),
(93397502, 'Santiago', 'Molina', '264642', 'Calle 10 # 30-32', 1),
(93397503, 'Isarael', 'Rodriguez', '2646473', 'Calle 10 # 30-33', 1),
(93397504, 'Arturo', 'Casas', '2646474', 'Calle 10 # 30-34', 1),
(93397505, 'Julian', 'Marin', '2646475', 'Calle 10 # 30-35', 2),
(93397506, 'Fernando', 'Quijano', '2646476', 'Calle 10 # 30-36', 2),
(93397507, 'Dario', 'Arias', '2646477', 'Calle 10 # 30-37', 3),
(93397508, 'Nicolas', 'Bolivar', '2646478', 'Calle 10 # 30-38', 3),
(93397509, 'Juliana', 'Triana', '2646479', 'Calle 10 # 30-39', 3);

-- --------------------------------------------------------

--
-- Table structure for table `producto`
--

CREATE TABLE IF NOT EXISTS `producto` (
  `idProducto` int(11) NOT NULL,
  `prod_nomb` varchar(45) DEFAULT NULL,
  `prod_desc` varchar(45) DEFAULT NULL,
  `prod_prec_comp` int(11) DEFAULT NULL,
  `prod_prec_vent` varchar(45) DEFAULT NULL,
  `prod_ruta_imag` varchar(45) DEFAULT NULL,
  `categoria_idCategoria` int(11) NOT NULL,
  PRIMARY KEY (`idProducto`),
  KEY `fk_producto_categoria_idx` (`categoria_idCategoria`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
(3, 'Proovedor');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `pedido`
--
ALTER TABLE `pedido`
  ADD CONSTRAINT `fk_Pedido_Personas1` FOREIGN KEY (`Personas_idPersona`) REFERENCES `persona` (`idPersona`) ON DELETE NO ACTION ON UPDATE NO ACTION;

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
  ADD CONSTRAINT `fk_Producto_has_Pedido_Producto1` FOREIGN KEY (`Producto_idProducto`) REFERENCES `producto` (`idProducto`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Producto_has_Pedido_Pedido1` FOREIGN KEY (`Pedido_idPedido`) REFERENCES `pedido` (`idPedido`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
