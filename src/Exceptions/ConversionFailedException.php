<?php

namespace Token\JWT\Exceptions;

use InvalidArgumentException;
use Token\JWT\Contracts\JSONWebTokenException;

final class ConversionFailedException extends InvalidArgumentException implements JSONWebTokenException
{
    public static function invalidLength(): self
    {
        return new self('Invalid signature length.');
    }

    public static function incorrectStartSequence(): self
    {
        return new self('Invalid data. Should start with a sequence.');
    }

    public static function integerExpected(): self
    {
        return new self('Invalid data. Should contain an integer.');
    }
}
