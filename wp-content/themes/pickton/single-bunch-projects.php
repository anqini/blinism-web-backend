<?php $options = _WSH()->option();
	get_header(); 
	$settings  = pickton_set(pickton_set(get_post_meta(get_the_ID(), 'bunch_page_meta', true) , 'bunch_page_options') , 0);
	$meta = _WSH()->get_meta('_bunch_layout_settings');
	$meta1 = _WSH()->get_meta('_bunch_header_settings');
	$meta2 = _WSH()->get_meta();
	_WSH()->page_settings = $meta;
	_WSH()->post_views( true );
	$bg = pickton_set($meta1, 'header_img');
	$title = pickton_set($meta1, 'header_title');
	$term_list = wp_get_post_terms(get_the_id(), 'gallery_category', array("fields" => "names"));
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

<?php while( have_posts() ): the_post(); 
	$post_meta = _WSH()->get_meta();
?> 

<!-- Project Single Section-->
<section class="project-single-section">
    <div class="auto-container">
        <?php if(has_post_thumbnail()):?>
        <div class="big-image">
            <?php the_post_thumbnail('pickton_1170x570'); ?>
        </div>
        <?php endif; ?>
        <!--Launch Info-->
        <div class="project-launch-section">
            <div class="row clearfix">
                <div class="info-column col-md-4 col-sm-12 col-xs-12">
                    <div class="inner-column">
                        <ul>
                            <li><span><?php esc_html_e('Customer', 'pickton'); ?> </span> <?php echo wp_kses_post(pickton_set($post_meta, 'customer_title')); ?></li>
                            <li><span><?php esc_html_e('Live demo', 'pickton'); ?> </span> <?php echo wp_kses_post(pickton_set($post_meta, 'demo_link')); ?></li>
                            <li><span><?php esc_html_e('Category', 'pickton'); ?> </span> <?php echo wp_kses_post(pickton_set($post_meta, 'category')); ?></li>
                            <li><span><?php esc_html_e('Date', 'pickton'); ?> </span> <?php echo wp_kses_post(pickton_set($post_meta, 'project_date')); ?></li>
                            <li><span><?php esc_html_e('Tags', 'pickton'); ?> </span> <?php echo wp_kses_post(pickton_set($post_meta, 'project_tags')); ?></li>
                        </ul>
                    </div>
                </div>
                <div class="content-column col-md-8 col-sm-12 col-xs-12">
                    <h3><?php the_title(); ?></h3>
                    <div class="sub-title"><?php echo wp_kses_post(pickton_set($post_meta, 'project_tags')); ?></div>
                    <div class="text">
						<?php the_content(); ?> 
                    </div>
                    <a href="<?php echo esc_url(pickton_set($post_meta, 'ext_url')); ?>" class="theme-btn btn-style-three"><?php esc_html_e('Launch Project', 'pickton'); ?></a>
                </div>
            </div>
        </div>
        
        <?php if($project = pickton_set($post_meta, 'project_analysis')):?>
        <!--Detail Section-->
        <div class="detail-section">
            <div class="row clearfix">
                <?php foreach($project as $key => $value):?>
                <div class="column col-md-4 col-sm-12 col-sm-12">
                    <h2><?php echo wp_kses_post(pickton_set($value, 'project_title')); ?></h2>
                </div>
                <div class="column col-md-8 col-sm-12 col-sm-12">
                    <?php echo wp_kses_post(pickton_set($value, 'text')); ?>
                    <div class="graph-box">
                        <div class="graph-title"><?php echo wp_kses_post(pickton_set($value, 'img_title')); ?></div>
                        <div class="image">
                            <img src="<?php echo esc_url(pickton_set($value, 'project_img')); ?>" alt="<?php esc_attr_e('image', 'pickton');?>" />
                        </div><br><br>
                    </div>
                </div>
                <?php endforeach;?>
            </div>
        </div>
        <?php endif; ?>
        
        <!--Project New Posts-->
        <div class="project-new-posts">
            <div class="inner-box clearfix">
                <div class="pull-left">
                    <?php previous_post_link('%link','<i class="fa fa-long-arrow-left" aria-hidden="true"></i>&ensp;Prev'); ?>
                </div>
                <div class="pull-right">
                    <?php next_post_link('%link','<div class="next-post">Next&ensp;<i class="fa fa-long-arrow-right" aria-hidden="true"></i></div>'); ?>
                </div>
                <div class="option-view text-center">
                    <a href="javascript:;"><span class="fa fa-th"></span></a>
                </div>
            </div>
        </div>
        <!--End Project New Posts-->
        
    </div>
</section>
<!--End Project Single Section-->

<?php endwhile;?>

<?php get_footer(); ?>