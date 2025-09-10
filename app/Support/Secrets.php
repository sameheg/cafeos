<?php

use Aws\Ssm\SsmClient;
use GuzzleHttp\Client;

if (! function_exists('secret')) {
    /**
     * Retrieve a secret value from environment, AWS SSM or HashiCorp Vault.
     */
    function secret(string $key, $default = null)
    {
        $value = $_ENV[$key] ?? $_SERVER[$key] ?? null;

        if ($value !== null) {
            return $value;
        }

        // AWS Systems Manager Parameter Store
        if (class_exists(SsmClient::class) && ($_ENV['AWS_USE_SSM'] ?? $_SERVER['AWS_USE_SSM'] ?? false)) {
            static $ssm;

            $ssm ??= new SsmClient([
                'version' => 'latest',
                'region' => $_ENV['AWS_DEFAULT_REGION'] ?? $_SERVER['AWS_DEFAULT_REGION'] ?? 'us-east-1',
            ]);

            try {
                $parameter = $ssm->getParameter([
                    'Name' => $key,
                    'WithDecryption' => true,
                ]);

                if (isset($parameter['Parameter']['Value'])) {
                    return $parameter['Parameter']['Value'];
                }
            } catch (\Throwable $e) {
                // ignore
            }
        }

        // HashiCorp Vault
        $vaultAddr = $_ENV['VAULT_ADDR'] ?? $_SERVER['VAULT_ADDR'] ?? null;
        $vaultToken = $_ENV['VAULT_TOKEN'] ?? $_SERVER['VAULT_TOKEN'] ?? null;

        if ($vaultAddr && $vaultToken) {
            static $vault;

            $vault ??= new Client([
                'base_uri' => rtrim($vaultAddr, '/').'/v1/',
            ]);

            try {
                $prefix = $_ENV['VAULT_PATH_PREFIX'] ?? $_SERVER['VAULT_PATH_PREFIX'] ?? '';
                $path = trim($prefix.$key, '/');
                $response = $vault->get($path, [
                    'headers' => [
                        'X-Vault-Token' => $vaultToken,
                    ],
                ]);

                $data = json_decode((string) $response->getBody(), true);

                if (isset($data['data']['data'][$key])) {
                    return $data['data']['data'][$key];
                }

                if (isset($data['data'][$key])) {
                    return $data['data'][$key];
                }
            } catch (\Throwable $e) {
                // ignore
            }
        }

        return $default;
    }
}
