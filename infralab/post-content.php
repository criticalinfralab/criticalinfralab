<?php $category = get_the_category(); ?>
<div class="item">
        <a class="permalink" href="<?php the_permalink(); ?>" title="permanent link to <?php the_title(); ?>">#</a>
    <?php if(has_tag('has-recording')): ?>
       <span class="has-recording">📹 <!-- has link to a recording --></span>
    <?php endif; ?>
    <h4 class="item-title">
        <em class="category"><?php echo $category[0]->cat_name; ?></em>
        <span class="title"><?php the_title(); ?></span>
        <span class="date"><?php if($category[0]->cat_name != "reading group"): the_time('F Y'); endif; ?></span>
    </h4>
    <div class="item-content hidden"><?php the_content(); ?></div>
</div>
