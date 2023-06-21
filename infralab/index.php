<?php get_header(); ?>
<div id="content">
   <?php if (have_posts()) : ?>
        <?php while (have_posts()) : the_post(); ?>
            <?php if(get_post_type() != 'page'): ?>
            <div class="section" id="section-activities">
               <div class="section-content">
                   <h2 class="section-title"><a href="<?php bloginfo('url'); ?>/activities" rel="nofollow">activities</a></h2>
                   <a class="go-home" href="<?php bloginfo('url'); ?>">←</a>
		   <div class="item">
		       <h2 class="item-title"><?php the_title(); ?></h2>
		       <div class="item-content">
		       <?php the_content(); ?>
	               </div>
		    </div>
		</div>
            </div>
            <?php else: ?>
		<?php global $post;
		$slug = $post->post_name; ?>
            <div class="section" id="section-<?php echo $slug; ?>">
               <h2 class="section-title"><a href="<?php echo $page->guid; ?>" rel="nofollow"><?php the_title(); ?></a></h2>
               <div class="section-content">
                   <?php the_content(); ?>
               </div>
            </div>
            <?php endif; ?>
       <?php endwhile; ?>
       <?php get_template_part('nav.php'); ?>
   <?php else: ?>
	<p>Oops, there is nothing here.
	<strong><a href="<?php bloginfo('url'); ?>">Go back to start and retrace your steps?</a></strong></p>
   <?php endif; ?>
</div>
<?php get_footer(); ?>
