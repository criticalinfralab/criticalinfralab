<?php
/*
Template Name: Homepage
*/
?>
<?php get_header(); ?>
    <div id="content" class="content">
        <?php if (have_posts()) : ?>
            <?php while (have_posts()) : the_post(); ?>
                <h1 class="page-title"><?php the_title(); ?></h1>
                <p class="infratext"><?php the_content(); ?></p>

                <?php // subpages
                $args = array(
                    'post_parent' => $post->ID,
                    'post-type' => 'page',
   		    'posts_per_page' => -1,
                    'post_status'  => 'publish',
                    'sort_column' => 'menu_order',
                    'sort_order' => 'ASC'
                );
                $pages = get_pages($args);
                $count = 0;
                foreach($pages as $page): ?>
		    <?php if(str_contains($page->post_title, 'activit')) : ?>
			<div class="item <?php echo 'item-activities'; ?>">
			    <h2 class="item-title">Our current activities</h2>
			    <div class="item-content">FIXME query blog items.</div>
			</div>
		    <?php else : ?>
			<div class="item <?php echo 'item-'.$count; ?>">
			    <h2 class="item-title"><?php echo $page->post_title; ?></h2>
			    <div class="item-content"><?php echo $page->post_content; ?></div>
			</div>
		    <?php endif; ?>
                    <?php $count++; ?>
                <?php endforeach; ?>
            <?php endwhile; ?>
            <?php wp_reset_postdata(); ?>
        <?php endif; ?>
    </div>
<?php get_footer(); ?>
