<?php
$options = _WSH()->option();
    get_header(); 
?>

<!--Page Title-->
<section class="page-title">
    <div class="auto-container">
        <h1><?php esc_html_e('404', 'pickton');?></h1>
    </div>
    <!--Page Info-->
    <div class="page-info">
        <div class="auto-container clearfix">
            <div class="pull-left">
            	<?php echo wp_kses_post(pickton_get_the_breadcrumb()); ?>  
            </div>
        </div>
    </div>
    <!--End Page Info-->
</section>
<!--End Page Title-->

<!--Start 404 area-->
<section class="not-found-area">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="not-found-content text-center">
                    <h1><?php esc_html_e('404', 'pickton'); ?></h1>
                    <h3><?php esc_html_e('OOPS! THE PAGE YOU WERE LOOKING FOR, COULDNT BE FOUND.', 'pickton'); ?></h3>
                    <p><?php esc_html_e('Try the search below to find matching pages:', 'pickton'); ?></p>
                   <?php get_template_part('searchform3')?>
                </div>
            </div>
        </div>
    </div>
</section> 
<!--End 404 area-->
  		
<?php get_footer(); ?>