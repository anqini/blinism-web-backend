<!--History Section-->
<section class="history-section">
    <div class="auto-container">
        <!--Sec Title-->
        <div class="sec-title centered">
            <h2><?php echo wp_kses_post($title); ?></h2>
            <div class="separator"></div>
        </div>
        
        <!--History Tabs-->
        <div class="history-tabs tabs-box">
            <!--History Btns-->
            <ul class="history-btns tab-buttons history-tabs-carousel owl-carousel owl-theme clearfix">
                <?php foreach( $atts['history_tab'] as $key => $item ):?>
                <li class="<?php if($key == 1) echo 'active-btn';?> tab-btn" data-tab="#year-one<?php echo esc_attr($key);?>"><?php echo wp_kses_post($item->years);?></li>
                <?php endforeach; ?>
            </ul>
            
            <!--Tabs Content-->
            <div class="tabs-content">
                <?php foreach( $atts['history_tab'] as $keys => $item ):
					$count = 0;
					$nums = $item->num;
					$sorts = $item->sort;
					$orders = $item->order;
					$cats = $item->cat;
					$query_args = array('post_type' => 'bunch_history' , 'showposts' => $nums , 'order_by' => $sorts , 'order' => $orders);
					if( $cats ) $query_args['history_category'] = $cats;
					$query = new WP_Query($query_args) ;
				?>
                
                <!--Tab-->
                <div class="tab <?php if($keys == 1) echo 'active-tab';?>" id="year-one<?php echo esc_attr($keys);?>">
                    <div class="row clearfix">
                        <?php while($query->have_posts()): $query->the_post();
							global $post; 
							$history_meta = _WSH()->get_meta();
						?>
						<?php if(($count%3) == 0 && $count != 0):?>
                    </div>
                </div><!--End Tab-->
                
                <div class="tab">
                    <div class="row clearfix">
                        <?php $count++; endif; ?>
                        <!--History Block-->
                        <div class="history-block col-md-4 col-sm-6 col-xs-12">
                            <div class="inner-box">
                                <div class="image">
                                    <a href="<?php echo esc_url(pickton_set($history_meta, 'ext_url')); ?>"><?php the_post_thumbnail('pickton_370x230'); ?></a>
                                </div>
                                <div class="lower-content">
                                    <div class="content">
                                        <div class="post-date"><?php echo get_the_date(); ?></div>
                                        <div class="big-text"><?php echo get_the_date(); ?></div>
                                        <h3><a href="<?php echo esc_url(pickton_set($history_meta, 'ext_url')); ?>"><?php the_title(); ?></a></h3>
                                        <div class="text"><?php echo wp_kses_post(pickton_trim(get_the_content(), $item->text_limit));?></div>
                                        <a href="<?php echo esc_url(pickton_set($history_meta, 'ext_url')); ?>" class="read-more"><?php esc_html_e('Read More', 'pickton'); ?> <span class="fa fa-angle-right"></span></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php $count++; endwhile;?>  
                    </div>
                </div><!--End Tab-->
                <?php endforeach; ?>
            </div>
        </div>
        <!--End History Tabs-->
    </div>
</section>
<!--End History Section-->