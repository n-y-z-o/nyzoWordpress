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

function nyzo_meta_boxes_elements($post) {

    wp_nonce_field('nyzo_post_meta', 'nyzo_nonce');

    echo '<div class="components-panel__row">';
    echo '<div class="components-base-control components-checkbox-control">';
    echo '<input id="nyzo_monetize_with_micropay" name="nyzo_monetize_with_micropay" type="checkbox" value="1" ';
    if (get_post_meta($post->ID, 'nyzo_monetize_with_micropay', true) === '1') {
        echo 'checked';
    }
    echo '/>';
    echo '<label for="nyzo_monetize_with_micropay">Monetize with Micropay</label>';
    echo '</div>';
    echo '</div>';

    $previewBlockCount = get_post_meta($post->ID, 'nyzo_preview_block_count', true);
    if (!is_numeric($previewBlockCount) || $previewBlockCount < 0) {
        $previewBlockCount = 3;
    }

    echo '<div class="components-panel__row">';
    echo '<div class="components-base-control components-checkbox-control">';
    echo '<label for="nyzo_preview_block_count">Number of preview blocks</label>';
    echo '<input id="nyzo_preview_block_count" name="nyzo_preview_block_count" type="number" min="0" value="' .
        $previewBlockCount . '"/>';
    echo '</div>';
    echo '</div>';
}

function nyzo_save_metadata($post_id) {

    if (isset($_POST['nyzo_nonce']) && wp_verify_nonce($_POST['nyzo_nonce'], 'nyzo_post_meta') &&
        current_user_can('edit_post', $post_id)) {

        // Save the monetization option.
        if (isset($_POST['nyzo_monetize_with_micropay'])) {
            update_post_meta($post_id, 'nyzo_monetize_with_micropay', '1');
        } else {
            delete_post_meta($post_id, 'nyzo_monetize_with_micropay');
        }

        // Save the number of preview blocks.
        if (isset($_POST['nyzo_preview_block_count']) && is_numeric($_POST['nyzo_preview_block_count']) &&
            $_POST['nyzo_preview_block_count'] >= 0) {
            update_post_meta($post_id, 'nyzo_preview_block_count', $_POST['nyzo_preview_block_count']);
        }
    }
}
add_action('save_post', 'nyzo_save_metadata');
