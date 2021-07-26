<?php

const QUESTION = 'strawpoule_question';
const ANSWER = 'strawpoule_answer';
const RESULT = 'strawpoule_result';
//[strawpoule att="value"]
add_shortcode('strawpoule', 'strawpoule_Shortcode');

function strawpoule_Shortcode($atts)
{


    $id = $atts['id'];

        global $wpdb;
        $question = $wpdb->prefix . QUESTION;
        $answer = $wpdb->prefix . ANSWER;
        $result = $wpdb->get_results("SELECT DISTINCT $question.id as question_id, titre, question,  createDate, reponse, type, COUNT(reponse) as countReponse FROM $question INNER JOIN $answer ON $question.id = $answer.Sondage_question_id WHERE $question.id=" . $id);
        $polls = json_decode(json_encode($result), true);

        $answer_poll = $wpdb->get_results("SELECT DISTINCT id, reponse, count(reponse) as countReponse FROM $answer WHERE Sondage_question_id =".$polls[0]['question_id']. " GROUP BY reponse");
        $answers = json_decode(json_encode($answer_poll), true);


            $output = '
							<form method="post" action="" id="simple-poll-%d" class="simple-poll">
								<fieldset id="field4">
									<legend id="titlesondage">' . $polls[0]['titre'] . '</legend>
									<p>'.$_SERVER['REMOTE_ADDR'].'</p>
									<h2> ' . $polls[0]['question'] . ' </h2>
									
								';

                    foreach($answers as $index => $answer){
                        $output .= '<p>
                       <input type="radio" name="answer" value="'.$answer["id"].'" id="option-'.$answer["id"].'" />
                       <label for=\"option-'.$answer["id"].'\">'.$answer["reponse"].'</label>
                     </p>';

                    }
            $output .= ' <input type="submit"id="button-toto" value="Répondre" />
									</p>
								</fieldset>
							
							</form>
						';
            return $output;


}


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
        add_action('wp_loaded', array($this,'save_email'));
    }

    public function widget($args,$instance)
    {
        extract($args);
        $title = apply_filters('widget_title', $instance['title']);
        echo '<form action="" method="post">
                    <label for="email_user">Votre email : </label>
                    <input id="email_user" name="email_user" type="email">
                    <input type="submit">
                </form>';
    }

    public function form($instance)
    {
        $title = isset($instance['title']) ? $instance['title'] : '';
        echo '<label for="'.$this->get_field_name('title').'">Titre : </label>
                <input type="text" id="'.$this->get_field_id('title').'" name="'.$this->get_field_name('title').'" value="'.$title.'"';
    }


    public function update($new_instance,$old_instance)
    {
        $instance =  array();
        $instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';
        return $instance;
    }

    public function save_email()
    {
        if(isset($_POST['email_user']) && !empty($_POST['email_user'])){
            global $wpdb;
            $email = $_POST['email_user'];
            $row = $wpdb->get_row("SELECT * FROM {$wpdb->prefix} toto_table WHERE email='$email'");
            if(is_null($row)){
                $wpdb->insert("{$wpdb->prefix}toto_table", array('
                email'=>$email),'');
            }
        }
    }
}

add_action('widgets_init','strawpoule_Widgets');

function strawpoule_Widgets(){
    register_widget('Strawpoule_Widget');
}
