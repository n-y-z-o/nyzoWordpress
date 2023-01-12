<?php

enum NyzoStringType {
    case Micropay;
    case PrefilledData;
    case PrivateSeed;
    case PublicIdentifier;
    case Signature;
    case Transaction;
}