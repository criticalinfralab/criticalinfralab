            <div class="post post-thumb" id="post-<?php the_ID(); ?>">
                <?php if( is_singular('post') || is_home() ): ?>
                    <div class="post-meta">
                        <?php echo get_the_date(); ?>
                    </div>
                <?php endif; ?>
                <h2 class="post-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                <?php if(has_post_thumbnail() && !is_home() && !is_category() && !is_singular('post')): ?>
                    <div class="featured-image"><?php the_post_thumbnail('thumbnail'); ?></div>
                <?php endif; ?>
                <div class="entry">
                    <?php the_content(); ?>
                </div>
            </div>
