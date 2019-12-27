<!--Faq Form Section-->
<section class="faq-form-section grey-bg">
    <div class="auto-container">
        <!--Sec Title-->
        <div class="sec-title centered">
            <h2><?php echo wp_kses_post($title); ?></h2>
            <div class="separator"></div>
        </div>
        
        <!--Faq Form-->
        <div class="faq-form">
            <?php echo do_shortcode($contact_form); ?>
        </div>
        <!--Faq Form-->
        
    </div>
</section>
<!--End Faq Form Section-->