<?php

namespace Token\JWT;

use DateTimeImmutable;
use Token\JWT\Contracts\Decoder;
use Token\JWT\Contracts\RegisteredClaims;
use Token\JWT\Contracts\Token;
use Token\JWT\Exceptions\InvalidTokenStructure;
use Token\JWT\Exceptions\UnsupportedHeaderFound;

final class Parser implements Contracts\Parser
{
    private const MICROSECOND_PRECISION = 6;

    private Decoder $decoder;

    public function __construct(Decoder $decoder)
    {
        $this->decoder = $decoder;
    }

    /**
     * @inheritdoc
     */
    public function parse(string $jwt): Token
    {
        [$encodedHeaders, $encodedClaims, $encodedSignature] = $this->splitJwt($jwt);

        $header = $this->parseHeader($encodedHeaders);

        return new Plain(
            new DataSet($header, $encodedHeaders),
            new DataSet($this->parseClaims($encodedClaims), $encodedClaims),
            $this->parseSignature($header, $encodedSignature)
        );
    }

    /**
     * Splits the JWT string into an array
     *
     * @param string $jwt
     *
     * @return string[]
     * @throws InvalidTokenStructure When JWT doesn't have all parts.
     */
    private function splitJwt(string $jwt): array
    {
        $data = explode('.', $jwt);

        if (count($data) !== 3) {
            throw InvalidTokenStructure::missingOrNotEnoughSeparators();
        }

        return $data;
    }

    /**
     * Parses the header from a string
     *
     * @param string $data
     *
     * @return array
     * @throws UnsupportedHeaderFound When an invalid header is informed.
     * @throws InvalidTokenStructure  When parsed content isn't an array.
     */
    private function parseHeader(string $data): array
    {
        $header = $this->decoder->jsonDecode($this->decoder->base64UrlDecode($data));

        if (!is_array($header)) {
            throw InvalidTokenStructure::arrayExpected('headers');
        }

        if (array_key_exists('enc', $header)) {
            throw UnsupportedHeaderFound::encryption();
        }

        if (!array_key_exists('typ', $header)) {
            $header['typ'] = 'JWT';
        }

        return $header;
    }

    /**
     * Parses the claim set from a string
     *
     * @param string $data
     *
     * @return array
     * @throws InvalidTokenStructure When parsed content isn't an array or contains non-parseable dates.
     */
    private function parseClaims(string $data): array
    {
        $claims = $this->decoder->jsonDecode($this->decoder->base64UrlDecode($data));

        if (!is_array($claims)) {
            throw InvalidTokenStructure::arrayExpected('claims');
        }

        if (array_key_exists(RegisteredClaims::AUDIENCE, $claims)) {
            $claims[RegisteredClaims::AUDIENCE] = (array)$claims[RegisteredClaims::AUDIENCE];
        }

        foreach (RegisteredClaims::DATE_CLAIMS as $claim) {
            if (!array_key_exists($claim, $claims)) {
                continue;
            }

            $claims[$claim] = $this->convertDate($claims[$claim]);
        }

        return $claims;
    }

    /**
     * @param int|float|string $timestamp
     *
     * @return DateTimeImmutable
     */
    private function convertDate(int|float|string $timestamp): DateTimeImmutable
    {
        if (!is_numeric($timestamp)) {
            throw InvalidTokenStructure::dateIsNotParseable($timestamp);
        }

        $normalizedTimestamp = number_format((float)$timestamp, self::MICROSECOND_PRECISION, '.', '');

        $date = DateTimeImmutable::createFromFormat('U.u', $normalizedTimestamp);

        if ($date === false) {
            throw InvalidTokenStructure::dateIsNotParseable($normalizedTimestamp);
        }

        return $date;
    }

    /**
     * Returns the signature from given data
     *
     * @param array  $header
     * @param string $data
     *
     * @return Signature
     */
    private function parseSignature(array $header, string $data): Signature
    {
        if ($data === '' || !array_key_exists('alg', $header) || $header['alg'] === 'none') {
            return Signature::fromEmptyData();
        }

        $hash = $this->decoder->base64UrlDecode($data);

        return new Signature($hash, $data);
    }
}
