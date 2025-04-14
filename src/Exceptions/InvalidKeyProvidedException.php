<?php

namespace Token\JWT\Exceptions;

use InvalidArgumentException;
use Token\JWT\Contracts\JSONWebTokenException;

final class InvalidKeyProvidedException extends InvalidArgumentException implements JSONWebTokenException
{
    public static function cannotBeParsed(string $details): self
    {
        return new self('It was not possible to parse your key, reason: ' . $details);
    }

    public static function incompatibleKey(): self
    {
        return new self('This key is not compatible with this signer');
    }
}
