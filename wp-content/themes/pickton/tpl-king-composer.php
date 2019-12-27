<?php /* Template Name: King Composer Page */
	get_header() ;
	$meta = _WSH()->get_meta('_bunch_header_settings');
	$bg = (pickton_set($meta, 'header_img')) ? pickton_set($meta, 'header_img') : get_template_directory_uri().'/images/background/10.jpg';
	$title = pickton_set($meta, 'header_title');
?>
<?php if(pickton_set($meta, 'breadcrumb')):?>

<!--Page Title-->
<section class="page-title" <?php if($bg):?>style="background-image:url(<?php echo esc_url($bg)?>);"<?php endif;?>>
    <div class="auto-container">
        <h1><?php if($title) echo wp_kses_post($title); else wp_title('');?></h1>
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

<?php endif;?>
<?php while( have_posts() ): the_post(); ?>
    <?php the_content(); ?>
<?php endwhile;  ?>
<?php get_footer() ; ?>