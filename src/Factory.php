<?php

namespace Token\JWT;

use Closure;
use Token\JWT\Contracts\Builder as BuilderContract;
use Token\JWT\Contracts\ClaimsFormatter;
use Token\JWT\Contracts\Constraint;
use Token\JWT\Contracts\Decoder;
use Token\JWT\Contracts\Encoder;
use Token\JWT\Contracts\Key as KeyContract;
use Token\JWT\Contracts\Parser as ParserContract;
use Token\JWT\Contracts\Signer;
use Token\JWT\Contracts\Validator as ValidatorContract;
use Token\JWT\Encoding\ChainedFormatter;
use Token\JWT\Encoding\JoseEncoder;
use Token\JWT\Signature\None;
use Token\JWT\Validation\Validator;

final class Factory
{
    private ParserContract    $parser;
    private Signer            $signer;
    private KeyContract       $signingKey;
    private KeyContract       $verificationKey;
    private ValidatorContract $validator;

    /**
     * @var Closure(ClaimsFormatter $claimFormatter): BuilderContract
     */
    private Closure $builderFactory;

    /**
     * @var Constraint[]
     */
    private array $validationConstraints = [];

    private function __construct(
        Signer   $signer,
        Key      $signingKey,
        Key      $verificationKey,
        ?Encoder $encoder = null,
        ?Decoder $decoder = null
    )
    {
        $this->signer          = $signer;
        $this->signingKey      = $signingKey;
        $this->verificationKey = $verificationKey;
        $this->parser          = new Parser($decoder ?? new JoseEncoder());
        $this->validator       = new Validator();

        $this->builderFactory = static function (ClaimsFormatter $claimFormatter) use ($encoder): BuilderContract {
            return new Builder($encoder ?? new JoseEncoder(), $claimFormatter);
        };
    }

    /**
     * @param Signer       $signer
     * @param Key          $signingKey
     * @param Key          $verificationKey
     * @param Encoder|null $encoder
     * @param Decoder|null $decoder
     *
     * @return self
     */
    public static function forAsymmetricSigner(
        Signer   $signer,
        Key      $signingKey,
        Key      $verificationKey,
        ?Encoder $encoder = null,
        ?Decoder $decoder = null
    ): self
    {
        return new self(
            $signer,
            $signingKey,
            $verificationKey,
            $encoder,
            $decoder
        );
    }

    /**
     * @param Signer       $signer
     * @param Key          $key
     * @param Encoder|null $encoder
     * @param Decoder|null $decoder
     *
     * @return self
     */
    public static function forSymmetricSigner(
        Signer   $signer,
        Key      $key,
        ?Encoder $encoder = null,
        ?Decoder $decoder = null
    ): self
    {
        return new self(
            $signer,
            $key,
            $key,
            $encoder,
            $decoder
        );
    }

    /**
     * @param Encoder|null $encoder
     * @param Decoder|null $decoder
     *
     * @return self
     */
    public static function forUnsecuredSigner(
        ?Encoder $encoder = null,
        ?Decoder $decoder = null
    ): self
    {
        $key = Key::empty();

        return new self(
            new None(),
            $key,
            $key,
            $encoder,
            $decoder
        );
    }

    /**
     * @param callable(ClaimsFormatter): BuilderContract $builderFactory
     *
     * @return void
     */
    public function setBuilderFactory(callable $builderFactory): void
    {
        $this->builderFactory = Closure::fromCallable($builderFactory);
    }

    /**
     * @param ClaimsFormatter|null $claimFormatter
     *
     * @return BuilderContract
     */
    public function builder(?ClaimsFormatter $claimFormatter = null): BuilderContract
    {
        return ($this->builderFactory)($claimFormatter ?? ChainedFormatter::default());
    }

    /**
     * @return ParserContract
     */
    public function parser(): ParserContract
    {
        return $this->parser;
    }

    /**
     * @param ParserContract $parser
     *
     * @return void
     */
    public function setParser(ParserContract $parser): void
    {
        $this->parser = $parser;
    }

    /**
     * @return Signer
     */
    public function signer(): Signer
    {
        return $this->signer;
    }

    /**
     * @return KeyContract
     */
    public function signingKey(): KeyContract
    {
        return $this->signingKey;
    }

    /**
     * @return KeyContract
     */
    public function verificationKey(): KeyContract
    {
        return $this->verificationKey;
    }

    public function validator(): ValidatorContract
    {
        return $this->validator;
    }

    /**
     * @param ValidatorContract $validator
     *
     * @return void
     */
    public function setValidator(ValidatorContract $validator): void
    {
        $this->validator = $validator;
    }

    /**
     * @return Constraint[]
     */
    public function validationConstraints(): array
    {
        return $this->validationConstraints;
    }

    /**
     * @param Constraint[] $validationConstraints
     *
     * @return void
     */
    public function setValidationConstraints(Constraint ...$validationConstraints): void
    {
        $this->validationConstraints = $validationConstraints;
    }
}
