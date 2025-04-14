<?php

namespace Token\JWT\Signature\Hmac;

use Token\JWT\Signature\Hmac;

final class HS256 extends Hmac
{
    public function algorithmId(): string
    {
        return 'HS256';
    }

    public function algorithm(): string
    {
        return 'sha256';
    }
}
