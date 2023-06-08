<?php get_header(); ?>
    <div id="content" class="content">
        <?php if (have_posts()) : ?>
            <?php while (have_posts()) : the_post(); ?>
                <?php include(TEMPLATEPATH.'/content_thumb.php'); ?>
            <?php endwhile; ?>
        <?php endif; ?>
    </div>
    <?php include(TEMPLATEPATH.'/nav.php'); ?>
<?php get_footer(); ?>
