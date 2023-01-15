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
}

for ($i = 0; $i < strlen(NyzoStringEncoder::characterLookup); $i++) {
    NyzoStringEncoder::$characterToValueMap[NyzoStringEncoder::characterLookup[$i]] = $i;
}

for ($i = 0; $i < 256; $i++) {
    NyzoStringEncoder::$byteValueToHexStringMap[$i] = $i < 16 ? '0' . dechex($i) : dechex($i);
}