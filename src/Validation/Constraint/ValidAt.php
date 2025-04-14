<?php

namespace Token\JWT\Validation\Constraint;

use DateInterval;
use DateTimeInterface;

use Token\JWT\Contracts\Constraint;
use Token\JWT\Contracts\Token;
use Token\JWT\Exceptions\ConstraintViolationException;
use Token\JWT\Exceptions\LeewayCannotBeNegative;

final class ValidAt implements Constraint
{
    private Clock        $clock;
    private DateInterval $leeway;

    public function __construct(Clock $clock, ?DateInterval $leeway = null)
    {
        $this->clock  = $clock;
        $this->leeway = $this->guardLeeway($leeway);
    }

    /**
     * @param DateInterval|null $leeway
     *
     * @return DateInterval
     * @throws LeewayCannotBeNegative
     */
    private function guardLeeway(?DateInterval $leeway): DateInterval
    {
        if ($leeway === null) {
            return new DateInterval('PT0S');
        }

        if ($leeway->invert === 1) {
            throw LeewayCannotBeNegative::create();
        }

        return $leeway;
    }

    /**
     * @param Token $token
     *
     * @return void
     * @throws ConstraintViolationException
     */
    public function assert(Token $token): void
    {
        $now = $this->clock->now();

        $this->assertIssueTime($token, $now->add($this->leeway));
        $this->assertMinimumTime($token, $now->add($this->leeway));
        $this->assertExpiration($token, $now->sub($this->leeway));
    }

    /**
     * @param Token             $token
     * @param DateTimeInterface $now
     *
     * @return void
     * @throws ConstraintViolationException
     */
    private function assertExpiration(Token $token, DateTimeInterface $now): void
    {
        if ($token->isExpired($now)) {
            throw new ConstraintViolationException('The token is expired');
        }
    }

    /**
     * @param Token             $token
     * @param DateTimeInterface $now
     *
     * @return void
     * @throws ConstraintViolationException
     */
    private function assertMinimumTime(Token $token, DateTimeInterface $now): void
    {
        if (!$token->isMinimumTimeBefore($now)) {
            throw new ConstraintViolationException('The token cannot be used yet');
        }
    }

    /**
     * @param Token             $token
     * @param DateTimeInterface $now
     *
     * @return void
     * @throws ConstraintViolationException
     */
    private function assertIssueTime(Token $token, DateTimeInterface $now): void
    {
        if (!$token->hasBeenIssuedBefore($now)) {
            throw new ConstraintViolationException('The token was issued in the future');
        }
    }
}
