<?php  
   $count = 1;
   $query_args = array('post_type' => 'bunch_testimonials' , 'showposts' => $num , 'order_by' => $sort , 'order' => $order);
   if( $cat ) $query_args['testimonials_category'] = $cat;
   $query = new WP_Query($query_args) ; 
   ?>
<?php if($query->have_posts()):  ?>   

<!--Testimonial Page Section-->
<section class="testimonial-page-section">
    <div class="auto-container">
        
        <div class="masonry-items-container row clearfix">
        	<?php while($query->have_posts()): $query->the_post();
				global $post ; 
				$testimonial_meta = _WSH()->get_meta();
			?>
            <!--Testimonial Block Two-->
            <div class="testimonial-block-two masonry-item col-lg-3 col-md-4 col-sm-6 col-xs-12">
                <div class="inner-box">
                    <div class="image">
                        <?php the_post_thumbnail('pickton_85x85'); ?>
                    </div>
                    <div class="text"><?php echo wp_kses_post(pickton_trim(get_the_content(), $text_limit)); ?></div>
                    <h2><?php the_title(); ?></h2>
                    <div class="location"><?php echo wp_kses_post(pickton_set($testimonial_meta, 'designation')); ?></div>
                </div>
            </div>
            <?php endwhile;?>
        </div>
    </div>
</section>

<?php endif; wp_reset_postdata(); ?>