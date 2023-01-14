<?php

define('__ROOT__', dirname(__FILE__));
require_once(__ROOT__ . '/lib/nyzoStringEncoder.php');
require_once(__ROOT__ . '/lib/nyzoStringType.php');

function runTests() {
    echo '*****************' . PHP_EOL;
    echo '* running tests *' . PHP_EOL;
    echo '*****************' . PHP_EOL . PHP_EOL;

    displayNyzoStringTypeValues();
    displayNyzoStringEncoderValues();

    echo PHP_EOL;
}

function displayNyzoStringTypeValues() {

    echo 'NyzoStringType values:' . PHP_EOL;
    foreach (NyzoStringType::cases() as $nyzoStringType) {
        echo '- ' . $nyzoStringType->name . ' (' . $nyzoStringType->getPrefix() . ')' . PHP_EOL;
    }
    echo PHP_EOL;
}

function displayNyzoStringEncoderValues() {
    echo 'NyzoStringEncoder::characterLookup: ' . NyzoStringEncoder::characterLookup . PHP_EOL;
    echo 'NyzoStringEncoder::$characterToValueMap: ';
    echo print_r(NyzoStringEncoder::$characterToValueMap) . PHP_EOL;
    echo 'NyzoStringEncoder::headerLength: ' . NyzoStringEncoder::headerLength . PHP_EOL;

}

runTests();