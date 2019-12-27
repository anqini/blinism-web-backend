<!--Sidebar Page Container-->
<div class="sidebar-page-container">
    <div class="auto-container">
        <div class="row clearfix">
            
            <!--Sidebar Side-->
            <div class="sidebar-side no-border col-lg-3 col-md-4 col-sm-12 col-xs-12">
                <aside class="sidebar default-sidebar">
                    <?php if ( is_active_sidebar( $sidebar_slug ) ) : ?>
						<?php dynamic_sidebar( $sidebar_slug ); ?>
                	<?php endif; ?>
                </aside>
            </div>
            
            <!--Content Side-->
            <div class="content-side col-lg-9 col-md-8 col-sm-12 col-xs-12">
                <!--Services Single One-->
                <div class="service-single-one">
                    <div class="inner-box">
                        <div class="image">
                            <img src="<?php echo esc_url($image); ?>" alt="<?php esc_attr_e('image', 'pickton');?>" />
                        </div>
                        <div class="lower-content">
                            <h2><?php echo wp_kses_post($title); ?></h2>
                            <div class="text">
                                <?php echo wp_kses_post($text); ?>
                                <blockquote>
                                    <div class="text"><span class="quote-icon flaticon-quote"></span><?php echo wp_kses_post($quote_text); ?></div>
                                </blockquote>
                                
                                <?php if($title1):?>
                                <div class="two-column">
                                    <h3><?php echo wp_kses_post($title1); ?></h3>
                                    <div class="row clearfix">
                                        <div class="column col-md-6 col-sm-6 col-xs-12">
                                            <p><?php echo wp_kses_post($text1); ?></p>
                                            <ul class="list-style-two">
                                                <?php $fearures = explode("\n", ($feature_str));?>
							  					<?php foreach($fearures as $feature):?>
                                                    <li><?php echo wp_kses_post($feature ); ?></li>
                                                <?php endforeach;?>
                                            </ul>
                                        </div>
                                        <div class="vido-column col-md-6 col-sm-6 col-xs-12">
                                            <div class="video-box">
                                                <figure class="image">
                                                    <img src="<?php echo esc_url($video_image); ?>" alt="<?php esc_attr_e('image', 'pickton');?>">
                                                </figure>
                                                <a href="<?php echo esc_url($video_link); ?>" class="lightbox-image overlay-box"><span class="fa fa-play"></span></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                        <?php endif; ?>
                        
                        <?php if($title2):?>
                        <!--Business Tab Section-->
                        <div class="business-tab-section">
                            <h3><?php echo wp_kses_post($title2); ?></h3>
                            <div class="text"><?php echo wp_kses_post($text2); ?></div>
                            
                            <!--Business Info Tabs-->
                            <div class="business-info-tabs">
                                
                                <!--Product Tabs-->
                                <div class="prod-tabs tabs-box" id="product-tabs">
                                
                                    <!--Tab Btns-->
                                    <ul class="tab-btns tab-buttons clearfix">
                                        <?php foreach( $atts['tabs'] as $key => $item ): ?>
                                        <li data-tab="#prod-description<?php echo esc_attr($key); ?>" class="tab-btn <?php if($key == 1) echo 'active-btn'; ?>"><?php echo wp_kses_post($item->button_title); ?></li>
                                        <?php endforeach;?>
                                    </ul>
                                    
                                    <!--Tabs Content-->
                                    <div class="tabs-container tabs-content">
                                        <?php foreach( $atts['tabs'] as $key => $item ): ?>
                                        <!--Tab / Active Tab-->
                                        <div class="tab <?php if($key == 1) echo 'active-tab'; ?>" id="prod-description<?php echo esc_attr($key); ?>">
                                            <div class="content">
                                                <div class="row clearfix">
                                                    <div class="col-md-5 col-sm-4 col-xs-12">
                                                        <img src="<?php echo esc_url($item->tab_image); ?>" alt="<?php esc_attr_e('image', 'pickton');?>" />
                                                    </div>
                                                    <div class="col-md-7 col-sm-8 col-xs-12">
                                                        <div class="text">
                                                            <?php echo wp_kses_post($item->tab_des); ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php endforeach;?>
                                    </div>
                                    
                                </div>
                                
                            </div>
                    		<!--End Product Info Tabs-->
                            
                        </div>
                        <?php endif; ?>
                        
                        <?php if($title3):?>
                        <!--Consult Form Two-->
                        <div class="consult-section-two">
                            <h3><?php echo wp_kses_post($title3); ?></h3>
                            <!--Default Form-->
                            <div class="consult-form-two">
                                <?php echo do_shortcode($contact_form); ?>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</div>