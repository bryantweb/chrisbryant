<?php

//* 1. Add ACF Options Menu and Page (default: active)
//* 2. Disable ACF on Frontend (default: inactive)
//* 3. Control Who Sees What (default: active)
//* 4. Remove Genesis menu link (default: inactive)
//* 5. Remove WP LOGO from Top Bar in the backend (default: active)
//* 6. Customize Footer Text in the Admin Area (default: active)
//* 7. Remove WP Admin Bar (default: active)

//* 8. Unregister default Genesis layouts. (default: inactive)
//* 9. Unregister default Genesis sidebars. (default: inactive)
//* 10. Unregister default Genesis widgets. (default: active)


//* 11. Remove Dashboard Meta
//* 12. Unregister Widgets
// - Akismet (default: active)
// - Welcome Panel (default: active)
// - Yoast Dashboard Widget (default: inactive)
//* 13. Unregister Default WP Widgets



//* 1. ACF
// If using ACF, this code controls the options menu.
/*---------------------------------------------------*/

if( function_exists('acf_add_options_page') ) {
    
    acf_add_options_page(array(
        'page_title'    => 'Site Options',
        'menu_title'    => 'Site Options',
        'menu_slug'     => 'site-options',
        'capability'    => 'edit_posts',
        'redirect'      => false
    ));   
}

// 2. Disable ACF on Frontend
/*---------------------------------------------------*/

function ea_disable_acf_on_frontend( $plugins ) {

    if( is_admin() )
        return $plugins;

    foreach( $plugins as $i => $plugin )
        if( 'advanced-custom-fields-pro/acf.php' == $plugin )
            unset( $plugins[$i] );
    return $plugins;
}
//add_filter( 'option_active_plugins', 'ea_disable_acf_on_frontend' );



// 3. Control Who Sees What
// Enables the specified user to see selected Admin menus
/*---------------------------------------------------*/

function remove_admin_menus()
{

    // users who can edit selected areas 
    $admins = array( 
        'cebryant', 
    );

    // get the current user
    $current_user = wp_get_current_user();

    // match and remove if needed
    if( !in_array( $current_user->user_login, $admins ) )
    {
      remove_menu_page('edit.php?post_type=acf');		 //Advanced Custom Fields	
      remove_menu_page( 'edit.php' );                   //Posts
    	remove_menu_page( 'edit-comments.php' );          //Comments
    	remove_menu_page( 'themes.php' );                 //Appearance
    	remove_menu_page( 'tools.php' );                  //Tools
    	remove_menu_page( 'options-general.php' );        //Settings
    	remove_menu_page( 'plugins.php' );                //Plugins
    	remove_menu_page('wpseo_dashboard');
    	remove_menu_page( 'index.php' );                  //Dashboard
    	remove_menu_page( 'users.php' );                  //Users
    }

}

add_action( 'admin_menu', 'remove_admin_menus', 999 );

// 4. Remove Genesis menu link
/*---------------------------------------------------*/
//remove_theme_support( 'genesis-admin-menu' ); 



// 5. Remove WP LOGO from Top Bar in the backend
/**
 * Removes the WP icon from the admin bar
 * See: http://wp-snippets.com/remove-wordpress-logo-admin-bar/
 * @since 2.0.0
 */
/*---------------------------------------------------*/

add_action( 'wp_before_admin_bar_render', 'bfg_remove_wp_icon_from_admin_bar' );

function bfg_remove_wp_icon_from_admin_bar() {

	global $wp_admin_bar;
	$wp_admin_bar->remove_menu('wp-logo');

}


// 6. Customize Footer Text in the Admin Area
/**
 * Modify the admin footer text
 * See: http://wp-snippets.com/change-footer-text-in-wp-admin/
 * @since 2.0.0
 */
/*---------------------------------------------------*/

add_filter( 'admin_footer_text', 'bfg_admin_footer_text' );

function bfg_admin_footer_text () {

	echo 'Custom Website by <a href="https://chrisbryant.com" title="Chris Bryant">Chris Bryant</a>. Call 778-215-7784 For Support &amp; Maintenance';

}

// 7. Remove WP Admin Bar
/*---------------------------------------------------*/

show_admin_bar( false );



// 8. Unregister default Genesis layouts.
/*---------------------------------------------------*/

// genesis_unregister_layout( 'content-sidebar' );
// genesis_unregister_layout( 'sidebar-content' );
genesis_unregister_layout( 'content-sidebar-sidebar' );
genesis_unregister_layout( 'sidebar-sidebar-content' );
genesis_unregister_layout( 'sidebar-content-sidebar' );
// genesis_unregister_layout( 'full-width-content' );


// 9. Unregister default Genesis sidebars.
/*---------------------------------------------------*/

// unregister_sidebar( 'header-right' );
unregister_sidebar( 'sidebar-alt' );
// unregister_sidebar( 'sidebar' );

// 10. Unregister default Genesis widgets.
/*---------------------------------------------------*/

add_action( 'widgets_init', 'unregister_genesis_widgets', 20 );
function unregister_genesis_widgets() {
unregister_widget( 'Genesis_Featured_Page' );
unregister_widget( 'Genesis_Featured_Post' );
unregister_widget( 'Genesis_User_Profile_Widget' );
}



// 11. Remove Dashboard Meta
/*---------------------------------------------------*/

function remove_dashboard_meta() {
        remove_meta_box( 'dashboard_incoming_links', 'dashboard', 'normal' );
        remove_meta_box( 'dashboard_plugins', 'dashboard', 'normal' );
        remove_meta_box( 'dashboard_primary', 'dashboard', 'normal' );
        remove_meta_box( 'dashboard_secondary', 'dashboard', 'normal' );
        remove_meta_box( 'dashboard_quick_press', 'dashboard', 'side' );
        remove_meta_box( 'dashboard_recent_drafts', 'dashboard', 'side' );
        remove_meta_box( 'dashboard_recent_comments', 'dashboard', 'normal' );
        remove_meta_box( 'dashboard_right_now', 'dashboard', 'normal' );
        remove_meta_box( 'dashboard_activity', 'dashboard', 'normal');//since 3.8
}
add_action( 'admin_init', 'remove_dashboard_meta' );


// 12. Unregister Widgets
/*---------------------------------------------------*/

// Starting with the Akismet widget...
remove_action( 'welcome_panel', 'wp_welcome_panel' );
function removeAkismetWidget() {
        unregister_widget( 'Akismet_Widget' );
}
add_action( 'widgets_init', 'removeAkismetWidget', 11 );

// removing plugin dashboard boxes
// remove_meta_box( 'yoast_db_widget', 'dashboard', 'normal' ); // Yoast's SEO Plugin Widget

// Remove the Welcome Panel
// remove_action('welcome_panel', 'wp_welcome_panel');


// 13. Unregister Default WordPress Widgets
/*---------------------------------------------------*/

function remove_default_wp_widgets() {
  unregister_widget('WP_Widget_Calendar'); //= Calendar Widget
  unregister_widget('WP_Widget_Pages'); //= Pages Widget
  unregister_widget('WP_Widget_Archives'); //= Archives Widget
  unregister_widget('WP_Widget_Links'); // = Links Widget
  unregister_widget('WP_Widget_Meta'); //= Meta Widget
  //unregister_widget('WP_Widget_Text'); //= Text Widget
  unregister_widget('WP_Widget_Categories'); //= Categories Widget
  unregister_widget('WP_Widget_Recent_Posts'); //= Recent Posts Widget
  unregister_widget('WP_Widget_Recent_Comments'); // = Recent Comments Widget
  unregister_widget('WP_Widget_RSS'); //= RSS Widget
  unregister_widget('WP_Widget_Tag_Cloud'); //= Tag Cloud Widget
  
  // unregister_widget('WP_Nav_Menu_Widget'); //= Menus Widget
  // unregister_widget('WP_Widget_Search'); //= Search Widget
}

add_action( 'widgets_init', 'remove_default_wp_widgets' );





