<?php

if (!defined('__ROOT__')) { define('__ROOT__', dirname(dirname(__FILE__))); }
require_once(__ROOT__ . '/lib/nyzoHashUtil.php');

class NyzoStringEncoder {
    const characterLookup = '0123456789' .
        'abcdefghijkmnopqrstuvwxyz' .  // all except lowercase "L"
        'ABCDEFGHIJKLMNPQRSTUVWXYZ' .  // all except uppercase "o"
        '-.~_';                        // see https://tools.ietf.org/html/rfc3986#section-2.3

    static $characterToValueMap;
    static $byteValueToHexStringMap;

    const headerLength = 4;

    static function encode(NyzoString $stringObject): string {

        // Get the prefix array from the type and the content array from the content object.
        $prefixBytes = $stringObject->getType()->getPrefixBytes();
        $contentBytes = $stringObject->getBytes();

        // Determine the length of the expanded array with the header and the checksum. The header is the type-specific
        // prefix in characters followed by a single byte that indicates the length of the content array (four bytes
        // total). The checksum is a minimum of 4 bytes and a maximum of 6 bytes, widening the expanded array so that
        // its length is divisible by 3.
        $contentLength = strlen($contentBytes) / 2;
        $checksumLength = 4 + (3 - ($contentLength + 2) % 3) % 3;

        // Create the array and add the header and the content. The first three bytes turn into the user-readable
        // prefix in the encoded string. The next byte specifies the length of the content array, and it is immediately
        // followed by the content array.
        $expandedArray = $prefixBytes . self::$byteValueToHexStringMap[$contentLength] . $contentBytes;

        // Compute the checksum and add the appropriate number of bytes to the end of the array.
        $checksum = NyzoHashUtil::doubleSHA256($expandedArray);
        $expandedArray .= substr($checksum, 0, $checksumLength * 2);

        // Build and return the encoded string from the expanded array.
        return self::encodedStringForByteArray($expandedArray);
    }

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