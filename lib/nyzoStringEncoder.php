<?php

class NyzoStringEncoder {
    const characterLookup = '0123456789' .
        'abcdefghijkmnopqrstuvwxyz' .  // all except lowercase "L"
        'ABCDEFGHIJKLMNPQRSTUVWXYZ' .  // all except uppercase "o"
        '-.~_';                        // see https://tools.ietf.org/html/rfc3986#section-2.3

    static $characterToValueMap;

    const headerLength = 4;
}

for ($i = 0; $i < strlen(NyzoStringEncoder::characterLookup); $i++) {
    NyzoStringEncoder::$characterToValueMap[NyzoStringEncoder::characterLookup[$i]] = $i;
}

function byteArrayForEncodedString(string $encodedString): string {

        //int arrayLength = (encodedString.length() * 6 + 7) / 8;
        //byte[] array = new byte[arrayLength];
        //for (int i = 0; i < arrayLength; i++) {

        //    char leftCharacter = encodedString.charAt(i * 8 / 6);
        //    char rightCharacter = encodedString.charAt(i * 8 / 6 + 1);

        //    int leftValue = characterToValueMap.getOrDefault(leftCharacter, 0);
        //    int rightValue = characterToValueMap.getOrDefault(rightCharacter, 0);
        //    int bitOffset = (i * 2) % 6;
        //    array[i] = (byte) ((((leftValue << 6) + rightValue) >> 4 - bitOffset) & 0xff);
        //}

    return 'hello'; //    return array;
}