<?php

if (!defined('__NYZO_EXTENSION_ROOT__')) { define('__NYZO_EXTENSION_ROOT__', dirname(dirname(__FILE__))); }
require_once(__NYZO_EXTENSION_ROOT__ . '/lib/nyzoString.php');

class NyzoStringPrivateSeed implements NyzoString {

    private string $seed;

    function __construct(string $seed) {
        $this->seed = $seed;
    }

    function getSeed(): string {
        return $this->seed;
    }

    function getType(): NyzoStringType {
        return NyzoStringType::PrivateSeed;
    }

    function getBytes(): string {
        return $this->seed;
    }
}