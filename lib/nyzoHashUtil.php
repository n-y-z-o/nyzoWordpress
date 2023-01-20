<?php

class NyzoHashUtil {
    static function doubleSHA256(string $data): string {
        return hash('sha256', hash('sha256', hex2bin($data), true));
    }
}