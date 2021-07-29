<?php

const QUESTION = 'strawpoule_question';
const ANSWER = 'strawpoule_answer';
const RESULT = 'strawpoule_result';


/**
 * @return string
 * Recovery of the user's IP address
 */
function getPublicIp() {

        if(!empty($_SERVER['HTTP_CLIENT_IP'])){
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        }elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        }else{
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip;

}

/**
 * Creation of the Strawpoule's shortcode
 */
add_shortcode('strawpoule', 'strawpoule_Shortcode');

/**
 * @param $atts
 * @return string
 * Content of the strawpoule's shortcode
 */
function strawpoule_Shortcode($atts)
{
        $id = $atts['id'];
        global $wpdb;
        $question = $wpdb->prefix . QUESTION;
        $answer = $wpdb->prefix . ANSWER;
        $results = $wpdb->prefix . RESULT;
        $res = $wpdb->get_results("SELECT DISTINCT $question.id as question_id, titre, question,  createDate, reponse, type, COUNT(reponse) as countReponse FROM $question INNER JOIN $answer ON $question.id = $answer.Sondage_question_id WHERE $question.id=" . $id);
        $polls = json_decode(json_encode($res), true);
        $ip = '"'.getPublicIp().'"';
        $answer_poll = $wpdb->get_results("SELECT DISTINCT id, reponse, count(reponse) as countReponse FROM $answer WHERE Sondage_question_id =".$polls[0]['question_id']. " GROUP BY reponse");
        $answers = json_decode(json_encode($answer_poll), true);

        $ipExist = "SELECT count(ip) FROM $results WHERE ip=".$ip." AND question_id=".$polls[0]['question_id'];
        $count = $wpdb->get_var($ipExist, 0,0);

    /**
     * We check if the user has already voted (verify if the ip and the answer's id already exist in the database)
     */
        if($count=='0') {
            if (isset($_POST)
                && count($_POST) > 0
                && isset($_POST['answer'])
                && is_numeric($_POST['answer'])
            ) {
                $answer = $_POST['answer'];
                $data = array(
                    'ip' => getPublicIp(),
                    'question_id' => $polls[0]['question_id'],
                    'reponse_id' => $answer,
                );
                if ($wpdb->insert($results, $data)) {

                    echo "<p>Votre réponse a bien été prise en compte</p>";
                }
            } else {

                /**
                 * Creation of the survey's form
                 */
                $output = '
							<form method="post" action="" id="simple-poll-%d" class="simple-poll">
								<fieldset id="field4">
									<legend id="titlesondage">' . $polls[0]['titre'] . '</legend>
									<h2> ' . $polls[0]['question'] . ' </h2>
									
								';

                foreach ($answers as $index => $answer) {
                    $output .= '<p>
                       <input type="radio" name="answer" value="' . $answer["id"] . '" id="option-' . $answer["id"] . '" />
                       <label for=\"option-' . $answer["id"] . '\">' . $answer["reponse"] . '</label>
                     </p>';
                }
                $output .= '  <input type="submit"id="button-toto" value="Répondre" />
									</p>
								</fieldset>
							
							</form>
						';
                return $output;
            }
        }else{
            echo "<p>Vous avez déjà voté</p>";
        }

}

/**
 * Class Strawpoule_Widget
 * TODO : Faire le widget avec un sondage "Aimez-vous notre site ?"
 */
class Strawpoule_Widget extends WP_Widget{
    public function __construct()
    {
        parent::__construct('strawpoule_widget',__('Widget Strawpoule', 'strawpoulelg',
                array(
                    'description' => __('Widget simple issu du plugin Strawpoule',
                        'mypluginlg')
                )
            )
        );
        add_action('widgets_init','Strawpoule_Widget');
    }

    // Display Widget
    public function widget($args,$instance)
    {
        $id = $instance['id'];
        global $wpdb;
        $question = $wpdb->prefix . QUESTION;
        $answer = $wpdb->prefix . ANSWER;
        $results = $wpdb->prefix . RESULT;
        $res = $wpdb->get_results("SELECT DISTINCT $question.id as question_id, titre, question,  createDate, reponse, type, COUNT(reponse) as countReponse FROM $question INNER JOIN $answer ON $question.id = $answer.Sondage_question_id WHERE $question.id=" . $id);
        $polls = json_decode(json_encode($res), true);
        $ip = '"'.getPublicIp().'"';
        $answer_poll = $wpdb->get_results("SELECT DISTINCT id, reponse, count(reponse) as countReponse FROM $answer WHERE Sondage_question_id =".$polls[0]['question_id']. " GROUP BY reponse");
        $answers = json_decode(json_encode($answer_poll), true);

        $ipExist = "SELECT count(ip) FROM $results WHERE ip=".$ip." AND question_id=".$polls[0]['question_id'];
        $count = $wpdb->get_var($ipExist, 0,0);
  /*      global $wpdb;
        $question = $wpdb->prefix . QUESTION;
        $answer = $wpdb->prefix . ANSWER;
        $results = $wpdb->prefix . RESULT;
        $id = $instance['question.id'];
        $answer = $wpdb->get_results("select reponse,id from ".$answer."where Sondage_question_id = ".$id);
        $reponse= $answer['reponse'];
        $id_answer= $answer['id'];
        var_dump($answer);
        $question = $wpdb->get_results("select id,titre,question from ".$question);
        $titre=$question['titre'];
        $question=$question['question'];
        $id_question=$question['id'];
        var_dump($question);
        $results = $wpdb->get_results("select  count(reponse_id) from ".$results." where question_id = ".$id) ;
        $count=$results['reponse_id'];
        echo $args['before_widget'];*/
        echo $args['before_widget'];
        echo $id = (int) $instance['id'];

        if($count=='0') {
            if (isset($_POST)
                && count($_POST) > 0
                && isset($_POST['answer'])
                && is_numeric($_POST['answer'])
            ) {
                $answer = $_POST['answer'];
                $data = array(
                    'ip' => getPublicIp(),
                    'question_id' => $polls[0]['question_id'],
                    'reponse_id' => $answer,
                );
                if ($wpdb->insert($results, $data)) {

                    echo "<p>Votre réponse a bien été prise en compte</p>";
                }
            } else {

                /**
                 * Creation of the survey's form
                 */
                $output = '
							<form method="post" action="" id="simple-poll-%d" class="simple-poll">
								<fieldset id="field4">
									<legend id="titlesondage">' . $polls[0]['titre'] . '</legend>
									<h2> ' . $polls[0]['question'] . ' </h2>
									
								';

                foreach ($answers as $index => $answer) {
                    $output .= '<p>
                       <input type="radio" name="answer" value="' . $answer["id"] . '" id="option-' . $answer["id"] . '" />
                       <label for=\"option-' . $answer["id"] . '\">' . $answer["reponse"] . '</label>
                     </p>';
                }
                $output .= '  <input type="submit"id="button-toto" value="Répondre" />
									</p>
								</fieldset>
							
							</form>
						';
                return $output;
            }
        echo $args['after_widget'];
    }
    }

//        extract($args);
//        $title = apply_filters('widget_title', $instance['title']);
//        $poll_id = (int) $instance['poll_id'];
//        echo '<form action="" method="post">
//                    <label for="email_user">Votre email : </label>
//                    <input id="email_user" name="email_user" type="email">
//                    <input type="submit">
//                </form>';

    public function form($instance)
    {
        global $wpdb;

        $id = ( isset( $instance[ 'id' ] ) ) ? $instance[ 'id' ] : 1;


        $question = $wpdb->prefix . QUESTION;
        $questions = $wpdb->get_results("select id,titre,question from ".$question);
        $titre=$question['titre'];
        //$question=$question['question'];
        $id_question=$question['id'];
        ?>
        <p>
            <label for="<?php echo $this->get_field_id( 'poll' ); ?>"><?php _e( 'Poll:' ); ?></label>
            <select id = "strawpoule_select" name = "strawpoule_widget_select" >
                <?php
                if ( 0 < count( $questions ) ) {
                    foreach( $questions as $row ) {
                        ?>
                        <option value="<?php echo $row->id;?>" <?php selected( $row->id); ?>>
                            <?php echo $row->question."  ";
                            echo $row->titre;?>
                        </option>
                        <?php
                    }
                }
                ?>
            </select>
        </p>
        <?php
    }



    public function update($new_instance,$old_instance)
    {

        $instance = array();
        $instance['id'] = (!empty($new_instance['id'])) ? strip_tags($new_instance['id']) : $_POST['strawpoule_widget_select'];

        return $instance;

        }

}

/**
 * Creation of the strawpoule's widget
 */
add_action('widgets_init','Strawpoule_Widget');

function Strawpoule_Widget(){
    register_widget('Strawpoule_Widget');
}
