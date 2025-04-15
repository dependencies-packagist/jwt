# 验证令牌

要验证一个令牌，你必须创建一个新的验证器（使用 [配置对象](../usage/configuration.md) 时更为方便），然后对该令牌进行断言或验证。

## 使用 `Validator#assert()`

> 警告
> 你必须 **至少** 提供一个验证约束，否则将抛出 `\Token\JWT\Exceptions\NoConstraintsException` 异常。

该方法会遍历验证集合中的每一个约束，收集所有违反的项，并抛出一个包含所有验证错误的异常：

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

## 使用 `Validator#validate()`

> 警告
> 你必须 **至少** 提供一个验证约束，否则将抛出 `\Token\JWT\Exceptions\NoConstraintsException` 异常。

不同之处在于我们将始终获得一个 **布尔值** 结果，并在遇到第一个违反约束时立即停止：

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

## 可用的验证约束

此库提供以下验证约束：

* `Token\JWT\Validation\Constraint\IdentifiedBy`: 验证 `jti`（JWT ID）声明是否与期望值匹配
* `Token\JWT\Validation\Constraint\IssuedBy`: 验证 `iss`（签发者）声明是否在期望值列表中
* `Token\JWT\Validation\Constraint\PermittedFor`: 验证 `aud`（接收方）声明是否包含期望值
* `Token\JWT\Validation\Constraint\RelatedTo`: 验证 `sub`（主题）声明是否与期望值匹配
* `Token\JWT\Validation\Constraint\SignedWith`: 验证令牌是否使用预期的签名器和密钥进行签名
* `Token\JWT\Validation\Constraint\ValidAt`: 验证 `iat`（签发时间）、`nbf`（生效时间）和 `exp`（过期时间）声明（支持时间偏移配置）

你也可以[自定义验证约束](../guides/extending-the-library.md#验证约束集合)。
