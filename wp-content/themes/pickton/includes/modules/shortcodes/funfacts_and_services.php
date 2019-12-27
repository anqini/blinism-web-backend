<!--Services Section-->
<section class="services-section-two" style="background-image:url('<?php echo esc_url($bg_img); ?>');">
    <div class="auto-container">
        
        <!--Counter Section-->
        <section class="counter-section style-two">
            
            <div class="fact-counter">
                <div class="row clearfix">
                	<?php foreach( $atts['funfact'] as $key => $item ): ?>
                    <!--Column-->
                    <div class="column counter-column col-md-3 col-sm-6 col-xs-12">
                        <div class="inner">
                            <div class="content">
                                <div class="icon-box"><span class="icon <?php echo esc_attr($item->icons); ?>"></span></div>
                                <div class="count-outer count-box">
                                    <span class="count-text" data-speed="2000" data-stop="<?php echo wp_kses_post($item->counter_stop); ?>"><?php echo wp_kses_post($item->counter_start); ?></span><?php echo wp_kses_post($item->plus_sign); ?>
                                </div>
                                <h4 class="counter-title"><?php echo wp_kses_post($item->title); ?></h4>
                            </div>
                        </div>
                    </div>
            		<?php endforeach;?>
                </div>
            </div>
                
        </section>
        <!--End Counter Section-->
        
        <div class="row clearfix">
            <?php foreach( $atts['services'] as $key => $item ): ?>
            <!--Services Block-->
            <div class="services-block-two col-md-4 col-sm-6 col-xs-12">
                <div class="inner-box">
                    <div class="icon-box">
                        <span class="icon <?php echo esc_attr($item->ser_icons); ?>"></span>
                    </div>
                    <h3><a href="<?php echo esc_url($item->ext_url); ?>"><?php echo wp_kses_post($item->ser_title); ?></a></h3>
                    <div class="text"><?php echo wp_kses_post($item->ser_text); ?></div>
                </div>
            </div>
            <?php endforeach;?>
        </div>
        
    </div>
</section>
<!--End Services Section-->