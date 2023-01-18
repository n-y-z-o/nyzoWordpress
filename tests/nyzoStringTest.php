<?php

define('__ROOT__', dirname(dirname(__FILE__)));
require_once(__ROOT__ . '/lib/nyzoString.php');
require_once(__ROOT__ . '/lib/nyzoStringEncoder.php');
require_once(__ROOT__ . '/lib/nyzoStringType.php');

class NyzoStringTest {

    static function run(): bool {
        self::displayNyzoStringTypeValues();
        self::displayNyzoStringEncoderValues();

        $successful = true;
        $failureCause = '';
        try {
            $successful = self::testEncoder();
        } catch (Exception $e) {
            $failureCause = "exception in NyzoStringTest->testEncoder(): " + $e;
            $successful = false;
        }

        return $successful;
    }

    static function testEncoder(): bool {

        // The encoding lookup table is 64 characters. 64 characters store 6 bits (2^6=64). This allows the encoder to
        // store 3 bytes (24 bits) in 4 characters. This test checks encoding and decoding up to double this packing
        // increment, from 1 to 6 bytes (1 to 8 characters).

        $byteArrays = [ '89', '712aab', '3a0536', 'bd53aa', '2e', '98', '9d65ed', '1bdd1542ca', '0b49ddab',
            '78fdccc42427', '994d0200', '0e0000', '40', 'e6093ad212', '19941b43', 'e5221d048a', 'b419', '65bb880d55',
            '6a2b74e7f9', '595c', 'db851f52', '7193', 'a817', '82', '9f2e4dee75f2', 'de805a40e3e9', '2920d328b493',
            '5151', '1e1345be', '826b82f468dd' ];
        $strings = [ 'zg', 'tiHI', 'exkU', 'MmeH', 'bx', 'D0', 'EnoK', '6.SmgJF', '2SEuHN', 'vfVcP2gE', 'DkS200',
            '3x00', 'g0', 'XxBYSy8', '6qgsgN', 'Xi8u18F', 'K1B', 'qsL83mk', 'rzKSX_B', 'nmN', 'UWkwkx', 'tqc', 'H1t',
            'xx', 'EQXdZEoQ', 'VF1rgefG', 'ai3jabij', 'km4', '7yd5Mx', 'xDL2.6Au' ];

        // Check decoding and encoding for all values.
        $successful = true;
        for ($i = 0; $i < count($byteArrays) && $successful; $i++) {

            $byteArray = $byteArrays[$i];
            $string = $strings[$i];

            // Check decoding against the expected byte array.
            $decodedByteArray = NyzoStringEncoder::byteArrayForEncodedString($string);
            if ($byteArray !== $decodedByteArray) {
                $successful = false;
                $failureCause = 'mismatch of expected byte array (' . $byteArray . ') and decoded byte array (' .
                     $decodedByteArray . ') in iteration ' . $i . ' of NyzoStringTest::testEncoder()';
            }

            // Check encoding against the expected encoded string.
            $encodedString = NyzoStringEncoder::encodedStringForByteArray($byteArray);
            if ($string !== $encodedString) {
                $successful = false;
                $failureCause = 'mismatch of expected string (' . $string . ') and encoded string (' . $encodedString .
                    ') in iteration ' . $i . ' of NyzoStringTest::testEncoder()';
            }
        }

        echo NyzoTestUtil::passFail($successful) . PHP_EOL;
        if (!$successful) {
            echo 'failure cause: ' . $failureCause;
        }

        return $successful;
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