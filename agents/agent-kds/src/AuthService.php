<?php
declare(strict_types=1);

/**
 * Minimal JWT service for token generation and validation.
 */
class AuthService
{
    public function __construct(private string $secret)
    {
    }

    /**
     * Generate a JWT for the given role.
     */
    public function generateToken(string $role): string
    {
        $header = $this->base64UrlEncode(json_encode(['alg' => 'HS256', 'typ' => 'JWT']));
        $payload = $this->base64UrlEncode(json_encode(['role' => $role]));
        $signature = $this->base64UrlEncode(hash_hmac('sha256', "$header.$payload", $this->secret, true));

        return "$header.$payload.$signature";
    }

    /**
     * Validate a JWT and ensure it contains one of the allowed roles.
     *
     * @param string[] $allowedRoles
     */
    public function validate(string $token, array $allowedRoles): bool
    {
        $parts = explode('.', $token);
        if (count($parts) !== 3) {
            return false;
        }
        [$header, $payload, $signature] = $parts;
        $expected = $this->base64UrlEncode(hash_hmac('sha256', "$header.$payload", $this->secret, true));
        if (!hash_equals($expected, $signature)) {
            return false;
        }
        $data = json_decode(base64_decode($payload) ?: '', true);
        if (!is_array($data) || !isset($data['role'])) {
            return false;
        }
        return in_array($data['role'], $allowedRoles, true);
    }

    private function base64UrlEncode(string $data): string
    {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }
}

