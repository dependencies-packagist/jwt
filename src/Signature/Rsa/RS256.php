<?php

namespace Token\JWT\Signature\Rsa;

use Token\JWT\Signature\Rsa;

final class RS256 extends Rsa
{
    public function algorithmId(): string
    {
        return 'RS256';
    }

    public function algorithm(): int
    {
        return OPENSSL_ALGO_SHA256;
    }
}
