<?php

namespace Token\JWT\Signature\Hmac;

use Token\JWT\Signature\Hmac;

final class HS384 extends Hmac
{
    public function algorithmId(): string
    {
        return 'HS384';
    }

    public function algorithm(): string
    {
        return 'sha384';
    }
}
