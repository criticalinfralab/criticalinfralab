<?php get_header(); ?>
<div class="section">
    <div class="section-content">
        <?php if (have_posts()) : ?>
            <?php while (have_posts()) : the_post(); ?>
                <?php get_template_part('post-content.php'); ?>
            <?php endwhile; ?>
        <?php endif; ?>
    </div>
</div>
<?php get_template_part('nav.php'); ?>
<?php get_footer(); ?>
