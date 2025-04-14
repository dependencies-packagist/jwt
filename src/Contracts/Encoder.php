<?php

namespace Token\JWT\Contracts;

use Token\JWT\Exceptions\CannotEncodeContentException;

interface Encoder
{
    /**
     * Encodes to JSON, validating the errors
     *
     * @param mixed $data
     *
     * @throws CannotEncodeContentException When something goes wrong while encoding.
     */
    public function jsonEncode(mixed $data): string;

    /**
     * Encodes to base64url
     *
     * @link http://tools.ietf.org/html/rfc4648#section-5
     *
     * @param string $data
     *
     * @return string
     */
    public function base64UrlEncode(string $data): string;
}
