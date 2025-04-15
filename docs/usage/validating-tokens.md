# Validating tokens

To validate a token you must create a new validator (easier when using the [Configuration](../usage/configuration.md)) and assert or validate a token.

## Using `Validator#assert()`

> Warning
> You **MUST** provide at least one constraint, otherwise `\Token\JWT\Exceptions\NoConstraintsException` exception will be thrown.

This method goes through every single constraint in the set, groups all the violations, and throws an exception with the grouped violations:

```php
use Token\JWT\Exceptions\RequiredConstraintsViolated;
use Token\JWT\Key;
use Token\JWT\Signature\None;
use Token\JWT\Token;
use Token\JWT\Validation\Constraint\IdentifiedBy;
use Token\JWT\Validation\Constraint\SignedWith;

$token = Token::forSymmetricSigner(
    new None(),
    Key::empty()
);

//$jwt = $token->builder()
//    ->identifiedBy(10000)
//    ->getToken($token->signer(), $token->signingKey())
//    ->toString();

$plainToken = $token->parser()->parse($jwt);

$token->setValidationConstraints(
    new SignedWith($token->signer(), $token->signingKey()),
    new IdentifiedBy(10001)
);

$constraints = $token->validationConstraints();

try {
    $token->validator()->assert($plainToken, ...$constraints);
} catch (RequiredConstraintsViolated $e) {
    // list of constraints violation exceptions:
    var_dump($e->violations());
}

var_dump($plainToken->toString());
```

## Using `Validator#validate()`

> Warning
> You **MUST** provide at least one constraint, otherwise `\Token\JWT\Exceptions\NoConstraintsException` exception will be thrown.

The difference here is that we'll always a get a `boolean` result and stop in the very first violation:

```php
use Token\JWT\Key;
use Token\JWT\Signature\Hmac\HS256;
use Token\JWT\Token;
use Token\JWT\Validation\Constraint\IdentifiedBy;
use Token\JWT\Validation\Constraint\SignedWith;

$algorithm  = new HS256();
$signingKey = Key::plainText(random_bytes(32));

$token = Token::forSymmetricSigner(
    $algorithm,
    $signingKey
);

$jwt = $token->builder()
    ->identifiedBy(10000)
    ->getToken($token->signer(), $token->signingKey())
    ->toString();

$plainToken = $token->parser()->parse($jwt);

$token->setValidationConstraints(
    new SignedWith($token->signer(), $token->signingKey()),
    new IdentifiedBy(10000)
);

$constraints = $token->validationConstraints();

if (!$token->validator()->validate($plainToken, ...$constraints)) {
    throw new RuntimeException('No way!');
}

var_dump($plainToken->toString());
```

## Available constraints

This library provides the following constraints:

* `Token\JWT\Validation\Constraint\IdentifiedBy`: verifies if the claim `jti` matches the expected value
* `Token\JWT\Validation\Constraint\IssuedBy`: verifies if the claim `iss` is listed as expected values
* `Token\JWT\Validation\Constraint\PermittedFor`: verifies if the claim `aud` contains the expected value
* `Token\JWT\Validation\Constraint\RelatedTo`: verifies if the claim `sub` matches the expected value
* `Token\JWT\Validation\Constraint\SignedWith`: verifies if the token was signed with the expected signer and key
* `Token\JWT\Validation\Constraint\ValidAt`: verifies the claims `iat`, `nbf`, and `exp` (supports leeway configuration)

You may also create your [Validation constraints](../guides/extending-the-library.md#validation-constraints).
