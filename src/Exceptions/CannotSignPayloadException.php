<?php

namespace Token\JWT\Exceptions;

use InvalidArgumentException;
use Token\JWT\Contracts\JSONWebTokenException;

final class CannotSignPayloadException extends InvalidArgumentException implements JSONWebTokenException
{
    public static function errorHappened(string $error): self
    {
        return new self('There was an error while creating the signature: ' . $error);
    }
}
