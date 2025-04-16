# 签名算法

本库支持使用对称算法和非对称算法对令牌进行签名和验证。
**目前尚不支持加密功能。**
每种算法生成的签名长度不同。如果你对生成令牌的长度有要求，建议选择生成签名较短的算法（如 `HS256`、`RS256` 和 `ES256`）。

## 对称算法（Symmetric algorithms）

对称算法在签名创建和验证过程中使用的是同一把密钥/秘钥。
适用于签名和验证都由同一个组件处理的场景。

| 名称      | 描述                | 类名                                | 密钥长度要求        |
|---------|-------------------|-----------------------------------|---------------|
| `HS256` | 基于 SHA-256 的 HMAC | `\Token\JWT\Signature\Hmac\HS256` | `>= 256 bits` |
| `HS384` | 基于 SHA-384 的 HMAC | `\Token\JWT\Signature\Hmac\HS384` | `>= 384 bits` |
| `HS512` | 基于 SHA-512 的 HMAC | `\Token\JWT\Signature\Hmac\HS512` | `>= 512 bits` |

## 非对称算法（Asymmetric algorithms）

非对称算法使用 `私钥/密钥` 进行签名创建，使用 `公钥` 进行签名验证。
适用于由一个组件创建令牌，而多个组件进行验证的场景。

| 名称      | 描述                                  | 类名                                 | 密钥长度要求         |
|---------|-------------------------------------|------------------------------------|----------------|
| `ES256` | 使用 P-256 和 SHA-256 的 ECDSA 签名算法     | `\Token\JWT\Signature\Ecdsa\ES256` | `== 256 bits`  |
| `ES384` | 使用 P-256 和 SHA-256 的 ECDSA 签名算法     | `\Token\JWT\Signature\Ecdsa\ES384` | `== 384 bits`  |
| `ES512` | 使用 P-256 和 SHA-256 的 ECDSA 签名算法     | `\Token\JWT\Signature\Ecdsa\ES512` | `== 521 bits`  |
| `RS256` | 使用 SHA-256 的 RSASSA-PKCS1-v1_5 签名算法 | `\Token\JWT\Signature\Rsa\RS256`   | `>= 2048 bits` |
| `RS384` | 使用 SHA-256 的 RSASSA-PKCS1-v1_5 签名算法 | `\Token\JWT\Signature\Rsa\RS384`   | `>= 2048 bits` |
| `RS512` | 使用 SHA-256 的 RSASSA-PKCS1-v1_5 签名算法 | `\Token\JWT\Signature\Rsa\RS512`   | `>= 2048 bits` |

## 适用于未使用任何签名算法的情况（即 alg: none）

`none` 算法（如 [JWT 标准](https://www.iana.org/assignments/jose/jose.xhtml#web-signature-encryption-algorithms) 中所述）未实现也不被支持。
因为其被滥用的风险极高，即便存在其他机制确保令牌的有效性，在现代硬件环境下，使用对称算法也不应构成性能瓶颈。
