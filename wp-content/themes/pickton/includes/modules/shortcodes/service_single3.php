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
                <!--Services Single Three-->
                <div class="service-single-three">
                    <div class="inner-box">
                        <h2><?php echo wp_kses_post($title); ?></h2>
                        <div class="images">
                            <div class="row clearfix">
                                <div class="column col-md-6 col-sm-6 col-xs-12">
                                    <div class="image">
                                        <img src="<?php echo esc_url($image1); ?>" alt="<?php esc_attr_e('image', 'pickton');?>" />
                                    </div>
                                </div>
                                <div class="column col-md-6 col-sm-6 col-xs-12">
                                    <div class="image">
                                        <img src="<?php echo esc_url($image2); ?>" alt="<?php esc_attr_e('image', 'pickton');?>" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="text">
                            <?php echo wp_kses_post($text); ?>
                        </div>
                        
                        <?php if($title1):?>
                        <!--Graph Section-->
                        <div class="graph-section">
                            <h3><?php echo wp_kses_post($title1); ?></h3>
                            <div class="row clearfix">
                                <div class="column col-md-7 col-sm-7 col-xs-12">
                                    <div class="text"><?php echo wp_kses_post($text1); ?></div>
                                    <ul class="list-style-three">
                                        <?php $fearures = explode("\n", ($feature_str));?>
										<?php foreach($fearures as $feature):?>
                                            <li><?php echo wp_kses_post($feature ); ?></li>
                                        <?php endforeach;?>
                                    </ul>
                                </div>
                                <div class="column image-column col-md-5 col-sm-5 col-xs-12">
                                    <div class="image">
                                        <img src="<?php echo esc_url($graph_image); ?>" alt="<?php esc_attr_e('image', 'pickton');?>" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>
                        
                        
                        <!--Default Section-->
                        <section class="default-section">
                            <div class="row clearfix">
                                <?php if($title2):?>
                                <div class="column col-md-6 col-sm-6 col-xs-12">
                                    <h3><?php echo wp_kses_post($title2); ?></h3>
                                    <?php foreach( $atts['services'] as $key => $item ): ?>
                                    <!--Service Block-->
                                    <div class="service-block-four">
                                        <div class="inner-box">
                                            <div class="icon-box">
                                                <span class="<?php echo esc_attr($item->icons); ?>"></span>
                                            </div>
                                            <h4><a href="<?php echo esc_url($item->link); ?>"><?php echo wp_kses_post($item->ser_title); ?></a></h4>
                                            <div class="service-text"><?php echo wp_kses_post($item->ser_text); ?></div>
                                        </div>
                                    </div>
                                    <?php endforeach;?>
                                </div>
                                <?php endif; ?>
                                
                                <?php if($title3):?>
                                <div class="column col-md-6 col-sm-6 col-xs-12">
                                    <h3><?php echo wp_kses_post($title3); ?></h3>
                                    
                                    <!--Accordian Box-->
                                    <ul class="accordion-box">
                                        <?php foreach( $atts['accordion'] as $key => $item ): ?>
                                        
                                        <!--Block-->
                                        <li class="accordion block">
                                            <div class="acc-btn <?php if($key == 2) echo 'active'; ?>"><div class="icon-outer"><span class="icon icon-plus fa fa-plus"></span> <span class="icon icon-minus fa fa-minus"></span></div><?php echo wp_kses_post($item->acc_title); ?></div>
                                            <div class="acc-content <?php if($key == 2) echo 'current'; ?>">
                                                <div class="content">
                                                    <div class="text">
                                                        <p><?php echo wp_kses_post($item->acc_text); ?></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <?php endforeach;?>
                                    </ul>
                                    
                                </div>
                                <?php endif; ?>
                            </div>
                        </section>
                        <!--End Default Section-->
                        
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</div>