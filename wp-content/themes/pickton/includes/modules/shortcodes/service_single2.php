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
                <!--Services Single Two-->
                <div class="service-single-two">
                    <div class="inner-box">
                        <h2><?php echo wp_kses_post($title); ?></h2>
                        <div class="two-column">
                            <div class="row clearfix">
                                <div class="content col-md-6 col-sm-6 col-xs-12">
                                    <div class="bold-text"><?php echo wp_kses_post($sub_title); ?></div>
                                    <div class="text">
                                        <?php echo wp_kses_post($text); ?>
                                    </div>
                                </div>
                                <div class="content col-md-6 col-sm-6 col-xs-12">
                                    <div class="image">
                                        <img src="<?php echo esc_url($image); ?>" alt="<?php esc_attr_e('image', 'pickton');?>" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <?php if($title1):?>
                        <!--Analysic Section-->
                        <div class="analysic-section">
                            <h3><?php echo wp_kses_post($title1); ?></h3>
                            <div class="text"><?php echo wp_kses_post($text1); ?></div>
                            <div class="row clearfix">
                                <?php foreach( $atts['analysis'] as $key => $item ): ?>
                                <!--Analysic Column-->
                                <div class="analysic-column col-md-4 col-sm-6 col-xs-12">
                                    <div class="image">
                                        <img src="<?php echo esc_url($item->analysis_image); ?>" alt="<?php esc_attr_e('image', 'pickton');?>" />
                                    </div>
                                    <h4><?php echo wp_kses_post($item->analysis_title); ?></h4>
                                </div>
                                <?php endforeach;?>
                            </div>
                        </div>
                        <?php endif; ?>
                        
                        <?php if($title2):?>
                        <!--Analysic Result-->
                        <div class="analysic-result">
                            <h3><?php echo wp_kses_post($title2); ?></h3>
                            <div class="text"><?php echo wp_kses_post($text2); ?></div>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</div>