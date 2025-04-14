<?php

namespace Token\JWT\Exceptions;

use InvalidArgumentException;
use Token\JWT\Contracts\JSONWebTokenException;

class RegisteredClaimException extends InvalidArgumentException implements JSONWebTokenException
{
    public static function forClaim(string $name): self
    {
        return new self(sprintf(
            'Builder#withClaim() is meant to be used for non-registered claims, check the documentation on how to set claim "%s"',
            $name
        ));
    }
}
