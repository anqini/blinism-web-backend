<?php $options = _WSH()->option();
	pickton_bunch_global_variable();
	$icon_href = (pickton_set( $options, 'site_favicon' )) ? pickton_set( $options, 'site_favicon' ) : get_template_directory_uri().'/images/favicon.ico';
 ?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<?php if ( ! function_exists( 'has_site_icon' ) || ! has_site_icon() ):?>
	<link rel="shortcut icon" href="<?php echo esc_url($icon_href);?>" type="image/x-icon">
	<link rel="icon" href="<?php echo esc_url($icon_href);?>" type="image/x-icon">
<?php endif;?>
<!-- Responsive -->
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<div class="page-wrapper">
 	
    <?php if(pickton_set($options, 'preloader')):?>
		<!-- Preloader -->
		<div class="preloader"></div>
	<?php endif;?>
 	
    <!-- Main Header-->
    <header class="main-header">
    
    	<!--Header Top-->
    	<div class="header-top">
        	<div class="auto-container">
            	<div class="clearfix">
                    <?php if(pickton_set($options, 'welcome_text')):?>
                    <div class="top-left">
                        <ul class="clearfix">
                        	<li><?php echo wp_kses_post(pickton_set($options, 'welcome_text')); ?></li>
                        </ul>
                    </div>
                    <?php endif;?>
                    
                    <div class="top-right clearfix">
                    	<ul class="clearfix">
                        	<?php if(pickton_set($options, 'head_social')): ?>
								<?php if(pickton_set( $options, 'social_media' ) && is_array( pickton_set( $options, 'social_media' ) )): ?>
                                    <li>
                                        <div class="social-links">
                                            <?php $social_icons = pickton_set( $options, 'social_media' );
												foreach( pickton_set( $social_icons, 'social_media' ) as $social_icon ):
												if( isset( $social_icon['tocopy' ] ) ) continue; ?>
												<a href="<?php echo esc_url(pickton_set( $social_icon, 'social_link')); ?>"><span class="fa <?php echo esc_attr(pickton_set( $social_icon, 'social_icon')); ?>"></span></a>
											<?php endforeach; ?>
                                        </div>
                                    </li>
                                <?php endif;?>
                            <?php endif;?>
                            
                            <?php if(pickton_set($options, 'lang_switcher')): ?>
                        	<li class="language dropdown"><a class="btn btn-default dropdown-toggle" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" href="#">ENG &nbsp;<span class="icon fa fa-angle-down"></span></a>
                                <?php do_action('wpml_add_language_selector'); ?>
                            </li>
                            <?php endif;?>
                        </ul>
                        
                    </div>
                </div>
            </div>
        </div>
    
        <!--Header-Upper-->
        <div class="header-upper">
        	<div class="auto-container">
            	<div class="inner-container clearfix">
                	
                	<div class="pull-left logo-outer">
                    	<?php if(pickton_set($options, 'logo_image')):?>
                            <div class="logo"><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><img src="<?php echo esc_url(pickton_set($options, 'logo_image'));?>" alt="欢迎关注比邻主义留学" title="欢迎关注比邻主义留学"></a></div>
                        <?php else:?>
                            <div class="logo"><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><img src="<?php echo esc_url(get_template_directory_uri().'/images/logo.png');?>" alt="<?php esc_attr_e('Pickton', 'pickton');?>"></a></div>
                        <?php endif;?>
                    </div>
                    
                    <div class="pull-right upper-right clearfix">
                    	
                        <?php if(pickton_set($options, 'phone')):?>
                        <!--Info Box-->
                        <div class="upper-column info-box">
                        	<div class="icon-box"><span class="flaticon-technology-2"></span></div>
                            <ul>
                            	<li><strong><?php esc_html_e('联系我们', 'pickton'); ?></strong><?php echo wp_kses_post(pickton_set($options, 'phone')); ?></li>
                            </ul>
                        </div>
                        <?php endif;?>
                        
                        <?php if(pickton_set($options, 'email')):?>
                        <!--Info Box-->
                        <div class="upper-column info-box">
                        	<div class="icon-box"><span class="flaticon-web"></span></div>
                            <ul>
                            	<li><strong><?php esc_html_e('电子邮件', 'pickton'); ?></strong><?php echo sanitize_email(pickton_set($options, 'email')); ?></li>
                            </ul>
                        </div>
                        <?php endif;?>
                        
                        <?php if(pickton_set($options, 'opening_hours')):?>
                        <!--Info Box-->
                        <div class="upper-column info-box">
                        	<div class="icon-box"><span class="flaticon-big-circular-clock"></span></div>
                            <ul>
                            	<li><strong><?php esc_html_e('工作时间', 'pickton'); ?></strong><?php echo wp_kses_post(pickton_set($options, 'opening_hours')); ?></li>
                            </ul>
                        </div>
                        <?php endif;?>
                    </div>
                    
                </div>
            </div>
        </div>
        <!--End Header Upper-->
        
        <!--Header Lower-->
        <div class="header-lower">
            
        	<div class="auto-container">
            	<div class="nav-outer clearfix">
                    <!-- Main Menu -->
                    <nav class="main-menu">
                        <div class="navbar-header">
                            <!-- Toggle Button -->    	
                            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            </button>
                        </div>
                        
                        <div class="navbar-collapse collapse clearfix">
                            <ul class="navigation clearfix">
                                <?php wp_nav_menu( array( 'theme_location' => 'main_menu', 'container_id' => 'navbar-collapse-1',
									'container_class'=>'navbar-collapse collapse navbar-right',
									'menu_class'=>'nav navbar-nav',
									'fallback_cb'=>false, 
									'items_wrap' => '%3$s', 
									'depth' => 3,
									'container'=>false,
									'walker'=> new Bootstrap_walker()  
								) ); ?>
                            </ul>
                        </div>
                    </nav>
                    <!-- Main Menu End-->
                    <?php if(has_nav_menu('main_menu')):?>
                    <div class="outer-box">
                    	<!--Search Box-->
                        <div class="search-box-outer">
                            <div class="dropdown">
                                <button class="search-box-btn dropdown-toggle" type="button" id="dropdownMenu3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="fa fa-search"></span></button>
                                <ul class="dropdown-menu pull-right search-panel" aria-labelledby="dropdownMenu3">
                                    <li class="panel-outer">
                                        <div class="form-container">
                                            <?php get_template_part('searchform2')?>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        
						<?php if(pickton_set($options, 'button')): ?>
                        <a onclick="window.open('https://chat.mqimg.com/dist/standalone.html?eid=169019', '_blank', 'height=540,width=504,top=50,left=200,status=yes,toolbar=no,menubar=no,resizable=no,scrollbars=no,location=no,titlebar=no')" class="consult-btn theme-btn"><?php echo wp_kses_post(pickton_set($options, 'btn_title')); ?></a>
                        <?php endif;?>
                    </div>
                    <?php endif;?>
                </div>
            </div>
        </div>
        <!--End Header Lower-->
        
        <!--Sticky Header-->
        <div class="sticky-header">
        	<div class="auto-container clearfix">
            	<!--Logo-->
            	<div class="logo pull-left">
                	<?php if(pickton_set($options, 'logo_responsive')):?>
                        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="img-responsive"><img src="<?php echo esc_url(pickton_set($options, 'logo_responsive'));?>" alt="<?php esc_attr_e('Pickton', 'pickton');?>" title="<?php esc_attr_e('Pickton', 'pickton');?>"></a>
                    <?php else:?>
                        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="img-responsive"><img src="<?php echo esc_url(get_template_directory_uri().'/images/logo-small.png');?>" alt="<?php esc_attr_e('Pickton', 'pickton');?>"></a>
                    <?php endif;?>
                </div>
                
                <!--Right Col-->
                <div class="right-col pull-right">
                	<!-- Main Menu -->
                    <nav class="main-menu">
                        <div class="navbar-header">
                            <!-- Toggle Button -->    	
                            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>
                        </div>
                        
                        <div class="navbar-collapse collapse clearfix">
                            <ul class="navigation clearfix">
                                <?php wp_nav_menu( array( 'theme_location' => 'main_menu', 'container_id' => 'navbar-collapse-1',
									'container_class'=>'navbar-collapse collapse navbar-right',
									'menu_class'=>'nav navbar-nav',
									'fallback_cb'=>false, 
									'items_wrap' => '%3$s', 
									'container'=>false,
									'walker'=> new Bootstrap_walker()  
								) ); ?>
                            </ul>
                        </div>
                    </nav><!-- Main Menu End-->
                </div>
                
            </div>
        </div>
        <!--End Sticky Header-->
    
    </header>
    <!--End Main Header -->
