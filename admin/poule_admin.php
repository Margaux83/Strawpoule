<?php
function poule_admin_menu(){
    add_menu_page(
        'Steawpoule',
        'Steawpoule',
        'read',
        'Steawpoule',
        'dashicons'
    );
}
add_action('admin_menu','poule_admin_menu');

function poule_admin_sub_menu(){
    add_submenu_page(
        'Steawpoule',
        'Nouveau Sondage',
        'Nouveau Sondage',
        'read',
        'new-poule',
        'poule_admin_new_render'
    );
    add_submenu_page(
        'Steawpoule',
        'Editer Sondage',
        'Editer Sondage',
        'read',
        'edit-poule',
        'poule_admin_edit_render'
    );
    add_submenu_page(
        'Steawpoule',
        'Statisique Sondage',
        'Statisique Sondage',
        'read',
        'stats-poule',
        'poule_admin_stats_render'
    );

}
add_action('admin_menu','poule_admin_sub_menu');

function toolbar_link_to_mypage( $wp_admin_bar){
    $args = array(
        'id'=>'poule',
        'title'=>'sondage',
        'href'=> admin_url(),'admin.php?page=sondage',
        'meta'=>array('class'=>'')
    );
    $args = array(
        'parent'=>'poule',
        'id'=>'poule-new',
        'title'=> 'Nouveau Sondage',
        'meta'=>admin_url(),'admin.php?page=new-poule'
    );
    $args = array(
        'parent'=>'poule',
        'id'=>'poule-stats',
        'title'=> 'Statistiques',
        'meta'=>admin_url(),'admin.php?page=stats-poule'
    );

}
