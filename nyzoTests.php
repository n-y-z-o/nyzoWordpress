<?php

define('__ROOT__', dirname(__FILE__));
require_once(__ROOT__ . '/lib/nyzoStringType.php');

function runTests() {
    echo '*****************' . PHP_EOL;
    echo '* running tests *' . PHP_EOL;
    echo '*****************' . PHP_EOL . PHP_EOL;

    displayNyzoStringTypeValues();
}

function displayNyzoStringTypeValues() {

    echo 'NyzoStringType values:' . PHP_EOL;
    foreach (NyzoStringType::cases() as $nyzoStringType) {
        echo '- ' . $nyzoStringType->name . ' (' . $nyzoStringType->getPrefix() . ')' . PHP_EOL;
    }
    echo PHP_EOL;
}

runTests();