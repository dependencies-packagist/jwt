# Supported Algorithms

This library supports signing and verifying tokens with both symmetric and asymmetric algorithms.
Encryption is not yet supported.

Each algorithm will produce signature with different length.
If you have constraints regarding the length of the issued tokens, choose the algorithms that generate shorter output (`HS256`, `RS256`, and `ES256`).

## Symmetric algorithms

Symmetric algorithms perform signature creation and verification using the very same key/secret.
They're usually recommended for scenarios where these operations are handled by the very same component.

| Name    | Description        | Class                             | Key length req. |
|---------|--------------------|-----------------------------------|-----------------|
| `HS256` | HMAC using SHA-256 | `\Token\JWT\Signature\Hmac\HS256` | `>= 256 bits`   |
| `HS384` | HMAC using SHA-384 | `\Token\JWT\Signature\Hmac\HS384` | `>= 384 bits`   |
| `HS512` | HMAC using SHA-512 | `\Token\JWT\Signature\Hmac\HS512` | `>= 512 bits`   |

## Asymmetric algorithms

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

## `none` algorithm

The `none` algorithm as described by [JWT standard](https://www.iana.org/assignments/jose/jose.xhtml#web-signature-encryption-algorithms) is intentionally not implemented and not supported.
The risk of misusing it is too high, and even where other means guarantee the token validity a symmetric algorithm
shouldn't represent a computational bottleneck with modern hardware.
