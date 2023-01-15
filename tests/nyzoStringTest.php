<?php

define('__ROOT__', dirname(dirname(__FILE__)));
require_once(__ROOT__ . '/lib/nyzoStringEncoder.php');
require_once(__ROOT__ . '/lib/nyzoStringType.php');

class NyzoStringTest {

    static function run() {
        self::displayNyzoStringTypeValues();
        self::displayNyzoStringEncoderValues();
    }

    static function displayNyzoStringTypeValues() {

        echo 'NyzoStringType values:' . PHP_EOL;
        foreach (NyzoStringType::cases() as $nyzoStringType) {
            echo '- ' . $nyzoStringType->name . ' (' . $nyzoStringType->getPrefix() . ')' . PHP_EOL;
        }
        echo PHP_EOL;
    }

    static function displayNyzoStringEncoderValues() {
        echo 'NyzoStringEncoder::characterLookup: ' . NyzoStringEncoder::characterLookup . PHP_EOL;
        echo 'NyzoStringEncoder::$characterToValueMap: ';
        echo print_r(NyzoStringEncoder::$characterToValueMap) . PHP_EOL;
        echo 'NyzoStringEncoder::headerLength: ' . NyzoStringEncoder::headerLength . PHP_EOL;
    }
}