<?php

namespace Token\JWT\Validation\Constraint;

use Token\JWT\Contracts\Constraint;
use Token\JWT\Contracts\Token;
use Token\JWT\Exceptions\ConstraintViolationException;

final class IdentifiedBy implements Constraint
{
    private string $id;

    public function __construct(string $id)
    {
        $this->id = $id;
    }

    public function assert(Token $token): void
    {
        if (!$token->isIdentifiedBy($this->id)) {
            throw new ConstraintViolationException(
                'The token is not identified with the expected ID'
            );
        }
    }
}
