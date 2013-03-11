SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

CREATE SCHEMA IF NOT EXISTS `_datos` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
USE `_datos` ;

-- -----------------------------------------------------
-- Table `_datos`.`categoria`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `_datos`.`categoria` (
  `idCategoria` INT(11) NOT NULL ,
  `cate_nomb` VARCHAR(45) NULL DEFAULT NULL ,
  PRIMARY KEY (`idCategoria`) )
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `_datos`.`tipopersona`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `_datos`.`tipopersona` (
  `idTipoPersona` INT(11) NOT NULL ,
  `tipo_pers` VARCHAR(45) NULL DEFAULT NULL ,
  PRIMARY KEY (`idTipoPersona`) )
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `_datos`.`persona`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `_datos`.`persona` (
  `idPersona` INT(11) NOT NULL ,
  `pers_nomb` VARCHAR(45) NULL DEFAULT NULL ,
  `pers_apel` VARCHAR(45) NULL DEFAULT NULL ,
  `pers_tele` VARCHAR(45) NULL DEFAULT NULL ,
  `pers_dire` VARCHAR(45) NULL DEFAULT NULL ,
  `TipoPersona_idTipoPersona` INT(11) NOT NULL ,
  PRIMARY KEY (`idPersona`, `TipoPersona_idTipoPersona`) ,
  INDEX `fk_Personas_TipoPersona1_idx` (`TipoPersona_idTipoPersona` ASC) ,
  CONSTRAINT `fk_Personas_TipoPersona1`
    FOREIGN KEY (`TipoPersona_idTipoPersona` )
    REFERENCES `_datos`.`tipopersona` (`idTipoPersona` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `_datos`.`producto`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `_datos`.`producto` (
  `idProducto` INT(11) NOT NULL ,
  `prod_nomb` VARCHAR(45) NULL DEFAULT NULL ,
  `prod_desc` VARCHAR(45) NULL DEFAULT NULL ,
  `prod_prec_comp` INT(11) NULL DEFAULT NULL ,
  `prod_prec_vent` INT(11) NULL DEFAULT NULL ,
  `prod_ruta_imag` VARCHAR(45) NULL DEFAULT NULL ,
  `categoria_idCategoria` INT(11) NOT NULL ,
  PRIMARY KEY (`idProducto`, `categoria_idCategoria`) ,
  INDEX `fk_producto_categoria_idx` (`categoria_idCategoria` ASC) ,
  CONSTRAINT `fk_producto_categoria`
    FOREIGN KEY (`categoria_idCategoria` )
    REFERENCES `_datos`.`categoria` (`idCategoria` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `_datos`.`pedido`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `_datos`.`pedido` (
  `idPedido` INT(11) NOT NULL ,
  `pedi_fech` DATETIME NULL DEFAULT NULL ,
  `pedi_cant` VARCHAR(45) NULL DEFAULT NULL ,
  `Personas_idPersona` INT(11) NOT NULL ,
  `idProducto` INT NULL ,
  PRIMARY KEY (`idPedido`, `Personas_idPersona`) ,
  INDEX `fk_Pedido_Personas1_idx` (`Personas_idPersona` ASC) ,
  INDEX (`idProducto` ASC) ,
  CONSTRAINT `fk_Pedido_Personas1`
    FOREIGN KEY (`Personas_idPersona` )
    REFERENCES `_datos`.`persona` (`idPersona` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `idProducto`
    FOREIGN KEY (`idProducto` )
    REFERENCES `_datos`.`producto` (`idProducto` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `_datos`.`producto_has_pedido`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `_datos`.`producto_has_pedido` (
  `Producto_idProducto` INT(11) NOT NULL ,
  `Pedido_idPedido` INT(11) NOT NULL ,
  PRIMARY KEY (`Producto_idProducto`, `Pedido_idPedido`) ,
  INDEX `fk_Producto_has_Pedido_Pedido1_idx` (`Pedido_idPedido` ASC) ,
  INDEX `fk_Producto_has_Pedido_Producto1_idx` (`Producto_idProducto` ASC) ,
  CONSTRAINT `fk_Producto_has_Pedido_Pedido1`
    FOREIGN KEY (`Pedido_idPedido` )
    REFERENCES `_datos`.`pedido` (`idPedido` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Producto_has_Pedido_Producto1`
    FOREIGN KEY (`Producto_idProducto` )
    REFERENCES `_datos`.`producto` (`idProducto` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

USE `_datos` ;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
