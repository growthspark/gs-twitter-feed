<?php
/**
 * GS Twitter Settings Panel
 *
 * @since Version 1.0
 */


/**
 * Register the form setting for our options array.
 *
 *
 * @since Version 1.0
 */
function gs_twitter_options_init() {

	// If we have no options in the database, let's add them now.
	if ( false === growthspark_get_twitter_options() )
		add_option( 'gs_twitter_options', growthspark_get_default_twitter_options()  );

	register_setting(
		'gs_twitter_options',       // Options group, see settings_fields() call in gs_twitter_options_render_page()
		'gs_twitter_options', // Database option, see growthspark_get_twitter_options()
		'gs_twitter_options_validate' // The sanitization callback, see gs_twitter_options_validate()
	);

	// Register our settings field group
	add_settings_section(
		'general', // Unique identifier for the settings section
		'', // Section title (we don't want one)
		'__return_false', // Section callback (we don't want anything)
		'twitter_options' // Menu slug, used to uniquely identify the page; see gs_twitter_options_add_page()
	);

	add_settings_field( 'twitter_username', __( 'Username',     'growthspark' ), 'growthspark_settings_field_twitter_username', 'twitter_options', 'general' );

	add_settings_field( 'tweet_count', __( 'Tweet Count',     'growthspark' ), 'growthspark_settings_field_tweet_count', 'twitter_options', 'general' );

	add_settings_field( 'avatar_size', __( 'Avatar Size',     'growthspark' ), 'growthspark_settings_field_avatar_size', 'twitter_options', 'general' );

	add_settings_field( 'loading_text', __( 'Loading Text',     'growthspark' ), 'growthspark_settings_field_loading_text', 'twitter_options', 'general' );

	add_settings_field( 'twitter_template', __( 'Template',     'growthspark' ), 'growthspark_settings_field_twitter_template', 'twitter_options', 'general' );

}
add_action( 'admin_init', 'gs_twitter_options_init' );

/**
 * Change the capability required to save the options group.
 *
 *
 * @param string $capability The capability used for the page, which is manage_options by default.
 * @return string The capability to actually use.
 */
function growthspark_twitter_option_page_capability( $capability ) {
	return 'manage_options';
}
add_filter( 'option_page_capability_gs_twitter_options', 'growthspark_twitter_option_page_capability' );

/**
 * Add our options page to the admin menu.
 *
 * This function is attached to the admin_menu action hook.
 *
 * @since Version 1.0
 */
function gs_twitter_options_add_page() {
	$theme_page = add_options_page(
		__( 'Twitter Feed Settings', 'growthspark' ),   // Name of page
		__( 'Twitter Feed', 'growthspark' ),   // Label in menu
		'manage_options',                    // Capability required
		'twitter_options',                         // Menu slug, used to uniquely identify the page
		'gs_twitter_options_render_page' // Function that renders the options page
	);

	if ( ! $theme_page )
		return;
}
add_action( 'admin_menu', 'gs_twitter_options_add_page' );




/**
 * Returns the default options.
 *
 * @since Version 1.0
 */
function growthspark_get_default_twitter_options()  {
	$default_twitter_options = array(
		'twitter_username' => 'growthspark',
		'tweet_count' => 3,
		'loading_text' => 'loading tweets...',
		'avatar_size' => '',
		'twitter_template' => '{avatar}{time}{join}{text}'
	);

	return apply_filters( 'growthspark_default_twitter_options', $default_twitter_options );
}

/**
 * Returns the options array.
 *
 * @since Version 1.0
 */
function growthspark_get_twitter_options() {
	return get_option( 'gs_twitter_options', growthspark_get_default_twitter_options()  );
}


/**
 * Renders a setting field.
 *
 * 
 */
function growthspark_settings_field_twitter_username() {
	$options = growthspark_get_twitter_options();

			// Sanitize
			$id = 'twitter_username';
			$value = ( isset($options[$id]) && !empty($options[$id]) ) ? $options[$id] : '';
			$field = '<p>
				<input name="gs_twitter_options[' . $id . ']" id="gs_twitter_options[' . $id . ']" type="text" value="' . $value . '" size="20" maxlength="20" />
			
			<small>Twitter account to display tweets from</small></p>';

		echo $field;

}

/**
 * Renders a setting field.
 *
 * 
 */
function growthspark_settings_field_tweet_count() {
	$options = growthspark_get_twitter_options();

			// Sanitize
			$id = 'tweet_count';
			$value = ( isset($options[$id]) && !empty($options[$id]) ) ? intval($options[$id]) : '';
			$field = '<p>
				<input name="gs_twitter_options[' . $id . ']" id="gs_twitter_options[' . $id . ']" type="text" value="' . $value . '" size="2" maxlength="2" />
				<small># of Tweets to display</small></p>';

		echo $field;

}

/**
 * Renders a setting field.
 *
 * 
 */
function growthspark_settings_field_avatar_size() {
	$options = growthspark_get_twitter_options();

			// Sanitize
			$id = 'avatar_size';
			$value = ( isset($options[$id]) && !empty($options[$id]) ) ? intval($options[$id]) : '';
			$field = '<p>
				<input name="gs_twitter_options[' . $id . ']" id="gs_twitter_options[' . $id . ']" type="text" value="' . $value . '" size="3" maxlength="3" />
				
				<small>pixels</small></p>';

		echo $field;

}


/**
 * Renders a setting field.
 *
 * 
 */
function growthspark_settings_field_loading_text() {
	$options = growthspark_get_twitter_options();

			// Sanitize
			$id = 'loading_text';
			$value = ( isset($options[$id]) && !empty($options[$id]) ) ? $options[$id] : '';
			$field = '<p>
				<input name="gs_twitter_options[' . $id . ']" id="gs_twitter_options[' . $id . ']" type="text" value="' . $value . '" size="20" maxlength="20" />
			<small>Text to display while tweets are loading</small></p>';

		echo $field;

}


/**
 * Renders a setting field.
 *
 * 
 */
function growthspark_settings_field_twitter_template() {
	$options = growthspark_get_twitter_options();

			// Sanitize
			$id = 'twitter_template';
			$value = ( isset($options[$id]) && !empty($options[$id]) ) ? $options[$id] : '';
			$field = '<p>
				<textarea name="gs_twitter_options[' . $id . ']" id="gs_twitter_options[' . $id . ']" cols="80" rows="5" />' . $value . '</textarea></p>
			<p><small>Customize how tweets are displayed</small></p>';

		echo $field;

}




/**
 * Builds the options page.
 *
 * @since Version 1.0
 */
function gs_twitter_options_render_page() {
	?>
	<div class="wrap">
		<?php screen_icon(); ?>
		<h2>Twitter Feed</h2>
		<?php settings_errors(); ?>

		<form method="post" action="options.php">
			<?php
				settings_fields( 'gs_twitter_options' );
				do_settings_sections( 'twitter_options' );
				submit_button();
			?>
		</form>
	</div>
	<?php
}

/**
 * Sanitize and validate form input. Accepts an array, return a sanitized array.
 *
 * @since Version 1.0
 */
function gs_twitter_options_validate( $input ) {
	$output = $defaults = growthspark_get_default_twitter_options() ;

	$output['twitter_username'] = $input['twitter_username'];
	$output['tweet_count'] = intval($input['tweet_count']);
	$output['avatar_size'] = intval($input['avatar_size']);
	$output['loading_text'] = $input['loading_text'];
	$output['twitter_template'] = $input['twitter_template'];

	return apply_filters( 'gs_twitter_options_validate', $output, $input, $defaults );
}
