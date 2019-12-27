<?php if($slider_slug): ?>

	<!--Main Slider-->
	<section class="main-slider">	
		<?php if( ($slider_slug) && function_exists ( 'putRevSlider' ) ) putRevSlider( $slider_slug ); ?>
	</section>
	<!--End Main Slider-->

<?php endif; ?>