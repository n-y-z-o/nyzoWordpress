<?php

if (!defined('__NYZO_EXTENSION_ROOT__')) { define('__NYZO_EXTENSION_ROOT__', dirname(dirname(__FILE__))); }
require_once(__NYZO_EXTENSION_ROOT__ . '/lib/nyzoString.php');
require_once(__NYZO_EXTENSION_ROOT__ . '/lib/nyzoStringEncoder.php');

class NyzoStringPublicIdentifier implements NyzoString {

    private string $identifier;

    function __construct(string $identifier) {
        $this->identifier = $identifier;
    }

    function getIdentifier(): string {
        return $this->identifier;
    }

    function getType(): NyzoStringType {
        return NyzoStringType::PublicIdentifier;
    }

    function getBytes(): string {
        return $this->identifier;
    }
}
