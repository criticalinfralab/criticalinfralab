<?php $category = get_the_category(); ?>
<div class="item<?php if ( empty( get_the_content() ) ): echo " empty-content"; endif; ?>">
    <?php if($post->post_status == "publish"): ?>
        <a class="permalink" href="<?php the_permalink(); ?>" title="permanent link to <?php the_title(); ?>">#</a>
    <?php endif; ?>
    <?php if(has_tag('has-recording')): ?>
       <span class="has-recording" title="This item has a link to a recording."><!-- has link to a recording --></span>
    <?php endif; ?>
    <h4 class="item-title">
        <em class="category"><?php echo $category[0]->cat_name; ?></em>
        <span class="title"><?php the_title(); ?></span>
        <span class="date"><?php the_time('F Y');?></span>
    </h4>
    <?php if ( !empty( get_the_content() ) ): ?>
    <div class="item-content hidden"><?php the_content(); ?></div>
    <?php endif; ?>
</div>
