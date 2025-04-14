<?php

namespace Token\JWT\Encoding;

use JsonException;

use Token\JWT\Contracts\Decoder;
use Token\JWT\Contracts\Encoder;
use Token\JWT\Exceptions\CannotDecodeContentException;
use Token\JWT\Exceptions\CannotEncodeContentException;

/**
 * @deprecated
 */
final class JoseEncoder implements Encoder, Decoder
{
    private const JSON_DEFAULT_DEPTH = 512;

    /**
     * @inheritdoc
     */
    public function jsonEncode($data): string
    {
        try {
            return json_encode($data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR);
        } catch (JsonException $exception) {
            throw CannotEncodeContentException::jsonIssues($exception);
        }
    }

    /**
     * @inheritdoc
     */
    public function jsonDecode(string $json): mixed
    {
        try {
            return json_decode($json, true, self::JSON_DEFAULT_DEPTH, JSON_THROW_ON_ERROR);
        } catch (JsonException $exception) {
            throw CannotDecodeContentException::jsonIssues($exception);
        }
    }

    /**
     * @inheritdoc
     */
    public function base64UrlEncode(string $data): string
    {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }

    /**
     * @inheritdoc
     */
    public function base64UrlDecode(string $data): string
    {
        // Padding isn't added back because it isn't strictly necessary for decoding with PHP
        $decodedContent = base64_decode(strtr($data, '-_', '+/'), true);

        if (!is_string($decodedContent)) {
            throw CannotDecodeContentException::invalidBase64String();
        }

        return $decodedContent;
    }
}
