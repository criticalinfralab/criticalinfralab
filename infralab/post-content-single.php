<?php $category = get_the_category(); ?>
<div class="item">
    <?php if(has_tag('has-recording')): ?>
       <span class="has-recording">📹 <!-- has link to a recording --></span>
    <?php endif; ?>
    <h2 class="item-title">
        <em class="section-title"><?php echo $category[0]->cat_name; ?></em>
        <span class="title"><?php the_title(); ?></span>
        <span class="date"><?php if($category[0]->cat_name != "reading group"): the_time('F Y'); endif; ?></span>
    </h2>
    <div class="item-content"><?php the_content(); ?></div>
</div>
