<?php

namespace Token\JWT\Validation;

use Token\JWT\Contracts\Constraint;
use Token\JWT\Contracts\Token;
use Token\JWT\Contracts\Validator as ValidatorContract;
use Token\JWT\Exceptions\ConstraintViolationException;
use Token\JWT\Exceptions\NoConstraintsException;
use Token\JWT\Exceptions\RequiredConstraintsViolated;

final class Validator implements ValidatorContract
{
    public function assert(Token $token, Constraint ...$constraints): void
    {
        if ($constraints === []) {
            throw new NoConstraintsException('No constraint given.');
        }

        $violations = [];

        foreach ($constraints as $constraint) {
            $this->checkConstraint($constraint, $token, $violations);
        }

        if ($violations) {
            throw RequiredConstraintsViolated::fromViolations(...$violations);
        }
    }

    /**
     * @param Constraint                     $constraint
     * @param Token                          $token
     * @param ConstraintViolationException[] $violations
     *
     * @return void
     */
    private function checkConstraint(Constraint $constraint, Token $token, array &$violations): void
    {
        try {
            $constraint->assert($token);
        } catch (ConstraintViolationException $e) {
            $violations[] = $e;
        }
    }

    /**
     * @param Token      $token
     * @param Constraint ...$constraints
     *
     * @return bool
     */
    public function validate(Token $token, Constraint ...$constraints): bool
    {
        if ($constraints === []) {
            throw new NoConstraintsException('No constraint given.');
        }

        try {
            foreach ($constraints as $constraint) {
                $constraint->assert($token);
            }

            return true;
        } catch (ConstraintViolationException $e) {
            return false;
        }
    }
}
