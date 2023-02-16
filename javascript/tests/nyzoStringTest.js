class NyzoStringTest {

    constructor() {
    }

    run() {
        let result = [];

        result.push(this.testEncoder());
        result.push(this.testPrivateSeedStrings());
        result.push(this.testPublicIdentifierStrings());

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
            if (string != encodedString && successful) {
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
            if (nyzoString != encodedString && successful) {
                successful = false;
                result = 'mismatch of expected Nyzo string (' + nyzoString + ') and encoded Nyzo string (' +
                    encodedString + ') in iteration ' + i + ' of NyzoStringTest.testPrivateSeedStrings()';
            }
        }

        return { name: 'NyzoStringTest.testPrivateSeedStrings()', result: result, successful: successful }
    }

    testPublicIdentifierStrings() {

        const rawIdentifiers = [
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
        const nyzoStrings = [
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
        let successful = true;
        let result = 'successful';
        for (let i = 0; i < rawIdentifiers.length && successful; i++) {

            const rawIdentifier = hexStringAsUint8Array(rawIdentifiers[i]);
            const nyzoString = nyzoStrings[i];

            // Check decoding against the expected raw identifier.
            const decodedIdentifier = decode(nyzoString);
            if (decodedIdentifier == null) {
                successful = false;
                result = 'unable to decode Nyzo string (' + nyzoString + ') in iteration ' + i +
                    ' of NyzoStringTest.testPublicIdentifierStrings()';
            } else if (!arraysAreEqual(decodedIdentifier.getIdentifier(), rawIdentifier)) {
                successful = false;
                result = 'mismatch of expected raw identifier (' + uint8ArrayAsHexString(rawIdentifier) +
                    ') and decoded identifier (' + uint8ArrayAsHexString(decodedIdentifier.getIdentifier()) +
                    ') in iteration ' + i + ' of NyzoStringTest.testPublicIdentifierStrings()';
            }

            // Check encoding against the expected encoded string.
            const encodedString = nyzoStringFromPublicIdentifier(rawIdentifier);
            if (nyzoString != encodedString && successful) {
                successful = false;
                result = 'mismatch of expected Nyzo string (' + nyzoString + ') and encoded Nyzo string (' +
                    encodedString + ') in iteration ' + i + ' of NyzoStringTest.testPublicIdentifierStrings()';
            }
        }

        return { name: 'NyzoStringTest.testPublicIdentifierStrings()', result: result, successful: successful }
    }
}