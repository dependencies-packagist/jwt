<?php

namespace Token\JWT\Exceptions;

use InvalidArgumentException;
use Token\JWT\Contracts\JSONWebTokenException;

final class LeewayCannotBeNegative extends InvalidArgumentException implements JSONWebTokenException
{
    public static function create(): self
    {
        return new self('Leeway cannot be negative');
    }
}
