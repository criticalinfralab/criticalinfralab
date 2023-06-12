<div class="navigation">
<?php if (is_single()) : ?>
    <div class="previous"><?php previous_post_link('%link') ?></div>
    <div class="next"><?php next_post_link('%link') ?></div>
<?php else: ?>
    <span class="next"><?php next_posts_link() ?></span>
    <span class="previous"><?php previous_posts_link() ?></span>
<?php endif; ?>
</div>
