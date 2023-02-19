<?php

if (!defined('__NYZO_EXTENSION_ROOT__')) { define('__NYZO_EXTENSION_ROOT__', dirname(__FILE__)); }
require_once(__NYZO_EXTENSION_ROOT__ . '/lib/nyzoStringEncoder.php');
require_once(__NYZO_EXTENSION_ROOT__ . '/lib/nyzoStringPublicIdentifier.php');
require_once(__NYZO_EXTENSION_ROOT__ . '/lib/nyzoTip.php');

add_shortcode('nyzo_tip', 'nyzoTipShortcode');

function nyzoTipShortcode() {
    return nyzoTipElement() . ' (included with shortcode)';
}