<?php

namespace App\Services;

/**
 * Explore quantum-resistant encryption using libsodium's seal functions.
 * This is a placeholder and not a full PQC implementation.
 */
class QuantumEncryptionService
{
    public function encrypt(string $plain, string $publicKey): string
    {
        return sodium_bin2base64(
            sodium_crypto_box_seal($plain, $publicKey),
            SODIUM_BASE64_VARIANT_URLSAFE_NO_PADDING
        );
    }

    public function decrypt(string $cipher, string $publicKey, string $secretKey): string
    {
        $decoded = sodium_base642bin($cipher, SODIUM_BASE64_VARIANT_URLSAFE_NO_PADDING);
        return sodium_crypto_box_seal_open($decoded, sodium_crypto_box_keypair_from_secretkey_and_publickey($secretKey, $publicKey));
    }
}
