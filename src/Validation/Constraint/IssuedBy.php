<?php

namespace Token\JWT\Validation\Constraint;

use Token\JWT\Contracts\Constraint;
use Token\JWT\Contracts\Token;
use Token\JWT\Exceptions\ConstraintViolationException;

final class IssuedBy implements Constraint
{
    private array $issuers;

    public function __construct(string ...$issuers)
    {
        $this->issuers = $issuers;
    }

    public function assert(Token $token): void
    {
        if (!$token->hasBeenIssuedBy(...$this->issuers)) {
            throw new ConstraintViolationException(
                'The token was not issued by the given issuers'
            );
        }
    }
}
