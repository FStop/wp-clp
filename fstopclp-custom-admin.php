<?php
/**
 * Plugin Name:     WordPress Custom Login Page
 * Plugin URI:      https://github.com/FStop/wp-clp
 * Description:     A plugin that customizes the WordPress login page
 * Author:          Gabriel Luethje
 * Author URI:      http://github.com/fstop
 * Text Domain:     fstopclp-custom-admin
 * Domain Path:     /languages
 * Version:         0.1.0
 *
 * @package         FStop_clp_Custom_Admin
 */

/**
 * Define constants
 */
define( 'FSTOPCLP_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'FSTOPCLP_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

/**
 * Declare add_action, add_filter functions
 */
add_action( 'login_enqueue_scripts', 'FStop_clp_load_assets' );
add_action( 'login_form', 'FStop_clp_alter_form_html' );
add_action( 'register_form', 'FStop_clp_alter_form_html' );
add_action( 'lostpassword_form', 'FStop_clp_alter_form_html' );

add_filter( 'login_headerurl', 'FStop_clp_login_logo_url' );
add_filter( 'login_headertitle', 'FStop_clp_login_logo_url_title' );

/**
 * Enqueue custom styles and scripts
 */
function FStop_clp_load_assets() {
	wp_enqueue_style( 'custom-login', FSTOPCLP_PLUGIN_URL . '/assets/css/style.css' );
}

/**
 * Update login logo URL to point to site home
 */
function FStop_clp_login_logo_url() {
	return home_url();
}

/**
 * Update login logo link title to use site title and description
 */
function FStop_clp_login_logo_url_title() {
	return get_bloginfo( 'name' ) . ' - ' . get_bloginfo( 'description' );
}

/**
 * Alter the form HTML for better styling:
 * wrap text within <label> tags in a <span> removing the <br /> tag
 */
function FStop_clp_alter_form_html() {
	$page_content = ob_get_contents();

	// Wrap label text in <span> tags for better styling.
	$page_content = preg_replace( '/(<label.*?>\s*?)(.*?)(\s*?<br ?\/?>)/', '$1<span class="label-text">$2</span>', $page_content );

	ob_end_clean();
	echo $page_content;
}
