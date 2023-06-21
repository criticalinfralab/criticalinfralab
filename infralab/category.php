<?php get_header(); ?>
<div id="content">
   <?php if (have_posts()) : ?>
        <div class="section" id="section-activities">
           <div class="section-content">
               <a class="go-home" href="<?php bloginfo('url'); ?>">←</a>
               <h2 class="section-title">activities</h2>
	       <?php while (have_posts()) : the_post(); ?>
                   <?php get_template_part('post-content'); ?>
                <?php endwhile; ?>
            </div>
       </div>
       <?php get_template_part('nav.php'); ?>
   <?php else: ?>
	<p>Oops, there is nothing here.
	<strong><a href="<?php bloginfo('url'); ?>">Go back to start and retrace your steps?</a></strong></p>
   <?php endif; ?>
</div>
<?php get_footer(); ?>
