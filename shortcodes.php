<?php

if (!defined('__NYZO_EXTENSION_ROOT__')) { define('__NYZO_EXTENSION_ROOT__', dirname(__FILE__)); }
require_once(__NYZO_EXTENSION_ROOT__ . '/lib/nyzoStringEncoder.php');
require_once(__NYZO_EXTENSION_ROOT__ . '/lib/nyzoStringPublicIdentifier.php');

add_shortcode('nyzo_tip', 'nyzoTipShortcode');

function nyzoTipShortcode() {
    // Get the receiver identifier.
    $options = get_option('nyzo_plugin_options');
    try {
        $receiverId = $options['receiver_id'];
    } catch (Throwable $t) {
        $receiverId = '';
    }

    // Get the client endpoint.
    try {
        $clientEndpoint = $options['client_endpoint'];
    } catch (Throwable $t) {
        $clientEndpoint = '';
    }

    // Get the scheme.
    try {
        $scheme = strtolower(parse_url($clientEndpoint, PHP_URL_SCHEME));
    } catch (Throwable $t) {
        $scheme = '';
    }
    error_log('scheme: ' . $scheme);

    // If the client endpoint is not a valid URL, or if the client scheme is not http or https, use the default
    // endpoint.
    if (!filter_var($clientEndpoint, FILTER_VALIDATE_URL) || (strcmp($scheme, 'http') && strcmp($scheme, 'https'))) {
        error_log('Nyzo client endpoint is invalid; using default');
        $clientEndpoint = 'https://client.nyzo.co/api/forwardTransaction';;
    }

    return '<div class="nyzo-tip-button nyzo-extension-not-installed" ' .
        'data-client-url="' . $clientEndpoint . '" ' .
        'data-receiver-id="' . $receiverId . '" ' .
        'data-tag="tip">' .
        'This is the Nyzo tip element' .
        '</div>';
}