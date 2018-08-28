-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema db744451699
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema db744451699
-- -----------------------------------------------------
USE `db744451699` ;

-- -----------------------------------------------------
-- Table `db744451699`.`usuario`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `db744451699`.`usuario` ;

CREATE TABLE IF NOT EXISTS `db744451699`.`usuario` (
  `codUsuario` INT(11) NOT NULL AUTO_INCREMENT,
  `rol` ENUM('admin', 'user') NOT NULL,
  `usuario` VARCHAR(45) NOT NULL,
  `clave` VARCHAR(100) NOT NULL,
  `nombres` VARCHAR(45) NULL,
  `primerApellido` VARCHAR(45) NULL,
  `segundoApellido` VARCHAR(45) NULL,
  `imagenPerfil` VARCHAR(200) NULL,
  PRIMARY KEY (`codUsuario`),
  UNIQUE INDEX `usuario_UNIQUE` (`usuario` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `db744451699`.`terrenos`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `db744451699`.`terrenos` ;

CREATE TABLE IF NOT EXISTS `db744451699`.`terrenos` (
  `codTerreno` INT(11) NOT NULL AUTO_INCREMENT,
  `manzana` VARCHAR(15) NOT NULL,
  `codigoLote` VARCHAR(45) NULL,
  `lote` VARCHAR(45) NULL,
  `nombre` VARCHAR(45) NULL,
  `tamanio` VARCHAR(45) NULL,
  `escrituras` VARCHAR(45) NULL,
  `registroPropiedad` VARCHAR(45) NULL,
  `precio` DECIMAL(10,2) NULL,
  `inicial` DECIMAL(10,2) NULL,
  `saldo` DECIMAL(10,2) NULL,
  `vendido` ENUM('Si', 'Libre', 'En proceso') NULL,
  `fechaVenta` DATETIME NULL,
  `cuotas` VARCHAR(10) NULL,
  `montoPagar` DECIMAL(10,2) NULL,
  `cordenadas` TINYTEXT NULL,
  `cedulaComprador` VARCHAR(12) NULL,
  `nombresComprador` VARCHAR(45) NULL,
  `apellidosComprador` VARCHAR(45) NULL,
  `telefonoComprador` VARCHAR(20) NULL,
  `direccionComprador` VARCHAR(200) NULL,
  PRIMARY KEY (`codTerreno`),
  UNIQUE INDEX `codigo_UNIQUE` (`codigoLote` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `db744451699`.`pagos`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `db744451699`.`pagos` ;

CREATE TABLE IF NOT EXISTS `db744451699`.`pagos` (
  `codPago` INT(11) NOT NULL AUTO_INCREMENT,
  `numeroCuota` INT(4) NULL,
  `fechaPago` DATETIME NULL,
  `formaPago` VARCHAR(45) NULL,
  `valor` DECIMAL(10,2) NULL,
  `saldoAFecha` DECIMAL(10,2) NULL,
  `comprobante` VARCHAR(200) NULL,
  `codTerreno` INT(11) NOT NULL,
  `codUsuario` INT(11) NOT NULL,
  `fechaCreacion` DATETIME NULL,
  PRIMARY KEY (`codPago`, `codTerreno`, `codUsuario`),
  INDEX `fk_pagos_terrenos_idx` (`codTerreno` ASC),
  INDEX `fk_pagos_usuario1_idx` (`codUsuario` ASC),
  CONSTRAINT `fk_pagos_terrenos`
    FOREIGN KEY (`codTerreno`)
    REFERENCES `db744451699`.`terrenos` (`codTerreno`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_pagos_usuario1`
    FOREIGN KEY (`codUsuario`)
    REFERENCES `db744451699`.`usuario` (`codUsuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

-- -----------------------------------------------------
-- Data for table `db744451699`.`usuario`
-- -----------------------------------------------------
START TRANSACTION;
USE `db744451699`;
INSERT INTO `db744451699`.`usuario` (`codUsuario`, `rol`, `usuario`, `clave`, `nombres`, `primerApellido`, `segundoApellido`, `imagenPerfil`) VALUES (DEFAULT, 'admin', 'zirtrex', 'zirtrex', 'Rafael', 'Contreras', 'Martinez', NULL);
INSERT INTO `db744451699`.`usuario` (`codUsuario`, `rol`, `usuario`, `clave`, `nombres`, `primerApellido`, `segundoApellido`, `imagenPerfil`) VALUES (DEFAULT, 'user', 'manchundia', 'manchundia', 'MARIA EULALIA', 'ANCHUNDIA', 'PARRALES', NULL);

COMMIT;


-- -----------------------------------------------------
-- Data for table `db744451699`.`terrenos`
-- -----------------------------------------------------
START TRANSACTION;
USE `db744451699`;
INSERT INTO `db744451699`.`terrenos` (`codTerreno`, `manzana`, `codigoLote`, `lote`, `nombre`, `tamanio`, `escrituras`, `registroPropiedad`, `precio`, `inicial`, `saldo`, `vendido`, `fechaVenta`, `cuotas`, `montoPagar`, `cordenadas`, `cedulaComprador`, `nombresComprador`, `apellidosComprador`, `telefonoComprador`, `direccionComprador`) VALUES (DEFAULT, 'Manzana_2', '1100201', '1', NULL, '200mts2', 'Si', 'No', 10000, 2000, 8000, 'Si', '2017-04-15', '12', 800, NULL, NULL, 'Jorge', 'Peña', NULL, NULL);
INSERT INTO `db744451699`.`terrenos` (`codTerreno`, `manzana`, `codigoLote`, `lote`, `nombre`, `tamanio`, `escrituras`, `registroPropiedad`, `precio`, `inicial`, `saldo`, `vendido`, `fechaVenta`, `cuotas`, `montoPagar`, `cordenadas`, `cedulaComprador`, `nombresComprador`, `apellidosComprador`, `telefonoComprador`, `direccionComprador`) VALUES (DEFAULT, 'Manzana_1', '', '3', NULL, NULL, NULL, NULL, 10000, 2000, 8000, 'En proceso', '2017-04-15', '36', 200, NULL, NULL, 'Max', 'Paredes', NULL, NULL);

COMMIT;

