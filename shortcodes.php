<?php

if (!defined('__NYZO_EXTENSION_ROOT__')) { define('__NYZO_EXTENSION_ROOT__', dirname(__FILE__)); }
require_once(__NYZO_EXTENSION_ROOT__ . '/lib/nyzoStringEncoder.php');
require_once(__NYZO_EXTENSION_ROOT__ . '/lib/nyzoStringPublicIdentifier.php');

add_shortcode('nyzo_tip', 'nyzoTipShortcode');

function nyzoTipShortcode() {
    $options = get_option('nyzo_plugin_options');
    try {
        $receiverId = $options['receiver_id'];
    } catch (Throwable $t) {
        $receiverId = '';
    }

    return '<div class="nyzo-tip-button nyzo-extension-not-installed" ' .
        'data-client-url="https://client.nyzo.co/api/forwardTransaction" ' .
        'data-receiver-id="' . $receiverId . '" ' .
        'data-tag="tip">' .
        'This is the Nyzo tip element' .
        '</div>';
}