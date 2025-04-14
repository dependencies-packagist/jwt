<?php

namespace Token\JWT\Encoding;

use DateTimeImmutable;
use Token\JWT\Contracts\ClaimsFormatter;
use Token\JWT\Contracts\RegisteredClaims;

final class MicrosecondBasedDateConversion implements ClaimsFormatter
{
    /**
     * @inheritdoc
     */
    public function formatClaims(array $claims): array
    {
        foreach (RegisteredClaims::DATE_CLAIMS as $claim) {
            if (!array_key_exists($claim, $claims)) {
                continue;
            }

            $claims[$claim] = $this->convertDate($claims[$claim]);
        }

        return $claims;
    }

    private function convertDate(DateTimeImmutable $date): float|int
    {
        if ($date->format('u') === '000000') {
            return (int)$date->format('U');
        }

        return (float)$date->format('U.u');
    }
}
