<?php

namespace Token\JWT;

use DateTimeImmutable;

use Token\JWT\Contracts\ClaimsFormatter;
use Token\JWT\Contracts\Encoder;
use Token\JWT\Contracts\Key;
use Token\JWT\Contracts\RegisteredClaims;
use Token\JWT\Contracts\Signer;
use Token\JWT\Exceptions\CannotEncodeContentException;
use Token\JWT\Exceptions\RegisteredClaimException;

final class Builder implements Contracts\Builder
{
    private array $headers = ['typ' => 'JWT', 'alg' => null];

    private array $claims = [];

    private Encoder         $encoder;
    private ClaimsFormatter $claimFormatter;

    public function __construct(Encoder $encoder, ClaimsFormatter $claimFormatter)
    {
        $this->encoder        = $encoder;
        $this->claimFormatter = $claimFormatter;
    }

    /**
     * @inheritdoc
     */
    public function permittedFor(string ...$audiences): Contracts\Builder
    {
        $configured = $this->claims[RegisteredClaims::AUDIENCE] ?? [];
        $toAppend   = array_diff($audiences, $configured);

        return $this->setClaim(RegisteredClaims::AUDIENCE, array_merge($configured, $toAppend));
    }

    /**
     * @inheritdoc
     */
    public function expiresAt(DateTimeImmutable $expiration): Contracts\Builder
    {
        return $this->setClaim(RegisteredClaims::EXPIRATION_TIME, $expiration);
    }

    /**
     * @inheritdoc
     */
    public function identifiedBy(string $id): Contracts\Builder
    {
        return $this->setClaim(RegisteredClaims::ID, $id);
    }

    /**
     * @inheritdoc
     */
    public function issuedAt(DateTimeImmutable $issuedAt): Contracts\Builder
    {
        return $this->setClaim(RegisteredClaims::ISSUED_AT, $issuedAt);
    }

    /**
     * @inheritdoc
     */
    public function issuedBy(string $issuer): Contracts\Builder
    {
        return $this->setClaim(RegisteredClaims::ISSUER, $issuer);
    }

    /**
     * @inheritdoc
     */
    public function canOnlyBeUsedAfter(DateTimeImmutable $notBefore): Contracts\Builder
    {
        return $this->setClaim(RegisteredClaims::NOT_BEFORE, $notBefore);
    }

    /**
     * @inheritdoc
     */
    public function relatedTo(string $subject): Contracts\Builder
    {
        return $this->setClaim(RegisteredClaims::SUBJECT, $subject);
    }

    /**
     * @inheritdoc
     */
    public function withHeader(string $name, mixed $value): Contracts\Builder
    {
        $this->headers[$name] = $value;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function withClaim(string $name, mixed $value): Contracts\Builder
    {
        if (in_array($name, RegisteredClaims::ALL, true)) {
            throw RegisteredClaimException::forClaim($name);
        }

        return $this->setClaim($name, $value);
    }

    /**
     * @param string $name
     * @param mixed  $value
     *
     * @return Contracts\Builder
     */
    private function setClaim(string $name, mixed $value): Contracts\Builder
    {
        $this->claims[$name] = $value;

        return $this;
    }

    /**
     * @param array $items
     *
     * @return string
     * @throws CannotEncodeContentException When data cannot be converted to JSON.
     */
    private function encode(array $items): string
    {
        return $this->encoder->base64UrlEncode(
            $this->encoder->jsonEncode($items)
        );
    }

    /**
     * @inheritdoc
     */
    public function getToken(Signer $signer, Key $key): Contracts\Token
    {
        $headers        = $this->headers;
        $headers['alg'] = $signer->algorithmId();

        $encodedHeaders = $this->encode($headers);
        $encodedClaims  = $this->encode($this->claimFormatter->formatClaims($this->claims));

        $signature        = $signer->sign($encodedHeaders . '.' . $encodedClaims, $key);
        $encodedSignature = $this->encoder->base64UrlEncode($signature);

        return new Token(
            new DataSet($headers, $encodedHeaders),
            new DataSet($this->claims, $encodedClaims),
            new Signature($signature, $encodedSignature)
        );
    }
}
