<?php

namespace Token\JWT\Contracts;

use Token\JWT\Exceptions\CannotDecodeContentException;

interface Decoder
{
    /**
     * Decodes from JSON, validating the errors
     *
     * @param string $json
     *
     * @return mixed
     *
     * @throws CannotDecodeContentException When something goes wrong while decoding.
     */
    public function jsonDecode(string $json): mixed;

    /**
     * Decodes from Base64URL
     *
     * @link http://tools.ietf.org/html/rfc4648#section-5
     *
     * @param string $data
     *
     * @return string
     *
     * @throws CannotDecodeContentException When something goes wrong while decoding.
     */
    public function base64UrlDecode(string $data): string;
}
