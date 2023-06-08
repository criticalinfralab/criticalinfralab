<?php get_header(); ?>
    <div id="content" class="content">
        <h1 class="page-title"><?php pll_e('Search results:'); echo " ".get_search_query(); ?></h1>
        <?php if (have_posts()) : ?>
            <?php while (have_posts()) : the_post(); ?>
                <?php include(TEMPLATEPATH.'/content_result.php'); ?>
            <?php endwhile; ?>
        <?php else : ?>
            <?php pll_e('No results for your search.'); ?>
        <?php endif; ?>
        <?php include(TEMPLATEPATH.'/nav.php'); ?>
    </div>
<?php get_footer(); ?>
