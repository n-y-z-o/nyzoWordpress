<?php

if (!defined('__NYZO_EXTENSION_ROOT__')) { define('__NYZO_EXTENSION_ROOT__', dirname(__FILE__)); }
require_once(__NYZO_EXTENSION_ROOT__ . '/lib/nyzoStringEncoder.php');
require_once(__NYZO_EXTENSION_ROOT__ . '/lib/nyzoStringPublicIdentifier.php');
require_once(__NYZO_EXTENSION_ROOT__ . '/lib/nyzoTip.php');

add_shortcode('nyzo_tip', 'nyzoTipShortcodeDefault');
add_shortcode('nyzo_tip_hidden', 'nyzoTipShortcodeHidden');
add_shortcode('nyzo_tip_small', 'nyzoTipShortcodeSmall');
add_shortcode('nyzo_tip_large', 'nyzoTipShortcodeLarge');

function nyzoTipShortcodeDefault() {
    $options = get_option('nyzo_plugin_options');
    try {
        $style = $options['default_shortcode_tip_element'];
    } catch (Throwable $t) {
        $style = 'hidden';
    }
    return nyzoTipElement($style, 'shortcode nyzo_tip');
}

function nyzoTipShortcodeHidden() {
    return nyzoTipElement('hidden', 'shortcode nyzo_tip_hidden');
}

function nyzoTipShortcodeSmall() {
    return nyzoTipElement('small', 'shortcode nyzo_tip_small');
}

function nyzoTipShortcodeLarge() {
    return nyzoTipElement('large', 'shortcode nyzo_tip_large');
}