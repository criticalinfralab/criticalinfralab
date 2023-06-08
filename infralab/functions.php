<?php
add_action( 'after_setup_theme', 'curlybracket_setup' );
if ( ! function_exists( 'curlybracket_setup' ) ):
function curlybracket_setup() {
    // This theme uses wp_nav_menu() in one location.
    register_nav_menu( 'primary', __( 'MainMenu', 'curlybracket' ) );
    // WP post thumbnails
    add_theme_support( 'post-thumbnails' );
}
endif;

function removeHeadLinks() {
       remove_action('wp_head', 'rsd_link');
       remove_action('wp_head', 'wlwmanifest_link');
}
add_action('init', 'removeHeadLinks');

// Globally deactivate comments
function __disable_feature($data) { return false; }
add_filter('comments_number', '__disable_feature');
add_filter('comments_open', '__disable_feature');

// no generator in head
remove_action('wp_head', 'wp_generator');

/*
 * Safari Mac cannot display images with Umlauts as Filenames. so we force a replacement when uploading.
*/
function sanitize_filename_on_upload($filename) {
    $ext = end(explode('.',$filename));
    // Replace all weird characters
    $sanitized = preg_replace('/[^a-zA-Z0-9-_.]/','', substr($filename, 0, -(strlen($ext)+1)));
    // Replace dots inside filename
    $sanitized = str_replace('.','-', $sanitized);
    return strtolower($sanitized.'.'.$ext);
}
add_filter('sanitize_file_name', 'sanitize_filename_on_upload', 10);

/**
 * Adds the Customize page to the WordPress admin area
 */
function theme_customizer_menu_on() {
    add_theme_page( 'Customize', 'Customize', 'edit_theme_options', 'customize.php' );
}
add_action( 'admin_menu', 'theme_customizer_menu_on' );
