<?php
/**
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 3.4.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product;

// Ensure visibility
if ( empty( $product ) || ! $product->is_visible() ) {
	return;
}
$meta = _WSH()->get_meta('_bunch_layout_settings', get_option( 'woocommerce_shop_page_id' ));
$meta1 = _WSH()->get_meta('_bunch_header_settings', get_option( 'woocommerce_shop_page_id' ));
$layout = pickton_set( $meta, 'layout', 'right' );
$layout = pickton_set( $_GET, 'layout' ) ? $_GET['layout'] : $layout; 
if(pickton_set($_GET, 'layout_style')) $layout = pickton_set($_GET, 'layout_style'); else
$layout = pickton_set( $meta, 'layout', 'right' );
$sidebar = pickton_set( $meta, 'sidebar', 'blog-sidebar' );

$layout = ($layout) ? $layout : 'right';
$sidebar = ($sidebar) ? $sidebar : 'blog-sidebar';

if( !$layout || $layout == 'full' || pickton_set($_GET, 'layout_style')=='full' ) $classes[] = 'shop-item col-lg-3 col-md-6 col-sm-6 col-xs-12'; else $classes[] = ' shop-item col-lg-4 col-md-6 col-sm-6 col-xs-12'; 
?>
<div <?php post_class( $classes ); ?>>
	<div class="inner-box">
	<?php
	/**
	 * woocommerce_before_shop_loop_item hook.
	 *
	 * @hooked woocommerce_template_loop_product_link_open - 10
	 */
	//do_action( 'woocommerce_before_shop_loop_item' );

	/**
	 * woocommerce_before_shop_loop_item_title hook.
	 *
	 * @hooked woocommerce_show_product_loop_sale_flash - 10
	 * @hooked woocommerce_template_loop_product_thumbnail - 10
	 */
	 ?>
     
     <div class="image">
        <?php woocommerce_template_loop_product_thumbnail();?>
        <div class="overlay-box">
            <ul class="cart-option">
                <li><a href="<?php echo esc_url(get_permalink(get_the_id()));?>"><span class="fa fa-shopping-basket"></span></a><span class="tooltip-data"><?php esc_html_e('Add to Cart', 'pickton');?></span></li>
            </ul>
        </div>
     </div>
     
     <?php do_action( 'woocommerce_before_shop_loop_item_title' );

	/**
	 * woocommerce_shop_loop_item_title hook.
	 *
	 * @hooked woocommerce_template_loop_product_title - 10
	 */
	//do_action( 'woocommerce_shop_loop_item_title' );

	/**
	 * woocommerce_after_shop_loop_item_title hook.
	 *
	 * @hooked woocommerce_template_loop_rating - 5
	 * @hooked woocommerce_template_loop_price - 10
	 */
	do_action( 'woocommerce_after_shop_loop_item_title' );
	?>
        
        <div class="lower-content">
            <div class="clearfix">
                <div class="pull-left">
                    <h3><a href="<?php echo esc_url(get_the_permalink(get_the_id()));?>"><?php the_title();?></a></h3>
                </div>
                <div class="pull-right">
                    <!--Rating-->
                    <div class="rating">
                        <?php woocommerce_template_loop_rating();?>
                    </div>
                </div>
            </div>
            <?php woocommerce_template_loop_price();?>
        </div>
        
	<?php /**
	 * woocommerce_after_shop_loop_item hook.
	 *
	 * @hooked woocommerce_template_loop_product_link_close - 5
	 * @hooked woocommerce_template_loop_add_to_cart - 10
	 */
	//do_action( 'woocommerce_after_shop_loop_item' );
	?>
	</div>
</div>
