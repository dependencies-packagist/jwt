<?php

namespace Token\JWT\Contracts;

use DateTimeInterface;

interface Token
{
    /**
     * Returns the token headers
     */
    public function headers(): DataSet;

    public function claims(): DataSet;

    public function signature(): Signature;

    /**
     * Returns the token payload
     */
    public function payload(): string;

    /**
     * Returns if the token is allowed to be used by the audience
     */
    public function isPermittedFor(string $audience): bool;

    /**
     * Returns if the token has the given id
     */
    public function isIdentifiedBy(string $id): bool;

    /**
     * Returns if the token has the given subject
     */
    public function isRelatedTo(string $subject): bool;

    /**
     * Returns if the token was issued by any of given issuers
     */
    public function hasBeenIssuedBy(string ...$issuers): bool;

    /**
     * Returns if the token was issued before of given time
     */
    public function hasBeenIssuedBefore(DateTimeInterface $now): bool;

    /**
     * Returns if the token minimum time is before than given time
     */
    public function isMinimumTimeBefore(DateTimeInterface $now): bool;

    /**
     * Returns if the token is expired
     */
    public function isExpired(DateTimeInterface $now): bool;

    /**
     * Returns an encoded representation of the token
     */
    public function toString(): string;
}
