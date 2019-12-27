<?php $options = _WSH()->option();
	get_header();
	$settings  = pickton_set(pickton_set(get_post_meta(get_the_ID(), 'bunch_page_meta', true) , 'bunch_page_options') , 0);
	$meta = _WSH()->get_meta('_bunch_layout_settings');
	$meta1 = _WSH()->get_meta('_bunch_header_settings');
	if(pickton_set($_GET, 'layout_style')) $layout = pickton_set($_GET, 'layout_style'); else
	$layout = pickton_set( $meta, 'layout', 'full' );
	$sidebar = pickton_set( $meta, 'sidebar', 'default-sidebar' );
	$layout = ($layout) ? $layout : 'full';
	$sidebar = ($sidebar) ? $sidebar : 'default-sidebar';
	
	$classes = ( !$layout || $layout == 'full' || pickton_set($_GET, 'layout_style')=='full' ) ? ' col-lg-12 col-md-12 col-sm-12 col-xs-12 ' : ' col-lg-8 col-md-8 col-sm-12 col-xs-12 ' ;
	$bg = pickton_set($meta1, 'header_img');
	$title = pickton_set($meta1, 'header_title');
	
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
                            <?php the_content(); ?>
                            <div class="clearfix"></div>
                            <?php comments_template(); ?><!-- end comments -->
                        
                    
                    <!--Pagination-->
                    <div class="styled-pagination text-center">
                        <?php pickton_the_pagination(); ?>
                    </div>
                    <!-- comment area -->
                    <div class="clearfix"></div>
					<?php wp_link_pages(array('before'=>'<div class="paginate-links">'.esc_html__('Pages: ', 'pickton'), 'after' => '</div>', 'link_before'=>'<span>', 'link_after'=>'</span>')); ?>
                    <div class="clearfix"></div>
                    <div class="post-pagination">
                        <div class="pull-left">
                            <?php previous_post_link('%link','<div class="prev-post"><span class="fa fa-long-arrow-left"></span> &ensp; Prev Page</div>'); ?>
                        </div>
                        <div class="pull-right">
                            <?php next_post_link('%link','<div class="next-post">Next Page &ensp; <span class="fa fa-long-arrow-right"></span> </div>'); ?>
                        </div>
                    </div>
                	<div class="clearfix"></div>
                </div>
                <?php endwhile;?>
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