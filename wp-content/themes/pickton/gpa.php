<?php
$options = _WSH()->option();
    get_header(); 
?>

<!--Page Title-->
<section class="page-title">
    <div class="auto-container">
        <h1><?php esc_html_e('404', 'pickton');?></h1>
    </div>
<!--End Page Title-->

<!--Start 404 area-->
<section class="not-found-area">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="not-found-content text-center">
                    <h1>Hello World! </h1>
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
