<?php

namespace Token\JWT\Signature;

use OpenSSLAsymmetricKey;
use Token\JWT\Contracts\Signer;
use Token\JWT\Exceptions\CannotSignPayloadException;
use Token\JWT\Exceptions\InvalidKeyProvidedException;

abstract class OpenSSL implements Signer
{
    /**
     * Generate signature
     *
     * @param string $pem
     * @param string $passphrase
     * @param string $payload
     *
     * @return string
     * @throws CannotSignPayloadException
     * @throws InvalidKeyProvidedException
     */
    final protected function createSignature(string $pem, string $passphrase, string $payload): string
    {
        $key = $this->getPrivateKey($pem, $passphrase);

        try {
            $signature = '';

            if (!openssl_sign($payload, $signature, $key, $this->algorithm())) {
                $error = openssl_error_string();
                assert(is_string($error));

                throw CannotSignPayloadException::errorHappened($error);
            }

            return $signature;
        } finally {
            $this->freeKey($key);
        }
    }

    /**
     * Get a private key
     *
     * @param string $pem
     * @param string $passphrase
     *
     * @return false|OpenSSLAsymmetricKey|resource
     * @throws InvalidKeyProvidedException
     */
    private function getPrivateKey(string $pem, string $passphrase): OpenSSLAsymmetricKey|bool
    {
        $privateKey = openssl_pkey_get_private($pem, $passphrase);
        $this->validateKey($privateKey);

        return $privateKey;
    }

    /**
     * Verify signature
     *
     * @param string $expected
     * @param string $payload
     * @param string $pem
     *
     * @return bool
     * @throws InvalidKeyProvidedException
     */
    final protected function verifySignature(string $expected, string $payload, string $pem): bool
    {
        $key    = $this->getPublicKey($pem);
        $result = openssl_verify($payload, $expected, $key, $this->algorithm());
        $this->freeKey($key);

        return $result === 1;
    }

    /**
     * Extract public key from certificate and prepare it for use
     *
     * @param string $pem
     *
     * @return false|OpenSSLAsymmetricKey|resource
     * @throws InvalidKeyProvidedException
     */
    private function getPublicKey(string $pem): OpenSSLAsymmetricKey|bool
    {
        $publicKey = openssl_pkey_get_public($pem);
        $this->validateKey($publicKey);

        return $publicKey;
    }

    /**
     * Raises an exception when the key type is not the expected type
     *
     * @param resource|OpenSSLAsymmetricKey|bool $key
     *
     * @return void
     * @throws InvalidKeyProvidedException
     */
    private function validateKey(resource|OpenSSLAsymmetricKey|bool $key): void
    {
        if (is_bool($key)) {
            $error = openssl_error_string();
            assert(is_string($error));

            throw InvalidKeyProvidedException::cannotBeParsed($error);
        }

        $details = openssl_pkey_get_details($key);
        assert(is_array($details));

        if (!array_key_exists('key', $details) || $details['type'] !== $this->keyType()) {
            throw InvalidKeyProvidedException::incompatibleKey();
        }
    }

    /**
     * Free key resource
     *
     * @param resource|OpenSSLAsymmetricKey|bool $key
     *
     * @return void
     */
    private function freeKey(resource|OpenSSLAsymmetricKey|bool $key): void
    {
        if ($key instanceof OpenSSLAsymmetricKey) {
            return;
        }

        openssl_free_key($key); // Deprecated and no longer necessary as of PHP >= 8.0
    }

    /**
     * Returns the type of key to be used to create/verify the signature (using OpenSSL constants)
     *
     * @internal
     */
    abstract public function keyType(): int;

    /**
     * Returns which algorithm to be used to create/verify the signature (using OpenSSL constants)
     *
     * @internal
     */
    abstract public function algorithm(): int;
}
