<?php
///----footer widgets---
//About Us
class Bunch_About_us extends WP_Widget
{
	
	/** constructor */
	function __construct()
	{
		parent::__construct( /* Base ID */'Bunch_About_us', /* Name */esc_html__('Pickton About Us','pickton'), array( 'description' => esc_html__('Show the information about company', 'pickton' )) );
	}

	/** @see WP_Widget::widget */
	function widget($args, $instance)
	{
		extract( $args );
		
		
		echo wp_kses_post($before_widget);?>
      		
			<!--About Widget-->
            <div class="logo-widget">
                <div class="logo">
                    <a href="<?php echo esc_url(home_url('/')); ?>"><img src="<?php echo esc_url($instance['footer_logo']); ?>" alt="<?php esc_attr_e('image', 'pickton');?>" /></a>
                </div>
                <div class="text"><?php echo wp_kses_post($instance['content']); ?>.</div>
                <a href="<?php echo esc_url($instance['btn_link']); ?>" class="theme-btn btn-style-one"><?php echo wp_kses_post($instance['btn_title']); ?></a>
            </div>
            
		<?php
		
		echo wp_kses_post($after_widget);
	}
	
	
	/** @see WP_Widget::update */
	function update($new_instance, $old_instance)
	{
		$instance = $old_instance;

		$instance['footer_logo'] = strip_tags($new_instance['footer_logo']);
		$instance['content'] = $new_instance['content'];
		$instance['btn_title'] = $new_instance['btn_title'];
		$instance['btn_link'] = $new_instance['btn_link'];

		return $instance;
	}

	/** @see WP_Widget::form */
	function form($instance)
	{
		$footer_logo = ($instance) ? esc_attr($instance['footer_logo']) : 'http://tonatheme.com/newwp/pickton/wp-content/uploads/2017/11/footer-logo.png';
		$content = ($instance) ? esc_attr($instance['content']) : '';
		$btn_title = ( $instance ) ? esc_attr($instance['btn_title']) : '';
		$btn_link = ( $instance ) ? esc_attr($instance['btn_link']) : '';?>
        
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('footer_logo')); ?>"><?php esc_html_e('Footer Logo Image:', 'pickton'); ?></label>
            <input placeholder="<?php esc_attr_e('URL', 'pickton');?>" class="widefat" id="<?php echo esc_attr($this->get_field_id('footer_logo')); ?>" name="<?php echo esc_attr($this->get_field_name('footer_logo')); ?>" type="text" value="<?php echo esc_attr($footer_logo); ?>" />
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('content')); ?>"><?php esc_html_e('Content:', 'pickton'); ?></label>
            <textarea class="widefat" id="<?php echo esc_attr($this->get_field_id('content')); ?>" name="<?php echo esc_attr($this->get_field_name('content')); ?>" ><?php echo wp_kses_post($content); ?></textarea>
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('btn_title')); ?>"><?php esc_html_e('Button Title:', 'pickton'); ?></label>
            <input placeholder="<?php esc_attr_e('Read More', 'pickton');?>" class="widefat" id="<?php echo esc_attr($this->get_field_id('btn_title')); ?>" name="<?php echo esc_attr($this->get_field_name('btn_title')); ?>" type="text" value="<?php echo esc_attr($btn_title); ?>" />
        </p> 
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('btn_link')); ?>"><?php esc_html_e('Button Link:', 'pickton'); ?></label>
            <input placeholder="<?php esc_attr_e('#', 'pickton');?>" class="widefat" id="<?php echo esc_attr($this->get_field_id('btn_link')); ?>" name="<?php echo esc_attr($this->get_field_name('btn_link')); ?>" type="text" value="<?php echo esc_attr($btn_link); ?>" />
        </p>        
                
		<?php 
	}
	
}

/// Latest News
class Bunch_Latest_News extends WP_Widget
{
	/** constructor */
	function __construct()
	{
		parent::__construct( /* Base ID */'Bunch_Latest_News', /* Name */esc_html__('Pickton Latest News','pickton'), array( 'description' => esc_html__('Show the Latest News', 'pickton' )) );
	}
 

	/** @see WP_Widget::widget */
	function widget($args, $instance)
	{
		extract( $args );
		$title = apply_filters( 'widget_title', $instance['title'] );
		
		echo wp_kses_post($before_widget); ?>
		
        <!--About Widget-->
        <div class="news-widget">
            <?php echo wp_kses_post($before_title.$title.$after_title); ?>
            
            <?php $query_string = 'posts_per_page='.$instance['number'];
				if( $instance['cat'] ) $query_string .= '&cat='.$instance['cat'];
				 
				$this->posts($query_string);
			?>
        </div>
        
		<?php echo wp_kses_post($after_widget);
	}
 
 
	/** @see WP_Widget::update */
	function update($new_instance, $old_instance)
	{
		$instance = $old_instance;
		
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['number'] = $new_instance['number'];
		$instance['cat'] = $new_instance['cat'];
		
		return $instance;
	}

	/** @see WP_Widget::form */
	function form($instance)
	{
		$title = ( $instance ) ? esc_attr($instance['title']) : esc_html__('Latest News', 'pickton');
		$number = ( $instance ) ? esc_attr($instance['number']) : 3;
		$cat = ( $instance ) ? esc_attr($instance['cat']) : '';?>
			
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_html_e('Title: ', 'pickton'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('number')); ?>"><?php esc_html_e('No. of Posts:', 'pickton'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('number')); ?>" name="<?php echo esc_attr($this->get_field_name('number')); ?>" type="text" value="<?php echo esc_attr( $number ); ?>" />
        </p>
       
    	<p>
            <label for="<?php echo esc_attr($this->get_field_id('cat')); ?>"><?php esc_html_e('Category', 'pickton'); ?></label>
            <?php wp_dropdown_categories( array('show_option_all'=>esc_html__('All Categories', 'pickton'), 'selected'=>$cat, 'class'=>'widefat', 'name'=>$this->get_field_name('cat')) ); ?>
        </p>
            
		<?php 
	}
	
	function posts($query_string)
	{
		$query = new WP_Query($query_string); 
		if( $query->have_posts() ):?>
        
           	<!-- Title -->
			<?php while( $query->have_posts() ): $query->the_post(); ?>
                <div class="news-widget-block">
                    <div class="inner">
                        <div class="icon flaticon-image"></div>
                        <div class="post-date"><?php echo get_the_date(); ?></div>
                        <div class="text"><a href="<?php echo esc_url(get_the_permalink(get_the_id()));?>"><?php the_title(); ?></a></div>
                    </div>
                </div>
            <?php endwhile; ?>
            
        <?php endif;
		wp_reset_postdata();
    }
}


///----Blog widgets---
/// Popular Posts 
class Bunch_Popular_Post extends WP_Widget
{
	/** constructor */
	function __construct()
	{
		parent::__construct( /* Base ID */'Bunch_Popular_Post', /* Name */esc_html__('Pickton Popular Posts','pickton'), array( 'description' => esc_html__('Show the Popular Posts', 'pickton' )) );
	}
 

	/** @see WP_Widget::widget */
	function widget($args, $instance)
	{
		extract( $args );
		$title = apply_filters( 'widget_title', $instance['title'] );
		
		echo wp_kses_post($before_widget); ?>
		
        <!-- Popular Posts -->
        <div class="popular-posts">
            <?php echo wp_kses_post($before_title.$title.$after_title); ?>
            
            <?php $query_string = 'posts_per_page='.$instance['number'];
				if( $instance['cat'] ) $query_string .= '&cat='.$instance['cat'];
				 
				$this->posts($query_string);
			?>
        </div>
        
		<?php echo wp_kses_post($after_widget);
	}
 
 
	/** @see WP_Widget::update */
	function update($new_instance, $old_instance)
	{
		$instance = $old_instance;
		
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['number'] = $new_instance['number'];
		$instance['cat'] = $new_instance['cat'];
		
		return $instance;
	}

	/** @see WP_Widget::form */
	function form($instance)
	{
		$title = ( $instance ) ? esc_attr($instance['title']) : esc_html__('Popular Posts', 'pickton');
		$number = ( $instance ) ? esc_attr($instance['number']) : 3;
		$cat = ( $instance ) ? esc_attr($instance['cat']) : '';?>
			
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_html_e('Title: ', 'pickton'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('number')); ?>"><?php esc_html_e('No. of Posts:', 'pickton'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('number')); ?>" name="<?php echo esc_attr($this->get_field_name('number')); ?>" type="text" value="<?php echo esc_attr( $number ); ?>" />
        </p>
       
    	<p>
            <label for="<?php echo esc_attr($this->get_field_id('cat')); ?>"><?php esc_html_e('Category', 'pickton'); ?></label>
            <?php wp_dropdown_categories( array('show_option_all'=>esc_html__('All Categories', 'pickton'), 'selected'=>$cat, 'class'=>'widefat', 'name'=>$this->get_field_name('cat')) ); ?>
        </p>
            
		<?php 
	}
	
	function posts($query_string)
	{
		$query = new WP_Query($query_string);
		if( $query->have_posts() ):?>
        
           	<!-- Title -->
			<?php while( $query->have_posts() ): $query->the_post(); ?>
                <article class="post">
                    <figure class="post-thumb"><?php the_post_thumbnail('pickton_90x90'); ?><a class="overlay" href="<?php echo esc_url(get_the_permalink(get_the_id()));?>"></a></figure>
                    <div class="text"><a href="<?php echo esc_url(get_the_permalink(get_the_id()));?>"><?php the_title(); ?></a></div>
                    <div class="post-info"><?php echo get_the_date(); ?></div>
                </article>
            <?php endwhile; ?>
            
        <?php endif;
		wp_reset_postdata();
    }
}


///----Dynamic Sidebar Widget---
/// Recent Services
class Bunch_servies extends WP_Widget
{
	/** constructor */
	function __construct()
	{
		parent::__construct( /* Base ID */'Bunch_servies', /* Name */esc_html__('Pickton Services Sidebar','pickton'), array( 'description' => esc_html__('Show the Services Sidebar', 'pickton' )) );
	}
 
	/** @see WP_Widget::widget */
	function widget($args, $instance)
	{
		extract( $args );
		
		echo wp_kses_post($before_widget); ?>
		
        <!-- Sidebar Category -->
        <div class="sidebar-category">
            <ul class="list">
                <?php 
					$args = array('post_type' => 'bunch_services', 'showposts'=>$instance['number']);
					if( $instance['cat'] ) $args['tax_query'] = array(array('taxonomy' => 'services_category','field' => 'id','terms' => (array)$instance['cat']));
					 
					$this->posts($args);
				?>
            </ul>
        </div>
		
        <?php echo wp_kses_post($after_widget);
	}
 
 
	/** @see WP_Widget::update */
	function update($new_instance, $old_instance)
	{
		$instance = $old_instance;
		
		$instance['number'] = $new_instance['number'];
		$instance['cat'] = $new_instance['cat'];
		
		return $instance;
	}
	/** @see WP_Widget::form */
	function form($instance)
	{
		$number = ( $instance ) ? esc_attr($instance['number']) : 6;
		$cat = ( $instance ) ? esc_attr($instance['cat']) : '';?>
		
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('number')); ?>"><?php esc_html_e('Number of posts: ', 'pickton'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('number')); ?>" name="<?php echo esc_attr($this->get_field_name('number')); ?>" type="text" value="<?php echo esc_attr( $number ); ?>" />
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('cat')); ?>"><?php esc_html_e('Category', 'pickton'); ?></label>
            <?php wp_dropdown_categories( array('show_option_all'=>esc_html__('All Categories', 'pickton'), 'selected'=>$cat, 'taxonomy' => 'services_category', 'class'=>'widefat', 'name'=>$this->get_field_name('cat')) ); ?>
        </p>
            
		<?php 
	}
	
	function posts($args)
	{
		$query = new WP_Query($args);
		if( $query->have_posts() ):?>
        
           	<!-- Title -->
            <?php $count = 1; while( $query->have_posts() ): $query->the_post(); 
				$services_meta = _WSH()->get_meta();
			?>
            <li class="<?php if($count == 1) echo 'current';?>"><a href="<?php echo esc_url(pickton_set($services_meta, 'ext_url')); ?>"><?php the_title(); ?></a></li>
            <?php $count++; endwhile; ?>
                
        <?php endif;
		wp_reset_postdata();
    }
}

/// Our Brochures
class Bunch_Brochures extends WP_Widget
{
	
	/** constructor */
	function __construct()
	{
		parent::__construct( /* Base ID */'Bunch_Brochures', /* Name */esc_html__('Pickton Our Brochures','pickton'), array( 'description' => esc_html__('Show the info Our Brochures', 'pickton' )) );
	}
	/** @see WP_Widget::widget */
	function widget($args, $instance)
	{
		extract( $args );
		$title = apply_filters( 'widget_title', $instance['title'] );
		
		echo wp_kses_post($before_widget);?>
      		
            <!-- Sidebar brochure-->
            <div class="sidebar-brochure">
                <a class="brochure" href="<?php echo esc_url($instance['pdf']); ?>"><span class="icon flaticon-pdf"></span><?php esc_html_e('Research Results', 'pickton'); ?> <span><?php esc_html_e('Download.Pdf', 'pickton'); ?></span></a>
                <a class="brochure" href="<?php echo esc_url($instance['word']); ?>"><span class="icon flaticon-word-file"></span><?php esc_html_e('Service Brochure', 'pickton'); ?> <span><?php esc_html_e('Download.txt', 'pickton'); ?></span></a>
            </div>
            
		<?php
		
		echo wp_kses_post($after_widget);
	}
	
	
	/** @see WP_Widget::update */
	function update($new_instance, $old_instance)
	{
		$instance = $old_instance;
		
		$instance['pdf'] = $new_instance['pdf'];
		$instance['word'] = $new_instance['word'];
		return $instance;
	}
	/** @see WP_Widget::form */
	function form($instance)
	{
		$pdf = ( $instance ) ? esc_attr($instance['pdf']) : '#';
		$word = ($instance) ? esc_attr($instance['word']) : '#';
		?>
        
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('pdf')); ?>"><?php esc_html_e('PDF Link:', 'pickton'); ?></label>
            <input placeholder="<?php esc_attr_e('PDF link here', 'pickton');?>" class="widefat" id="<?php echo esc_attr($this->get_field_id('pdf')); ?>" name="<?php echo esc_attr($this->get_field_name('pdf')); ?>" type="text" value="<?php echo esc_attr($pdf); ?>" />
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('word')); ?>"><?php esc_html_e('Work Doc Link:', 'pickton'); ?></label>
            <input placeholder="<?php esc_attr_e('Word link here', 'pickton');?>" class="widefat" id="<?php echo esc_attr($this->get_field_id('word')); ?>" name="<?php echo esc_attr($this->get_field_name('word')); ?>" type="text" value="<?php echo esc_attr($word); ?>" />
        </p>
                
		<?php 
	}
	
}

/// Our Team
class Bunch_Our_Team extends WP_Widget
{
	/** constructor */
	function __construct()
	{
		parent::__construct( /* Base ID */'Bunch_Our_Team', /* Name */esc_html__('Pickton Our Team','pickton'), array( 'description' => esc_html__('Show the Our Team', 'pickton' )) );
	}
 
	/** @see WP_Widget::widget */
	function widget($args, $instance)
	{
		extract( $args );
		$title = apply_filters( 'widget_title', $instance['title'] );
		
		echo wp_kses_post($before_widget); ?>
        
        <!-- Sidebar Info Widget-->
        <div class="sidebar-info-widget">
            <div class="inner-box">
                <?php 
					$args = array('post_type' => 'bunch_team', 'showposts'=>$instance['number']);
					if( $instance['cat'] ) $args['tax_query'] = array(array('taxonomy' => 'team_category','field' => 'id','terms' => (array)$instance['cat']));
					 
					$this->posts($args);
				?>
            </div>
        </div>
		
        <?php echo wp_kses_post($after_widget);
	}
 
 
	/** @see WP_Widget::update */
	function update($new_instance, $old_instance)
	{
		$instance = $old_instance;
		
		$instance['number'] = $new_instance['number'];
		$instance['cat'] = $new_instance['cat'];
		
		return $instance;
	}
	/** @see WP_Widget::form */
	function form($instance)
	{
		$number = ( $instance ) ? esc_attr($instance['number']) : 2;
		$cat = ( $instance ) ? esc_attr($instance['cat']) : '';?>
		
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('number')); ?>"><?php esc_html_e('Number of posts: ', 'pickton'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('number')); ?>" name="<?php echo esc_attr($this->get_field_name('number')); ?>" type="text" value="<?php echo esc_attr( $number ); ?>" />
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('cat')); ?>"><?php esc_html_e('Category', 'pickton'); ?></label>
            <?php wp_dropdown_categories( array('show_option_all'=>esc_html__('All Categories', 'pickton'), 'selected'=>$cat, 'taxonomy' => 'team_category', 'class'=>'widefat', 'name'=>$this->get_field_name('cat')) ); ?>
        </p>
            
		<?php 
	}
	
	function posts($args)
	{
		$query = new WP_Query($args);
		if( $query->have_posts() ):?>
        
           	<!-- Title -->
            <?php while( $query->have_posts() ): $query->the_post();
				$team_meta = _WSH()->get_meta();
			?>
            <div class="author-info-box">
                <h3><?php the_title(); ?>:</h3>
                <div class="author-inner">
                    <div class="image">
                        <?php the_post_thumbnail('pickton_67x64'); ?>
                    </div>
                    <div class="author-name"><?php echo wp_kses_post(pickton_set($team_meta, 'designation')); ?></div>
                    <ul>
                        <li><span class="icon fa fa-phone"></span><?php echo wp_kses_post(pickton_set($team_meta, 'phone')); ?></li>
                        <li><span class="icon fa fa-envelope"></span><?php echo sanitize_email(pickton_set($team_meta, 'email')); ?></li>
                    </ul>
                </div>
            </div>
            
            <?php endwhile; ?>
                
        <?php endif;
		wp_reset_postdata();
    }
}

