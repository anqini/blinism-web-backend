<!--End About Section Two-->
<section class="about-section-two">
    <div class="auto-container">
        <div class="row clearfix">
            <!--Column-->
            <div class="column col-md-6 col-sm-12 col-xs-12">
                <!--About Column-->
                <div class="about-company">
                    <div class="inner-box">
                        <div class="image">
                            <a href="<?php echo esc_url($btn_link); ?>"><img src="<?php echo esc_url($image); ?>" alt="<?php esc_attr_e('image', 'pickton');?>" /></a>
                        </div>
                        <div class="lower-content">
                            <h2><?php echo wp_kses_post($title); ?></h2>
                            <div class="separator"></div>
                            <div class="bold-text"><?php echo wp_kses_post($sub_title); ?></div>
                            <div class="text">
                                <?php echo wp_kses_post($text); ?>
                            </div>
                            <a href="<?php echo esc_url($btn_link); ?>" class="meet-team"><?php echo wp_kses_post($btn_title); ?> <span class="fa fa-angle-right"></span></a>
                        </div>
                    </div>
                </div>
            </div>
            <!--Column-->
            <div class="column col-md-6 col-sm-12 col-xs-12">
                <!--What We Do-->
                <div class="what-we-do">
                    <div class="inner-box">
                        <div class="image">
                            <a href="<?php echo esc_url($btn_link1); ?>"><img src="<?php echo esc_url($image1); ?>" alt="<?php esc_attr_e('image', 'pickton');?>" /></a>
                        </div>
                        <div class="lower-content">
                            <?php foreach( $atts['services'] as $key => $item ): ?>
                            <!--Servives Block-->
                            <div class="service-block-three">
                                <div class="inner">
                                    <div class="icon-box">
                                        <span class="icon <?php echo esc_attr($item->icons); ?>"></span>
                                    </div>
                                    <h3><a href="<?php echo esc_url($item->ext_url); ?>"><?php echo wp_kses_post($item->title1); ?></a></h3>
                                    <div class="sub-title"><?php echo wp_kses_post($item->sub_title1); ?> </div>
                                    <div class="text"><?php echo wp_kses_post($item->text1); ?></div>
                                </div>
                            </div>
                            <?php endforeach;?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--End About Section Two-->