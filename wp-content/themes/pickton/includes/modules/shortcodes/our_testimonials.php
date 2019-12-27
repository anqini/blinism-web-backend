<?php  
   $count = 1;
   $query_args = array('post_type' => 'bunch_testimonials' , 'showposts' => $num , 'order_by' => $sort , 'order' => $order);
   if( $cat ) $query_args['testimonials_category'] = $cat;
   $query = new WP_Query($query_args) ; 
   ?>
<?php if($query->have_posts()):  ?>   

<!--Testimonial Section-->
<div class="testimonial-section <?php if($style_two == 'option_1') echo 'grey-bg'; ?>">
    <div class="auto-container">
        <!--Sec Title-->
        <div class="sec-title centered">
            <h2><?php echo wp_kses_post($title); ?></h2>
            <div class="separator"></div>
        </div>
        <div class="two-item-carousel owl-carousel owl-theme">
        	<?php while($query->have_posts()): $query->the_post();
				global $post ; 
				$testimonial_meta = _WSH()->get_meta();
			?>
            <!--Testmonial Block-->
            <div class="testimonial-block">
                <div class="inner-box">
                    <div class="upper-box clearfix">
                        <div class="pull-left">
                            <div class="author-info">
                                <div class="author-inner">
                                    <div class="image">
                                        <?php the_post_thumbnail('pickton_80x80'); ?>
                                    </div>
                                    <h3><?php the_title(); ?></h3>
                                    <div class="location"><?php echo wp_kses_post(pickton_set($testimonial_meta, 'designation')); ?></div>
                                </div>
                            </div>
                        </div>
                        <div class="pull-right text-right">
                            <div class="days"><?php echo esc_html( human_time_diff( get_the_time('U'), current_time('timestamp') ) ) . ' ago'; ?></div>
                            <div class="quote-icon"></div>
                        </div>
                    </div>
                    <div class="lower-box">
                        <div class="text"><?php echo wp_kses_post(pickton_trim(get_the_content(), $text_limit)); ?></div>
                    </div>
                </div>
            </div>
            <?php endwhile;?>
        </div>
    </div>
</div>
<!--End Testimonial Section-->

<?php endif; wp_reset_postdata(); ?>