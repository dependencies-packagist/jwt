<?php

namespace Token\JWT\Exceptions;

use InvalidArgumentException;
use Throwable;
use Token\JWT\Contracts\JSONWebTokenException;

final class FileCouldNotBeReadException extends InvalidArgumentException implements JSONWebTokenException
{
    public static function onPath(string $path, ?Throwable $cause = null): self
    {
        return new self(
            'The path "' . $path . '" does not contain a valid key file',
            0,
            $cause
        );
    }
}
