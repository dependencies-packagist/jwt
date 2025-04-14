<?php

namespace Token\JWT\Signature\Rsa;

use Token\JWT\Signature\Rsa;

final class RS512 extends Rsa
{
    public function algorithmId(): string
    {
        return 'RS512';
    }

    public function algorithm(): int
    {
        return OPENSSL_ALGO_SHA512;
    }
}
