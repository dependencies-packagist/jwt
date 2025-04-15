# Parsing tokens

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

> Important
> In case of parsing errors the Parser will throw an exception of type `InvalidArgumentException`.
