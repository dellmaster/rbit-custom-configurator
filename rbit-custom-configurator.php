<?php
/*
Plugin Name: RBIT ItaliaStyle Configurator custom post types
Description: Custom Post Types for "ItaliaStyle" configurator.
Author: Oleksii Yurchenko
Author URI: https://runbyit.com
*/

require_once 'custom-post-types.php'; // custom post types file
require_once 'product-meta-box.php'; // custom metabox on product edit page
require_once 'json-to-front.php'; // API response with options for product id

// START register JS for wp-admin
add_action( 'admin_enqueue_scripts', 'enqueue_admin_configurator_script' );
function enqueue_admin_configurator_script() {
    wp_enqueue_script( 'rbit-configurator-script-admin', plugin_dir_url(__FILE__).'js/get-options-functions.js?v='.time(), array('jquery'), null, true );
    wp_enqueue_style( 'rbit-configurator-styles-admin',  plugin_dir_url(__FILE__) . 'css/configurator.css?vr=' .time() );
}
// END register JS for wp-admin


// START Register Configurator custom post types
function rbit_register_configurator_custom_post_types() {

    rbit_italiastyle_options_group_custom_post_type();
    rbit_italiastyle_option_custom_post_type();
    rbit_italiastyle_option_value_custom_post_type();

}

add_action( 'init', 'rbit_register_configurator_custom_post_types', 0 );

// END Register Configurator custom post types


//




