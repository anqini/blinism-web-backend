<!--Contact Section-->
<section class="contact-section">
    <div class="auto-container">
        <!--Sec Title-->
        <div class="sec-title centered">
            <h2><?php echo wp_kses_post($title); ?></h2>
            <div class="separator"></div>
            <div class="text"><?php echo wp_kses_post($text); ?></div>
        </div>
        <div class="row clearfix">
            <!--Info Column-->
            <div class="info-column col-md-4 col-sm-12 col-xs-12">
                <div class="inner-box">
                    <ul class="contact-info-list">
                        <li><span class="icon flaticon-maps-and-flags"></span><strong><?php esc_html_e('Address:', 'pickton'); ?></strong> <?php echo wp_kses_post($address); ?></li>
                        <li><span class="icon flaticon-technology-2"></span><strong><?php esc_html_e('Call Us:', 'pickton'); ?></strong><br> <?php echo wp_kses_post($phone); ?></li>
                        <li><span class="icon flaticon-web"></span><strong><?php esc_html_e('Mail Us:', 'pickton'); ?></strong><br><?php echo sanitize_email($email); ?></li>
                        <li><span class="icon flaticon-big-circular-clock"></span><strong><?php esc_html_e('Opening Time:', 'pickton'); ?></strong><br> <?php echo wp_kses_post($opening_hours); ?></li>
                    </ul>
                    
                    <ul class="social-icon-three">
                        <?php foreach( $atts['socials'] as $key => $item ): ?>
                        <li><a href="<?php echo esc_url($item->link); ?>"><span class="fa <?php echo esc_attr($item->icons); ?>"></span></a></li>
                        <?php endforeach;?>
                    </ul>
                </div>
            </div>
            <!--Form Column-->
            <div class="form-column col-md-8 col-sm-12 col-xs-12">
                <div class="contact-form">
                    <?php echo do_shortcode($contact_form); ?>
                </div>
            </div>
        </div>
    </div>
</section>
<!--End Contact Section-->