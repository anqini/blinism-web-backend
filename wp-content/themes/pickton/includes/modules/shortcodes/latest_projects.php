<?php  
   $count = 1;
   $query_args = array('post_type' => 'bunch-projects' , 'showposts' => $num , 'order_by' => $sort , 'order' => $order);
   if( $cat ) $query_args['projects_category'] = $cat;
   $query = new WP_Query($query_args) ; 
   ?>
<?php if($query->have_posts()):  ?>   

<!--Project Section-->
<section class="project-section">
    <div class="auto-container">
        <div class="sec-title clearfix">
            <div class="pull-left">
                <h2><?php echo wp_kses_post($title); ?></h2>
                <div class="separator"></div>
            </div>
            <div class="pull-right">
                <a href="<?php echo esc_url($btn_link); ?>" class="theme-btn btn-style-three"><?php echo wp_kses_post($btn_title); ?></a>
            </div>
        </div>
        <div class="row clearfix">
            <?php while($query->have_posts()): $query->the_post();
				global $post ; 
				$project_meta = _WSH()->get_meta();
			?>
            <!--Project Block-->
            <div class="project-block <?php echo esc_attr($term_slug); ?> <?php if(pickton_set($project_meta, 'extra_width') == 'extra_width') echo 'col-md-6 col-sm-12 col-xs-12'; else echo ' col-md-3 col-sm-6 col-xs-12';?> ">
                <div class="inner-box">
                    <div class="image">
                        <?php if(pickton_set($project_meta, 'extra_width') == 'extra_width') 
							$image_size = 'pickton_570x250'; 
						  else
							$image_size = 'pickton_270x250'; 
						  the_post_thumbnail($image_size);
						?>
                        <div class="overlay-box">
                            <div class="overlay-inner">
                                <div class="content">
                                    <h3><a href="<?php echo esc_url(get_the_permalink(get_the_id()));?>"><?php the_title(); ?></a></h3>
                                    <?php $term_list = wp_get_post_terms(get_the_id(), 'projects_category', array("fields" => "names")); ?>
 									<div class="designation"><?php echo implode( ', ', (array)$term_list );?></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endwhile;?>
        </div>
    </div>
</section>
<!--End Project Section-->

<?php endif; wp_reset_postdata(); ?>