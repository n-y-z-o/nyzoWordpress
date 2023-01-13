<?php

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
}