<?php

namespace Token\JWT\Signature\Rsa;

use Token\JWT\Signature\Rsa;

final class RS384 extends Rsa
{
    public function algorithmId(): string
    {
        return 'RS384';
    }

    public function algorithm(): int
    {
        return OPENSSL_ALGO_SHA384;
    }
}
