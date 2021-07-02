<?php

register_activation_hook( POULE_MAIN_FILE, 'poule_install');

register_deactivation_hook( POULE_MAIN_FILE, 'poule_uninstall');

function poule_install(){
    global $wpdb;

    $poule_table_name = $wpdb->prefix . 'poule';


    $sql ="";
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php')
    dbDelta ($sql);


}
function poule_uninstall(){
    global $wpdb;

    $poule_table_name = $wpdb->prefix . 'poule';


    $query = "DROP TABLE ".$poule_table_name;

    $wpdb->query($query);

    delete_option('poule');
}