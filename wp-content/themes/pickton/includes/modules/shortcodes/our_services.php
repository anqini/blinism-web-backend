<?php  
   $count = 1;
   $query_args = array('post_type' => 'bunch_services' , 'showposts' => $num , 'order_by' => $sort , 'order' => $order);
   if( $cat ) $query_args['services_category'] = $cat;
   $query = new WP_Query($query_args) ; 
   ?>
<?php if($query->have_posts()):  ?>   

<!--Services Page Section-->
<section class="services-page-section">
    <div class="auto-container">
        
        <div class="row clearfix">
        	<?php while($query->have_posts()): $query->the_post();
				global $post ; 
				$services_meta = _WSH()->get_meta();
			?>
            <!--Services Block-->
            <div class="services-block col-lg-4 col-md-6 col-sm-6 col-xs-12">
                <div class="inner-box">
                    <div class="image">
                        <div class="icon-tag"><span class="icon <?php echo str_replace("icon ", "", pickton_set($services_meta, 'fontawesome'));?>"></span></div>
                        <?php the_post_thumbnail('pickton_370x220'); ?>
                        <div class="overlay-box">
                            <div class="overlay-inner">
                                <div class="content">
                                    <div class="text"><?php echo wp_kses_post(pickton_trim(get_the_content(), $text_limit));?> </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="lower-box">
                        <h3><?php the_title();?></h3>
                        <div class="hover-title">
                            <h4><a href="<?php echo esc_url(pickton_set($services_meta, 'ext_url')); ?>"><?php the_title();?></a></h4>
                            <a class="arrow-box" href="<?php echo esc_url(pickton_set($services_meta, 'ext_url')); ?>"><span class="arrow fa fa-angle-right"></span></a>
                        </div>
                    </div>
                </div>
            </div>
            <?php endwhile;?>
        </div>
    </div>
</section>
<!--End Services Section-->

<?php endif; wp_reset_postdata(); ?>