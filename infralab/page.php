<?php get_header(); ?>
<div id="content" class="content">
    <?php if (have_posts()) : ?>
        <?php while (have_posts()) : the_post(); ?>
        <div class="section" id="section-<?php echo $post->post_name; ?>">
            <a class="go-home" href="<?php bloginfo('url'); ?>">←</a>
            <div class="section-content">
                <h1 class="section-title"><?php the_title(); ?></h1>
                <?php the_content(); ?>
            </div>
        </div>
        <?php endwhile; ?>
    <?php else: ?>
	<p>Oops, there is nothing here.
	<strong><a href="<?php bloginfo('url'); ?>">Go back to start and retrace your steps?</a></strong></p>
    <?php endif; ?>
</div>
<?php get_footer(); ?>
