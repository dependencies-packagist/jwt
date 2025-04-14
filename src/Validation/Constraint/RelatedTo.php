<?php

namespace Token\JWT\Validation\Constraint;

use Token\JWT\Contracts\Constraint;
use Token\JWT\Contracts\Token;
use Token\JWT\Exceptions\ConstraintViolationException;

final class RelatedTo implements Constraint
{
    private string $subject;

    public function __construct(string $subject)
    {
        $this->subject = $subject;
    }

    public function assert(Token $token): void
    {
        if (!$token->isRelatedTo($this->subject)) {
            throw new ConstraintViolationException(
                'The token is not related to the expected subject'
            );
        }
    }
}
