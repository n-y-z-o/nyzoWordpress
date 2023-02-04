<?php
/*
Plugin Name: Nyzo
Author: Nyzo
Author URI: http://tech.nyzo.co
Description: This plugin is being developed to enable easier integration of Nyzo Micropay and related functionalities on WordPress sites.
Version: 0.0.1
Requires PHP: 8.1
License: The Unlicense
 */

define( 'NYZO__PLUGIN_DIRECTORY', plugin_dir_path( __FILE__ ) );
require_once( NYZO__PLUGIN_DIRECTORY . 'settings.php' );

function nyzo_content_filter( $content ) {
     return $content . '<p class="nyzo-notice">Nyzo plugin installed and activated</p>';
}
add_filter('the_content', 'nyzo_content_filter');

wp_enqueue_style('nyzo-style', plugins_url('css/nyzo.css', __FILE__));
wp_enqueue_script('nyzo-nacl', plugins_url('javascript/nacl.min.js', __FILE__));
wp_enqueue_script('nyzo-sha256', plugins_url('javascript/sha256.min.js', __FILE__));
wp_enqueue_script('nyzo-byte-buffer', plugins_url('javascript/byteBuffer.js', __FILE__));
wp_enqueue_script('nyzo-string', plugins_url('javascript/nyzoString.js', __FILE__));
wp_enqueue_script('nyzo-util', plugins_url('javascript/util.js', __FILE__));