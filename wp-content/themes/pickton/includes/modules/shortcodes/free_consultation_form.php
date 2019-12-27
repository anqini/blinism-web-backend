<!--Consult Section-->
<section class="consult-section" style="background-image:url('<?php echo esc_url($bg_img); ?>');">
    <div class="auto-container">
        <div class="consult-form-box">
            <h2><?php echo wp_kses_post($title); ?></h2>
            
            <!--Default Form-->
            <div class="default-form">
                <?php echo do_shortcode($contact_form); ?>
            </div>
            <!--Default Form-->
            
        </div>
    </div>
</section>
<!--End Consult Section-->