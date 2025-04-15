# Extending the library

We've designed a few extension points in this library.
These should enable people to easily customise our core components if they want to.

## Builder

The token builder defines a fluent interface for plain token creation.

To create your own builder of it you must implement the `Token\JWT\Contracts\Builder` interface:

```php
use Token\JWT\Contracts\Builder;

final class MyCustomTokenBuilder implements Builder
{
    // implement all methods
}
```

Then, register a custom factory in the [Configuration](../usage/configuration.md):

```php
use Token\JWT\Contracts\Builder;
use Token\JWT\Contracts\ClaimsFormatter;
use Token\JWT\Token;

$factory->setBuilderFactory(
    static function (ClaimsFormatter $formatter): Builder {
        return new MyCustomTokenBuilder($formatter);
    }
);
```

## Claims formatter

By default, we provide formatters that:

- unify the audience claim, making sure we use strings when there's only one item in that claim
- format date based claims using microseconds (float)

You may customise and even create your own formatters:

```php
use Token\JWT\Contracts\ClaimsFormatter;
use Token\JWT\Contracts\RegisteredClaims;
use Token\JWT\Token;

final class UnixTimestampDates implements ClaimsFormatter
{
    public function formatClaims(array $claims): array
    {
        foreach (RegisteredClaims::DATE_CLAIMS as $claim) {
            if (! array_key_exists($claim, $claims)) {
                continue;
            }

            assert($claims[$claim] instanceof DateTimeImmutable);
            $claims[$claim] = $claims[$claim]->getTimestamp();
        }

        return $claims;
    }
}

$factory->builder(new UnixTimestampDates());
```

The class `Token\JWT\Contracts\ChainedFormatter` allows for users to combine multiple formatters.

## Parser

The token parser defines how a JWT string should be converted into token objects.

To create your own parser of it you must implement the `Token\JWT\Parser` interface:

```php
use Token\JWT\Contracts\Parser;

final class MyCustomTokenParser implements Parser
{
    // implement all methods
}
```

Then register an instance in the [Configuration](../usage/configuration.md):

```php
use Token\JWT\Token;

$factory->setParser(new MyCustomTokenParser());
```

## Signer

The signer defines how to create and verify signatures.

To create your own signer of it you must implement the `Token\JWT\Contracts\Signer` interface:

```php
use Token\JWT\Contracts\Signer;

final class SignerForAVeryCustomizedAlgorithm implements Signer
{
    // implement all methods
}
```

Then pass an instance of it while creating an instance of the [Configuration](../usage/configuration.md), [Issuing tokens](../usage/issuing-tokens.md), or [Validating tokens](../usage/validating-tokens.md).

## Key

The key object is passed down to signers and provide the necessary information to create and verify signatures.

To create your own signer of it you must implement the `Token\JWT\Contracts\Key` interface:

```php
use Token\JWT\Contracts\Key;

final class KeyWithSomeMagicalProperties implements Key
{
    // implement all methods
}
```

## Validator

The token validator defines how to apply validation constraint to either validate or assert tokens.

To create your own validator of it you must implement the `Token\JWT\Contracts\Validator` interface:

```php
use Token\JWT\Contracts\Validator;

final class MyCustomTokenValidator implements Validator
{
    // implement all methods
}
```

Then register an instance in the [Configuration](../usage/configuration.md):

```php
use Token\JWT\Token;

$factory->setValidator(new MyCustomTokenValidator());
```

## Validation constraints

A validation constraint define how one or more claims/headers should be validated.
Custom validation constraints are handy to provide advanced rules for the registered claims or to validate private claims.

To create your own implementation of constraint you must implement the `Token\JWT\Contracts\Constraint` interface:

```php
use Token\JWT\Contracts\Token;
use Token\JWT\Contracts\Constraint;
use Token\JWT\Exceptions\ConstraintViolationException;

final class SubjectMustBeAValidUser implements Constraint
{
    public function assert(Token $token): void
    {
        if (! $this->existsInDatabase($token->claims()->get('sub'))) {
            throw new ConstraintViolationException('Token related to an unknown user');
        }
    }

    private function existsInDatabase(string $userId): bool
    {
        // ...
    }
}
```

Then use it while [Validating tokens](../usage/validating-tokens.md).
