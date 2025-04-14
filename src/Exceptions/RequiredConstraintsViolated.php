<?php

namespace Token\JWT\Exceptions;

use RuntimeException;
use Token\JWT\Contracts\JSONWebTokenException;

final class RequiredConstraintsViolated extends RuntimeException implements JSONWebTokenException
{
    /**
     * @var ConstraintViolationException[]
     */
    private array $violations = [];

    public static function fromViolations(ConstraintViolationException ...$violations): self
    {
        $exception             = new self(self::buildMessage($violations));
        $exception->violations = $violations;

        return $exception;
    }

    /**
     * @param ConstraintViolationException[] $violations
     *
     * @return string
     */
    private static function buildMessage(array $violations): string
    {
        $violations = array_map(
            static function (ConstraintViolationException $violation): string {
                return '- ' . $violation->getMessage();
            },
            $violations
        );

        $message = "The token violates some mandatory constraints, details:\n";
        $message .= implode("\n", $violations);

        return $message;
    }

    /**
     * @return ConstraintViolationException[]
     */
    public function violations(): array
    {
        return $this->violations;
    }
}
