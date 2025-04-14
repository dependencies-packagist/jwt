<?php

namespace Token\JWT\Exceptions;

use InvalidArgumentException;
use Token\JWT\Contracts\JSONWebTokenException;

final class UnsupportedHeaderFound extends InvalidArgumentException implements JSONWebTokenException
{
    public static function encryption(): self
    {
        return new self('Encryption is not supported yet');
    }
}
