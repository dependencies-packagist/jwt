# 配置

为了简化该库的配置，我们提供了 `Token\JWT\Factory` 类。 该类主要用于以下用途：

* 配置默认的签名算法（Signer）和密钥
* 配置默认的验证约束集合
* 提供自定义实现以扩展库的功能（参考：[扩展指南](../guides/extending-the-library.md)）
* 获取各个组件（编码器、解码器、解析器、验证器 和 构建器）

要使用它，你需要：

1. 初始化配置对象
1. 自定义配置对象
1. 获取所需组件

### 初始化配置对象

`Token\JWT\Contracts\Signer` 是用于处理对称加密（如 HMAC）或非对称加密（如 RSA、ECDSA）签名的密钥对象。
你可以通过将密钥内容（如密钥字符串或私钥文件内容）以纯文本形式传入来完成初始化。

```php
use Token\JWT\Key;

$key = Key::plainText('my-key-as-plaintext');
```

请提供一个使用 Base64 编码的字符串，作为密钥或令牌的一部分：

```php
use Token\JWT\Key;

$key = Key::base64Encoded('YSB2ZXJ5IGxvbmcgYSB2ZXJ5IHVsdHJhIHNlY3VyZSBrZXkgZm9yIG15IGFtYXppbmcgdG9rZW5z');
```

或提供一个文件路径：

```php
use Token\JWT\Key;

$key = Key::file(__DIR__ . '/path-to-my-key-stored-in-a-file.pem'); // this reads the file and keeps its contents in memory
```

#### 对称加密

对称算法在生成签名和验证签名时使用相同的密钥。
因此，**确保密钥保持机密性** 是极其重要的安全要求。

> 提示
> 建议你使用一个具有 **高熵值** 的密钥，最好通过 **加密安全的伪随机数生成器（CSPRNG）** 生成。
> 你可以使用工具 [CryptoKey](https://github.com/AndrewCarterUK/CryptoKey) 来帮助你生成这样的密钥。

```php
use Token\JWT\Factory;
use Token\JWT\Signature\Hmac\HS256;
use Token\JWT\Key;

$factory = Factory::forSymmetricSigner(
    // You may use any HMAC variations (256, 384, and 512)
    new HS256(),
    // replace the value below with a key of your own!
    Key::base64Encoded('mBC5v1sOKVvbdEitdSBenu59nfNfhwkedkJVNabosTw=')
    // You may also override the JOSE encoder/decoder if needed by providing extra arguments here
);
```

#### 非对称加密

非对称算法通过 **私钥** 生成签名，并通过 **公钥** 进行验证。
因此，**公钥** 可公开分发，而 **私钥** 必须保持机密，以保障安全性。

```php
use Token\JWT\Factory;
use Token\JWT\Signature\Rsa\RS256;
use Token\JWT\Key;

$factory = Factory::forAsymmetricSigner(
    // You may use RSA or ECDSA and all their variations (256, 384, and 512)
    new RS256(),
    Key::file(__DIR__ . '/my-private-key.pem'),
    Key::base64Encoded('mBC5v1sOKVvbdEitdSBenu59nfNfhwkedkJVNabosTw=')
    // You may also override the JOSE encoder/decoder if needed by providing extra arguments here
);
```

> 重要提示
> ECDSA 算法的实现具有构造函数依赖项。
> 为避免手动处理这些依赖，建议使用 `create()` 命名构造方法，例如：`Token\JWT\Signature\Ecdsa\ES256::create()`。

#### 适用于未使用任何签名算法的情况（即 `alg: none`）

> 警告
> 这种配置类型 **不建议** 在生产环境中使用。
> 它仅提供给用户以便在测试时可以更简便、快速地设置，避免任何形式的签名创建/验证。

```php
use Token\JWT\Factory;

$factory = Factory::forUnsecuredSigner(
    // 如有需要你也可以通过提供额外的参数来重写 JOSE 编码器/解码器
);
```

### 自定义配置对象

通过使用 `Token\JWT\Factory` 的设置方法，你可以自定义此库的配置。

> 重要提示
> 如果你希望使用自定义配置，请确保在调用任何获取方法之前先调用设置方法。
> 否则，将使用默认的实现。

以下是可用的设置方法：

* `Token\JWT\Factory#setBuilderFactory()`: 配置如何创建令牌构建器
* `Token\JWT\Factory#setParser()`: 配置自定义的令牌解析器
* `Token\JWT\Factory#setValidator()`: 配置自定义的验证器
* `Token\JWT\Factory#setValidationConstraints()`: 配置默认的验证约束集合

### 获取所需组件

一旦完成了所有必要的配置，你可以将配置对象传递到代码中，并使用获取方法来检索各个组件：

以下是可用的获取方法：

* `Token\JWT\Factory#builder()`: 检索令牌构建器（每次都会创建一个新的实例）
* `Token\JWT\Factory#parser()`: 检索令牌解析器
* `Token\JWT\Factory#signer()`: 检索签名器
* `Token\JWT\Factory#signingKey()`: 检索签名创建的密钥
* `Token\JWT\Factory#verificationKey()`: 检索签名验证的密钥
* `Token\JWT\Factory#validator()`: 检索令牌验证器
* `Token\JWT\Factory#validationConstraints()`: 检索默认的验证约束集合
