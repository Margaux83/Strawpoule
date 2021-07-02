<?php

register_activation_hook( POULE_MAIN_FILE, 'poule_install');

register_deactivation_hook( POULE_MAIN_FILE, 'poule_uninstall');

function poule_install(){
    global $wpdb;

    $poule_table_name = $wpdb->prefix . 'poule';


    $sql ="CREATE SCHEMA IF NOT EXISTS `mydb` DEFAULT CHARACTER SET utf8 ;
USE `mydb` ;

-- -----------------------------------------------------
-- Table `mydb`.`Sondage_question`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`Sondage_question` (
  `id` INT(10) NOT NULL AUTO_INCREMENT,
  `titre` VARCHAR(255) NOT NULL,
  `question` VARCHAR(255) NOT NULL,
  `type` TINYINT(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC) VISIBLE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`reponse`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`reponse` (
  `id` INT(10) NOT NULL AUTO_INCREMENT,
  `Sondage_question_id` INT(10) NOT NULL,
  `reponse` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC) VISIBLE,
  INDEX `fk_reponse_Sondage_question_idx` (`Sondage_question_id` ASC) VISIBLE,
  CONSTRAINT `fk_reponse_Sondage_question`
    FOREIGN KEY (`Sondage_question_id`)
    REFERENCES `mydb`.`Sondage_question` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`resultat`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`resultat` (
  `id` INT(10) NOT NULL AUTO_INCREMENT,
  `ip` VARCHAR(255) NULL,
  `reponse_id` INT(10) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC) VISIBLE,
  INDEX `fk_resultat_reponse1_idx` (`reponse_id` ASC) VISIBLE,
  CONSTRAINT `fk_resultat_reponse1`
    FOREIGN KEY (`reponse_id`)
    REFERENCES `mydb`.`reponse` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
";
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta ($sql);


}
function poule_uninstall(){
    global $wpdb;

    $poule_table_name = $wpdb->prefix . 'poule';


    $query = "DROP TABLE ".$poule_table_name;

    $wpdb->query($query);


}