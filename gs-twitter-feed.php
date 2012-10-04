<?php
/*
Plugin Name: Growth Spark Twitter Feed
Plugin URI: http://www.growthspark.com
Description: Enables a Twitter Feed widget for displaying the latest tweets from a Twitter account.
Author: Growth Spark
Author URI: http://www.growthspark.com
Version: 1.0
*/

require('widget.php');
require('settings.php');

add_action('admin_enqueue_scripts', 'gs_twitter_admin_styles');
function gs_twitter_admin_styles() {
	wp_register_style( 'gs-twitter-admin-styles', plugins_url( 'css/admin.css', __FILE__ ) , array(), '1', 'all');
	wp_enqueue_style('gs-twitter-admin-styles');
}

?>