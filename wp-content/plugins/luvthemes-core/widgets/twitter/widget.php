<?php 

class Luv_Twitter_Widget extends WP_Widget {
	
	function __construct() {
		parent::__construct('luv-twitter-tweets-widget', esc_html__( 'Luvthemes Twitter Tweets Widget', 'fevr' ), array('description' => esc_html__( 'Displays latest tweets from Twitter.', 'fevr')));
	}
	
	/**
	 * Widget settings form
	 * @param object $instance
	 */
	public function form( $instance ) {
	
		if ( empty( $instance ) ) {
			$twitter_username = '';
			$update_count = '';
			$oauth_access_token = '';
			$oauth_access_token_secret = '';
			$consumer_key = '';
			$consumer_secret = '';
			$title = '';
		} else {
			$twitter_username = $instance['twitter_username'];
			$update_count = isset( $instance['update_count'] ) ? $instance['update_count'] : 5;
			$oauth_access_token = $instance['oauth_access_token'];
			$oauth_access_token_secret = $instance['oauth_access_token_secret'];
			$consumer_key = $instance['consumer_key'];
			$consumer_secret = $instance['consumer_secret'];
	
			if ( isset( $instance['title'] ) ) {
				$title = $instance['title'];
			} else {
				$title = esc_html__( 'Twitter feed', 'fevr' );
			}
		}
		 
		?>
	    <p>
	        <label for="<?php echo $this->get_field_id( 'title' ); ?>">
	            <?php echo esc_html__( 'Title', 'fevr' ) . ':'; ?>
	        </label>
	        <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
	    </p>
	    <p>
	        <label for="<?php echo $this->get_field_id( 'twitter_username' ); ?>">
	            <?php echo esc_html__( 'Twitter Username (without @)', 'fevr' ) . ':'; ?>
	        </label>
	        <input class="widefat" id="<?php echo $this->get_field_id( 'twitter_username' ); ?>" name="<?php echo $this->get_field_name( 'twitter_username' ); ?>" type="text" value="<?php echo esc_attr( $twitter_username ); ?>" />
	    </p>
	    <p>
	        <label for="<?php echo $this->get_field_id( 'update_count' ); ?>">
	            <?php echo esc_html__( 'Number of Tweets to Display', 'fevr' ) . ':'; ?>
	        </label>
	        <input class="widefat" id="<?php echo $this->get_field_id( 'update_count' ); ?>" name="<?php echo $this->get_field_name( 'update_count' ); ?>" type="number" value="<?php echo esc_attr( $update_count ); ?>" />
	    </p>
	    <p>
	        <label for="<?php echo $this->get_field_id( 'oauth_access_token' ); ?>">
	            <?php echo esc_html__( 'OAuth Access Token', 'fevr' ) . ':'; ?>
	        </label>
	        <input class="widefat" id="<?php echo $this->get_field_id( 'oauth_access_token' ); ?>" name="<?php echo $this->get_field_name( 'oauth_access_token' ); ?>" type="text" value="<?php echo esc_attr( $oauth_access_token ); ?>" />
	    </p>
	    <p>
	        <label for="<?php echo $this->get_field_id( 'oauth_access_token_secret' ); ?>">
	            <?php echo esc_html__( 'OAuth Access Token Secret', 'fevr' ) . ':'; ?>
	        </label>
	        <input class="widefat" id="<?php echo $this->get_field_id( 'oauth_access_token_secret' ); ?>" name="<?php echo $this->get_field_name( 'oauth_access_token_secret' ); ?>" type="text" value="<?php echo esc_attr( $oauth_access_token_secret ); ?>" />
	    </p>
	    <p>
	        <label for="<?php echo $this->get_field_id( 'consumer_key' ); ?>">
	            <?php echo esc_html__( 'Consumer Key', 'fevr' ) . ':'; ?>
	        </label>
	        <input class="widefat" id="<?php echo $this->get_field_id( 'consumer_key' ); ?>" name="<?php echo $this->get_field_name( 'consumer_key' ); ?>" type="text" value="<?php echo esc_attr( $consumer_key ); ?>" />
	    </p>
	    <p>
	        <label for="<?php echo $this->get_field_id( 'consumer_secret' ); ?>">
	            <?php echo esc_html__( 'Consumer Secret', 'fevr' ) . ':'; ?>
	        </label>
	        <input class="widefat" id="<?php echo $this->get_field_id( 'consumer_secret' ); ?>" name="<?php echo $this->get_field_name( 'consumer_secret' ); ?>" type="text" value="<?php echo esc_attr( $consumer_secret ); ?>" />
	    </p>
	    <?php
	}
	
	/**
	 * Update settings
	 * @param object $new_instance
	 * @param object $old_instance
	 * @return object
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		 
		$instance['title']                      = ( ! empty( $new_instance['title'] ) )                     ? strip_tags( $new_instance['title'] ) : '';
		$instance['title']                      = ( ! empty( $new_instance['title'] ) )                     ? strip_tags( $new_instance['title'] ) : '';
		$instance['twitter_username']           = ( ! empty( $new_instance['twitter_username'] ) )          ? strip_tags( $new_instance['twitter_username'] ) : '';
		$instance['update_count']               = ( ! empty( $new_instance['update_count'] ) )              ? strip_tags( $new_instance['update_count'] ) : '';
		$instance['oauth_access_token']         = ( ! empty( $new_instance['oauth_access_token'] ) )        ? strip_tags( $new_instance['oauth_access_token'] ) : '';
		$instance['oauth_access_token_secret']  = ( ! empty( $new_instance['oauth_access_token_secret'] ) ) ? strip_tags( $new_instance['oauth_access_token_secret'] ) : '';
		$instance['consumer_key']               = ( ! empty( $new_instance['consumer_key'] ) )              ? strip_tags( $new_instance['consumer_key'] ) : '';
		$instance['consumer_secret']            = ( ! empty( $new_instance['consumer_secret'] ) )           ? strip_tags( $new_instance['consumer_secret'] ) : '';
	
		return $instance;
	}
	
	/**
	 * Get twitter timeline
	 * @param string $username
	 * @param int $limit
	 * @param string $oauth_access_token
	 * @param string $oauth_access_token_secret
	 * @param string $consumer_key
	 * @param string $consumer_secret
	 * @return array
	 */
	public function twitter_timeline( $username, $limit, $oauth_access_token, $oauth_access_token_secret, $consumer_key, $consumer_secret ) {
		require_once 'TwitterAPIExchange.php';
	
		/** Set access tokens here - see: https://dev.twitter.com/apps/ */
		$settings = array(
				'oauth_access_token'        => $oauth_access_token,
				'oauth_access_token_secret' => $oauth_access_token_secret,
				'consumer_key'              => $consumer_key,
				'consumer_secret'           => $consumer_secret
		);
	
		$url = 'https://api.twitter.com/1.1/statuses/user_timeline.json';
		$getfield = '?screen_name=' . $username . '&count=' . $limit;
		$request_method = 'GET';
		 
		$twitter_instance = new TwitterAPIExchange( $settings );
		 
		$query = $twitter_instance
		->setGetfield( $getfield )
		->buildOauth( $url, $request_method )
		->performRequest();
		 
		$timeline = json_decode($query);
	
		return $timeline;
	}
	
	/**
	 * Convert time to human readable version
	 * Thanks for Agbonghama Collins (Tuts+)
	 * @param string $time
	 * @return string
	 */
	public function tweet_time( $time ) {
		// Get current timestamp.
		$now = strtotime( 'now' );
	
		// Get timestamp when tweet created.
		$created = strtotime( $time );
	
		// Get difference.
		$difference = $now - $created;
	
		// Calculate different time values.
		$minute = 60;
		$hour = $minute * 60;
		$day = $hour * 24;
		$week = $day * 7;
	
		if ( is_numeric( $difference ) && $difference > 0 ) {
	
			// If less than 3 seconds.
			if ( $difference < 3 ) {
				return esc_html__( 'right now', 'fevr' );
			}
	
			// If less than minute.
			if ( $difference < $minute ) {
				return floor( $difference ) . ' ' . esc_html__( 'seconds ago', 'fevr' );;
			}
	
			// If less than 2 minutes.
			if ( $difference < $minute * 2 ) {
				return esc_html__( 'about 1 minute ago', 'fevr' );
			}
	
			// If less than hour.
			if ( $difference < $hour ) {
				return floor( $difference / $minute ) . ' ' . esc_html__( 'minutes ago', 'fevr' );
			}
	
			// If less than 2 hours.
			if ( $difference < $hour * 2 ) {
				return esc_html__( 'about 1 hour ago', 'fevr' );
			}
	
			// If less than day.
			if ( $difference < $day ) {
				return floor( $difference / $hour ) . ' ' . esc_html__( 'hours ago', 'fevr' );
			}
	
			// If more than day, but less than 2 days.
			if ( $difference > $day && $difference < $day * 2 ) {
				return esc_html__( 'yesterday', 'fevr' );;
			}
	
			// If less than year.
			if ( $difference < $day * 365 ) {
				return floor( $difference / $day ) . ' ' . esc_html__( 'days ago', 'fevr' );
			}
	
			// Else return more than a year.
			return esc_html__( 'over a year ago', 'fevr' );
		}
	}
	
	/**
	 * Display widget
	 * @param array $args
	 * @param object $instance
	 */
	public function widget( $args, $instance ) {
		$title                     = apply_filters( 'widget_title', $instance['title'] );
		$username                  = $instance['twitter_username'];
		$limit                     = $instance['update_count'];
		$oauth_access_token        = $instance['oauth_access_token'];
		$oauth_access_token_secret = $instance['oauth_access_token_secret'];
		$consumer_key              = $instance['consumer_key'];
		$consumer_secret           = $instance['consumer_secret'];
	
		echo $args['before_widget'];
	
		if ( ! empty( $title ) ) {
			echo $args['before_title'] . $title . $args['after_title'];
		}
	
		// Get the tweets.
		$timelines = get_option('luv_twitter_widget_timeline', array());
		if (!isset($timelines[$username . $limit]) || empty($timelines[$username . $limit])){
			$timelines[$username . $limit] = $this->twitter_timeline( $username, $limit, $oauth_access_token, $oauth_access_token_secret, $consumer_key, $consumer_secret );
			update_option('luv_twitter_widget_timeline', $timelines);
		}
	
		if ( isset($timelines[$username . $limit]) && !empty($timelines[$username . $limit]) ) {
	
			// Add links to URL and username mention in tweets.
			$patterns = array( '@(https?://([-\w\.]+)+(:\d+)?(/([\w/_\.]*(\?\S+)?)?)?)@', '/@([A-Za-z0-9_]{1,15})/' );
			$replace = array( '<a href="$1">$1</a>', '<a href="http://twitter.com/$1">@$1</a>' );
			
			echo '<ul>';
			foreach ( $timelines[$username . $limit] as $timeline ) {
				$result = preg_replace( $patterns, $replace, $timeline->text );
	
				echo '<li>';
				echo $result;
				echo '<span>'.$this->tweet_time( $timeline->created_at ) . '</span>';
				echo '</li>';
			}
			echo '</ul>';
	
		} else {
			esc_html_e( 'Error fetching feeds. Please verify the Twitter settings in the widget.', 'fevr' );
		}
	
		echo $args['after_widget'];
	}
}

add_action( 'widgets_init', 'luv_twitter_widget' );
function luv_twitter_widget() {
	register_widget( 'Luv_Twitter_Widget' );
}

// Create "every_minutes" cron schedule
add_filter( 'cron_schedules', 'luv_cron_add_every_minutes' );

/**
 * Add cron schedules
 * @param array $schedules
 * @return array
 */
function luv_cron_add_every_minutes( $schedules ) {
	$schedules['every_minutes'] = array(
			'interval' => 60,
			'display' => esc_html__( 'Every minutes', 'fevr' )
	);
	return $schedules;
}

// Clear cached timelines in every minute
add_action('luv_clear_twitter_widget_cache', 'luv_clear_twitter_widget_cache');

if (!wp_next_scheduled('luv_clear_twitter_widget_cache')){
	wp_schedule_event(time(), 'every_minutes', 'luv_clear_twitter_widget_cache');
}

/**
 * Clear cached tweets
 */
function luv_clear_twitter_widget_cache(){
	update_option('luv_twitter_widget_timeline', array());
}


?>