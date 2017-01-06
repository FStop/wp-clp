<?php
/**
 * Plugin Name:     10up Custom Login Page
 * Plugin URI:      PLUGIN SITE HERE
 * Description:     A plugin that customizes the login page for 10up
 * Author:          Gabriel Luethje
 * Author URI:      http://github.com/fstop
 * Text Domain:     10up-custom-admin
 * Domain Path:     /languages
 * Version:         0.1.0
 *
 * @package         10up_Custom_Admin
 */

define( 'TENUPCLP_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'TENUPCLP_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

function tenupclp_load_assets() {
    wp_enqueue_style( 'custom-login', TENUPCLP_PLUGIN_URL . '/assets/css/style.css' );
    wp_enqueue_script( 'custom-login', TENUPCLP_PLUGIN_URL . 'assets/js/dist/scripts.min.js' );
}
add_action( 'login_enqueue_scripts', 'tenupclp_load_assets' );

function tenupclp_login_logo_url() {
	return home_url();
}
add_filter('login_headerurl', 'tenupclp_login_logo_url');

function tenupclp_login_logo_url_title() {
    return get_bloginfo('name') . ' - ' . get_bloginfo('description');
}
add_filter( 'login_headertitle', 'tenupclp_login_logo_url_title' );

