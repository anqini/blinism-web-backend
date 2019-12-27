<?php $options = _WSH()->option();
	get_header(); 
	$settings  = pickton_set(pickton_set(get_post_meta(get_the_ID(), 'bunch_page_meta', true) , 'bunch_page_options') , 0);
	$meta = _WSH()->get_meta('_bunch_layout_settings');
	$meta1 = _WSH()->get_meta('_bunch_header_settings');
	$meta2 = _WSH()->get_meta();
	_WSH()->page_settings = $meta;
	if(pickton_set($_GET, 'layout_style')) $layout = pickton_set($_GET, 'layout_style'); else
	$layout = pickton_set( $meta, 'layout', 'full' );
	if( !$layout || $layout == 'full' || pickton_set($_GET, 'layout_style')=='full' ) $sidebar = ''; else
	$sidebar = pickton_set( $meta, 'sidebar', 'default-sidebar' );
	
	$layout = ( $layout ) ? $layout : 'full';
	$sidebar = ( $sidebar ) ? $sidebar : 'default-sidebar';
	
	$classes = ( !$layout || $layout == 'full' || pickton_set($_GET, 'layout_style')=='full' ) ? ' col-lg-12 col-md-12 col-sm-12 col-xs-12 ' : ' col-lg-8 col-md-8 col-sm-12 col-xs-12 ' ;
	_WSH()->post_views( true );
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
                <div class="thm-unit-test">
				<?php while( have_posts() ): the_post();
					global $post; 
					$post_meta = _WSH()->get_meta();
				?>
                 
                 <div class="blog-single">
                  
                    <div class="inner-box">
                        <?php if(has_post_thumbnail()):?>
                        <div class="image">
                            <?php the_post_thumbnail('pickton_1170x420'); ?>
                        </div>
                        <?php endif; ?>
                        <div class="lower-content">
                            <ul class="post-meta">
                                <li><span class="icon fa fa-calendar"></span><?php echo get_the_date(); ?></li>
                                <li><span class="icon fa fa-user"></span><?php esc_html_e('By', 'pickton'); ?> <?php the_author(); ?></li>
                                <li><span class="icon fa fa-comments"></span><?php comments_number( wp_kses_post(__('0 Comments' , 'pickton')), wp_kses_post(__('1 Comment' , 'pickton')), wp_kses_post(__('% Comments' , 'pickton'))); ?></li>
                            </ul>
                            
							<?php the_content();?>
                            <div class="clearfix"></div>
                            <?php wp_link_pages(array('before'=>'<div class="paginate-links">'.esc_html__('Pages: ', 'pickton'), 'after' => '</div>', 'link_before'=>'<span>', 'link_after'=>'</span>')); ?>
                            <!--post-share-options-->
                            <?php if(function_exists('bunch_share_us')): ?>
                            <div class="post-share-options clearfix">
                                <div class="pull-left tags"><?php the_tags('<span>Tags: </span>', ', ');?></div>
                                <?php echo wp_kses_post(bunch_share_us(get_the_id(),$post->post_name ));?>
                            </div>
                            <?php endif;?>
                            
                        </div>
                    </div>
                
                </div>
                
                <?php if(get_the_author_meta('description')):?> 
                <!--Author Box-->
                <div class="author-box">
                    <div class="author-comment">
                        <div class="inner-box">
                            <div class="image"><?php echo get_avatar('', 85 ); ?></div>
                            <h3><?php the_author(); ?></h3>
                            <div class="text"><?php the_author_meta( 'description', get_the_author_meta('ID') );?></div>
                            <ul class="social-icon-four">
                                <?php if($value = get_the_author_meta('facebook') ): ?>
                                <li><a href="<?php echo esc_url($value); ?>"><span class="fa fa-facebook"></span></a></li>
                                <?php endif; ?>
                                <?php if($value = get_the_author_meta('google-plus') ): ?>
                                <li><a href="<?php echo esc_url($value); ?>"><span class="fa fa-google-plus"></span></a></li>
                                <?php endif; ?>
                                <?php if($value = get_the_author_meta('twitter') ): ?>
                                <li><a href="<?php echo esc_url($value); ?>"><span class="fa fa-twitter"></span></a></li>
                                <?php endif; ?>
                                <?php if($value = get_the_author_meta('youtube') ): ?>
                                <li><a href="<?php echo esc_url($value); ?>"><span class="fa fa-youtube"></span></a></li>
                                <?php endif; ?>
                            </ul>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
                
                <!-- comment area -->
                <?php comments_template(); ?><!-- end comments -->    
                <div class="clearfix"></div>
                <div class="post-pagination">
                    <div class="pull-left">
                        <?php previous_post_link('%link','<div class="prev-post"><span class="fa fa-long-arrow-left"></span> &ensp; Prev Post</div>'); ?>
                    </div>
                    <div class="pull-right">
                        <?php next_post_link('%link','<div class="next-post">Next Post &ensp; <span class="fa fa-long-arrow-right"></span> </div>'); ?>
                    </div>
                </div>
                <div class="clearfix"></div>
				
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
        </div>
    </div>
</div>

<?php get_footer(); ?>