<?php
/**
 * The Template for displaying all single products.
 *
 * Override this template by copying it to yourtheme/woocommerce/single-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
$meta = _WSH()->get_meta('_bunch_layout_settings');
$meta1 = _WSH()->get_meta('_bunch_header_settings');
$layout = pickton_set( $meta, 'layout', 'right' );
$sidebar = pickton_set( $meta, 'sidebar', 'blog-sidebar' );

$layout = ($layout) ? $layout : 'right';
$sidebar = ($sidebar) ? $sidebar : 'default-sidebar';

$classes = ( !$layout || $layout == 'full' || pickton_set($_GET, 'layout_style')=='full' ) ? ' col-lg-12 col-md-12 col-sm-12 col-xs-12 ' : ' col-lg-9 col-md-8 col-sm-12 col-xs-12 ' ;

$bg = pickton_set($meta1, 'header_img');
$title = pickton_set($meta1, 'header_title');

get_header( 'shop' ); ?>

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

<!--Sidebar Page Container-->
<div class="sidebar-page-container">
    <div class="auto-container">
        <div class="row clearfix">
			
            <!-- sidebar area -->
			<?php if( $layout == 'left' ): ?>
				<?php if ( is_active_sidebar( $sidebar ) ) { ?>
                    <div class="sidebar-side col-lg-3 col-md-4 col-sm-12 col-xs-12">        
                    	<aside class="sidebar default-sidebar with-border">
							<?php dynamic_sidebar( $sidebar ); ?>
                            <?php
								/**
								 * woocommerce_sidebar hook
								 *
								 * @hooked woocommerce_get_sidebar - 10
								 */
								do_action( 'woocommerce_sidebar' );
							?>
                        </aside>
                    </div>
                <?php } ?>
			<?php endif; ?>
			
            <div class="<?php echo esc_attr($classes);?> content-side ">
            <?php
                /**
                 * woocommerce_before_main_content hook
                 *
                 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
                 * @hooked woocommerce_breadcrumb - 20
                 */
                do_action( 'woocommerce_before_main_content' );
            ?>
                <?php while ( have_posts() ) : the_post(); ?>
                    <?php wc_get_template_part( 'content', 'single-product' ); ?>
                <?php endwhile; // end of the loop. ?>
            <?php
                /**
                 * woocommerce_after_main_content hook
                 *
                 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
                 */
                do_action( 'woocommerce_after_main_content' );
            ?>
            
            </div>
		
        	<!-- sidebar area -->
			<?php if( $layout == 'right' ): ?>
				<?php if ( is_active_sidebar( $sidebar ) ) { ?>
                    <div class="sidebar-side col-lg-3 col-md-4 col-sm-12 col-xs-12">        
                        <aside class="sidebar default-sidebar with-border">
                            <?php dynamic_sidebar( $sidebar ); ?>
                            <?php
                                /**
                                 * woocommerce_sidebar hook
                                 *
                                 * @hooked woocommerce_get_sidebar - 10
                                 */
                                do_action( 'woocommerce_sidebar' );
                            ?>
                        </aside>
                    </div>
                <?php } ?>
			<?php endif; ?>
		
        </div>
	</div>
</div>
<?php get_footer( 'shop' ); ?>
