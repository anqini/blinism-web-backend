<!--Map Section-->
<section class="map-section">
    <!--Map Outer-->
    <div class="map-outer">
        <!--Map Canvas-->
        <div class="map-canvas"
            data-zoom="12"
            data-lat="<?php echo esc_js($lat); ?>"
            data-lng="<?php echo esc_js($long); ?>"
            data-type="roadmap"
            data-hue="#ffc400"
            data-title="<?php echo esc_js($title); ?>"
            data-icon-path="<?php echo esc_url($img); ?>"
            data-content="<?php echo esc_js($address); ?><br><a href='mailto:<?php echo sanitize_email($email); ?>'><?php echo sanitize_email($email); ?></a>">
        </div>
    </div>
</section>
<!--End Map Section-->