<?php
/**
 * Plugin Name:     TenUp Custom Login Page
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

/**
 * Define constants
 */
define( 'TENUPCLP_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'TENUPCLP_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

/**
 * add_action, add_filter
 */
add_action( 'login_enqueue_scripts', 'tenupclp_load_assets' );
add_action( 'login_form', 'tenupclp_alter_form_html' );
add_action( 'register_form', 'tenupclp_alter_form_html' );
add_action( 'lostpassword_form', 'tenupclp_alter_form_html' );

add_filter( 'login_headerurl', 'tenupclp_login_logo_url');
add_filter( 'login_headertitle', 'tenupclp_login_logo_url_title' );

/**
 * Enqueue custom styles and scripts
 */
function tenupclp_load_assets() {
    wp_enqueue_style( 'custom-login', TENUPCLP_PLUGIN_URL . '/assets/css/style.css' );
    wp_enqueue_script( 'custom-login', TENUPCLP_PLUGIN_URL . 'assets/js/dist/scripts.min.js' );
}

/**
 * Update login logo URL to point to site home
 */
function tenupclp_login_logo_url() {
	return home_url();
}

/**
 * Update login logo link title to use site title and description
 */
function tenupclp_login_logo_url_title() {
    return get_bloginfo('name') . ' - ' . get_bloginfo('description');
}

/**
 * Alter the form HTML for better styling:
 * wrap text within <label> tags in a <span> removing the <br /> tag
 */
function tenupclp_alter_form_html() {
	$page_content = ob_get_contents();

	// Wrap label text in <span> tags for better styling
	$page_content = preg_replace( '/\<label for=\"(.*?)\" ?\>(.*?)\<br ?\/?>/', '<label for="$1"><span class="label-text">$2</span>', $page_content );

	ob_end_clean();
	echo $page_content;
}
