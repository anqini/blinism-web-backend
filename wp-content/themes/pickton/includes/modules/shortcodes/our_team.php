<?php  
   $count = 1;
   $query_args = array('post_type' => 'bunch_team' , 'showposts' => $num , 'order_by' => $sort , 'order' => $order);
   if( $cat ) $query_args['team_category'] = $cat;
   $query = new WP_Query($query_args) ; 
   ?>
<?php if($query->have_posts()):  ?>   

<!--Team Section-->
<section class="team-section">
    <div class="auto-container">
        <!--Sec Title-->
        <div class="sec-title light clearfix">
            <div class="pull-left">
                <h2><?php echo wp_kses_post($title);?></h2>
                <div class="separator"></div>
            </div>
            <div class="pull-right">
                <a href="<?php echo esc_url($btn_link);?>" class="theme-btn btn-style-four"><?php echo wp_kses_post($btn_title);?></a>
            </div>
        </div>
        <div class="row clearfix">
            <?php while($query->have_posts()): $query->the_post();
				global $post ; 
				$team_meta = _WSH()->get_meta();
			?>
            <!--Team Block-->
            <div class="team-block col-lg-3 col-md-4 col-sm-6 col-xs-12">
                <div class="inner-box">
                    <div class="image">
                        <?php the_post_thumbnail('pickton_270x235');?>
                        <div class="overlay-box">
                            <?php if($socials = pickton_set($team_meta, 'bunch_team_social')):?>
                            <ul class="social-icon-two">
                                <?php foreach($socials as $key => $value):?>
                                <li><a href="<?php echo esc_url(pickton_set($value, 'social_link'));?>"><span class="fa <?php echo esc_attr(pickton_set($value, 'social_icon'));?>"></span></a></li>
                                <?php endforeach;?>                                 
                            </ul>
                            <?php endif;?>
                        </div>
                    </div>
                    <div class="lower-content">
                        <h3><a href="<?php echo esc_url(pickton_set($team_meta, 'ext_url')); ?>"><?php the_title(); ?></a></h3>
                        <div class="designation"><?php echo wp_kses_post(pickton_set($team_meta, 'designation')); ?></div>
                        <ul>
                            <li><?php esc_html_e('Ph:', 'pickton'); ?> <?php echo wp_kses_post(pickton_set($team_meta, 'phone')); ?></li>
                            <li><a href="mailto:<?php echo sanitize_email(pickton_set($team_meta, 'email')); ?>"><?php esc_html_e('Email:', 'pickton'); ?> <?php echo sanitize_email(pickton_set($team_meta, 'email')); ?></a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <?php endwhile;?>
        </div>
    </div>
</section>
<!--End Team Section-->

<?php endif; wp_reset_postdata(); ?>