<?php

namespace Token\JWT\Signature\Ecdsa;

use Token\JWT\Signature\Ecdsa;

final class ES384 extends Ecdsa
{
    public function algorithmId(): string
    {
        return 'ES384';
    }

    public function algorithm(): int
    {
        return OPENSSL_ALGO_SHA384;
    }

    public function keyLength(): int
    {
        return 96;
    }
}
