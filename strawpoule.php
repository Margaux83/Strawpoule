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
add_action('admin_menu', 			array('Strawpoule','init'));
register_deactivation_hook( __FILE__, array('Strawpoule','uninstall'));
class Strawpoule
{
    const QUESTION = 'strawpoule_question';
    const ANSWER = 'strawpoule_answer';
    const RESULT = 'strawpoule_result';


    static function init()
    {
        add_menu_page('Strawpoule', 'Strawpoule', 'manage_options', 'strawpoule_menu', array(__CLASS__, 'backend'));
        add_submenu_page('strawpoule_menu', "Strawpoule Sondages", "Sondages", 'manage_options', "strawpoule_polls", array(__CLASS__, 'backend'));
        add_submenu_page('strawpoule_menu', "Nouveau Sondage", "Nouveau Sondage", 'manage_options', "strawpoule_new_poll", array(__CLASS__, 'backendOptions'));
        add_submenu_page('strawpoule_menu', "Editer Sondage", "Editer Sondage", 'manage_options', "strawpoule_edit_poll", array(__CLASS__, 'backendOptions'));
        add_submenu_page('strawpoule_menu', "Statistique", "Statistique", 'manage_options', "strawpoule_statistic", array(__CLASS__, 'backendOptions'));
        remove_submenu_page('strawpoule_menu', 'strawpoule_menu');
    }

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
         $query = "DROP TABLE ".$question.",".$answer.",".$result;
         $wpdb->query($query);
    }
}

define ("POULE_MAIN_FILE",__FILE__);

define('PLUGIN_DIR', dirname(__FILE__).'/');
