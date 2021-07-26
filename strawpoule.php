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

require_once 'includes/strawpoule_functions.php';

class Strawpoule
{
    const QUESTION = 'strawpoule_question';
    const ANSWER = 'strawpoule_answer';
    const RESULT = 'strawpoule_result';

    static function init() {
        add_menu_page( __('Strawpoule', 'wordpress-custom-polls'), __('Strawpoule', 'wordpress-custom-polls'), 'edit_posts', 'strawpoule', array(__CLASS__,'admin_poll_function'), 'dashicons-list-view' , 120 );
        add_submenu_page( 'strawpoule', __( 'Nouveau sondage', 'wordpress-custom-polls' ), __( 'Nouveau sondage', 'wordpress-custom-polls' ), 'manage_options', 'new-poll', array(__CLASS__,'admin_new_poll_function'));
    }


    static function admin_poll_function () {
        global $wpdb;
        $prefix = $wpdb->prefix;
        $question = $prefix . self::QUESTION;
        $answer = $prefix . self::ANSWER;
        $result = $prefix . self::RESULT;

        $result = $wpdb->get_results("SELECT DISTINCT $question.id as question_id, titre, question,  createDate, reponse, COUNT(reponse) as countReponse FROM $question INNER JOIN $answer ON $question.id = $answer.Sondage_question_id GROUP BY question_id");

        $polls = json_decode(json_encode($result), true);
        foreach ($polls as $poll){
            $answer_poll = $wpdb->get_results("SELECT DISTINCT reponse FROM $answer WHERE Sondage_question_id =".$poll['question_id']. " GROUP BY reponse");
            $answers = json_decode(json_encode($answer_poll), true);
            $shortcode =  strawpoule_Shortcode(['id' => $poll['question_id']]);
        }


        require_once plugin_dir_path(__FILE__) . 'includes/views/admin_poll.php';
    }

   static function admin_new_poll_function () {
        require_once plugin_dir_path(__FILE__) . 'includes/views/admin_poll_add.php';
        global $wpdb;
       $prefix = $wpdb->prefix;

        $question = $prefix . self::QUESTION;
        $answer = $prefix . self::ANSWER;
        $result = $prefix . self::RESULT;
        if(isset($_POST) && count($_POST)>0){
            $_POST = stripslashes_deep($_POST);
            $wpdb->show_errors(true);
            if($_GET['id']=='0'){

                $wpdb->insert($polls, $_POST);
            }else{
                $wpdb->update($polls, $_POST, array('id'=> $_GET['id']));
            }

            unset($_GET['id']);
        }
    }

    function admin_edit_poll_function () {
        require_once plugin_dir_path(__FILE__) . 'includes/views/admin_poll_edit.php';
    }

    function admin_stat_poll_function () {
        require_once plugin_dir_path(__FILE__) . 'includes/views/admin_poll_statistic.php';

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
            createDate datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
          PRIMARY KEY (id)
		);
		
		CREATE TABLE $answer(
          id int(10) NOT NULL AUTO_INCREMENT,
          Sondage_question_id int(10) NOT NULL,
          reponse varchar(255) NOT NULL,
          PRIMARY KEY (id),
          
          FOREIGN KEY (Sondage_question_id) REFERENCES $question(id)
		);

		CREATE TABLE $result(
          id int(10) NOT NULL AUTO_INCREMENT,
          ip varchar(255) DEFAULT NULL,
          reponse_id int(10) NOT NULL,
          PRIMARY KEY (id),
          createDate datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
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


