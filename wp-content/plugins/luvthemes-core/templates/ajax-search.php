<?php 
	defined('ABSPATH') or die("KEEP CALM AND CARRY ON");
	
	$hide_title = isset($_POST['hide_title']) ? $_POST['hide_title'] : false;
	$hide_excerpt = isset($_POST['hide_excerpt']) ? $_POST['hide_excerpt'] : false;
	$hide_featured_image = isset($_POST['hide_featured_image']) ? $_POST['hide_featured_image'] : false;
	$hide_date = isset($_POST['hide_date']) ? $_POST['hide_date'] : false;
	
?>
<div class="luv-ajax-result">
	<a href="<?php esc_url(the_permalink()); ?>" title="<?php the_title(); ?>">
		<?php if ( has_post_thumbnail() && $hide_featured_image != 'true'): ?>
			<div class="post-featured-img">
				<?php the_post_thumbnail('thumb');?>
			</div>
		<?php endif; ?>
		<div class="luv-result-content">
			<?php if ($hide_title != 'true'):?>
			<h3 class="post-title"><?php the_title(); ?></h3>
			<?php endif;?>
			<?php if ($hide_excerpt != 'true'):?>
			<div class="post-excerpt"><?php strip_shortcodes(the_excerpt());?></div>
			<?php endif;?>
			<?php if ($hide_date != 'true'):?>
			<div class="luv-ajax-results-meta">
				<div class="post-date"><?php the_date();?></div>
			</div>
			<?php endif;?>
		</div>
	</a>
</div>