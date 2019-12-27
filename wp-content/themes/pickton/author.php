<?php pickton_bunch_global_variable(); 
	$options = _WSH()->option();
	get_header(); 
	$settings  = _WSH()->option(); 
	if(pickton_set($_GET, 'layout_style')) $layout = pickton_set($_GET, 'layout_style'); else
	$layout = pickton_set( $settings, 'author_page_layout', 'right' );
	$sidebar = pickton_set( $settings, 'author_page_sidebar', 'blog-sidebar' );
	$view = pickton_set( $settings, 'author_page_view', 'list' );
	_WSH()->page_settings = array('layout'=>$layout, 'sidebar'=>$sidebar);
	$classes = ( !$layout || $layout == 'full' || pickton_set($_GET, 'layout_style')=='full' ) ? ' col-lg-12 col-md-12 col-sm-12 col-xs-12 ' : ' col-lg-8 col-md-8 col-sm-12 col-xs-12 ' ;
	$bg = pickton_set($settings, 'author_page_header_img');
	$title = pickton_set($settings, 'author_page_header_title');
?>

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
					<div class="sidebar-side col-lg-4 col-md-4 col-sm-12 col-xs-12">
                        <aside class="sidebar default-sidebar with-border">
						<?php dynamic_sidebar( $sidebar ); ?>
						</aside>
            		</div>
				<?php } ?>
			<?php endif; ?>
            
            <!--Content Side-->	
            <div class="content-side <?php echo esc_attr($classes);?>">
                
                <!--Default Section-->
                <div class="blog-classic">
                    <!--Blog Post-->
                    <div class="thm-unit-test">
					<?php while( have_posts() ): the_post();?>
						<!-- blog post item -->
						<!-- Post -->
						<div id="post-<?php the_ID(); ?>" <?php post_class();?>>
							<?php get_template_part( 'blog' ); ?>
						<!-- blog post item -->
						</div><!-- End Post -->
					<?php endwhile;?>
                    </div>
                    <!--Pagination-->
                    <div class="styled-pagination text-center">
                        <?php pickton_the_pagination(); ?>
                    </div>
                </div>
            
            </div>
            <!--Content Side-->
            
            <!-- sidebar area -->
			<?php if( $layout == 'right' ): ?>
				<?php if ( is_active_sidebar( $sidebar ) ) { ?>
					<div class="sidebar-side col-lg-4 col-md-4 col-sm-12 col-xs-12">
                        <aside class="sidebar default-sidebar with-border">
							<?php dynamic_sidebar( $sidebar ); ?>
                        </aside>
                    </div>
                <?php } ?>
			<?php endif; ?>
            <!--Sidebar-->
        </div>
    </div>
</div>

<?php get_footer(); ?>