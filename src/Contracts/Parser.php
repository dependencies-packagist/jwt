<?php

namespace Token\JWT\Contracts;

use Token\JWT\Exceptions\CannotDecodeContentException;
use Token\JWT\Exceptions\InvalidTokenStructure;
use Token\JWT\Exceptions\UnsupportedHeaderFound;

interface Parser
{
    /**
     * Parses the JWT and returns a token
     *
     * @param string $jwt
     *
     * @return Token
     * @throws CannotDecodeContentException      When something goes wrong while decoding.
     * @throws InvalidTokenStructure    When token string structure is invalid.
     * @throws UnsupportedHeaderFound   When parsed token has an unsupported header.
     */
    public function parse(string $jwt): Token;
}
