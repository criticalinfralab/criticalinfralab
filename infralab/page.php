<?php get_header(); ?>
<div id="content" class="content">
    <?php if (have_posts()) : ?>
        <div id="section">
            <div class="section-content">
                <?php while (have_posts()) : the_post(); ?>
                    <h1 class="section-title"><?php the_title(); ?></h1>
                    <div class="item" id="page-<?php the_ID(); ?>">
                        <div class="item-content">
                            <?php the_content(); ?>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>
    <?php else: ?>
	<p>Oops, there is nothing here.
	<strong><a href="<?php bloginfo('url'); ?>">Go back to start and retrace your steps?</a></strong></p>
    <?php endif; ?>
</div>
<?php get_footer(); ?>
