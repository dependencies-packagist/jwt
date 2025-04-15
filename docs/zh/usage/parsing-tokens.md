# 解析令牌

要解析一个令牌，你必须创建一个新的解析器，并请求它解析一个字符串：

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

> 重要
> 在解析错误的情况下，解析器会抛出 `InvalidArgumentException` 类型的异常。
