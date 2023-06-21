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
	        <div class="section" id="section-<?php echo $page->post_name; ?>">
	            <h2 class="section-title"><a href="<?php echo $page->guid; ?>" rel="nofollow"><?php echo $page->post_title; ?></a></h2>
	            <?php if(str_contains($page->post_title, 'activit')) : ?>
	    	    <div class="section-content blogposts">
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
	        <?php else : ?>
	    	   <div class="section-content">
	    	       <?php echo remove_html_comments($page->post_content); ?>
	           </div>
	        <?php endif; ?>
	        </div>
            <?php endforeach; ?>
        <?php endif;
        wp_reset_postdata(); ?>
    </div>
<?php get_footer(); ?>
