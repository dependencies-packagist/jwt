<?php

namespace Token\JWT\Contracts;

use DateTimeImmutable;
use Token\JWT\Exceptions\CannotEncodeContentException;
use Token\JWT\Exceptions\CannotSignPayloadException;
use Token\JWT\Exceptions\ConversionFailedException;
use Token\JWT\Exceptions\InvalidKeyProvidedException;
use Token\JWT\Exceptions\RegisteredClaimException;

interface Builder
{
    /**
     * Appends new items to audience
     *
     * @param string ...$audiences
     *
     * @return Builder
     */
    public function permittedFor(string ...$audiences): Builder;

    /**
     * Configures the expiration time
     *
     * @param DateTimeImmutable $expiration
     *
     * @return Builder
     */
    public function expiresAt(DateTimeImmutable $expiration): Builder;

    /**
     * Configures the token id
     *
     * @param string $id
     *
     * @return Builder
     */
    public function identifiedBy(string $id): Builder;

    /**
     * Configures the time that the token was issued
     *
     * @param DateTimeImmutable $issuedAt
     *
     * @return Builder
     */
    public function issuedAt(DateTimeImmutable $issuedAt): Builder;

    /**
     * Configures the issuer
     *
     * @param string $issuer
     *
     * @return Builder
     */
    public function issuedBy(string $issuer): Builder;

    /**
     * Configures the time before which the token cannot be accepted
     *
     * @param DateTimeImmutable $notBefore
     *
     * @return Builder
     */
    public function canOnlyBeUsedAfter(DateTimeImmutable $notBefore): Builder;

    /**
     * Configures the subject
     *
     * @param string $subject
     *
     * @return Builder
     */
    public function relatedTo(string $subject): Builder;

    /**
     * Configures a header item
     *
     * @param string $name
     * @param mixed  $value
     *
     * @return Builder
     */
    public function withHeader(string $name, mixed $value): Builder;

    /**
     * Configures a claim item
     *
     * @param string $name
     * @param mixed  $value
     *
     * @return Builder
     * @throws RegisteredClaimException When trying to set a registered claim.
     */
    public function withClaim(string $name, mixed $value): Builder;

    /**
     * Returns a signed token to be used
     *
     * @param Signer $signer
     * @param Key    $key
     *
     * @return Token
     * @throws CannotEncodeContentException When data cannot be converted to JSON.
     * @throws CannotSignPayloadException   When payload signing fails.
     * @throws InvalidKeyProvidedException  When issue key is invalid/incompatible.
     * @throws ConversionFailedException    When signature could not be converted.
     */
    public function getToken(Signer $signer, Key $key): Token;
}
