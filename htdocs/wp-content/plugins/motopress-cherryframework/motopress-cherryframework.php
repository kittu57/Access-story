<?php

/**
* Plugin Name: MotoPress and CherryFramework-3 Integration
* Plugin URI: http://www.getmotopress.com/
* Description: Extend MotoPress Content Editor plugin with CherryFramework 3 shortcodes.
* Version: 1.3.1
* Author: MotoPress
* Author URI: http://www.getmotopress.com/
* License: GPL2 or later
*/

if (!defined('ABSPATH')) die();

define( 'MOTOPRESS_CHERRYFRAMEWORK_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'MOTOPRESS_CHERRYFRAMEWORK_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );

global $motopress_cherry_default_title, $motopress_cherry_default_text, $motopress_cherry_default_button;

$motopress_cherry_default_title = 'Lorem ipsum dolor sit amet';
$motopress_cherry_default_text =
    'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam adipiscing sodales massa at luctus.';
$motopress_cherry_default_button = 'Read more';

if (is_admin()) {
    add_action('admin_init', 'motopress_cherryframework_init');
} else {
    motopress_cherryframework_init();
}

add_action('wp_head', 'motopress_cherryframework_wphead');

function motopress_cherryframework_init() {

    include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

    // cherry framework shortcodes
    if ( is_plugin_active( 'cherry-plugin/cherry-plugin.php' ) ) {
        require_once 'motopress-cherry-shortcodes.php';
    }

    // cherry-parallax plugin
    if ( is_plugin_active( 'cherry-parallax/cherry-parallax.php' ) ) {
        require_once 'motopress-cherry-parallax.php';
    }
    
    // cherry-lazy-load plugin
    if ( is_plugin_active( 'cherry-lazy-load/cherry-lazy-load.php' ) ) {
        require_once 'motopress-cherry-lazy-load.php';
    }
}

function motopress_cherryframework_wphead() {
    if (isset($_GET['motopress-ce']) && $_GET['motopress-ce'] == 1) {
        wp_register_style('motopress-cherryframework-style', MOTOPRESS_CHERRYFRAMEWORK_PLUGIN_URL .
            'motopress-cherryframework-style.css', array(), '1.0');
        wp_enqueue_style('motopress-cherryframework-style');
    }
}