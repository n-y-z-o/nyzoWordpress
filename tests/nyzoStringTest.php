<?php

if (!defined('__NYZO_EXTENSION_ROOT__')) { define('__NYZO_EXTENSION_ROOT__', dirname(dirname(__FILE__))); }
require_once(__NYZO_EXTENSION_ROOT__ . '/lib/nyzoString.php');
require_once(__NYZO_EXTENSION_ROOT__ . '/lib/nyzoStringEncoder.php');
require_once(__NYZO_EXTENSION_ROOT__ . '/lib/nyzoStringPublicIdentifier.php');
require_once(__NYZO_EXTENSION_ROOT__ . '/lib/nyzoStringType.php');
require_once(__NYZO_EXTENSION_ROOT__ . '/tests/nyzoTest.php');

class NyzoStringTest implements NyzoTest {

    private string $failureCause = '';

    function run(): bool {
        self::displayNyzoStringTypeValues();
        self::displayNyzoStringEncoderValues();

        $successful = true;
        try {
            $successful = self::testEncoder();
        } catch (Throwable $t) {
            $this->failureCause = 'throwable in NyzoStringTest->testEncoder(): ' . $t->getMessage();
            $successful = false;
        }

        if ($successful) {
            try {
                $successful = self::testPublicIdentifierStrings();
            } catch (Throwable $t) {
                $this->failureCause = 'throwable in NyzoStringTest->testPublicIdentifierStrings(): ' . $t->getMessage();
                $successful = false;
            }
        }

        return $successful;
    }

    function getFailureCause(): string {
        return $this->failureCause;
    }

    function testEncoder(): bool {

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
                $this->failureCause = 'mismatch of expected byte array (' . $byteArray . ') and decoded byte array (' .
                     $decodedByteArray . ') in iteration ' . $i . ' of NyzoStringTest::testEncoder()';
            }

            // Check encoding against the expected encoded string.
            $encodedString = NyzoStringEncoder::encodedStringForByteArray($byteArray);
            if ($string !== $encodedString) {
                $successful = false;
                $this->failureCause = 'mismatch of expected string (' . $string . ') and encoded string (' .
                    $encodedString . ') in iteration ' . $i . ' of NyzoStringTest::testEncoder()';
            }
        }

        echo NyzoTestUtil::passFail($successful, $this->failureCause) . PHP_EOL;

        return $successful;
    }

    function testPublicIdentifierStrings(): bool {

        $rawIdentifiers = [
            'c34a6f1942cb7ec10d2a440b3e116041d05df2746ebe7b41802340a1495e7af5',  // Argo 746
            'b5fd3e8d789a5055091e46db881f1b741b0ab6f8d65b21ae88cc543dfd92173b',  // Nyzo 0
            '15fa0cd9b161953858d097090621a4de24063449b66d4dac2af90543389a9f89',  // Nyzo 1
            '4ddefde6a0c5abf78868f2c13803f934c45a0f675f69fd750d6578046617eec5',  // Nyzo 2
            '1459eed3a8d3bbf1d1faaf553f0860336615d10e0ebd44b5f8b5c94418457a43',  // Nyzo 3
            '684d8b1bfedb0bb319954ba3e330d82577ed7ffa45fdf468cfe01accac6db89d',  // Nyzo 4
            'e917bf3cf77b2c8e100a3715500397abcb89f99963a174e13c5b4e11cbb72852',  // Nyzo 5
            'f83cf2e0e3abc5df01bddd67fead3099bff7efaf467010f53b654f293a9a9887',  // Nyzo 6
            '363a10a67dfac9a2ac59dc7a1fd03e3705665f01560d399c78a367dc21ce94ce',  // Nyzo 7
            'de2fd26165e1b774ce8da5365040fc60be84a2167e1d62e7f847b40fea05863a',  // Nyzo 8
            '92a5849feebbb2e1fb64b6d93940bad36168ff0d4f984f1a7b64dc6fedc0dae5'   // Nyzo 9
        ];
        $nyzoStrings = [
            'id__8cdasPC2QVZ13iG42RWhp47gow9SsIXZgp0Aga59oEITG2X-M7Ur',  // Argo 746
            'id__8bo.fFTWDC1m2hX6UWxw6Vgs2IsWTCJyIFAcm3V.BytZgoahsDN5',  // Nyzo 0
            'id__81oY3dDPpqkWnd2o2gpyGdWB1Ah9KDTdI2IX1kcWDG~9zSnx2qrV',  // Nyzo 1
            'id__84Vv_vrxPrMVz6AQNjx3~jj4nx.EoUE.ugTCv0hD5~Z5p5hM3PFu',  // Nyzo 2
            'id__81hqZKeFSZMPSwHMmj-8p3dD5u4e3IT4KwzTQkgphoG3ZTTQRQpV',  // Nyzo 3
            'id__86ydzPM~UNLR6qmbF~cNU2mVZo_YhwVSrc_x6JQJsszua_S7524c',  // Nyzo 4
            'id__8eBoMRRVvQQe40FV5m03CYMbzwDqpY5SWjPsjy7bKQyi07~ubwHD',  // Nyzo 5
            'id__8fx--L3AH-ow0sVuq_YKc9D_.~~MhE0g.jKCjQBYDGz72811JoPW',  // Nyzo 6
            'id__83pY4aq.~JDzI5Etvy_gfAt5qC-1mxSXE7zAq.NyRGjeRKZ72xT5',  // Nyzo 7
            'id__8dWMSD5CWsuSRFUCdC10_62~ya8nwyTzX_y7K0_H1ppYBEsF1teA',  // Nyzo 8
            'id__89aCy9_LLZby~UiUUjC0LKdyrf-djXyf6EKBV6_KNdICIpCfGqK3'   // Nyzo 9
        ];

        // Check decoding and encoding for all values.
        $successful = true;
        for ($i = 0; $i < count($rawIdentifiers) && $successful; $i++) {

            $rawIdentifier = $rawIdentifiers[$i];
            $nyzoString = $nyzoStrings[$i];

            // Check decoding against the expected raw identifier.
            $decodedIdentifier = NyzoStringEncoder::decode($nyzoString);
            if ($decodedIdentifier == null) {
                $successful = false;
                $this->failureCause = 'unable to decode Nyzo string (' . $nyzoString . ') in iteration ' . $i .
                    ' of NyzoStringTest::testPublicIdentifierStrings()';
            } else if ($decodedIdentifier->getIdentifier() != $rawIdentifier) {
                $successful = false;
                $this->failureCause = 'mismatch of expected raw identifier (' . $rawIdentifier .
                                    ') and decoded identifier (' . $decodedIdentifier->getIdentifier() .
                                    ') in iteration ' . $i . ' of NyzoStringTest::testPublicIdentifierStrings()';
            }

            // Check encoding against the expected encoded string.
            $encodedString = NyzoStringEncoder::encode(new NyzoStringPublicIdentifier($rawIdentifier));
            if ($nyzoString !== $encodedString) {
                $successful = false;
                $this->failureCause = 'mismatch of expected Nyzo string (' . $nyzoString .
                    ') and encoded Nyzo string (' . $encodedString . ') in iteration ' . $i .
                    ' of NyzoStringTest::testPublicIdentifierStrings()';
            }
        }

        echo NyzoTestUtil::passFail($successful, $this->failureCause) . PHP_EOL;

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