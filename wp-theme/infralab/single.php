<?php get_header(); ?>
<?php if (have_posts()) : ?>
    <div id="content">
        <div class="section" id="section-activities">
            <span class="section-title"><a href="<?php bloginfo('url'); ?>/activities" rel="nofollow">activities</a></span>
            <a class="go-home" href="<?php bloginfo('url'); ?>">←</a>
            <div class="section-content">
                <?php while (have_posts()) : the_post(); ?>
                    <?php get_template_part('post-content-single'); ?>
                <?php endwhile; ?>
                <?php get_template_part('nav'); ?>
            </div>
        </div>
    </div>
<?php endif; ?>
<?php get_footer(); ?>
