<?php

namespace Token\JWT;

final class Signature implements Contracts\Signature
{
    private string $hash;
    private string $encoded;

    public function __construct(string $hash, string $encoded)
    {
        $this->hash    = $hash;
        $this->encoded = $encoded;
    }

    public static function fromEmptyData(): self
    {
        return new self('', '');
    }

    public function hash(): string
    {
        return $this->hash;
    }

    public function toString(): string
    {
        return $this->encoded;
    }
}
