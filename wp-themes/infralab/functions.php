<?php
function removeHeadLinks() {
   remove_action('wp_head', 'rsd_link');
   remove_action('wp_head', 'wlwmanifest_link');
   // remove emoji code
   remove_action('wp_head', 'print_emoji_detection_script', 7);
   remove_action('wp_print_styles', 'print_emoji_styles');
   remove_action('admin_print_scripts', 'print_emoji_detection_script');
   remove_action('admin_print_styles', 'print_emoji_styles');
}
add_action('init', 'removeHeadLinks');

// no generator in head
remove_action('wp_head', 'wp_generator');

// remove WP HTML markup comments
// https://davidwalsh.name/remove-html-comments-php
function remove_html_comments($content='') {
    return preg_replace('/<!--(.|\s)*?-->/', '', $content);
}

// Globally deactivate comments
function __disable_feature($data) { return false; }
add_filter('comments_number', '__disable_feature');
add_filter('comments_open', '__disable_feature');

/**
 * Ajax load more posts
 */

function infralab_load_scripts() {
    wp_enqueue_script('jquery');
    wp_register_script( 'infralab_load_more', get_stylesheet_directory_uri() . '/js/loadmore.js', array('jquery') );
    wp_localize_script('infralab_load_more', 'infralab_string', array(
        'ajaxurl' => admin_url('admin-ajax.php'),
        'buttontxt' => __('See more','infralab-theme'),
        'buttonload' => __('Loading…','infralab-theme'),
    ));
    wp_enqueue_script( 'infralab_load_more' );

    wp_register_script( 'infralab_cookie', get_stylesheet_directory_uri() . '/js/js.cookie.min.js' );
    wp_enqueue_script( 'infralab_cookie' );

    wp_register_script( 'infralab_cookie_bg', get_stylesheet_directory_uri() . '/js/cookie-background.js' );
    wp_enqueue_script( 'infralab_cookie_bg' );
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
