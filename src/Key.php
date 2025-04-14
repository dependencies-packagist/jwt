<?php

namespace Token\JWT;

use SplFileObject;
use Throwable;
use Token\JWT\Exceptions\CannotDecodeContentException;
use Token\JWT\Exceptions\FileCouldNotBeReadException;

final class Key implements Contracts\Key
{
    private string $contents;
    private string $passphrase;

    private function __construct(string $contents = '', string $passphrase = '')
    {
        $this->contents   = $contents;
        $this->passphrase = $passphrase;
    }

    public static function empty(): self
    {
        return new self('', '');
    }

    public static function plainText(string $contents, string $passphrase = ''): self
    {
        return new self($contents, $passphrase);
    }

    public static function base64Encoded(string $contents, string $passphrase = ''): self
    {
        $decoded = base64_decode($contents, true);

        if ($decoded === false) {
            throw CannotDecodeContentException::invalidBase64String();
        }

        return new self($decoded, $passphrase);
    }

    public static function file(string $path, string $passphrase = ''): self
    {
        try {
            $file = new SplFileObject($path);
        } catch (Throwable $exception) {
            throw FileCouldNotBeReadException::onPath($path, $exception);
        }

        $contents = $file->fread($file->getSize());
        assert(is_string($contents));

        return new self($contents, $passphrase);
    }

    public function contents(): string
    {
        return $this->contents;
    }

    public function passphrase(): string
    {
        return $this->passphrase;
    }
}
