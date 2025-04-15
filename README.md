# JSON Web Token and JSON Web Signature

A simple library to work with JSON Web Token and JSON Web Signature based on the [RFC 7519](https://tools.ietf.org/html/rfc7519).

[![GitHub Tag](https://img.shields.io/github/v/tag/dependencies-packagist/jwt)](https://github.com/dependencies-packagist/jwt/tags)
[![Total Downloads](https://img.shields.io/packagist/dt/token/jwt?style=flat-square)](https://packagist.org/packages/token/jwt)
[![Packagist Version](https://img.shields.io/packagist/v/token/jwt)](https://packagist.org/packages/token/jwt)
[![Packagist PHP Version Support](https://img.shields.io/packagist/php-v/token/jwt)](https://github.com/dependencies-packagist/jwt)
[![Packagist License](https://img.shields.io/github/license/dependencies-packagist/jwt)](https://github.com/dependencies-packagist/jwt)

## Installation

You can install the package via [Composer](https://getcomposer.org/):

```bash
composer require token/jwt
```

## Supported Algorithms

This library supports signing and verifying tokens with both symmetric and asymmetric algorithms.
Encryption is not yet supported.

Each algorithm will produce signature with different length.
If you have constraints regarding the length of the issued tokens, choose the algorithms that generate shorter output (`HS256`, `RS256`, and `ES256`).

### Symmetric algorithms

Symmetric algorithms perform signature creation and verification using the very same key/secret.
They're usually recommended for scenarios where these operations are handled by the very same component.

| Name    | Description        | Class                             | Key length req. |
|---------|--------------------|-----------------------------------|-----------------|
| `HS256` | HMAC using SHA-256 | `\Token\JWT\Signature\Hmac\HS256` | `>= 256 bits`   |
| `HS384` | HMAC using SHA-384 | `\Token\JWT\Signature\Hmac\HS384` | `>= 384 bits`   |
| `HS512` | HMAC using SHA-512 | `\Token\JWT\Signature\Hmac\HS512` | `>= 512 bits`   |

### Asymmetric algorithms

Asymmetric algorithms perform signature creation with private/secret keys and verification with public keys.
They're usually recommended for scenarios where creation is handled by a component and verification by many others.

| Name    | Description                     | Class                              | Key length req. |
|---------|---------------------------------|------------------------------------|-----------------|
| `ES256` | ECDSA using P-256 and SHA-256   | `\Token\JWT\Signature\Ecdsa\ES256` | `== 256 bits`   |
| `ES384` | ECDSA using P-384 and SHA-384   | `\Token\JWT\Signature\Ecdsa\ES384` | `== 384 bits`   |
| `ES512` | ECDSA using P-521 and SHA-512   | `\Token\JWT\Signature\Ecdsa\ES512` | `== 521 bits`   |
| `RS256` | RSASSA-PKCS1-v1_5 using SHA-256 | `\Token\JWT\Signature\Rsa\RS256`   | `>= 2048 bits`  |
| `RS384` | RSASSA-PKCS1-v1_5 using SHA-384 | `\Token\JWT\Signature\Rsa\RS384`   | `>= 2048 bits`  |
| `RS512` | RSASSA-PKCS1-v1_5 using SHA-512 | `\Token\JWT\Signature\Rsa\RS512`   | `>= 2048 bits`  |
| `EdDSA` | EdDSA signature algorithms      | `\Token\JWT\Signature\Eddsa`       | `>= 256 bits`   |

### `none` algorithm

The `none` algorithm as described by [JWT standard](https://www.iana.org/assignments/jose/jose.xhtml#web-signature-encryption-algorithms) is intentionally not implemented and not supported.
The risk of misusing it is too high, and even where other means guarantee the token validity a symmetric algorithm
shouldn't represent a computational bottleneck with modern hardware.

## Usage

### Issuing tokens

```php
use Token\JWT\Builder;
use Token\JWT\Encoding\ChainedFormatter;
use Token\JWT\Encoding\JoseEncoder;
use Token\JWT\Signature\Hmac\HS256;
use Token\JWT\Key;

$algorithm  = new HS256();
$signingKey = Key::plainText(random_bytes(32));

$now     = new DateTimeImmutable();
$builder = new Builder(new JoseEncoder(), ChainedFormatter::default());
$token   = $builder
    // Configures the issuer (iss claim)
    ->issuedBy('http://example.com')
    // Configures the audience (aud claim)
    ->permittedFor('http://example.org')
    // Configures the id (jti claim)
    ->identifiedBy('4f1g23a12aa')
    // Configures the time that the token was issue (iat claim)
    ->issuedAt($now)
    // Configures the time that the token can be used (nbf claim)
    ->canOnlyBeUsedAfter($now->modify('+1 minute'))
    // Configures the expiration time of the token (exp claim)
    ->expiresAt($now->modify('+1 hour'))
    // Configures a new claim, called "uid"
    ->withClaim('uid', 1)
    // Configures a new header, called "foo"
    ->withHeader('foo', 'bar')
    // Builds a new token
    ->getToken($algorithm, $signingKey);

var_dump($token->toString());
```

### Parsing tokens

To parse a token you must create a new parser and ask it to parse a string:

```php
use Token\JWT\Parser;
use Token\JWT\Encoding\JoseEncoder;

$parser = new Parser(new JoseEncoder());

$token = $parser->parse(
    'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.'
    . 'eyJzdWIiOiIxMjM0NTY3ODkwIn0.'
    . '2gSBz9EOsQRN9I-3iSxJoFt7NtgV6Rm0IL6a8CAwl3Q'
);

var_dump($token->headers()); // Retrieves the token headers
var_dump($token->claims()); // Retrieves the token claims
```

### Validating tokens

This method goes through every single constraint in the set, groups all the violations, and throws an exception with the grouped violations:

```php
use Token\JWT\Encoding\JoseEncoder;
use Token\JWT\Exceptions\RequiredConstraintsViolated;
use Token\JWT\Parser;
use Token\JWT\Validation\Constraint\RelatedTo;
use Token\JWT\Validation\Validator;

$parser = new Parser(new JoseEncoder());

$token = $parser->parse(
    'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.'
    . 'eyJzdWIiOiIxMjM0NTY3ODkwIn0.'
    . '2gSBz9EOsQRN9I-3iSxJoFt7NtgV6Rm0IL6a8CAwl3Q'
);

$validator = new Validator();

try {
    // $validator->assert($token, new RelatedTo('1234567891'));// throw an exception
    $validator->assert($token, new RelatedTo('1234567890'));
} catch (RequiredConstraintsViolated $e) {
    // list of constraints violation exceptions:
    var_dump($e->violations());
}

var_dump($token->toString());
```

## License

Nacosvel Contracts is made available under the MIT License (MIT). Please see [License File](LICENSE) for more information.
