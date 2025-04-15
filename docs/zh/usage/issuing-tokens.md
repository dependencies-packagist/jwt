# 发放令牌

要发放新的令牌，你必须创建一个新的令牌构建器：

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

一旦你创建了一个令牌，你就可以检索它的数据并将其转换为字符串表示形式：

```php
$token = $builder
    ->issuedBy('http://example.com')
    ->withClaim('uid', 1)
    ->withHeader('foo', 'bar')
    ->getToken($algorithm, $signingKey);

var_dump($token->headers()); // Retrieves the token headers
var_dump($token->claims());  // Retrieves the token claims

var_dump($token->headers()->get('foo')); // will print "bar"
var_dump($token->claims()->get('iss'));  // will print "http://example.com"
var_dump($token->claims()->get('uid'));  // will print "1"

var_dump($token->toString()); // The string representation of the object is a JWT string
```
