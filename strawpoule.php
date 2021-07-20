<?php
/**
 * Plugin Name: Strawpoule
 * Plugin URI: https://github.com/Margaux83/Strawpoule
 * Description:
 * Version: 1.0
 * Liencse: GPL2
 */

// Security issue: you cannot run the script invoking it directly
if(__FILE__ == $_SERVER['SCRIPT_FILENAME']) die();

register_activation_hook(__FILE__, 	array('Strawpoule','register'));
register_deactivation_hook( __FILE__, array('Strawpoule','uninstall'));

require_once 'includes/strawpoule_functions.php';
require_once 'includes/class-wpcpolls-cpt.php';
require_once 'includes/class-wpcpolls-shortcode.php';

class Strawpoule
{
    const QUESTION = 'strawpoule_question';
    const ANSWER = 'strawpoule_answer';
    const RESULT = 'strawpoule_result';


    static function register()
    {
        global $wpdb;
        $prefix = $wpdb->prefix;

        $question = $prefix . self::QUESTION;
        $answer = $prefix . self::ANSWER;
        $result = $prefix . self::RESULT;

        $sql = "
		CREATE TABLE $question(
          id INT(10) NOT NULL AUTO_INCREMENT,
          titre VARCHAR(255) NOT NULL,
          question VARCHAR(255) NOT NULL,
          type TINYINT(1) NOT NULL,
          PRIMARY KEY (id)
		);
		
		CREATE TABLE $answer(
          id int(10) NOT NULL,
          Sondage_question_id int(10) NOT NULL,
          reponse varchar(255) NOT NULL,
          PRIMARY KEY (id),
          FOREIGN KEY (Sondage_question_id) REFERENCES $question(id)
		);

		CREATE TABLE $result(
          id int(10) NOT NULL,
          ip varchar(255) DEFAULT NULL,
          reponse_id int(10) NOT NULL,
          PRIMARY KEY (id),
	      FOREIGN KEY (reponse_id) REFERENCES $answer(id)

		);
		";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        $wpdb->show_errors(true);
        dbDelta($sql, true);
    }
    static function uninstall(){

    	global $wpdb;
        $prefix = $wpdb->prefix;

        $question = $prefix . self::QUESTION;
        $answer = $prefix . self::ANSWER;
        $result = $prefix . self::RESULT;
        $query = "DROP TABLE $result,$answer,$question;";
		$wpdb->query($query);
		delete_option("uninstall_db");
    }
}

define ("POULE_MAIN_FILE",__FILE__);

define('PLUGIN_DIR', dirname(__FILE__).'/');


