<?php  
   $count = 1;
   $query_args = array('post_type' => 'bunch_services' , 'showposts' => $num , 'order_by' => $sort , 'order' => $order);
   if( $cat ) $query_args['services_category'] = $cat;
   $query = new WP_Query($query_args) ; 
   ?>
<?php if($query->have_posts()):  ?>   

<!--Choose Section-->
<section class="choose-section" style="background-image:url('<?php echo esc_url($bg_img); ?>');">
    <div class="auto-container">
        <div class="row clearfix">
            <div class="title-column col-md-3 col-sm-12 col-xs-12">
                <!--Sec Title-->
                <div class="sec-title light">
                    <h2><?php echo wp_kses_post($title); ?></h2>
                    <div class="separator"></div>
                </div>
                <div class="text">
                    <?php echo wp_kses_post($text); ?>
                </div>
            </div>
            <div class="services-column col-md-9 col-sm-12 col-xs-12">
                
                <div class="three-item-carousel owl-carousel owl-theme">
					<?php while($query->have_posts()): $query->the_post();
                        global $post ; 
                        $services_meta = _WSH()->get_meta();
                    ?>
                    <!--Services Block Two-->
                    <div class="service-block-two">
                        <div class="inner-box">
                            <div class="icon-box">
                                <span class="icon <?php echo str_replace("icon ", "", pickton_set($services_meta, 'fontawesome'));?>"></span>
                            </div>
                            <div class="content">
                                <h3><a href="<?php echo esc_url(pickton_set($services_meta, 'ext_url')); ?>"><?php the_title();?></a></h3>
                                <div class="text"><?php echo wp_kses_post(pickton_trim(get_the_content(), $text_limit));?></div>
                            </div>
                        </div>
                    </div>
                    <?php endwhile;?>
                </div>
            </div>
        </div>
    </div>
</section>
<!--End Choose Section-->

<?php endif; wp_reset_postdata(); ?>