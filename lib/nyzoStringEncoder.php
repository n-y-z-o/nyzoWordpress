<?php

class NyzoStringEncoder {
    const characterLookup = '0123456789' .
        'abcdefghijkmnopqrstuvwxyz' .  // all except lowercase "L"
        'ABCDEFGHIJKLMNPQRSTUVWXYZ' .  // all except uppercase "o"
        '-.~_';                        // see https://tools.ietf.org/html/rfc3986#section-2.3

    static $characterToValueMap;
    static $byteValueToHexStringMap;

    const headerLength = 4;

    static function byteArrayForEncodedString(string $encodedString): string {

        $arrayLength = floor(strlen($encodedString) * 6 / 8);
        $array = '';
        for ($i = 0; $i < $arrayLength; $i++) {

            $leftCharacter = $encodedString[intval($i * 8 / 6)];
            $rightCharacter = $encodedString[intval($i * 8 / 6) + 1];

            $leftValue = NyzoStringEncoder::$characterToValueMap[$leftCharacter];
            $rightValue = NyzoStringEncoder::$characterToValueMap[$rightCharacter];
            $bitOffset = ($i * 2) % 6;
            $array .= NyzoStringEncoder::$byteValueToHexStringMap[(((($leftValue << 6) + $rightValue) >> 4 - $bitOffset)
                & 0xff)];
        }

        return $array;
    }

    static function encodedStringForByteArray(string $array): string {

            $index = 0;
            $bitOffset = 0;
            $encodedString = '';
            $arrayLength = strlen($array);
            while ($index < $arrayLength) {

                // Get the current and next byte.
                $leftByte = hexdec($array[$index] . $array[$index + 1]);
                $rightByte = 0;
                if ($index < $arrayLength - 2) {
                    $rightByte = hexdec($array[$index + 2] . $array[$index + 3]);
                }

                // Append the character for the next 6 bits in the array.
                $lookupIndex = ((($leftByte << 8) + $rightByte) >> (10 - $bitOffset)) & 0x3f;
                $encodedString .= NyzoStringEncoder::characterLookup[$lookupIndex];

                // Advance forward 6 bits.
                if ($bitOffset == 0) {
                    $bitOffset = 6;
                } else {
                    $index += 2;
                    $bitOffset -= 2;
                }
            }

            return $encodedString;
        }
}

for ($i = 0; $i < strlen(NyzoStringEncoder::characterLookup); $i++) {
    NyzoStringEncoder::$characterToValueMap[NyzoStringEncoder::characterLookup[$i]] = $i;
}

for ($i = 0; $i < 256; $i++) {
    NyzoStringEncoder::$byteValueToHexStringMap[$i] = $i < 16 ? '0' . dechex($i) : dechex($i);
}