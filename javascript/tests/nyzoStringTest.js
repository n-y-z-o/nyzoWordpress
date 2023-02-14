class NyzoStringTest {

    constructor() {
    }

    run() {
        let result = [];

        result.push(this.testEncoder());
        result.push(this.testPrivateSeedStrings());

        return result;
    }

    testEncoder() {
        // The encoding lookup table is 64 characters. 64 characters store 6 bits (2^6=64). This allows the encoder to
        // store 3 bytes (24 bits) in 4 characters. This test checks encoding and decoding up to double this packing
        // increment, from 1 to 6 bytes (1 to 8 characters).

        const byteArrays = [ '89', '712aab', '3a0536', 'bd53aa', '2e', '98', '9d65ed', '1bdd1542ca', '0b49ddab',
            '78fdccc42427', '994d0200', '0e0000', '40', 'e6093ad212', '19941b43', 'e5221d048a', 'b419',  '65bb880d55',
            '6a2b74e7f9', '595c', 'db851f52', '7193', 'a817', '82', '9f2e4dee75f2', 'de805a40e3e9', '2920d328b493',
            '5151', '1e1345be', '826b82f468dd' ];
        const strings = [ 'zg', 'tiHI', 'exkU', 'MmeH', 'bx', 'D0', 'EnoK', '6.SmgJF', '2SEuHN', 'vfVcP2gE', 'DkS200',
            '3x00', 'g0', 'XxBYSy8', '6qgsgN', 'Xi8u18F', 'K1B', 'qsL83mk', 'rzKSX_B', 'nmN', 'UWkwkx', 'tqc', 'H1t',
            'xx', 'EQXdZEoQ', 'VF1rgefG', 'ai3jabij', 'km4', '7yd5Mx', 'xDL2.6Au' ];

        // Check decoding and encoding for all values.
        let successful = true;
        let result = 'successful';
        for (let i = 0; i < byteArrays.length && successful; i++) {
            const byteArray = hexStringAsUint8Array(byteArrays[i]);
            const string = strings[i];

            // Check decoding against the expected byte array.
            const decodedByteArray = byteArrayForEncodedString(string);
            if (!arraysAreEqual(byteArray, decodedByteArray)) {
                successful = false;
                result = 'mismatch of expected byte array (' + uint8ArrayAsHexString(byteArray) +
                    ') and decoded byte array (' + uint8ArrayAsHexString(decodedByteArray) + ') in iteration ' + i +
                    ' of NyzoStringTest.testEncoder()';
            }

            // Check encoding against the expected encoded string.
            const encodedString = encodedStringForByteArray(byteArray);
            if (string != encodedString) {
                successful = false;
                result = 'mismatch of expected string (' + string + ') and encoded string (' + encodedString +
                    ') in iteration ' + i + ' of NyzoStringTest.testEncoder()';
            }
        }

        return { name: 'NyzoStringTest.testEncoder()', result: result, successful: successful }
    }

    testPrivateSeedStrings() {

        const rawSeeds = [
            '74d84ed425f51e6faa9bae140e95260129d16a73241231dc6962619b5fbc6e27',
            '083a351b43b5b283adab877df813bf180fffce2c72a4748282ad5f5eeac04bbf',
            'b8339a33324ab02497954384b6ea999357e8b5132369a96241f74915032b5673',
            'c571973ddbf47ed2c595706b8ac4f5574207fe88f823f007d60e33ec54d5bf28',
            '97dae745780f98795c2983ed27f8fae37b0efe324773734876cc30b53d09cff5',
            '372f5fc01964a907c2e22b54370232408c11069a790ec948dbadea54512132c1',
            'd43b855022d33bf9234ee3ffd5cf5e0b663dade78d54ccd9c182af72d4fb34ba',
            '3f98368bcb4918aeede55d4a14d98a79dd20eeff942acc686a29e40f443d4216',
            '6ef86c169f08e51f5417da92760b48cf2a855349332a261b1b5bdd92cd625ae3',
            'fc0c914efd39b5cbcf567a6f7584763967d6b71f2420a9f79d887681d3a46a4a',
            'a7f3f7629ad8843c99441d73fd1b17e1161c591bb5da5831bdc6f79f6ca9ad4f',
            'd1376eadfde5daa931e165b3f0bef4c19b81430c47486dc0ccca1c69e30680fa',
            '0163f2e202f10b8bdad1e53ea1992e1abd6e54c8d0e5a6771ff74edc379652d1',
            '5f1d019e58ecd6d41cb59bff5912ed3f293058b05a7d52ad9077646f9995a4c1',
            '3bde14ad035556d44187371ad693cb49ef2f041f82349660fb6d7689f29a2fdf'
        ];
        const nyzoStrings = [
            'key_87jpjKgC.hXMHGLL50Ym9x4GSnGR918PV6CzpqKwM6WEgqRzfABZ',
            'key_80xYdhK3Ksa3IrL7wwxjMPxf_-WJtHhSxFaKoTZHN4L_7md3ZIZw',
            'key_8bxRDAcQiI0BCXm3ybsHDqdoYbkj8UDGpB7Vihk3aTqRRc19vgou',
            'key_8cmPCRVs.7ZiPqmNrWI4.mu21_Y8~2fN1.pec~PkTs-F1z~UFs3n',
            'key_89wrXSmW3XyXo2D3ZiwW~LdZ3MWQhVdRi7sccbk.2t_TNZe8NV6-',
            'key_83tMo-0qqaB7NL8Im3t2cB2c4grrvgZ9idLKYChh8jb1aHbuTfIs',
            'key_8dgZym0zSRMX8SZA_.ofoxKDfrVEAmjcUt62IVbk~RiY51mPR6kc',
            'key_83~pdFMbihzLZvmuiyjqzEEu8eZ_C2Icr6FGX0.4fk8nD6NvR.nE',
            'key_86ZWs1rw2ekwm1wrBEpbic-Hymd9cQFD6PKsVqbdpCIAi3q3iLQw',
            'key_8fNcBkZ.esobRTqYsVn4uACETItw922G.XU8uF7jG6GaUQxNGNI1',
            'key_8awR.UarU8g-Dkgut_Ss5~4n75BsKuGpcsV6.X.JHrTfMA8TdX8F',
            'key_8d4VsHV.XuHGcv5CJ_2~.c6sxkcchSyKNcRa76EA1F3YDgsruj2K',
            'key_805A-L82-gLbUK7CfH6qbyH.sCj8SenDuP_VjKNVCCbh7Y763Hmm',
            'key_85-u0qXpZdsk7bns_TBiZj-Gc5zNnETiIq1Vq6~qCrj1y31e7JvM',
            'key_83Mv5aS3mmskgptV6KrjQSEMbNgwxAinpfKKuFEQDz_w5mc5yPI0'
        ];

        // Check decoding and encoding for all values.
        let successful = true;
        let result = 'successful';
        for (let i = 0; i < rawSeeds.length && successful; i++) {

            const rawSeed = hexStringAsUint8Array(rawSeeds[i]);
            const nyzoString = nyzoStrings[i];

            // Check decoding against the expected raw seed.
            const decodedKey = decode(nyzoString);
            if (decodedKey == null) {
                successful = false;
                result = 'unable to decode Nyzo string (' + nyzoString + ') in iteration ' + i +
                    ' of NyzoStringTest.testPrivateSeedStrings()';
            } else if (!arraysAreEqual(decodedKey.getSeed(), rawSeed)) {
                successful = false;
                result = 'mismatch of expected raw seed (' + rawSeed + ') and decoded seed (' + decodedKey.getSeed() +
                    ') in iteration ' + i + ' of NyzoStringTest.testPrivateSeedStrings()';
            }

            // Check encoding against the expected encoded string.
            const encodedString = nyzoStringFromPrivateKey(rawSeed);
            if (nyzoString != encodedString) {
                successful = false;
                result = 'mismatch of expected Nyzo string (' + nyzoString + ') and encoded Nyzo string (' +
                    encodedString + ') in iteration ' + i + ' of NyzoStringTest.testPrivateSeedStrings()';
            }
        }

        return { name: 'NyzoStringTest.testPrivateSeedStrings()', result: result, successful: successful }
    }
}