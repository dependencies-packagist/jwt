<?php

namespace Token\JWT\Signature;

use Token\JWT\Contracts\Key;
use Token\JWT\Contracts\Signer;

abstract class Hmac implements Signer
{
    final public function sign(string $payload, Key $key): string
    {
        return hash_hmac($this->algorithm(), $payload, $key->contents(), true);
    }

    final public function verify(string $expected, string $payload, Key $key): bool
    {
        return hash_equals($expected, $this->sign($payload, $key));
    }

    abstract public function algorithm(): string;
}
