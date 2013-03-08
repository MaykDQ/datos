SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

CREATE SCHEMA IF NOT EXISTS ` getread2_univer_m` DEFAULT CHARACTER SET utf8 ;
USE ` getread2_univer_m` ;

-- -----------------------------------------------------
-- Table ` getread2_univer_m`.`TipoPersona`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS ` getread2_univer_m`.`TipoPersona` (
  `idTipoPersona` INT NOT NULL ,
  `tipo_pers` VARCHAR(45) NULL ,
  PRIMARY KEY (`idTipoPersona`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table ` getread2_univer_m`.`Persona`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS ` getread2_univer_m`.`Persona` (
  `idPersona` INT NOT NULL ,
  `pers_nomb` VARCHAR(45) NULL DEFAULT NULL ,
  `pers_apel` VARCHAR(45) NULL DEFAULT NULL ,
  `pers_tele` VARCHAR(45) NULL DEFAULT NULL ,
  `empl_dire` VARCHAR(45) NULL DEFAULT NULL ,
  `TipoPersona_idTipoPersona` INT NOT NULL ,
  PRIMARY KEY (`idPersona`) ,
  INDEX `fk_Personas_TipoPersona1_idx` (`TipoPersona_idTipoPersona` ASC) ,
  CONSTRAINT `fk_Personas_TipoPersona1`
    FOREIGN KEY (`TipoPersona_idTipoPersona` )
    REFERENCES ` getread2_univer_m`.`TipoPersona` (`idTipoPersona` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table ` getread2_univer_m`.`Categoria`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS ` getread2_univer_m`.`Categoria` (
  `idCategoria` INT NOT NULL ,
  `cate_nomb` VARCHAR(45) NULL DEFAULT NULL ,
  PRIMARY KEY (`idCategoria`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table ` getread2_univer_m`.`Producto`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS ` getread2_univer_m`.`Producto` (
  `idProducto` INT NOT NULL ,
  `prod_nomb` VARCHAR(45) NULL DEFAULT NULL ,
  `prod_desc` VARCHAR(45) NULL DEFAULT NULL ,
  `prod_prec_comp` INT NULL DEFAULT NULL ,
  `prod_prec_vent` VARCHAR(45) NULL DEFAULT NULL ,
  `prod_ruta_imag` VARCHAR(45) NULL DEFAULT NULL ,
  `categoria_idCategoria` INT NOT NULL ,
  PRIMARY KEY (`idProducto`) ,
  INDEX `fk_producto_categoria_idx` (`categoria_idCategoria` ASC) ,
  CONSTRAINT `fk_producto_categoria`
    FOREIGN KEY (`categoria_idCategoria` )
    REFERENCES ` getread2_univer_m`.`Categoria` (`idCategoria` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table ` getread2_univer_m`.`Pedido`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS ` getread2_univer_m`.`Pedido` (
  `idPedido` INT NOT NULL ,
  `pedi_fech` DATETIME NULL DEFAULT NULL ,
  `pedi_cant` VARCHAR(45) NULL DEFAULT NULL ,
  `Personas_idPersona` INT NULL ,
  PRIMARY KEY (`idPedido`) ,
  INDEX `fk_Pedido_Personas1_idx` (`Personas_idPersona` ASC) ,
  CONSTRAINT `fk_Pedido_Personas1`
    FOREIGN KEY (`Personas_idPersona` )
    REFERENCES ` getread2_univer_m`.`Persona` (`idPersona` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table ` getread2_univer_m`.`Producto_has_Pedido`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS ` getread2_univer_m`.`Producto_has_Pedido` (
  `Producto_idProducto` INT NULL ,
  `Pedido_idPedido` INT NULL ,
  PRIMARY KEY (`Producto_idProducto`, `Pedido_idPedido`) ,
  INDEX `fk_Producto_has_Pedido_Pedido1_idx` (`Pedido_idPedido` ASC) ,
  INDEX `fk_Producto_has_Pedido_Producto1_idx` (`Producto_idProducto` ASC) ,
  CONSTRAINT `fk_Producto_has_Pedido_Producto1`
    FOREIGN KEY (`Producto_idProducto` )
    REFERENCES ` getread2_univer_m`.`Producto` (`idProducto` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Producto_has_Pedido_Pedido1`
    FOREIGN KEY (`Pedido_idPedido` )
    REFERENCES ` getread2_univer_m`.`Pedido` (`idPedido` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

USE ` getread2_univer_m` ;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
