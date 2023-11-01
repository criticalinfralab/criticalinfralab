<?php
/*
Template Name: Upcoming
*/
?>
<?php get_header(); ?>
    <div id="content" class="content">
        <?php if (have_posts()) : ?>
        <?php while (have_posts()) : the_post(); ?>
       <div class="section" id="section-<?php echo $post->post_name; ?>">
           <h2 class="section-title"><?php the_title(); ?></h2>
               <a class="go-home" href="<?php bloginfo('url'); ?>">←</a>
    <?php endwhile; ?>
        <div class="section-content">
            <?php // blogposts
                $postquery = new WP_Query( array(
                    'post-type' => 'post',
                    'post_status'  => 'future',
                    'sort_order' => 'ASC',
                    'posts_per_page' => -1,
                ));
                if ($postquery->have_posts()) :
                    while ($postquery->have_posts()) : $postquery->the_post();
                         get_template_part('post-content');
                endwhile;
            endif;
            wp_reset_postdata(); ?>
        </div>
        <?php endif; ?>
    </div>
<?php get_footer(); ?>
