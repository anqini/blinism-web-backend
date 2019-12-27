<?php  
   global $post ;
   $count = 0;
   $query_args = array('post_type' => 'post' , 'showposts' => $num , 'order_by' => $sort , 'order' => $order);
   if( $cat ) $query_args['category_name'] = $cat;
   $query = new WP_Query($query_args) ; 
   ?>   
<?php if($query->have_posts()):  ?>   

<!--News Section-->
<section class="news-section">
    <div class="auto-container">
        <!--Sec Title-->
        <div class="sec-title light clearfix">
            <div class="pull-left">
                <h2><?php echo wp_kses_post($title); ?></h2>
                <div class="separator"></div>
            </div>
            <div class="pull-right">
                <a href="<?php echo esc_url($btn_link); ?>" class="theme-btn btn-style-four"><?php echo wp_kses_post($btn_title); ?></a>
            </div>
        </div>
        <div class="row clearfix">
            <?php while($query->have_posts()): $query->the_post();
				global $post ; 
				$post_meta = _WSH()->get_meta();
			?>
            <?php 
				$post_thumbnail_id = get_post_thumbnail_id($post->ID);
				$post_thumbnail_url = wp_get_attachment_url( $post_thumbnail_id );
			?>
            <!--News Block-->
            <div class="news-block col-lg-3 col-md-4 col-sm-6 col-xs-12">
                <div class="inner-box">
                    <div class="content">
                        <div class="post-date"><?php echo get_the_date(); ?></div>
                        <h3><?php the_title(); ?></h3>
                        <ul class="meta-option">
                            <li><span class="icon fa fa-user"></span><?php esc_html_e('By', 'pickton'); ?> <?php the_author(); ?></li>
                            <li><span class="icon fa fa-comments"></span><?php comments_number( wp_kses_post(__('0 Comments' , 'pickton')), wp_kses_post(__('1 Comment' , 'pickton')), wp_kses_post(__('% Comments' , 'pickton'))); ?></li>
                        </ul>
                    </div>
                    <div class="overlay-box" style="background-image:url('<?php echo esc_url($post_thumbnail_url); ?>');">
                        <div class="overlay-inner">
                            <h4><a href="<?php echo esc_url(get_the_permalink(get_the_id())); ?>"><?php the_title(); ?> </a></h4>
                            <div class="text"><?php echo wp_kses_post(pickton_trim(get_the_content(), $text_limit)); ?></div>
                            <a href="<?php echo esc_url(get_the_permalink(get_the_id())); ?>" class="read-more"><?php esc_html_e('Read More', 'pickton'); ?> <span class="fa fa-angle-right"></span></a>
                        </div>
                    </div>
                </div>
            </div>
            <?php endwhile;?>
        </div>
    </div>
</section>
<!--End News Section-->

<?php endif; wp_reset_postdata(); ?>