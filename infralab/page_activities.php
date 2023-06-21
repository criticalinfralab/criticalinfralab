<?php
/*
Template Name: Activities
*/
?>
<?php get_header(); ?>
    <div id="content" class="content">
        <?php if (have_posts()) : ?>
        <?php while (have_posts()) : the_post(); ?>
	   <div class="section" id="section-<?php echo $post->post_name; ?>">
               <a class="go-home" href="<?php bloginfo('url'); ?>">←</a>
	       <h2 class="section-title"><?php the_title(); ?></h2>
	<?php endwhile; ?>
	    <div class="section-content">
	        <?php // blogposts
                $count = get_option('posts_per_page', 5);
                $paged = get_query_var('paged') ? get_query_var('paged') : 1;
	        $postquery = new WP_Query( array(
	            'post-type' => 'post',
	            'post_status'  => 'publish',
	            'sort_order' => 'ASC',
                    'posts_per_page' => $count,
                    'paged' => $paged
	        ));
                if ($postquery->have_posts()) : 
                    while ($postquery->have_posts()) : $postquery->the_post();
                         get_template_part('post-content');
	            endwhile;
	        endif;
                // Pagination
                if($postquery->max_num_pages > 1) {
                    if($postquery->query_vars["paged"] == 0) {
                        $current_page = 1;
                    } else {
                        $current_page = $postquery->query_vars["paged"];
                    }
                    echo '<div class="pagination" data-query="'.htmlspecialchars(json_encode($postquery->query_vars)).'" data-maxpages="'.htmlspecialchars(json_encode($postquery->max_num_pages)).'" data-current="'.$current_page.'">'.paginate_links(array('total' => $postquery->max_num_pages)).'</div>';
                }
	        wp_reset_postdata(); ?>
	    </div>
        <?php endif; ?>
    </div>
<?php get_footer(); ?>
