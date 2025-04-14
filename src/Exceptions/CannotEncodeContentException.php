<?php

namespace Token\JWT\Exceptions;

use JsonException;
use RuntimeException;
use Token\JWT\Contracts\JSONWebTokenException;

class CannotEncodeContentException extends RuntimeException implements JSONWebTokenException
{
    public static function jsonIssues(JsonException $previous): self
    {
        return new self('Error while encoding to JSON', 0, $previous);
    }
}
