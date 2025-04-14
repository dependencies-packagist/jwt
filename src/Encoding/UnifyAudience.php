<?php

namespace Token\JWT\Encoding;

use Token\JWT\Contracts\ClaimsFormatter;
use Token\JWT\Contracts\RegisteredClaims;

class UnifyAudience implements ClaimsFormatter
{
    /**
     * @inheritdoc
     */
    public function formatClaims(array $claims): array
    {
        if (!array_key_exists(RegisteredClaims::AUDIENCE, $claims)
            || count($claims[RegisteredClaims::AUDIENCE]) !== 1) {
            return $claims;
        }

        $claims[RegisteredClaims::AUDIENCE] = current($claims[RegisteredClaims::AUDIENCE]);

        return $claims;
    }
}
