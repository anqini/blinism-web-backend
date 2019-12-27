<!--Subscribe Style One-->
<section class="subscribe-style-one" style="background:url('<?php echo esc_url($bg_img); ?>');">
    <div class="auto-container">
        <div class="row clearfix">
            <div class="col-md-5 col-sm-12 col-xs-12">
                <h2><?php echo wp_kses_post($title); ?></h2>
                <div class="text"><?php echo wp_kses_post($text); ?></div>
            </div>
            <div class="col-md-7 col-sm-12 col-xs-12">
                <form method="get" action="http://feedburner.google.com/fb/a/mailverify" accept-charset="utf-8">
                    <div class="form-group clearfix">
                        <input type="hidden" id="uri2" name="uri" value="<?php echo esc_attr($id); ?>">
                        <input type="email" name="email" value="" placeholder="<?php esc_attr_e('Enter Email Address', 'pickton'); ?>" required>
                        <button type="submit" class="theme-btn btn-style-one"><?php esc_html_e('Subscribe', 'pickton'); ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
<!--End Subscribe Style One-->