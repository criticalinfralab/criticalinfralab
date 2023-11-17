<?php
/*
Template Name: Preview Event
*/
?>
<?php get_header(); ?>
<div id="content" class="content">
    <?php if (have_posts()) : ?>
        <?php while (have_posts()) : the_post(); ?>
        <div class="section" id="section-<?php echo $post->post_name; ?>">
            <div class="section-content">
                <h1 class="section-title"><?php the_title(); ?></h1>
                <a class="go-home" href="<?php bloginfo('url'); ?>">←</a>
                <?php the_content(); ?>
                <?php // find out if the ID exists, if it's a scheduled post or a published post
                    if($_GET['id']) {
                        $postid = filter_var((int)$_GET['id'], FILTER_SANITIZE_NUMBER_INT);
                        $posttype = get_post_type( $postid );
                        if ( "publish" == get_post_status( $postid ) OR "future" == get_post_status( $postid ) AND $posttype == "post" ) {
                            $args = array(
                                'p' => $postid,
                                'post_type' => 'post'
                            );
                            $postquery = new WP_Query($args);
                            if ($postquery->have_posts()) :
                                while ($postquery->have_posts()) : $postquery->the_post();
                                    get_template_part('post-content');
                                endwhile;
                            endif;
                            wp_reset_postdata();

                            if ( "publish" == get_post_status( $postid ) ) {
                                // redirect to published post with JS
                                echo '<script>window.location = "'. get_permalink($postid) .'"</script>';
                                echo '<noscript>If you are not being redirected, please click <a href="'.get_permalink($postid).'>here</a>."</noscript>';
                            }
                        }
                    }
                ?>
            </div>
        </div>
        <?php endwhile; ?>
    <?php else: ?>
    <p>Oops, there is nothing here.
    <strong><a href="<?php bloginfo('url'); ?>">Go back to start and retrace your steps?</a></strong></p>
    <?php endif; ?>
</div>
<?php get_footer(); ?>
