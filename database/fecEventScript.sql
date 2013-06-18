-- -----------------------------------------------------
-- Table `member`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `member` ;

CREATE  TABLE IF NOT EXISTS `member` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(255) NOT NULL ,
  `extId` INT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `eventType`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `eventType` ;

CREATE  TABLE IF NOT EXISTS `eventType` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(255) NOT NULL ,
  `description` TEXT NULL ,
  `class` ENUM('training','operation') NOT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mission`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mission` ;

CREATE  TABLE IF NOT EXISTS `mission` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(255) NOT NULL ,
  `filehash` VARCHAR(45) NULL ,
  `filename` VARCHAR(45) NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `server`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `server` ;

CREATE  TABLE IF NOT EXISTS `server` (
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
    REFERENCES `mission` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `event`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `event` ;

CREATE  TABLE IF NOT EXISTS `event` (
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
    REFERENCES `eventType` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_event_server1`
    FOREIGN KEY (`server_id` )
    REFERENCES `server` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_event_mission1`
    FOREIGN KEY (`mission_id` )
    REFERENCES `mission` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `slotGroup`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `slotGroup` ;

CREATE  TABLE IF NOT EXISTS `slotGroup` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(45) NOT NULL ,
  `event_id` INT NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_slotGroup_event1_idx` (`event_id` ASC) ,
  CONSTRAINT `fk_slotGroup_event1`
    FOREIGN KEY (`event_id` )
    REFERENCES `event` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `slot`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `slot` ;

CREATE  TABLE IF NOT EXISTS `slot` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(45) NOT NULL ,
  `slotGroup_id` INT NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_slot_slotGroup1_idx` (`slotGroup_id` ASC) ,
  CONSTRAINT `fk_slot_slotGroup1`
    FOREIGN KEY (`slotGroup_id` )
    REFERENCES `slotGroup` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `serverInfo`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `serverInfo` ;

CREATE  TABLE IF NOT EXISTS `serverInfo` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `date` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ,
  `server_id` INT NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_serverInfo_server1_idx` (`server_id` ASC) ,
  CONSTRAINT `fk_serverInfo_server1`
    FOREIGN KEY (`server_id` )
    REFERENCES `server` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `playerActiveItem`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `playerActiveItem` ;

CREATE  TABLE IF NOT EXISTS `playerActiveItem` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(255) NOT NULL ,
  `serverInfo_id` INT NOT NULL ,
  `member_id` INT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_playerActiveItem_serverInfo1_idx` (`serverInfo_id` ASC) ,
  INDEX `fk_playerActiveItem_member1_idx` (`member_id` ASC) ,
  CONSTRAINT `fk_playerActiveItem_serverInfo1`
    FOREIGN KEY (`serverInfo_id` )
    REFERENCES `serverInfo` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_playerActiveItem_member1`
    FOREIGN KEY (`member_id` )
    REFERENCES `member` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `registration`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `registration` ;

CREATE  TABLE IF NOT EXISTS `registration` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `member_id` INT NOT NULL ,
  `event_id` INT NOT NULL ,
  `slot_id` INT NULL ,
  `registrationDate` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ,
  `cancellationDate` TIMESTAMP NULL ,
  `firstSeen` INT NULL ,
  `lastSeen` INT NULL ,
  INDEX `fk_registration_member1_idx` (`member_id` ASC) ,
  INDEX `fk_registration_event1_idx` (`event_id` ASC) ,
  INDEX `fk_registration_slot1_idx` (`slot_id` ASC) ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_registration_playerActiveItem1_idx` (`firstSeen` ASC) ,
  INDEX `fk_registration_playerActiveItem2_idx` (`lastSeen` ASC) ,
  CONSTRAINT `fk_registration_member1`
    FOREIGN KEY (`member_id` )
    REFERENCES `member` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_registration_event1`
    FOREIGN KEY (`event_id` )
    REFERENCES `event` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_registration_slot1`
    FOREIGN KEY (`slot_id` )
    REFERENCES `slot` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_registration_playerActiveItem1`
    FOREIGN KEY (`firstSeen` )
    REFERENCES `playerActiveItem` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_registration_playerActiveItem2`
    FOREIGN KEY (`lastSeen` )
    REFERENCES `playerActiveItem` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `administrator`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `administrator` ;

CREATE  TABLE IF NOT EXISTS `administrator` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `username` VARCHAR(45) NOT NULL ,
  `password` VARCHAR(45) NOT NULL ,
  PRIMARY KEY (`id`) ,
  UNIQUE INDEX `username_UNIQUE` (`username` ASC) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `addon`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `addon` ;

CREATE  TABLE IF NOT EXISTS `addon` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(100) NOT NULL ,
  `link` VARCHAR(255) NULL ,
  `hash` VARCHAR(45) NULL ,
  `shortname` VARCHAR(45) NULL ,
  `type` ENUM('mod','map','other') NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `event_has_addon`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `event_has_addon` ;

CREATE  TABLE IF NOT EXISTS `event_has_addon` (
  `event_id` INT NOT NULL ,
  `addon_id` INT NOT NULL ,
  PRIMARY KEY (`event_id`, `addon_id`) ,
  INDEX `fk_event_has_addon_addon1_idx` (`addon_id` ASC) ,
  INDEX `fk_event_has_addon_event1_idx` (`event_id` ASC) ,
  CONSTRAINT `fk_event_has_addon_event1`
    FOREIGN KEY (`event_id` )
    REFERENCES `event` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_event_has_addon_addon1`
    FOREIGN KEY (`addon_id` )
    REFERENCES `addon` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `missionSlotGroup`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `missionSlotGroup` ;

CREATE  TABLE IF NOT EXISTS `missionSlotGroup` (
  `id` INT NOT NULL ,
  `name` VARCHAR(45) NULL ,
  `mission_id` INT NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_missionSlotGroup_mission1_idx` (`mission_id` ASC) ,
  CONSTRAINT `fk_missionSlotGroup_mission1`
    FOREIGN KEY (`mission_id` )
    REFERENCES `mission` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `missionSlot`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `missionSlot` ;

CREATE  TABLE IF NOT EXISTS `missionSlot` (
  `id` INT NOT NULL ,
  `name` VARCHAR(45) NULL ,
  `missionSlotGroup_id` INT NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_missionSlot_missionSlotGroup1_idx` (`missionSlotGroup_id` ASC) ,
  CONSTRAINT `fk_missionSlot_missionSlotGroup1`
    FOREIGN KEY (`missionSlotGroup_id` )
    REFERENCES `missionSlotGroup` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `server_has_addon`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `server_has_addon` ;

CREATE  TABLE IF NOT EXISTS `server_has_addon` (
  `server_id` INT NOT NULL ,
  `addon_id` INT NOT NULL ,
  PRIMARY KEY (`server_id`, `addon_id`) ,
  INDEX `fk_server_has_addon_addon1_idx` (`addon_id` ASC) ,
  INDEX `fk_server_has_addon_server1_idx` (`server_id` ASC) ,
  CONSTRAINT `fk_server_has_addon_server1`
    FOREIGN KEY (`server_id` )
    REFERENCES `server` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_server_has_addon_addon1`
    FOREIGN KEY (`addon_id` )
    REFERENCES `addon` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

