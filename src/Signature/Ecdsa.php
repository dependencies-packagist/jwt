<?php

namespace Token\JWT\Signature;

use Token\JWT\Contracts\Key;
use Token\JWT\Signature\Ecdsa\MultibyteStringConverter;
use Token\JWT\Signature\Ecdsa\SignatureConverter;

abstract class Ecdsa extends OpenSSL
{
    private SignatureConverter $converter;

    public function __construct(SignatureConverter $converter)
    {
        $this->converter = $converter;
    }

    public static function create(): Ecdsa
    {
        return new static(new MultibyteStringConverter());
    }

    final public function sign(string $payload, Key $key): string
    {
        return $this->converter->fromAsn1(
            $this->createSignature($key->contents(), $key->passphrase(), $payload),
            $this->keyLength()
        );
    }

    final public function verify(string $expected, string $payload, Key $key): bool
    {
        return $this->verifySignature(
            $this->converter->toAsn1($expected, $this->keyLength()),
            $payload,
            $key->contents()
        );
    }

    final public function keyType(): int
    {
        return OPENSSL_KEYTYPE_EC;
    }

    /**
     * Returns the length of each point in the signature, so that we can calculate and verify R and S points properly
     *
     * @internal
     */
    abstract public function keyLength(): int;
}
