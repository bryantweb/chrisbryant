<?php
/**
 * CBG
 *
 * This file adds functions to the Chris Bryant Custom Theme.
 *
 * @package CB
 * @author  Chris Bryant
 * @license GPL-2.0+
 * @link    https://cb.com/
 */

// Start the engine.
include_once( get_template_directory() . '/lib/init.php' );

// Setup Theme.
include_once( get_stylesheet_directory() . '/lib/theme-defaults.php' );

// Set Localization (do not remove).
add_action( 'after_setup_theme', 'cb_localization_setup' );
function cb_localization_setup(){
	load_child_theme_textdomain( 'cb', get_stylesheet_directory() . '/languages' );
}

// Add the helper functions.
include_once( get_stylesheet_directory() . '/lib/helper-functions.php' );

// Add Image upload and Color select to WordPress Theme Customizer.
require_once( get_stylesheet_directory() . '/lib/customize.php' );

// Include Customizer CSS.
include_once( get_stylesheet_directory() . '/lib/output.php' );

// Speed Up The Site
include_once( get_stylesheet_directory() . '/lib/optimize.php' );

// Custom Admin
include_once( get_stylesheet_directory() . '/lib/custom-admin.php' );

// Child theme (do not remove).
define( 'CHILD_THEME_NAME', 'Chris Bryant' );
define( 'CHILD_THEME_URL', 'https://chrisbryant.com' );
define( 'CHILD_THEME_VERSION', '0.0.1' );

// Enqueue Scripts and Styles.
add_action( 'wp_enqueue_scripts', 'cb_enqueue_scripts_styles' );
function cb_enqueue_scripts_styles() {

	wp_enqueue_style( 'cb-google-fonts', '//fonts.googleapis.com/css?family=Roboto:300,400,500,700', array(), CHILD_THEME_VERSION );
	wp_enqueue_style( 'dashicons' );
	wp_enqueue_script( 'chrisbryant-global-js', get_stylesheet_directory_uri() . "/js/global.js", array( 'jquery' ), CHILD_THEME_VERSION, true );

	$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';
	wp_enqueue_script( 'genesis-sample-responsive-menu', get_stylesheet_directory_uri() . "/js/responsive-menus{$suffix}.js", array( 'jquery' ), CHILD_THEME_VERSION, true );
	wp_localize_script(
		'genesis-sample-responsive-menu',
		'genesis_responsive_menu',
		cb_responsive_menu_settings()
	);

}

// Define our responsive menu settings.
function cb_responsive_menu_settings() {

	$settings = array(
		'mainMenu'          => __( 'Menu', 'genesis-sample' ),
		'menuIconClass'     => 'dashicons-before dashicons-menu',
		'subMenu'           => __( 'Submenu', 'genesis-sample' ),
		'subMenuIconsClass' => 'dashicons-before dashicons-arrow-down-alt2',
		'menuClasses'       => array(
			'combine' => array(
				'.nav-primary',
				'.nav-header',
			),
			'others'  => array(),
		),
	);

	return $settings;

}

// Add HTML5 markup structure.
add_theme_support( 'html5', array( 'caption', 'comment-form', 'comment-list', 'gallery', 'search-form' ) );

// Add Accessibility support.
add_theme_support( 'genesis-accessibility', array( '404-page', 'drop-down-menu', 'headings', 'rems', 'search-form', 'skip-links' ) );

// Add viewport meta tag for mobile browsers.
add_theme_support( 'genesis-responsive-viewport' );

// Add support for custom header.
add_theme_support( 'custom-header', array(
	'width'           => 600,
	'height'          => 160,
	'header-selector' => '.site-title a',
	'header-text'     => false,
	'flex-height'     => true,
) );


// Add support for custom background.
//add_theme_support( 'custom-background' );

// Add support for after entry widget.
add_theme_support( 'genesis-after-entry-widget-area' );

// Add support for 3-column footer widgets.
add_theme_support( 'genesis-footer-widgets', 3 );

// Add Image Sizes.
add_image_size( 'featured-image', 720, 400, TRUE );

// Rename primary and secondary navigation menus.
add_theme_support( 'genesis-menus', array( 'primary' => __( 'After Header Menu', 'cb' ), 'secondary' => __( 'Footer Menu', 'cb' ) ) );

// Reposition the secondary navigation menu.
remove_action( 'genesis_after_header', 'genesis_do_subnav' );
add_action( 'genesis_footer', 'genesis_do_subnav', 5 );

// Reduce the secondary navigation menu to one level depth.
add_filter( 'wp_nav_menu_args', 'cb_secondary_menu_args' );
function cb_secondary_menu_args( $args ) {

	if ( 'secondary' != $args['theme_location'] ) {
		return $args;
	}

	$args['depth'] = 1;

	return $args;

}

// Modify size of the Gravatar in the author box.
add_filter( 'genesis_author_box_gravatar_size', 'cb_author_box_gravatar' );
function cb_author_box_gravatar( $size ) {
	return 90;
}

// Modify size of the Gravatar in the entry comments.
add_filter( 'genesis_comment_list_args', 'cb_comments_gravatar' );
function cb_comments_gravatar( $args ) {

	$args['avatar_size'] = 60;

	return $args;

}

// FOOTER FUNCTIONS

//* Sticky Footer Functions
add_action( 'genesis_before_header', 'stickyfoot_wrap_begin');
function stickyfoot_wrap_begin() {
	echo '<div class="vh-wrap">';
}
//add_action( 'genesis_before_footer', 'stickyfoot_wrap_end');
add_action( 'genesis_after_content_sidebar_wrap', 'stickyfoot_wrap_end'); // if using footer widgets
function stickyfoot_wrap_end() {
	echo '</div><!--end-vh-wrap-->';
}

/**
 * Remove Genesis Page Templates
 *
 * @author Bill Erickson
 * @link http://www.billerickson.net/remove-genesis-page-templates
 *
 * @param array $page_templates
 * @return array
 */
function be_remove_genesis_page_templates( $page_templates ) {
	unset( $page_templates['page_archive.php'] );
	unset( $page_templates['page_blog.php'] );
	return $page_templates;
}
add_filter( 'theme_page_templates', 'be_remove_genesis_page_templates' );


unregister_sidebar( 'header-right' );
//* Reposition the primary navigation menu
remove_action( 'genesis_after_header', 'genesis_do_nav' );
add_action( 'genesis_header', 'genesis_do_nav', 12 );

// Add support for Genesis Structural Wraps
add_theme_support( 'genesis-structural-wraps', array( 
	'header', 
	//'nav', 
	//'subnav', 
	//'inner', 
	'footer-widgets', 
	'footer' ) );

/**
 * Custom footer 'creds' text.
 *
 * @since 2.0.0
 */
add_filter( 'genesis_footer_output', 'bfg_footer_creds_text' );

function bfg_footer_creds_text() {

	 return '<p>' . __( 'Copyright', CHILD_THEME_TEXT_DOMAIN ) . ' [footer_copyright] Chris Bryant, All rights reserved. <a href="/terms" title="Terms of Use">Disclaimer</a> <a href="/privacy" title="Privacy Policy">Privacy Policy</a> <a href="/sitemap" title="Sitemap">Sitemap</a> <a href="/contact" title="Contact Chris Bryant">Contact</a> <a class="cbatt" href="https://cb.com" title="Kelowna Web Design and Marketing">Site &amp; Marketing by Chris Bryant</a></p>';

}
