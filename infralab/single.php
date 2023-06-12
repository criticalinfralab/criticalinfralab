<?php get_header(); ?>
<?php if (have_posts()) : ?>
    <div id="content">
        <?php while (have_posts()) : the_post(); ?>
            <?php $category = get_the_category(); ?>
            <div class="section">
                <span class="section-title"><?php echo $category[0]->cat_name; ?></span>
		<div class="section-content">
                    <div class="item">
                        <?php if(has_tag('has-recording')): ?>
                        <span class="has-recording">📹 <!-- has link to a recording --></span>
                        <?php endif; ?>
                        <h2 class="item-title">
                            <span class="title"><?php the_title(); ?></span>
                            <span class="date"><?php if($category[0]->cat_name != "reading group"): the_time('F Y'); endif; ?></span>
                        </h2>
                        <div class="item-content"><?php the_content(); ?></div>
                   </div>
	      </div>
    	</div>
        <?php endwhile; ?>
        <?php get_template_part('nav'); ?>
    </div>
<?php endif; ?>
<?php get_footer(); ?>
