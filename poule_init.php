<?php

register_activation_hook( POULE_MAIN_FILE, 'poule_install');

register_deactivation_hook( POULE_MAIN_FILE, 'poule_uninstall');

function poule_install(){
        global $wpdb;
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');


    $poule_table_name = $wpdb->prefix . 'poule_';


    $sql ="CREATE TABLE IF NOT EXISTS ".$poule_table_name."question (
  id INT(10) NOT NULL AUTO_INCREMENT,
  titre VARCHAR(255) NOT NULL,
  question VARCHAR(255) NOT NULL,
  type TINYINT(1) NOT NULL,
  PRIMARY KEY (id),
  UNIQUE INDEX id_UNIQUE (id ASC))
ENGINE = InnoDB;


CREATE TABLE IF NOT EXISTS ".$poule_table_name."reponse (
  id INT(10) NOT NULL AUTO_INCREMENT,
  question_id INT(10) NOT NULL,
  reponse VARCHAR(255) NOT NULL,
  PRIMARY KEY (id),
  UNIQUE INDEX id_UNIQUE (id ASC),
  INDEX fk_reponse_question_idx (question_id ASC),
  CONSTRAINT fk_reponse_question
    FOREIGN KEY (question_id)
    REFERENCES question (id)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS ".$poule_table_name."resultat (
  id INT(10) NOT NULL AUTO_INCREMENT,
  ip VARCHAR(255) NULL,
  reponse_id INT(10) NOT NULL,
  PRIMARY KEY (id),
  UNIQUE INDEX id_UNIQUE (id ASC),
  INDEX fk_resultat_reponse1_idx (reponse_id ASC),
  CONSTRAINT fk_resultat_reponse1
    FOREIGN KEY (reponse_id)
    REFERENCES reponse (id)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;";

    dbDelta ($sql);



    }
    function poule_uninstall(){
        global $wpdb;

        $poule_table_name = $wpdb->prefix . 'poule';


        $query = "DROP TABLE ".$poule_table_name;

        $wpdb->query($query);


}