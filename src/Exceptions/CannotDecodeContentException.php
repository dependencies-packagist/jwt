<?php

namespace Token\JWT\Exceptions;

use JsonException;
use RuntimeException;
use Token\JWT\Contracts\JSONWebTokenException;

class CannotDecodeContentException extends RuntimeException implements JSONWebTokenException
{
    public static function jsonIssues(JsonException $previous): self
    {
        return new self('Error while decoding from JSON', 0, $previous);
    }

    public static function invalidBase64String(): self
    {
        return new self('Error while decoding from Base64Url, invalid base64 characters detected');
    }
}
