<?php $options = get_option('pickton'.'_theme_options');?>
	
    <div class="clearfix"></div>
	<!--Main Footer-->
    <footer class="main-footer">
    	<!--Widgets Section-->
        <div class="auto-container">
        	
			<?php if ( is_active_sidebar( 'footer-sidebar' ) ) { ?>
				<?php if(!(pickton_set($options, 'hide_upper_footer'))):?>
                    <div class="widgets-section">
                        <div class="row clearfix">
                        	<?php dynamic_sidebar( 'footer-sidebar' ); ?>
                        </div>
                    </div>
            	<?php endif;?>
			<?php } ?>
            
            <?php if(!(pickton_set($options, 'hide_middle_footer'))):?>
            <!--Footer Info Section-->
            <div class="footer-info-section">
            	<div class="row clearfix">
                	
					<?php if($contact_infos = pickton_set( $options, 'bunch_contact_information' )):
					foreach( pickton_set( $contact_infos, 'bunch_contact_information' ) as $contact_info ):
					if( isset( $contact_info['tocopy' ] ) ) continue; ?>
                    <!--Info Block-->
                    <div class="info-block col-md-4 col-sm-6 col-xs-12">
                    	<div class="inner">
                        	<div class="icon <?php echo esc_attr(pickton_set( $contact_info, 'icons')); ?>"></div>
                            <h4><?php echo wp_kses_post(pickton_set( $contact_info, 'title')); ?></h4>
                            <div class="text"><?php echo wp_kses_post(pickton_set( $contact_info, 'text')); ?></div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                    <?php endif;?>
                </div>
            </div>
            
			<?php endif;?>
        </div>
        
        <?php if(!(pickton_set($options, 'hide_bottom_footer'))):?>
        <!--Footer Bottom-->
        <div class="footer-bottom">
        	<div class="auto-container">
            	<div class="row clearfix">
                	<div class="column col-md-6 col-sm-12 col-xs-12">
                    	<div class="copyright"><?php echo wp_kses_post(pickton_set($options, 'copyright'));?></div>
                    </div>
                    <div class="nav-column col-md-6 col-sm-12 col-xs-12">
                    	<ul class="footer-nav">
                        	<?php wp_nav_menu( array( 'theme_location' => 'footer_menu', 'container_id' => 'navbar-collapse-1',
								'container_class'=>'navbar-collapse collapse navbar-right',
								'menu_class'=>'nav navbar-nav',
								'fallback_cb'=>false, 
								'items_wrap' => '%3$s', 
								'container'=>false,
								'depth' => 1,
								'walker'=> new Bootstrap_walker()  
							) ); ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!--End Footer Bottom-->
        <?php endif;?>
    </footer>
    <!--Scroll to top-->
	<div class="scroll-to-top scroll-to-target" data-target="html"><span class="icon fa fa-arrow-up"></span></div>
</div>
<!--End pagewrapper-->



<?php wp_footer(); ?>
</body>
</html>