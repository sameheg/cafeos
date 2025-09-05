# Delivery Provider Onboarding

This guide explains how to configure delivery integrations and store
credentials centrally using the `DeliveryProviderCredential` model.

## Talabat
1. Request API credentials from Talabat.
2. Insert the `client_id` and `client_secret` into the
   `delivery_provider_credentials` table. Example:
   ```php
   php artisan tinker
   App\DeliveryProviderCredential::create([
       'provider' => 'talabat',
       'token' => 'your-client-id',
       'secret' => 'your-client-secret',
   ]);
   ```
3. Set `TALABAT_BASE_URI` in your `.env` if a non-default endpoint is
   required.
4. Orders can now be created or updated through `TalabatAdapter`.

## UberEats
1. Request API credentials from UberEats.
2. Insert the credentials into `delivery_provider_credentials`:
   ```php
   php artisan tinker
   App\DeliveryProviderCredential::create([
       'provider' => 'ubereats',
       'token' => 'your-client-id',
       'secret' => 'your-client-secret',
   ]);
   ```
3. Configure `UBEREATS_BASE_URI` in `.env` if needed.
4. Use `UberEatsAdapter` to create and update orders via the
   `DeliveryProvider` interface.

