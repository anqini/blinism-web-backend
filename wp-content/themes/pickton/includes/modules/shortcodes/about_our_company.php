<!--About Section-->
<section class="about-section">
    <div class="auto-container">
        <!--Sec Title-->
        <div class="sec-title centered">
            <h2><?php echo wp_kses_post($title); ?></h2>
            <div class="separator"></div>
        </div>
        <div class="row clearfix">
            <!--Block Column-->
            <div class="block-column col-md-8 col-sm-12 col-xs-12">
                <div class="about-block">
                    <div class="inner-box">
                        <div class="row clearfix">
                            <!--Image Column-->
                            <div class="image-column col-md-6 col-sm-6 col-xs-12">
                                <div class="image">
                                    <img src="<?php echo esc_url($about_img); ?>" alt="<?php esc_attr_e('Awesome Image', 'pickton'); ?>" />
                                </div>
                            </div>
                            <!--Content Column-->
                            <div class="content-column col-md-6 col-sm-6 col-xs-12">
                                <div class="content">
                                    <h3><?php echo wp_kses_post($sub_title); ?></h3>
                                    <div class="text"><?php echo wp_kses_post($text); ?></div>
                                    <a href="<?php echo esc_url($btn_link); ?>" class="theme-btn btn-style-three"><?php echo wp_kses_post($btn_title); ?></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--Graph Column-->
            <div class="graph-column col-md-4 col-sm-12 col-xs-12">
                <div class="image">
                    <img src="<?php echo esc_url($chart_img); ?>" alt="<?php esc_attr_e('Awesome Image', 'pickton'); ?>" />
                </div>
            </div>
        </div>
    </div>
</section>
<!--End About Section-->