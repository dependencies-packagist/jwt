<?php

namespace Token\JWT\Validation\Constraint;

use Token\JWT\Contracts\Constraint;
use Token\JWT\Contracts\Token;
use Token\JWT\Exceptions\ConstraintViolationException;

final class PermittedFor implements Constraint
{
    private string $audience;

    public function __construct(string $audience)
    {
        $this->audience = $audience;
    }

    public function assert(Token $token): void
    {
        if (!$token->isPermittedFor($this->audience)) {
            throw new ConstraintViolationException(
                'The token is not allowed to be used by this audience'
            );
        }
    }
}
