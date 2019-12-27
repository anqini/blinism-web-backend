<!--News Block Three-->
<div class="news-block-three">
    <div class="inner-box">
        <?php if(has_post_thumbnail()):?>
        <div class="image">
            <?php the_post_thumbnail('pickton_1170x420'); ?>
            <div class="tag"><?php the_category(', '); ?></div>
        </div>
        <?php endif; ?>
        <div class="lower-content">
            <ul class="post-meta">
                <li><span class="icon fa fa-calendar"></span><?php echo get_the_date(); ?></li>
                <li><span class="icon fa fa-user"></span><?php esc_html_e('By', 'pickton'); ?> <?php the_author(); ?></li>
                <li><span class="icon fa fa-comments"></span><?php comments_number( wp_kses_post(__('0 Comments' , 'pickton')), wp_kses_post(__('1 Comment' , 'pickton')), wp_kses_post(__('% Comments' , 'pickton'))); ?></li>
            </ul>
            <h3><a href="<?php echo esc_url(get_the_permalink(get_the_id()));?>"><?php the_title(); ?></a></h3>
            <div class="text"><?php the_excerpt();?> </div>
            <a href="<?php echo esc_url(get_the_permalink(get_the_id()));?>" class="theme-btn btn-style-three"><?php esc_html_e('Read More', 'pickton'); ?></a>
        </div>
    </div>
</div>