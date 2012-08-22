<?php
/**************************************************************

:: Create Twitter Feed Widget

***************************************************************/

class GS_Twitter_Feed_Widget extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	public function __construct() {
		//global $wid, $wname;
		parent::__construct(
	 		'twitter_feed', // Base ID
			'Twitter Feed', // Name
			array( 'description' => __( 'Displays a custom twitter feed', 'text_domain' ), ) // Args
		);

		// Only load scripts if the widget is active
	 	if ( is_active_widget(false, false, $this->id_base, true) ) {
	 		add_action('wp_enqueue_scripts', array($this, 'twitter_register_scripts'));
			add_action('wp_footer', array($this, 'twitter_settings'));
    	}       

	}

	/**
	 * Register necessary JS & CSS on the frontend
	 */
	public function twitter_register_scripts() {
		wp_register_script( 'jquery-tweet', plugins_url( 'js/jquery.tweet.custom.js', __FILE__ ) , array( 'jquery' ), '1', false );
		wp_enqueue_script('jquery-tweet');

		wp_register_style( 'gs-twitter-styles', plugins_url( 'css/gs-twitter-feed.css', __FILE__ ) , array(), '1', 'all');
		wp_enqueue_style('gs-twitter-styles');
	}

	/**
	 * Add custom settings to the footer
	 */
	public function twitter_settings() {
	$option = get_option('gs_twitter_options');

	?>
	<!-- GS Twitter Feed Settings -->
	<script>
		jQuery(function($){
	        $('.gs-twitter').tweet({
	          avatar_size: <?php echo $option["avatar_size"]; ?>,
	          count: <?php echo $option["tweet_count"]; ?>,
	          username: '<?php echo $option["twitter_username"]; ?>',
	          loading_text: '<?php echo $option["loading_text"]; ?>',
	          template: '<?php echo $option["twitter_template"]; ?>'
	        });
	      });
	</script>
	<!-- / GS Twitter Feed Settings -->
	<?php
	}

	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget( $args, $instance ) {

		extract( $args );
		$title = apply_filters( 'widget_title', $instance['title'] );

		echo $before_widget;
		if ( ! empty( $title ) )
			echo $before_title . $title . $after_title;
		?>
		<div class="gs-twitter"></div>
		<div class="gs-twiter-more"></div>
		<?php
		echo $after_widget;
	}

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = strip_tags( $new_instance['title'] );

		return $instance;
	}

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {
		if ( isset( $instance[ 'title' ] ) ) {
			$title = $instance[ 'title' ];
		}
		else {
			$title = __( 'New title', 'text_domain' );
		}
		?>
		<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>
		<p><small>Configure settings under Settings -> Twitter Feed</small></p>
		<?php 
	}

} // Widget class 

// register the widget
add_action( 'widgets_init', create_function( '', 'register_widget( "GS_Twitter_Feed_Widget" );' ) );
