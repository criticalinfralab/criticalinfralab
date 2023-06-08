<?php get_header(); ?>
    <?php if (have_posts()) : ?>
    <div id="content" class="content">
        <?php if(is_singular('post')): ?> <h2 class="page-title"><?php the_title(); ?></h2> <?php endif; ?>
        <?php while (have_posts()) : the_post(); ?>
              <?php include(TEMPLATEPATH.'/content_thumb.php'); ?>
        <?php endwhile; ?>
        <?php include(TEMPLATEPATH.'/nav.php'); ?>
    </div>
    <?php endif; ?>
<?php get_footer(); ?>
