<?php

namespace Token\JWT\Contracts;

use Token\JWT\Exceptions\NoConstraintsException;
use Token\JWT\Exceptions\RequiredConstraintsViolated;

interface Validator
{
    /**
     * @param Token      $token
     * @param Constraint ...$constraints
     *
     * @return void
     * @throws RequiredConstraintsViolated
     * @throws NoConstraintsException
     */
    public function assert(Token $token, Constraint ...$constraints): void;

    /**
     * @param Token      $token
     * @param Constraint ...$constraints
     *
     * @return bool
     * @throws NoConstraintsException
     */
    public function validate(Token $token, Constraint ...$constraints): bool;
}
