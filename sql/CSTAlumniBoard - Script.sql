-- MySQL Script generated by MySQL Workbench
-- 03/31/18 15:40:04
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema CSTAlumniBoard
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema CSTAlumniBoard
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `CSTAlumniBoard` DEFAULT CHARACTER SET utf8 ;
USE `CSTAlumniBoard` ;

-- -----------------------------------------------------
-- Table `CSTAlumniBoard`.`USER`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `CSTAlumniBoard`.`USER` (
  `userID` INT NOT NULL AUTO_INCREMENT,
  `email` VARCHAR(254) NOT NULL,
  `firstName` VARCHAR(45) NULL,
  `lastName` VARCHAR(45) NULL,
  `password` VARCHAR(40) NULL,
  `joinDate` DATETIME NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`userID`, `email`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `CSTAlumniBoard`.`FORUM`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `CSTAlumniBoard`.`FORUM` (
  `forumID` INT NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(100) NULL,
  `timeCreated` DATETIME NULL DEFAULT CURRENT_TIMESTAMP,
  `userID` INT NOT NULL,
  PRIMARY KEY (`forumID`),
  INDEX `fk_FORUM_USER1_idx` (`userID` ASC),
  CONSTRAINT `fk_FORUM_USER1`
    FOREIGN KEY (`userID`)
    REFERENCES `CSTAlumniBoard`.`USER` (`userID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `CSTAlumniBoard`.`THREAD`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `CSTAlumniBoard`.`THREAD` (
  `threadID` INT NOT NULL AUTO_INCREMENT,
  `topic` VARCHAR(100) NULL,
  `timeCreated` DATETIME NULL DEFAULT CURRENT_TIMESTAMP,
  `isPinned` TINYINT(1) NULL,
  `userID` INT NOT NULL,
  `forumID` INT NOT NULL,
  PRIMARY KEY (`threadID`),
  INDEX `fk_THREAD_USER1_idx` (`userID` ASC),
  INDEX `fk_THREAD_FORUM1_idx` (`forumID` ASC),
  CONSTRAINT `fk_THREAD_USER1`
    FOREIGN KEY (`userID`)
    REFERENCES `CSTAlumniBoard`.`USER` (`userID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_THREAD_FORUM1`
    FOREIGN KEY (`forumID`)
    REFERENCES `CSTAlumniBoard`.`FORUM` (`forumID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `CSTAlumniBoard`.`POST`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `CSTAlumniBoard`.`POST` (
  `postID` INT NOT NULL AUTO_INCREMENT,
  `content` TEXT NULL,
  `timePosted` DATETIME NULL DEFAULT CURRENT_TIMESTAMP,
  `isPinned` TINYINT(1) NULL,
  `isQuestion` TINYINT(1) NULL,
  `isReply` TINYINT(1) NULL,
  `threadID` INT NOT NULL,
  `userID` INT NOT NULL,
  `originalPostID` INT NULL,
  PRIMARY KEY (`postID`),
  INDEX `fk_POST_THREAD1_idx` (`threadID` ASC),
  INDEX `fk_POST_USER1_idx` (`userID` ASC),
  INDEX `fk_POST_POST1_idx` (`originalPostID` ASC),
  CONSTRAINT `fk_POST_THREAD1`
    FOREIGN KEY (`threadID`)
    REFERENCES `CSTAlumniBoard`.`THREAD` (`threadID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_POST_USER1`
    FOREIGN KEY (`userID`)
    REFERENCES `CSTAlumniBoard`.`USER` (`userID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_POST_POST1`
    FOREIGN KEY (`originalPostID`)
    REFERENCES `CSTAlumniBoard`.`POST` (`postID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `CSTAlumniBoard`.`ATTACHMENT`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `CSTAlumniBoard`.`ATTACHMENT` (
  `attachmentID` INT NOT NULL AUTO_INCREMENT,
  `fileName` VARCHAR(45) NULL,
  `fileType` VARCHAR(45) NULL,
  `postID` INT NOT NULL,
  PRIMARY KEY (`attachmentID`),
  INDEX `fk_ATTACHMENT_POST1_idx` (`postID` ASC),
  CONSTRAINT `fk_ATTACHMENT_POST1`
    FOREIGN KEY (`postID`)
    REFERENCES `CSTAlumniBoard`.`POST` (`postID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `CSTAlumniBoard`.`ROLE`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `CSTAlumniBoard`.`ROLE` (
  `roleID` INT NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(100) NULL,
  `userID` INT NOT NULL,
  PRIMARY KEY (`roleID`),
  INDEX `fk_ROLE_USER1_idx` (`userID` ASC),
  CONSTRAINT `fk_ROLE_USER1`
    FOREIGN KEY (`userID`)
    REFERENCES `CSTAlumniBoard`.`USER` (`userID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `CSTAlumniBoard`.`PRIVILEGE`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `CSTAlumniBoard`.`PRIVILEGE` (
  `privilegeID` INT NOT NULL AUTO_INCREMENT,
  `description` VARCHAR(100) NULL,
  `roleID` INT NOT NULL,
  PRIMARY KEY (`privilegeID`),
  INDEX `fk_PRIVILEGE_ROLE_idx` (`roleID` ASC),
  CONSTRAINT `fk_PRIVILEGE_ROLE`
    FOREIGN KEY (`roleID`)
    REFERENCES `CSTAlumniBoard`.`ROLE` (`roleID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
