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

        /* $count = $wpdb->get_var($sql, 0,0);
         $sql = "select * from $polls where id='$id'";
         $data = $wpdb->get_row($sql);
         if($data->since> date('Y-m-d')){
             if($count=='0'){

                 if(isset($_POST)
                     && count($_POST)>0
                     && isset($_POST['answer'])
                     && is_numeric($_POST['answer'])
                     && isset($_POST['poll'])
                     && is_numeric($_POST['poll'])
                     && $_POST['poll'] == $id
                 ){
                     $answer = $_POST['answer'];

                     $data= array(
                         'user_id'		=> $uid,
                         'poll_id'		=> $id,
                         'answer_index'	=> $answer,
                         'expiration_date' => date('Y-m-d H:i:s')
                     );
                     if($wpdb->insert($rates, $data)){

                         $buffer = $thankyou;
                     }
                     return $buffer;
                 }else{*/




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



        /*}
    }else{
        return "<h3>$data->question</h3><p>$already_rated</p>";
    }
}else{

    $sql = "select p.id, p.question, p.answers, count(r.id) rating, r.answer_index idx from $polls p left join $rates r on p.id = r.poll_id where p.id=$id group by r.answer_index order by answer_index asc";
    $results = $wpdb->get_results($sql);
    $options = preg_split("/\n/",$data->answers);
    #print_r($results);
    $rates = array();
    for($i = 0; $i<count($results) || $i<count($options); $i++){
        $data = $results[$i];

        if(!isset($rates[$i]))
            $rates[$i] = array('answer' => $options[$i], 'rates' => 0);
        if(isset($data)){
            $question = $data->question;
            $rates[$data->idx] = array('answer' => $options[$data->idx], 'rates' => $data->rating);
        }
    }

    $output = "<h3>$poll_results_label</h3>";
    $output .= "<dl><dt>$question_label</dt><dd>$question</dd>";
    $output .= "<dt>$answers_label</dt>";
    $currentRate = 0;
    $currentRates=array();
    for($i = 0; $i < count($rates); $i++){
        $rate = $rates[$i];
        $rateText = sprintf($answer_structure,$rate['answer'], $rate['rates']);
        $output .= "<dd>$rateText</dd>";
        if($rate['rates']==$rates[$currentRate]['rates']){
            $currentRates[] = $i;
        }
        if($rate['rates']>$rates[$currentRate]['rates']){
            $currentRate = $i;
            $currentRates = array();
        }
    }
    $output .= "</dd>";

    $output .= "<dt class=\"most-rated\">$most_rated</dt>";
    foreach($currentRates as $r){
        $rate = $rates[$r];
        $rateText = sprintf($answer_structure,$rate['answer'], $rate['rates']);
        $output .= "<dd class=\"most-rated\">$rateText</dd>";
    }
    $output .="</dl>";
    return $output;
}
}*/




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

/* --------------------------------------------------------------
ADD PLUGIN PAGE IN ADMIN
-------------------------------------------------------------- */

function wpcpolls_frontend_styles_scripts() {
    $version_remove = '1.0.0';

    wp_enqueue_style('wpcpolls-css', plugins_url( '/wordpress-custom-polls/css/wpcpolls-frontend.css', '__FILE__'), false, $version_remove, 'all');

    wp_enqueue_script('wpcpolls-js', plugins_url( '/wordpress-custom-polls/js/wpcpolls-frontend.js', '__FILE__'), array('jquery'), $version_remove, true);

    wp_localize_script('wpcpolls-js', 'admin_url', array(
        'ajax_url' => admin_url('admin-ajax.php')
    ));
}

add_action('init', 'wpcpolls_frontend_styles_scripts');

/* --------------------------------------------------------------
SET VALUES
-------------------------------------------------------------- */

function wpcpolls_set_values($poll_id, $poll_option) {
    global $wpdb;

    /* GET TOTAL ON POLL */
    $query_total = $wpdb->get_results(
        "
    SELECT COUNT(id) FROM {$wpdb->prefix}wpcpolls_meta
    WHERE post_id = $poll_id", ARRAY_A);

    foreach($query_total as $query_data) {
        $total = $query_data['COUNT(id)'];
    }

    /* GET TOTAL ON OPTION */
    $query_array = $wpdb->get_results(
        "
    SELECT COUNT(id) FROM {$wpdb->prefix}wpcpolls_meta
    WHERE post_id = $poll_id AND selection = $poll_option", ARRAY_A);

    foreach($query_array as $query_data) {
        $result = $query_data['COUNT(id)'];
    }

    /* GET THE PERCENTAGE */
    if ($total != 0) {
        $result = ($result * 100) / $total;
    } else {
        $result = 0;
    }

    return round($result, 2);
}

/* --------------------------------------------------------------
SET VALUES ON CLICK - AJAX CALLER
-------------------------------------------------------------- */

function wpcpolls_update_values() {
    $poll_id = $_POST['id_post'];
    $poll_option = $_POST['id_poll'];
    global $wpdb;

    /* GET TOTAL ON POLL */
    $query_total = $wpdb->get_results(
        "
    SELECT COUNT(id) FROM {$wpdb->prefix}wpcpolls_meta
    WHERE post_id = $poll_id", ARRAY_A);

    foreach($query_total as $query_data) {
        $total = $query_data['COUNT(id)'];
    }

    for ($i = 1; $i <= 4; $i++) {
        /* GET TOTAL ON OPTION */
        $query_array = $wpdb->get_results(
            "
    SELECT COUNT(id) FROM {$wpdb->prefix}wpcpolls_meta
    WHERE post_id = $poll_id AND selection = $i", ARRAY_A);

        foreach($query_array as $query_data) {
            $result[$i] = $query_data['COUNT(id)'];
        }

        if ($poll_option == $i) {
            $result[$i] = $result[$i] + 1;
            $total = $total + 1;
        }
    }

    /* GET THE PERCENTAGE */
    for ($i = 1; $i <= 4; $i++) {
        $result[$i] = ($result[$i] * 100) / $total;
    }

    echo json_encode($result, JSON_PRETTY_PRINT);

    wp_die();
}

add_action('wp_ajax_nopriv_wpcpolls_update_values', 'wpcpolls_update_values');
add_action('wp_ajax_wpcpolls_update_values', 'wpcpolls_update_values');

/* --------------------------------------------------------------
ADD AJAX FUNCTIONS
-------------------------------------------------------------- */

function wpcpolls_insert_vote() {
    $poll_id = $_POST['id_post'];
    $poll_option = $_POST['id_poll'];
    $now = new DateTime();
    $ip = $_SERVER['REMOTE_ADDR'];
    global $wpdb;

    /* INSERT VOTE ON POLL */
    $wpdb->insert(
        $wpdb->prefix . 'wpcpolls_meta',
        array(
            'post_id'   => $poll_id,
            'time'      => $now->format('Y-m-d H:i:s'),
            'ip'        => $ip,
            'selection' =>  $poll_option
        ),
        array(
            '%s',
            '%s',
            '%s',
            '%s'
        )
    );

    wp_die();
}

add_action('wp_ajax_nopriv_wpcpolls_insert_vote', 'wpcpolls_insert_vote');
add_action('wp_ajax_wpcpolls_insert_vote', 'wpcpolls_insert_vote');
