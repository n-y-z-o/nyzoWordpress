<?php

if (!defined('__NYZO_EXTENSION_ROOT__')) { define('__NYZO_EXTENSION_ROOT__', dirname(dirname(__FILE__))); }
require_once(__NYZO_EXTENSION_ROOT__ . '/lib/nyzoStringType.php');

interface NyzoString {
    public function getType(): NyzoStringType;
    public function getBytes(): string;
}