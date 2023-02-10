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

error_log('loading Nyzo plugin');

define('NYZO__PLUGIN_DIRECTORY', plugin_dir_path( __FILE__ ));
require_once(NYZO__PLUGIN_DIRECTORY . 'settings.php');
require_once(NYZO__PLUGIN_DIRECTORY . 'shortcodes.php');

function nyzo_content_filter($content) {
     return $content . '<p class="nyzo-notice">Nyzo plugin installed and activated</p>';
}
add_filter('the_content', 'nyzo_content_filter');

function nyzo_enqueue_styles() {
    wp_enqueue_style('nyzo_style', plugins_url('css/nyzo.css', __FILE__));
}
add_action('wp_enqueue_styles', 'nyzo_enqueue_styles');

function nyzo_enqueue_scripts() {
    wp_enqueue_script('nyzo_nacl', plugins_url('javascript/nacl.min.js', __FILE__));
    wp_enqueue_script('nyzo_sha256', plugins_url('javascript/sha256.min.js', __FILE__));
    wp_enqueue_script('nyzo_byte-buffer', plugins_url('javascript/byteBuffer.js', __FILE__));
    wp_enqueue_script('nyzo_string', plugins_url('javascript/nyzoString.js', __FILE__));
    wp_enqueue_script('nyzo_util', plugins_url('javascript/util.js', __FILE__));
}
add_action('wp_enqueue_scripts', 'nyzo_enqueue_scripts');