<?php

// 1. Disable Emojis JS, CSS, and Feeds (default: active)
// 2. Disable Comment Reply JS (default: active)
// 3. FIX POOR Query Strings Reported by GT Metrix (default: active)
// 4. Clean up WordPress Head (default: active)
// 5. Remove WP Version Numbers
// 6. Remove Auto-Generated Markup
// 7. Add Browser to Body Class




// 1. Disable Emojis JS, CSS, and Feeds
// WP 4.2 Added a pile of emoticons and smilies - this removes it.
/*---------------------------------------------------*/

function disable_wp_emojicons() {

  // all actions related to emojis
  remove_action( 'admin_print_styles', 'print_emoji_styles' );
  remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
  remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
  remove_action( 'wp_print_styles', 'print_emoji_styles' );
  remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
  remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
  remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );

  // filter to remove TinyMCE emojis
  add_filter( 'tiny_mce_plugins', 'disable_emojicons_tinymce' );
}
add_action( 'init', 'disable_wp_emojicons' );

function disable_emojicons_tinymce( $plugins ) {
  if ( is_array( $plugins ) ) {
    return array_diff( $plugins, array( 'wpemoji' ) );
  } else {
    return array();
  }
}


// 2. Disable Comment Reply JS
// Comment this out if you are allowing comments on the site
/*---------------------------------------------------*/

function disable_comment_reply_js(){
    wp_deregister_script( 'comment-reply' );
         }
add_action('init','disable_comment_reply_js');



// 3. FIX POOR Query Strings Reported by GT Metrix
// No Idea how this works but if yields a higher score at GT Metrix
/*---------------------------------------------------*/

function pu_remove_script_version( $src ){
    return remove_query_arg( 'ver', $src );
}
add_filter( 'script_loader_src', 'pu_remove_script_version' );
add_filter( 'style_loader_src', 'pu_remove_script_version' );



// 4. Clean up WordPress Head
/*---------------------------------------------------*/

function bones_head_cleanup() {
  
  remove_action( 'wp_head', 'feed_links_extra', 3 ); // category feeds
  remove_action( 'wp_head', 'feed_links', 2 ); // post and comment feeds
  remove_action( 'wp_head', 'rsd_link' ); // EditURI link
  remove_action( 'wp_head', 'wlwmanifest_link' ); // windows live writer
  remove_action( 'wp_head', 'index_rel_link' ); // index link
  remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 ); // previous link
  remove_action( 'wp_head', 'start_post_rel_link', 10, 0 ); // start link
  remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 ); // links for adjacent posts
  remove_action( 'wp_head', 'wp_generator' ); // WP version
} 
add_action( 'init', 'bones_head_cleanup' );


// 5. Remove WP Version Numbers
/*---------------------------------------------------*/

function bones_remove_wp_ver_css_js( $src ) {
  if ( strpos( $src, 'ver=' ) )
    $src = remove_query_arg( 'ver', $src );
  return $src;
}
add_filter( 'style_loader_src', 'bones_remove_wp_ver_css_js', 9999 ); // remove WP version from css
add_filter( 'script_loader_src', 'bones_remove_wp_ver_css_js', 9999 ); // remove Wp ver from scripts


// 5. Remove Auto-Generated Markup
/*---------------------------------------------------*/

remove_filter('the_content', 'wpautop');

// remove the p from around imgs (http://css-tricks.com/snippets/wordpress/remove-paragraph-tags-from-around-images/)
function bones_filter_ptags_on_images($content){
  return preg_replace('/<p>\s*(<a .*>)?\s*(<img .* \/>)\s*(<\/a>)?\s*<\/p>/iU', '\1\2\3', $content);
}

// This removes the annoying […] to a Read More link
function bones_excerpt_more($more) {
  global $post;
  // edit here if you like
  return '...  <a class="excerpt-read-more" href="'. get_permalink($post->ID) . '" title="'. __( 'Read ', 'bonestheme' ) . get_the_title($post->ID).'">'. __( 'Read more &raquo;', 'bonestheme' ) .'</a>';
}



// 7. Add Browser to Body Class
// Nathan Rice Snippet to Add Browser to Body Class
// http://www.wpbeginner.com/wp-themes/wordpress-body-class-101-tips-and-tricks-for-theme-designers/
/*---------------------------------------------------*/

add_filter('body_class','browser_body_class');
function browser_body_class($classes) {
  global $is_lynx, $is_gecko, $is_IE, $is_opera, $is_NS4, $is_safari, $is_chrome, $is_iphone;

  if($is_lynx) $classes[] = 'lynx';
  elseif($is_gecko) $classes[] = 'gecko';
  elseif($is_opera) $classes[] = 'opera';
  elseif($is_NS4) $classes[] = 'ns4';
  elseif($is_safari) $classes[] = 'safari';
  elseif($is_chrome) $classes[] = 'chrome';
  elseif($is_IE) $classes[] = 'ie';
  else $classes[] = 'unknown';

  if($is_iphone) $classes[] = 'iphone';
  return $classes;
}



/* DON'T DELETE THIS CLOSING TAG */ ?>
