<?php

namespace Token\JWT\Signature;

use Token\JWT\Contracts\Key;
use Token\JWT\Contracts\Signer;

final class None implements Signer
{
    public function algorithmId(): string
    {
        return 'none';
    }

    public function sign(string $payload, Key $key): string
    {
        return '';
    }

    public function verify(string $expected, string $payload, Key $key): bool
    {
        return $expected === '';
    }
}
