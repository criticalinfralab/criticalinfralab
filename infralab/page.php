<?php get_header(); ?>
    <div id="content" class="content">
        <?php if (have_posts()) : ?>
            <?php while (have_posts()) : the_post(); ?>
                <div <?php echo post_class(); ?> id="post-<?php the_ID(); ?>">
                    <h1 class="page-title"><?php the_title(); ?></h1>
                    <div class="entry">
                        <?php the_content(); ?>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else : ?>
            <?php include(TEMPLATEPATH.'/404.php'); ?>
        <?php endif; ?>
    </div>
    <?php get_footer(); ?>
