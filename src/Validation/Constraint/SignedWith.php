<?php

namespace Token\JWT\Validation\Constraint;

use Token\JWT\Contracts\Constraint;
use Token\JWT\Contracts\Key;
use Token\JWT\Contracts\Signer;
use Token\JWT\Contracts\Token;
use Token\JWT\Exceptions\ConstraintViolationException;

final class SignedWith implements Constraint
{
    private Signer $signer;
    private Key    $key;

    public function __construct(Signer $signer, Key $key)
    {
        $this->signer = $signer;
        $this->key    = $key;
    }

    public function assert(Token $token): void
    {
        if ($token->headers()->get('alg') !== $this->signer->algorithmId()) {
            throw new ConstraintViolationException('Token signer mismatch');
        }

        if (!$this->signer->verify($token->signature()->hash(), $token->payload(), $this->key)) {
            throw new ConstraintViolationException('Token signature mismatch');
        }
    }
}
