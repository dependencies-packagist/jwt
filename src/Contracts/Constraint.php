<?php

namespace Token\JWT\Contracts;

use Token\JWT\Exceptions\ConstraintViolationException;

interface Constraint
{
    /**
     * @param Token $token
     *
     * @return void
     * @throws ConstraintViolationException
     */
    public function assert(Token $token): void;
}
