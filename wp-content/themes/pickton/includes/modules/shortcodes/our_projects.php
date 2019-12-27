<?php 
$paged = get_query_var('paged');
$args = array('post_type' => 'bunch-projects', 'showposts'=>$num, 'orderby'=>$sort, 'order'=>$order, 'paged'=>$paged);
$terms_array = explode(",",$exclude_cats);
if($exclude_cats) $args['tax_query'] = array(array('taxonomy' => 'projects_category','field' => 'id','terms' => $terms_array,'operator' => 'NOT IN',));
$query = new WP_Query($args);

$t = $GLOBALS['_bunch_base'];

$data_filtration = '';
$data_posts = '';
?>

<?php if( $query->have_posts() ):

ob_start();?>

	<?php $count = 0; 
	$fliteration = array();?>
	<?php while( $query->have_posts() ): $query->the_post();
		global  $post;
		$meta = get_post_meta( get_the_id(), '_bunch-projects_meta', true );//printr($meta);
		$meta1 = _WSH()->get_meta();
		$post_terms = get_the_terms( get_the_id(), 'projects_category');// printr($post_terms); exit();
		foreach( (array)$post_terms as $pos_term ) $fliteration[$pos_term->term_id] = $pos_term;
		$temp_category = get_the_term_list(get_the_id(), 'projects_category', '', ', ');
	?>
		<?php $post_terms = wp_get_post_terms( get_the_id(), 'projects_category'); 
		$term_slug = '';
		if( $post_terms ) foreach( $post_terms as $p_term ) $term_slug .= $p_term->slug.' ';?>		
           
            <?php 
				$post_thumbnail_id = get_post_thumbnail_id($post->ID);
				$post_thumbnail_url = wp_get_attachment_url( $post_thumbnail_id );
			?>
                    
            <!--Gallery Block-->
            <div class="gallery-block mix all col-lg-4 col-md-4 col-sm-6 col-xs-12 <?php echo esc_attr($term_slug); ?>">
                <div class="inner-box">
                    <figure class="image-box">
                        <?php the_post_thumbnail('pickton_370x275'); ?>
                        <div class="overlay-box">
                            <div class="overlay-inner">
                                <div class="content">
                                    <a href="<?php echo esc_url(get_the_permalink(get_the_id())); ?>" class="icon"><span class="fa fa-link"></span></a>
                                    <a href="<?php echo esc_url($post_thumbnail_url);?>" class="icon image-link lightbox-image" data-fancybox-group="example-gallery" ><span class="fa fa-search"></span></a>
                                </div>
                            </div>
                        </div>
                    </figure>
                    <div class="lower-box">
                        <h3><a href="<?php echo esc_url(get_the_permalink(get_the_id())); ?>"><?php the_title(); ?></a></h3>
                        <?php $term_list = wp_get_post_terms(get_the_id(), 'projects_category', array("fields" => "names")); ?>
 						<div class="designation"><?php echo implode( ', ', (array)$term_list );?></div>
                    </div>
                </div>
            </div>
           
            
<?php endwhile;?>
  
<?php wp_reset_postdata();
$data_posts = ob_get_contents();
ob_end_clean();

endif ;
ob_start();?>	 

<?php $terms = get_terms(array('projects_category')); ?>

<!--Gallery Section-->
<section class="gallery-section">
    <div class="auto-container">
        
        <!--Sortable Gallery-->
        <div class="mixitup-gallery">
        
            <!--Filter-->
            <div class="filters clearfix">
                <ul class="filter-tabs filter-btns">
                    <li class="filter active" data-role="button" data-filter="all"><?php esc_attr_e('View All', 'pickton');?></li>
                    <?php foreach( $fliteration as $t ): ?>
                    <li class="filter" data-role="button" data-filter=".<?php echo esc_attr(pickton_set( $t, 'slug' )); ?>"><?php echo wp_kses_post(pickton_set( $t, 'name')); ?></li>
                    <?php endforeach;?>
                </ul>
            </div>
            
            <div class="filter-list row clearfix">
            	<?php echo wp_kses_post($data_posts); ?>
            </div>
            
        </div>
        <!--End Sortable Gallery-->
        
        <!--Styled Pagination-->
        <div class="styled-pagination text-center">
            <?php pickton_the_pagination(array('total'=>$query->max_num_pages, 'next_text' => '<i class="fa fa-angle-right"></i>', 'prev_text' => '<i class="fa fa-angle-left"></i>')); ?>
        </div>
        <!--End Styled Pagination-->
        
    </div>
</section>
<!--Gallery Section-->