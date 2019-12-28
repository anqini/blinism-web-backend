<?php
defined('ABSPATH') or die("KEEP CALM AND CARRY ON");
global $fevr_custom_grid_atts;

$paged = ( isset($fevr_custom_grid_atts['paged']) ) ? absint( $fevr_custom_grid_atts['paged'] ) : 1;

$args = array(
		'post_type'			=> explode(',',$fevr_custom_grid_atts['post_types']),
		'posts_per_page'	=> $fevr_custom_grid_atts['posts_per_page'],
		'post__not_in'		=> array(get_the_id()),
		'paged'				=> $paged,
		'orderby' 			=> 'title',
		'order'   			=> 'ASC',
);

// Build meta filters
$meta_query = array();
if (isset($fevr_custom_grid_atts['filters'])){
	foreach ((array)$fevr_custom_grid_atts['filters'] as $filter){
		if ($filter['in'] == 'meta' && !empty($filter['value'])){
			$meta_query[] = array(
					'key' => $filter['meta_key'],
					'value' => $filter['value'],
					'compare' => $filter['compare'],
					'type' => $filter['meta_type']
			);
		}
	}
}

// Add meta filters
if (!empty($meta_query)){
	$args = array_merge($args,array('meta_query' => $meta_query));
}

$luv_custom_grid_query = new WP_Query( $args );

// Paginate links
$paginate_links = paginate_links( array(
		'base' => str_replace( PHP_INT_MAX, '%#%', esc_url( get_pagenum_link( PHP_INT_MAX ) ) ),
		'format' => '?paged=%#%',
		'current' => $paged,
		'total' => $luv_custom_grid_query->max_num_pages,
) );


$columns = json_decode(stripslashes(str_replace("'",'"',$fevr_custom_grid_atts['columns'])),true);
if ($columns === false || empty($fevr_custom_grid_atts['columns'])){
	$columns = 'vc_col-xs-6 vc_col-sm-4';
}
else{
	$columns['mobile'] = !isset($columns['mobile']) || (int)$columns['mobile'] == 0 ? 2 : $columns['mobile'];
	$columns['tablet-portrait'] = !isset($columns['tablet-portrait']) || (int)$columns['tablet-portrait'] == 0 ? 3 : $columns['tablet-portrait'];
	$columns['tablet-landscape'] = !isset($columns['tablet-landscape']) || (int)$columns['tablet-landscape'] == 0 ? $columns['tablet-portrait'] : $columns['tablet-landscape'];
	$columns['desktop'] = !isset($columns['desktop']) || (int)$columns['desktop'] == 0 ? $columns['tablet-landscape'] : $columns['desktop'];

	$columns = 'vc_col-xs-' . 12/$columns['mobile'] . ' '.
			   'vc_col-sm-' . 12/$columns['tablet-portrait'] . ' '.
			   'vc_col-md-' . 12/$columns['tablet-landscape'] . ' '.
			   'vc_col-lg-' . 12/$columns['desktop'] . ' ';
}

?>

<?php if ($fevr_custom_grid_atts['pagination'] == 'above' || $fevr_custom_grid_atts['pagination'] == 'both'):?>
<div class="luv-pagination-container">
<?php echo $paginate_links;?>
</div>
<?php endif;?>

<?php if ( $luv_custom_grid_query->have_posts() ) : while ( $luv_custom_grid_query->have_posts() ) : $luv_custom_grid_query->the_post(); ?>
<div class="wpb_column vc_column_container <?php echo $columns;?>">
	<div class="vc_column-inner">
		<div class="wpb_wrapper">
			<div class="luv-post<?php echo (!empty($fevr_custom_grid_atts['post_classes']) ? ' ' . $fevr_custom_grid_atts['post_classes'] : '');?>">
				<?php if ( has_post_thumbnail() && $fevr_custom_grid_atts['hide_featured_image'] != 'true'): ?>
				<div class="post-featured-img">
					<a href="<?php esc_url(the_permalink()); ?>" title="<?php the_title(); ?>">
						<?php the_post_thumbnail('thumbnail'); ?>
					</a>
				</div>
				<?php endif; ?>
				<?php if ($fevr_custom_grid_atts['hide_category'] != 'true'):?>
				<div class="luv-post-cat">
					<?php the_category( ', ' ); ?>
				</div>
				<?php endif;?>
				<?php if ($fevr_custom_grid_atts['hide_title'] != 'true'):?>
				<h2 class="luv-post-title"><a href="<?php esc_url(the_permalink()); ?>"><?php the_title(); ?></a></h2>
				<?php endif;?>
				<?php if ($fevr_custom_grid_atts['hide_date'] != 'true'):?>
			 	<div class="luv-post-date"><?php the_time(get_option('date_format')); ?></div>
				<?php endif;?>
				<?php if ($fevr_custom_grid_atts['hide_author'] != 'true'):?>
			 	<div class="luv-post-author"><?php the_author_posts_link();; ?></div>
				<?php endif;?>
				<?php if ($fevr_custom_grid_atts['hide_excerpt'] != 'true'):?>
			 	<div class="luv-post-content">
			 		<?php the_excerpt(); ?>
			 	</div>
			 	<?php endif;?>
				<?php if ($fevr_custom_grid_atts['hide_tags'] != 'true'):?>
			 	<div class="luv-post-meta">
				 	<?php the_tags('', '', ''); ?>
				</div>
			 	<?php endif;?>
			 </div>
		 </div>
	 </div>
 </div>
 <?php endwhile;?>
 <?php wp_reset_postdata();?>
 <?php if ($fevr_custom_grid_atts['pagination'] == 'under' || $fevr_custom_grid_atts['pagination'] == 'both'):?>
 <div class="luv-pagination-container">
 <?php echo $paginate_links;?>
 </div>
 <?php endif;?>
 <?php else :?>
 	<p><?php esc_html_e( 'Sorry, no posts matched your criteria.', 'fevr'); ?></p>
 <?php endif; ?>
