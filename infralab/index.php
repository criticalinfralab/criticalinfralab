<?php get_header(); ?>
<div id="content">
   <?php if (have_posts()) : ?>
        <?php while (have_posts()) : the_post(); ?>
            <?php if(get_post_type() != 'page'): ?>
            <div class="section" id="section-activities">
               <div class="section-content">
                   <h2 class="section-title">activities</h2>
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
               <h2 class="section-title"><?php the_title(); ?></h2>
               <div class="section-content">
                   <?php the_content(); ?>
               </div>
            </div>
            <?php endif; ?>
        <?php endwhile; ?>
   <?php endif; ?>
   <?php get_template_part('nav.php'); ?>
</div>
<?php get_footer(); ?>
