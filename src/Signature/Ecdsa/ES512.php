<?php

namespace Token\JWT\Signature\Ecdsa;

use Token\JWT\Signature\Ecdsa;

final class ES512 extends Ecdsa
{
    public function algorithmId(): string
    {
        return 'ES512';
    }

    public function algorithm(): int
    {
        return OPENSSL_ALGO_SHA512;
    }

    public function keyLength(): int
    {
        return 132;
    }
}
