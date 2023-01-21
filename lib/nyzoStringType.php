<?php

if (!defined('__NYZO_EXTENSION_ROOT__')) { define('__NYZO_EXTENSION_ROOT__', dirname(dirname(__FILE__))); }
require_once(__NYZO_EXTENSION_ROOT__ . '/lib/nyzoStringEncoder.php');

enum NyzoStringType: string {
    case Micropay = 'pay_';
    case PrefilledData = 'pre_';
    case PrivateSeed = 'key_';
    case PublicIdentifier = 'id__';
    case Signature = 'sig_';
    case Transaction = 'tx__';

    public function getPrefix() {
        return $this->value;
    }

    public function getPrefixBytes() {
        return NyzoStringEncoder::byteArrayForEncodedString($this->value);
    }

    public static function forPrefix(string $prefix): NyzoStringType {

        $result = null;
        foreach (self::cases() as $type) {
            if ($type->getPrefix() === $prefix) {
                $result = $type;
            }
        }

        return $result;
    }
}