<?php
/*
Template Name: Homepage
*/
?>
<?php get_header(); ?>
    <div id="content" class="content">
        <?php if (have_posts()) : ?>
            <?php while (have_posts()) : the_post(); ?>
                <div class="site-description"><?php the_content(); ?></div>
            <?php endwhile; ?>
            <?php // subpages
            $args = array(
                'child_of' => $post->ID,
                'post-type' => 'page',
   	        'posts_per_page' => -1,
                'post_status'  => 'publish',
                'sort_column' => 'menu_order',
                'sort_order' => 'ASC'
            );
            $pages = get_pages($args);
            foreach($pages as $page): ?>
	        <div class="section">
	            <h2 class="section-title"><?php echo $page->post_title; ?></h2>
	    	    <div class="section-content">
	            <?php if(str_contains($page->post_title, 'activit')) : ?>
	    	        <?php // blogposts
	    	        $postquery = new WP_Query( array(
	    	            'post-type' => 'post',
	    	            'posts_per_page' => -1,
	    	            'post_status'  => 'publish',
	    	            'sort_order' => 'ASC'
	    	        ));
                        if ($postquery->have_posts()) : 
                            while ($postquery->have_posts()) : $postquery->the_post();
                            $category = get_the_category(); ?> 
	                    <div class="item">
                                <?php if(has_tag('has-recording')): ?>
                                   <span class="has-recording">📹 <!-- has link to a recording --></span>
                                <?php endif; ?>
	                        <h4 class="item-title"><em class="category"><?php echo $category[0]->cat_name; ?></em><span><?php the_title(); ?></span></h4>
	                        <div class="item-content"><?php the_content(); ?></div>
	                   </div>
	                  <?php endwhile;
	                  wp_reset_postdata();
	               endif; ?>
	            <?php else : ?>
	    	        <?php echo $page->post_content; ?>
	            <?php endif; ?>
	            </div>
	        </div>
            <?php endforeach; ?>
        <?php endif;
        wp_reset_postdata(); ?>
    </div>
<?php get_footer(); ?>
