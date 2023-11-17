<?php $category = get_the_category(); ?>
<div class="item">
    <?php if(has_tag('has-recording')): ?>
    <span class="has-recording"><!-- has link to a recording --></span>
    <?php endif; ?>
    <h2 class="item-title">
        <em class="category"><?php echo $category[0]->cat_name; ?></a></em>
        <span class="title"><?php the_title(); ?></span>
        <span class="date">
        <?php if($category[0]->cat_name != "reading group"):
            $has_custom_date = filter_var(get_post_meta(get_the_ID(), 'date', true), FILTER_SANITIZE_STRING);;
            if(!empty($has_custom_date)):
                echo $has_custom_date;
            else:
                the_time('F Y');
            endif;
        endif; ?></span>
    </h2>
    <div class="item-content"><?php the_content(); ?></div>
</div>
