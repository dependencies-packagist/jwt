<?php

namespace Token\JWT\Signature\Ecdsa;

use Token\JWT\Signature\Ecdsa;

final class ES256 extends Ecdsa
{
    public function algorithmId(): string
    {
        return 'ES256';
    }

    public function algorithm(): int
    {
        return OPENSSL_ALGO_SHA256;
    }

    public function keyLength(): int
    {
        return 64;
    }
}
