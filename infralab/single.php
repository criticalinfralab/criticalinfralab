<?php get_header(); ?>
    <?php if (have_posts()) : ?>
    <div id="content" class="content">
        <?php while (have_posts()) : the_post(); ?>
            <?php get_template_part('post-content-single'); ?>
        <?php endwhile; ?>
        <?php get_template_part('nav'); ?>
    </div>
    <?php endif; ?>
<?php get_footer(); ?>
