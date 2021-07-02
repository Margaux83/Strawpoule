<?php
/**
 * Plugin Name: Strawpoule
 * Plugin URI: https://github.com/Margaux83/Strawpoule
 * Description:
 * Version: 0.1
 * Liencse: GPL2
 */

define ("POULE_MIAN_FILE",__FILE__);

define('PLUGIN_DIR', dirname(__FILE__).'/');

require_once ('poule_init.php');

require_once ('admin/poule_admin.php');