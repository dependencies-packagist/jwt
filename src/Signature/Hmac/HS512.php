<?php

namespace Token\JWT\Signature\Hmac;

use Token\JWT\Signature\Hmac;

final class HS512 extends Hmac
{
    public function algorithmId(): string
    {
        return 'HS512';
    }

    public function algorithm(): string
    {
        return 'sha512';
    }
}
