<?php

namespace Token\JWT\Contracts;

use Token\JWT\Exceptions\CannotSignPayloadException;
use Token\JWT\Exceptions\ConversionFailedException;
use Token\JWT\Exceptions\InvalidKeyProvidedException;

interface Signer
{
    /**
     * Returns the algorithm id
     */
    public function algorithmId(): string;

    /**
     * Creates a hash for the given payload
     *
     * @throws CannotSignPayloadException  When payload signing fails.
     * @throws InvalidKeyProvidedException When issue key is invalid/incompatible.
     * @throws ConversionFailedException   When signature could not be converted.
     */
    public function sign(string $payload, Key $key): string;

    /**
     * Returns if the expected hash matches with the data and key
     *
     * @throws InvalidKeyProvidedException When issue key is invalid/incompatible.
     * @throws ConversionFailedException   When signature could not be converted.
     */
    public function verify(string $expected, string $payload, Key $key): bool;
}
