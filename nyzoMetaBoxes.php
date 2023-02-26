<?php

if (!defined('__NYZO_EXTENSION_ROOT__')) { define('__NYZO_EXTENSION_ROOT__', dirname(__FILE__)); }

function nyzo_meta_boxes() {
    add_meta_box(
        'nyzo_micropay_options',     // ID
        'Nyzo',                      // display title
        'nyzo_meta_boxes_elements',  // content function
        'post',                      // display on post editor
        'side',                      // context
        'default'                    // priority
    );
}
add_action('add_meta_boxes', 'nyzo_meta_boxes');

function nyzo_meta_boxes_elements() {

    wp_nonce_field(plugin_basename(__FILE__), 'nyzo_nonce');

    echo '<input id="nyzo_monetize_with_micropay" name="nyzo_monetize_with_micropay" type="checkbox" value="1" />';
    echo '<label for="nyzo_monetize_with_micropay">Monetize with Micropay</label>';
}
