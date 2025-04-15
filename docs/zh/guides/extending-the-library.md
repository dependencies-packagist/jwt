# 扩展指南

我们在此库中设计了一些扩展点。
这些扩展点应该能够让用户根据需要轻松定制我们的核心组件。

## 令牌构建器

令牌构建器定义了一个用于创建普通令牌的流畅接口。
要创建您自己的令牌构建器，您必须实现 `Token\JWT\Contracts\Builder` 接口：

```php
use Token\JWT\Contracts\Builder;

final class MyCustomTokenBuilder implements Builder
{
    // implement all methods
}
```

然后，在 [配置](../usage/configuration.md) 中注册一个自定义工厂：

```php
use Token\JWT\Contracts\Builder;
use Token\JWT\Contracts\ClaimsFormatter;
use Token\JWT\Token;

$token->setBuilderFactory(
    static function (ClaimsFormatter $formatter): Builder {
        return new MyCustomTokenBuilder($formatter);
    }
);
```

## 格式处理器

默认情况下，JWT 声明格式处理器功能包括：

- 统一 aud（audience，受众）声明：当该声明中只有一个项时，确保它是一个字符串，而不是数组
- 使用微秒（浮点数）格式化日期类型的声明

你也可以自定义甚至创建你自己的格式化器。

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

$token->builder(new UnixTimestampDates());
```

`Token\JWT\Contracts\ChainedFormatter` 允许用户组合多个声明格式处理器。

## 令牌解析器

令牌解析器定义了应如何将 JWT 字符串转换为令牌对象。
要创建你自己的解析器，你必须实现 `Token\JWT\Parser` 接口。

```php
use Token\JWT\Contracts\Parser;

final class MyCustomTokenParser implements Parser
{
    // implement all methods
}
```

然后在 [配置](../usage/configuration.md) 中注册一个实例：

```php
use Token\JWT\Token;

$token->setParser(new MyCustomTokenParser());
```

## 签名器

签名器定义了如何生成和验证签名。
如果你想自定义签名器，则必须实现 `Token\JWT\Contracts\Signer` 接口。

```php
use Token\JWT\Contracts\Signer;

final class SignerForAVeryCustomizedAlgorithm implements Signer
{
    // implement all methods
}
```

然后在创建 [配置](../usage/configuration.md)、[发放令牌](../usage/issuing-tokens.md) 或 [解析令牌](../usage/validating-tokens.md) 实例时传递它的一个实例。

## 密钥对象

密钥对象会被传递给签名器，并提供生成和验证签名所需的信息。
如果你想自定义密钥对象，则必须实现 `Token\JWT\Contracts\Key` 接口。

```php
use Token\JWT\Contracts\Key;

final class KeyWithSomeMagicalProperties implements Key
{
    // implement all methods
}
```

## 令牌验证器

令牌验证器定义了如何应用验证约束，以对令牌进行验证或断言。
如果你想自定义验证器，则必须实现 `Token\JWT\Contracts\Validator` 接口。

```php
use Token\JWT\Contracts\Validator;

final class MyCustomTokenValidator implements Validator
{
    // implement all methods
}
```

然后在 [配置](../usage/configuration.md) 中注册一个实例：

```php
use Token\JWT\Token;

$token->setValidator(new MyCustomTokenValidator());
```

## 验证约束集合

验证约束定义了应如何验证一个或多个声明（claims）或头部（headers）。
自定义验证约束非常适合为注册声明提供高级验证规则，或用于验证私有声明。
如果你想自定义验证约束，则必须实现 `Token\JWT\Contracts\Constraint` 接口。

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

然后在 [验证令牌](../usage/validating-tokens.md) 时使用它。
