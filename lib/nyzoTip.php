<?php

if (!defined('__NYZO_EXTENSION_ROOT__')) { define('__NYZO_EXTENSION_ROOT__', dirname(dirname(__FILE__))); }
require_once(__NYZO_EXTENSION_ROOT__ . '/lib/nyzoStringEncoder.php');
require_once(__NYZO_EXTENSION_ROOT__ . '/lib/nyzoStringPublicIdentifier.php');

function nyzoTipElement($style, $debugTag) {
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

    // If the client endpoint is not a valid URL, or if the client scheme is not http or https, use the default
    // endpoint.
    if (!filter_var($clientEndpoint, FILTER_VALIDATE_URL) || (strcmp($scheme, 'http') && strcmp($scheme, 'https'))) {
        error_log('Nyzo client endpoint is invalid; using default');
        $clientEndpoint = 'https://client.nyzo.co/api/forwardTransaction';
    }

    // Assemble the result.
    $result = '<div class="nyzo-tip-button nyzo-extension-not-installed ';
    if ($style == 'large' || $style === 'small') {
        $result .= 'nyzo-tip-element-' . $style;
    }
    $result .= '" ';

    $result .= 'data-client-url="' . $clientEndpoint . '" ' .
        'data-receiver-id="' . $receiverId . '" ' .
        'data-tag="tip">';

    if ($style == 'large' || $style === 'small') {
        $result .= '<img src="' . plugins_url('images/nyzo-tip-button.png', dirname(__FILE__)) .
            '" class="nyzo-tip-element-' . $style . '" >';
        $result .= '<p>' . $debugTag . '</p>';
    }

    $result .= '</div>';

    return $result;
}