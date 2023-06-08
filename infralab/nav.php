<nav class="nav">
<?php if (is_single()) : ?>
    <div class="previous"><?php previous_post_link() ?></div>
    <div class="next"><?php next_post_link() ?></div>
<?php else: ?>
    <span class="next"><?php next_posts_link() ?></span>
    <span class="previous"><?php previous_posts_link() ?></span>
<?php endif; ?>
</nav>
