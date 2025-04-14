<?php

namespace Token\JWT\Signature;

use Token\JWT\Contracts\Key;

abstract class Rsa extends OpenSSL
{
    final public function sign(string $payload, Key $key): string
    {
        return $this->createSignature($key->contents(), $key->passphrase(), $payload);
    }

    final public function verify(string $expected, string $payload, Key $key): bool
    {
        return $this->verifySignature($expected, $payload, $key->contents());
    }

    final public function keyType(): int
    {
        return OPENSSL_KEYTYPE_RSA;
    }
}
