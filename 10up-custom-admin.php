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

/*
 * Define constants
 */
define( 'TENUPCLP_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'TENUPCLP_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

/*
 * Enqueue custom styles and scripts
 */
function tenupclp_load_assets() {
    wp_enqueue_style( 'custom-login', TENUPCLP_PLUGIN_URL . '/assets/css/style.css' );
    wp_enqueue_script( 'custom-login', TENUPCLP_PLUGIN_URL . 'assets/js/dist/scripts.min.js' );
}
add_action( 'login_enqueue_scripts', 'tenupclp_load_assets' );

/*
 * Update login logo URL to point to site home
 */
function tenupclp_login_logo_url() {
	return home_url();
}
add_filter('login_headerurl', 'tenupclp_login_logo_url');

/*
 * Update login logo link title to use site title and description
 */
function tenupclp_login_logo_url_title() {
    return get_bloginfo('name') . ' - ' . get_bloginfo('description');
}
add_filter( 'login_headertitle', 'tenupclp_login_logo_url_title' );

/*
 * Hacks to the HTML for the login form to better support custom styling
 */
function tenupclp_alter_login_html() {
	$login_page_content = ob_get_contents();

	// Wrap label text in <span> tags for better styling
	$login_page_content = preg_replace( '/\<label for="user_login"\>(.*?)\<br \/\>/', '<label for="user_login"><span class="label-text username">$1</span>', $login_page_content );
	$login_page_content = preg_replace( '/\<label for="user_pass"\>(.*?)\<br \/\>/', '<label for="user_pass"><span class="label-text password">$1</span>', $login_page_content );

	ob_get_clean();
	echo $login_page_content;
}
add_action( 'login_form', 'tenupclp_alter_login_html' );

/*
 * Same hacks as above to the HTML for the lost form
 * the lost password form uses a different action, so we have to duplicate
 * the lostpassword
 */
function tenupclp_alter_lostpass_html() {
	$lostpass_page_content = ob_get_contents();

	// Wrap label text in <span> tags for better styling
	// This <label> has an extra space before the closing `>`, which made it fun to figure out why preg_replace wasn't working here
	$lostpass_page_content = preg_replace( '/\<label for="user_login" \>(.*?)\<br \/\>/', '<label for="user_login"><span class="username">$1</span>', $lostpass_page_content );

	ob_get_clean();
	echo $lostpass_page_content;
}
add_action( 'lostpassword_form', 'tenupclp_alter_lostpass_html' );
