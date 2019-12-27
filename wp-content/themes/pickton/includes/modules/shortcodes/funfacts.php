<!--Counter Section-->
<section class="counter-section">
    <div class="auto-container">
            
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
        
    </div>
</section>
<!--End Counter Section-->