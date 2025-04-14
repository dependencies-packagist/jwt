<?php

namespace Token\JWT\Encoding;

use Token\JWT\Contracts\ClaimsFormatter;

final class ChainedFormatter implements ClaimsFormatter
{
    /**
     * @var ClaimsFormatter[]
     */
    private array $formatters;

    public function __construct(ClaimsFormatter ...$formatters)
    {
        $this->formatters = $formatters;
    }

    public static function default(): self
    {
        return new self(new UnifyAudience(), new MicrosecondBasedDateConversion());
    }

    /**
     * @inheritdoc
     */
    public function formatClaims(array $claims): array
    {
        foreach ($this->formatters as $formatter) {
            $claims = $formatter->formatClaims($claims);
        }

        return $claims;
    }
}
