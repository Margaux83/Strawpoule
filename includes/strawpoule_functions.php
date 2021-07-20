<?php

function wpcpolls_admin_secion_handler () {
    add_menu_page( __('Strawpoule', 'wordpress-custom-polls'), __('Strawpoule', 'wordpress-custom-polls'), 'edit_posts', 'strawpoule', 'admin_poll_function', 'dashicons-list-view' , 120 );
    add_submenu_page( 'strawpoule', __( 'Nouveau sondage', 'wordpress-custom-polls' ), __( 'Nouveau sondage', 'wordpress-custom-polls' ), 'manage_options', 'new-poll', 'admin_new_poll_function');
    add_submenu_page( 'strawpoule', __( 'Editer sondage', 'wordpress-custom-polls' ), __( 'Editer sondage', 'wordpress-custom-polls' ), 'manage_options', 'edit-poll', 'admin_edit_poll_function');
    add_submenu_page( 'strawpoule', __( 'Statisique sondage', 'wordpress-custom-polls' ), __( 'Statisique sondage', 'wordpress-custom-polls' ), 'manage_options', 'stat-poll', 'admin_stat_poll_function');
}

add_action('admin_menu', 'wpcpolls_admin_secion_handler');

function admin_poll_function () {
    require_once plugin_dir_path(__FILE__) . 'views/admin_poll.php';
}

function admin_new_poll_function () {
    require_once plugin_dir_path(__FILE__) . 'views/admin_poll_add.php';
}

function admin_edit_poll_function () {
    require_once plugin_dir_path(__FILE__) . 'views/admin_poll_edit.php';
}

function admin_stat_poll_function () {
    require_once plugin_dir_path(__FILE__) . 'views/admin_poll_statistic.php';

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
