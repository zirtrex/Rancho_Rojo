-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema rancho_rojo
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema rancho_rojo
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `rancho_rojo` DEFAULT CHARACTER SET utf8 COLLATE utf8_spanish2_ci ;
USE `rancho_rojo` ;

-- -----------------------------------------------------
-- Table `rancho_rojo`.`usuario`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `rancho_rojo`.`usuario` ;

CREATE TABLE IF NOT EXISTS `rancho_rojo`.`usuario` (
  `codUsuario` INT(11) NOT NULL AUTO_INCREMENT,
  `rol` ENUM('admin', 'user') NOT NULL,
  `usuario` VARCHAR(45) NOT NULL,
  `clave` VARCHAR(100) NOT NULL,
  `nombres` VARCHAR(45) NULL,
  `primerApellido` VARCHAR(45) NULL,
  `segundoApellido` VARCHAR(45) NULL,
  PRIMARY KEY (`codUsuario`),
  UNIQUE INDEX `usuario_UNIQUE` (`usuario` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `rancho_rojo`.`terrenos`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `rancho_rojo`.`terrenos` ;

CREATE TABLE IF NOT EXISTS `rancho_rojo`.`terrenos` (
  `codTerreno` INT(11) NOT NULL AUTO_INCREMENT,
  `codigo` VARCHAR(45) NULL,
  `lote` VARCHAR(45) NULL,
  `nombre` VARCHAR(45) NULL,
  `precio` DECIMAL(10,2) NULL,
  `inicial` DECIMAL(10,2) NULL,
  `saldo` DECIMAL(10,2) NULL,
  `vendido` ENUM('Si', 'No') NOT NULL,
  `fechaVenta` DATETIME NULL,
  `cuotas` VARCHAR(45) NULL,
  `cordenadas` TINYTEXT NULL,
  `nombresComprador` VARCHAR(45) NULL,
  `apellidosComprador` VARCHAR(45) NULL,
  `telefonoComprador` VARCHAR(20) NULL,
  PRIMARY KEY (`codTerreno`),
  UNIQUE INDEX `codigo_UNIQUE` (`codigo` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `rancho_rojo`.`pagos`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `rancho_rojo`.`pagos` ;

CREATE TABLE IF NOT EXISTS `rancho_rojo`.`pagos` (
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
    REFERENCES `rancho_rojo`.`terrenos` (`codTerreno`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_pagos_usuario1`
    FOREIGN KEY (`codUsuario`)
    REFERENCES `rancho_rojo`.`usuario` (`codUsuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

-- -----------------------------------------------------
-- Data for table `rancho_rojo`.`usuario`
-- -----------------------------------------------------
START TRANSACTION;
USE `rancho_rojo`;
INSERT INTO `rancho_rojo`.`usuario` (`codUsuario`, `rol`, `usuario`, `clave`, `nombres`, `primerApellido`, `segundoApellido`) VALUES (DEFAULT, 'admin', 'zirtrex', 'zirtrex', 'Rafael', 'Contreras', 'Martinez');
INSERT INTO `rancho_rojo`.`usuario` (`codUsuario`, `rol`, `usuario`, `clave`, `nombres`, `primerApellido`, `segundoApellido`) VALUES (DEFAULT, 'user', 'manchundia', 'manchundia', 'MARIA EULALIA', 'ANCHUNDIA', 'PARRALES');

COMMIT;


-- -----------------------------------------------------
-- Data for table `rancho_rojo`.`terrenos`
-- -----------------------------------------------------
START TRANSACTION;
USE `rancho_rojo`;
INSERT INTO `rancho_rojo`.`terrenos` (`codTerreno`, `codigo`, `lote`, `nombre`, `precio`, `inicial`, `saldo`, `vendido`, `fechaVenta`, `cuotas`, `cordenadas`, `nombresComprador`, `apellidosComprador`, `telefonoComprador`) VALUES (DEFAULT, '7642792', 'Lote_1', '1', 50000, NULL, 49900, 'Si', NULL, NULL, '{\"lat\":-0.57054, \"lng\":-80.38853}', 'Rafael', 'Contreras', '966102508');
INSERT INTO `rancho_rojo`.`terrenos` (`codTerreno`, `codigo`, `lote`, `nombre`, `precio`, `inicial`, `saldo`, `vendido`, `fechaVenta`, `cuotas`, `cordenadas`, `nombresComprador`, `apellidosComprador`, `telefonoComprador`) VALUES (DEFAULT, '3849145', 'Lote_2', '40', 65000, NULL, 64900, 'Si', NULL, NULL, '{\"lat\":-0.57054, \"lng\":-80.38806}', NULL, NULL, NULL);
INSERT INTO `rancho_rojo`.`terrenos` (`codTerreno`, `codigo`, `lote`, `nombre`, `precio`, `inicial`, `saldo`, `vendido`, `fechaVenta`, `cuotas`, `cordenadas`, `nombresComprador`, `apellidosComprador`, `telefonoComprador`) VALUES (DEFAULT, '1100201', 'Lote_3', '1', 38000, NULL, 38000, 'No', NULL, NULL, '{\"lat\":-0.57049, \"lng\":-80.38742}', NULL, NULL, NULL);
INSERT INTO `rancho_rojo`.`terrenos` (`codTerreno`, `codigo`, `lote`, `nombre`, `precio`, `inicial`, `saldo`, `vendido`, `fechaVenta`, `cuotas`, `cordenadas`, `nombresComprador`, `apellidosComprador`, `telefonoComprador`) VALUES (DEFAULT, '1917821', 'Lote_4', '4', 90000, NULL, 90000, 'No', NULL, NULL, '{\"lat\": 0.040472, \"lng\": -78.1476487}', NULL, NULL, NULL);
INSERT INTO `rancho_rojo`.`terrenos` (`codTerreno`, `codigo`, `lote`, `nombre`, `precio`, `inicial`, `saldo`, `vendido`, `fechaVenta`, `cuotas`, `cordenadas`, `nombresComprador`, `apellidosComprador`, `telefonoComprador`) VALUES (DEFAULT, '10715056', 'Lote_4', '5', 97000, NULL, 96900, 'Si', NULL, NULL, '{\"lat\":0.0404, \"lng\":-78.14542}', NULL, NULL, NULL);
INSERT INTO `rancho_rojo`.`terrenos` (`codTerreno`, `codigo`, `lote`, `nombre`, `precio`, `inicial`, `saldo`, `vendido`, `fechaVenta`, `cuotas`, `cordenadas`, `nombresComprador`, `apellidosComprador`, `telefonoComprador`) VALUES (DEFAULT, '3714459', 'Lote_5', '6', 45600, NULL, 45500, 'Si', NULL, NULL, '{\"lat\": 0.03968, \"lng\": -78.14566}', 'Pedro ', 'Peña', '976564122');

COMMIT;


-- -----------------------------------------------------
-- Data for table `rancho_rojo`.`pagos`
-- -----------------------------------------------------
START TRANSACTION;
USE `rancho_rojo`;
INSERT INTO `rancho_rojo`.`pagos` (`codPago`, `numeroCuota`, `fechaPago`, `formaPago`, `valor`, `saldoAFecha`, `comprobante`, `codTerreno`, `codUsuario`, `fechaCreacion`) VALUES (DEFAULT, 1, '2013-04-04', 'Cheque', 100, NULL, NULL, 1, 2, NULL);
INSERT INTO `rancho_rojo`.`pagos` (`codPago`, `numeroCuota`, `fechaPago`, `formaPago`, `valor`, `saldoAFecha`, `comprobante`, `codTerreno`, `codUsuario`, `fechaCreacion`) VALUES (DEFAULT, 2, '2013-08-16', 'Transferencia', 100, NULL, NULL, 2, 2, NULL);
INSERT INTO `rancho_rojo`.`pagos` (`codPago`, `numeroCuota`, `fechaPago`, `formaPago`, `valor`, `saldoAFecha`, `comprobante`, `codTerreno`, `codUsuario`, `fechaCreacion`) VALUES (DEFAULT, 3, '2013-11-13', 'Tarjeta', 100, NULL, NULL, 3, 2, NULL);

COMMIT;

