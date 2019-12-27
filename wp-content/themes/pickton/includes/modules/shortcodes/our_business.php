<!--Business Section-->
<section class="business-section">
    <div class="auto-container">
        <div class="title-box">
            <h2><?php echo wp_kses_post($title); ?></h2>
            <div class="text"> <?php echo wp_kses_post($text); ?></div>
        </div>
        <div class="row clearfix">
            <?php foreach( $atts['business_info'] as $key => $item ): ?>
            <!--Business Block-->
            <div class="business-block col-md-4 col-sm-6 col-xs-12">
                <div class="inner-box">
                    <div class="logo-box">
                        <div class="image"><img src="<?php echo esc_url($item->image); ?>" alt="<?php esc_attr_e('Business Image', 'pickton'); ?>" /></div>
                    </div>
                    <div class="text"><?php echo wp_kses_post($item->text1); ?></div>
                </div>
            </div>
            <?php endforeach;?>
        </div>
        
        <div class="text-center">
            <a href="<?php echo esc_url($btn_link); ?>" class="theme-btn btn-style-one"><?php echo wp_kses_post($btn_title); ?></a>
        </div>
        
    </div>
</section>
<!--End Business Section-->