# Secret Management

CafeOS retrieves sensitive configuration at runtime using a `secret()` helper. Secrets are
loaded from the environment by default, but the helper can fall back to external
stores such as AWS Systems Manager (SSM) Parameter Store or HashiCorp Vault.

## AWS SSM

Enable SSM lookups by setting `AWS_USE_SSM=true` and granting the application
IAM access to the desired parameters. The helper reads a parameter whose name
matches the requested key and returns the decrypted value.

## HashiCorp Vault

Set `VAULT_ADDR` and `VAULT_TOKEN` to point to your Vault server. Optionally
provide `VAULT_PATH_PREFIX` to prefix secret paths. The helper requests the
secret path for the key and returns its value.

## Usage

Configuration files call `secret('KEY')` instead of `env('KEY')` for sensitive
values. Example:

```php
'mail' => [
    'username' => secret('MAIL_USERNAME'),
    'password' => secret('MAIL_PASSWORD'),
],
```

This approach keeps credentials out of `.env` and supports centralized secret
management systems.
