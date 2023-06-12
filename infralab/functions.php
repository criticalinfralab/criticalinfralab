<?php
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
 * Ajax load more posts
 */

function infralab_load_scripts() {
    wp_enqueue_script('jquery');
    wp_register_script( 'infralab_load_more', get_stylesheet_directory_uri() . '/js/loadmore.js', array('jquery') );
    wp_localize_script('infralab_load_more', 'infralab_string', array(
        'ajaxurl' => admin_url('admin-ajax.php'),
        'buttontxt' => __('Load more','infralab-theme'),
        'buttonload' => __('Loading ...','infralab-theme'),
    ));
    wp_enqueue_script( 'infralab_load_more' );
}
add_action( 'wp_enqueue_scripts', 'infralab_load_scripts' );

function infralab_load_more_handler(){
    $args = json_decode( stripslashes( $_POST['query'] ), true );
    $args['paged'] = $_POST['page'] + 1;
    $args['post_status'] = 'publish';
    query_posts( $args );
    if( have_posts() ) {
        while( have_posts() ) { the_post();
            get_template_part('post-content');
        }
    }
    die;
}
add_action('wp_ajax_infralab_load_more', 'infralab_load_more_handler');
add_action('wp_ajax_nopriv_infralab_load_more', 'infralab_load_more_handler');
