SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';


-- -----------------------------------------------------
-- Table `fec`.`member`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `fec`.`member` ;

CREATE  TABLE IF NOT EXISTS `fec`.`member` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(255) NOT NULL ,
  `extId` INT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `fec`.`eventType`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `fec`.`eventType` ;

CREATE  TABLE IF NOT EXISTS `fec`.`eventType` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(255) NOT NULL ,
  `description` TEXT NULL ,
  `class` ENUM('training','operation') NOT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `fec`.`mission`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `fec`.`mission` ;

CREATE  TABLE IF NOT EXISTS `fec`.`mission` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(255) NOT NULL ,
  `filehash` VARCHAR(45) NULL ,
  `filename` VARCHAR(45) NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `fec`.`server`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `fec`.`server` ;

CREATE  TABLE IF NOT EXISTS `fec`.`server` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(255) NOT NULL ,
  `ip` VARCHAR(45) NULL ,
  `mission_id` INT NULL ,
  `hostname` VARCHAR(255) NULL ,
  `maxPlayer` INT NULL ,
  `passwordProtected` TINYINT(1) NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_server_mission1_idx` (`mission_id` ASC) ,
  CONSTRAINT `fk_server_mission1`
    FOREIGN KEY (`mission_id` )
    REFERENCES `fec`.`mission` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `fec`.`event`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `fec`.`event` ;

CREATE  TABLE IF NOT EXISTS `fec`.`event` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `eventType_id` INT NOT NULL ,
  `server_id` INT NOT NULL ,
  `name` VARCHAR(255) NOT NULL ,
  `date` TIMESTAMP NOT NULL ,
  `duration` INT NULL ,
  `description` TEXT NULL ,
  `mission_id` INT NULL ,
  `slotFreeRegistration` TINYINT(1) NOT NULL DEFAULT TRUE ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_event_fortbildungType_idx` (`eventType_id` ASC) ,
  INDEX `fk_event_server1_idx` (`server_id` ASC) ,
  INDEX `fk_event_mission1_idx` (`mission_id` ASC) ,
  CONSTRAINT `fk_event_fortbildungType`
    FOREIGN KEY (`eventType_id` )
    REFERENCES `fec`.`eventType` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_event_server1`
    FOREIGN KEY (`server_id` )
    REFERENCES `fec`.`server` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_event_mission1`
    FOREIGN KEY (`mission_id` )
    REFERENCES `fec`.`mission` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `fec`.`slotGroup`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `fec`.`slotGroup` ;

CREATE  TABLE IF NOT EXISTS `fec`.`slotGroup` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(45) NOT NULL ,
  `event_id` INT NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_slotGroup_event1_idx` (`event_id` ASC) ,
  CONSTRAINT `fk_slotGroup_event1`
    FOREIGN KEY (`event_id` )
    REFERENCES `fec`.`event` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `fec`.`slot`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `fec`.`slot` ;

CREATE  TABLE IF NOT EXISTS `fec`.`slot` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(45) NOT NULL ,
  `slotGroup_id` INT NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_slot_slotGroup1_idx` (`slotGroup_id` ASC) ,
  CONSTRAINT `fk_slot_slotGroup1`
    FOREIGN KEY (`slotGroup_id` )
    REFERENCES `fec`.`slotGroup` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `fec`.`serverInfo`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `fec`.`serverInfo` ;

CREATE  TABLE IF NOT EXISTS `fec`.`serverInfo` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `date` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ,
  `server_id` INT NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_serverInfo_server1_idx` (`server_id` ASC) ,
  CONSTRAINT `fk_serverInfo_server1`
    FOREIGN KEY (`server_id` )
    REFERENCES `fec`.`server` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `fec`.`playerActiveItem`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `fec`.`playerActiveItem` ;

CREATE  TABLE IF NOT EXISTS `fec`.`playerActiveItem` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(255) NOT NULL ,
  `serverInfo_id` INT NOT NULL ,
  `member_id` INT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_playerActiveItem_serverInfo1_idx` (`serverInfo_id` ASC) ,
  INDEX `fk_playerActiveItem_member1_idx` (`member_id` ASC) ,
  CONSTRAINT `fk_playerActiveItem_serverInfo1`
    FOREIGN KEY (`serverInfo_id` )
    REFERENCES `fec`.`serverInfo` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_playerActiveItem_member1`
    FOREIGN KEY (`member_id` )
    REFERENCES `fec`.`member` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `fec`.`anmeldung`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `fec`.`anmeldung` ;

CREATE  TABLE IF NOT EXISTS `fec`.`anmeldung` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `member_id` INT NOT NULL ,
  `event_id` INT NOT NULL ,
  `slot_id` INT NULL ,
  `registrationDate` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ,
  `cancellationDate` TIMESTAMP NULL ,
  `firstSeen` INT NULL ,
  `lastSeen` INT NULL ,
  INDEX `fk_anmeldung_member1_idx` (`member_id` ASC) ,
  INDEX `fk_anmeldung_event1_idx` (`event_id` ASC) ,
  INDEX `fk_anmeldung_slot1_idx` (`slot_id` ASC) ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_anmeldung_playerActiveItem1_idx` (`firstSeen` ASC) ,
  INDEX `fk_anmeldung_playerActiveItem2_idx` (`lastSeen` ASC) ,
  CONSTRAINT `fk_anmeldung_member1`
    FOREIGN KEY (`member_id` )
    REFERENCES `fec`.`member` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_anmeldung_event1`
    FOREIGN KEY (`event_id` )
    REFERENCES `fec`.`event` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_anmeldung_slot1`
    FOREIGN KEY (`slot_id` )
    REFERENCES `fec`.`slot` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_anmeldung_playerActiveItem1`
    FOREIGN KEY (`firstSeen` )
    REFERENCES `fec`.`playerActiveItem` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_anmeldung_playerActiveItem2`
    FOREIGN KEY (`lastSeen` )
    REFERENCES `fec`.`playerActiveItem` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `fec`.`administrator`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `fec`.`administrator` ;

CREATE  TABLE IF NOT EXISTS `fec`.`administrator` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `username` VARCHAR(45) NOT NULL ,
  `password` VARCHAR(45) NOT NULL ,
  PRIMARY KEY (`id`) ,
  UNIQUE INDEX `username_UNIQUE` (`username` ASC) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `fec`.`addon`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `fec`.`addon` ;

CREATE  TABLE IF NOT EXISTS `fec`.`addon` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(100) NOT NULL ,
  `link` VARCHAR(255) NULL ,
  `hash` VARCHAR(45) NULL ,
  `shortname` VARCHAR(45) NULL ,
  `type` ENUM('mod','map','other') NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `fec`.`event_has_addon`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `fec`.`event_has_addon` ;

CREATE  TABLE IF NOT EXISTS `fec`.`event_has_addon` (
  `event_id` INT NOT NULL ,
  `addon_id` INT NOT NULL ,
  PRIMARY KEY (`event_id`, `addon_id`) ,
  INDEX `fk_event_has_addon_addon1_idx` (`addon_id` ASC) ,
  INDEX `fk_event_has_addon_event1_idx` (`event_id` ASC) ,
  CONSTRAINT `fk_event_has_addon_event1`
    FOREIGN KEY (`event_id` )
    REFERENCES `fec`.`event` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_event_has_addon_addon1`
    FOREIGN KEY (`addon_id` )
    REFERENCES `fec`.`addon` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `fec`.`missionSlotGroup`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `fec`.`missionSlotGroup` ;

CREATE  TABLE IF NOT EXISTS `fec`.`missionSlotGroup` (
  `id` INT NOT NULL ,
  `name` VARCHAR(45) NULL ,
  `mission_id` INT NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_missionSlotGroup_mission1_idx` (`mission_id` ASC) ,
  CONSTRAINT `fk_missionSlotGroup_mission1`
    FOREIGN KEY (`mission_id` )
    REFERENCES `fec`.`mission` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `fec`.`missionSlot`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `fec`.`missionSlot` ;

CREATE  TABLE IF NOT EXISTS `fec`.`missionSlot` (
  `id` INT NOT NULL ,
  `name` VARCHAR(45) NULL ,
  `missionSlotGroup_id` INT NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_missionSlot_missionSlotGroup1_idx` (`missionSlotGroup_id` ASC) ,
  CONSTRAINT `fk_missionSlot_missionSlotGroup1`
    FOREIGN KEY (`missionSlotGroup_id` )
    REFERENCES `fec`.`missionSlotGroup` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `fec`.`server_has_addon`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `fec`.`server_has_addon` ;

CREATE  TABLE IF NOT EXISTS `fec`.`server_has_addon` (
  `server_id` INT NOT NULL ,
  `addon_id` INT NOT NULL ,
  PRIMARY KEY (`server_id`, `addon_id`) ,
  INDEX `fk_server_has_addon_addon1_idx` (`addon_id` ASC) ,
  INDEX `fk_server_has_addon_server1_idx` (`server_id` ASC) ,
  CONSTRAINT `fk_server_has_addon_server1`
    FOREIGN KEY (`server_id` )
    REFERENCES `fec`.`server` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_server_has_addon_addon1`
    FOREIGN KEY (`addon_id` )
    REFERENCES `fec`.`addon` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;



SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
