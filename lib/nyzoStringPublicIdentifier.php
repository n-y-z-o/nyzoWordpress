<?php

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
        return $identifier;
    }
}
