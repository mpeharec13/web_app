-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema iwa_2019_zb_projekt
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema iwa_2019_zb_projekt
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `iwa_2019_zb_projekt` DEFAULT CHARACTER SET utf8 ;
USE `iwa_2019_zb_projekt` ;

-- -----------------------------------------------------
-- Table `iwa_2019_zb_projekt`.`tip_korisnika`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `iwa_2019_zb_projekt`.`tip_korisnika` (
  `tip_id` INT(10) NOT NULL AUTO_INCREMENT,
  `naziv` VARCHAR(20) NOT NULL,
  PRIMARY KEY (`tip_id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `iwa_2019_zb_projekt`.`korisnik`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `iwa_2019_zb_projekt`.`korisnik` (
  `korisnik_id` INT(10) NOT NULL AUTO_INCREMENT,
  `tip_id` INT(10) NOT NULL,
  `korisnicko_ime` VARCHAR(50) NOT NULL,
  `lozinka` VARCHAR(50) NOT NULL,
  `ime` VARCHAR(50) NULL,
  `prezime` VARCHAR(50) NULL,
  `email` VARCHAR(50) NULL,
  `slika` TEXT NULL,
  PRIMARY KEY (`korisnik_id`),
  INDEX `fk_korisnik_tip_korisnika_idx` (`tip_id` ASC),
  CONSTRAINT `fk_korisnik_tip_korisnika`
    FOREIGN KEY (`tip_id`)
    REFERENCES `iwa_2019_zb_projekt`.`tip_korisnika` (`tip_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `iwa_2019_zb_projekt`.`kategorija`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `iwa_2019_zb_projekt`.`kategorija` (
  `kategorija_id` INT(10) NOT NULL AUTO_INCREMENT,
  `naziv` VARCHAR(50) NOT NULL,
  `opis` TEXT NULL,
  `obavezna` TINYINT(1) NOT NULL,
  PRIMARY KEY (`kategorija_id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `iwa_2019_zb_projekt`.`projekt`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `iwa_2019_zb_projekt`.`projekt` (
  `projekt_id` INT(10) NOT NULL AUTO_INCREMENT,
  `korisnik_id` INT(10) NOT NULL,
  `moderator_id` INT(10) NOT NULL,
  `datum_vrijeme_kreiranja` DATETIME NOT NULL,
  `naziv` VARCHAR(45) NULL,
  `opis` TEXT NULL,
  `zakljucan` TINYINT(1) NOT NULL,
  INDEX `fk_tvrtka_has_korisnik_korisnik1_idx` (`korisnik_id` ASC),
  PRIMARY KEY (`projekt_id`),
  INDEX `fk_projekt_korisnik1_idx` (`moderator_id` ASC),
  CONSTRAINT `fk_tvrtka_has_korisnik_korisnik1`
    FOREIGN KEY (`korisnik_id`)
    REFERENCES `iwa_2019_zb_projekt`.`korisnik` (`korisnik_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_projekt_korisnik1`
    FOREIGN KEY (`moderator_id`)
    REFERENCES `iwa_2019_zb_projekt`.`korisnik` (`korisnik_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `iwa_2019_zb_projekt`.`stavke_projekta`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `iwa_2019_zb_projekt`.`stavke_projekta` (
  `projekt_id` INT(10) NOT NULL,
  `kategorija_id` INT(10) NOT NULL,
  `opis` TEXT NOT NULL,
  `slika` TEXT NOT NULL,
  `video` TEXT NULL,
  PRIMARY KEY (`projekt_id`, `kategorija_id`),
  INDEX `fk_projekt_ima_kategoriju_kategorija1_idx` (`kategorija_id` ASC),
  INDEX `fk_projekt_ima_kategoriju_projekt1_idx` (`projekt_id` ASC),
  CONSTRAINT `fk_projekt_ima_kategoriju_kategorija1`
    FOREIGN KEY (`kategorija_id`)
    REFERENCES `iwa_2019_zb_projekt`.`kategorija` (`kategorija_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_projekt_ima_kategoriju_projekt1`
    FOREIGN KEY (`projekt_id`)
    REFERENCES `iwa_2019_zb_projekt`.`projekt` (`projekt_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE USER 'iwa_2019'@'localhost' IDENTIFIED BY 'foi2019';

GRANT SELECT, INSERT, TRIGGER, UPDATE, DELETE ON TABLE `iwa_2019_zb_projekt`.* TO 'iwa_2019'@'localhost';

SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
