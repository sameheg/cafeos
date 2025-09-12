# Rentals Module

```mermaid
stateDiagram-v2
    [*] --> Listed
    Listed --> Rented: sign()
    Rented --> Paid: collect()
    Rented --> Disputed: dispute()
    Disputed --> Resolved: resolve()
```

## API
- `POST /api/v1/rentals/contracts` – create contract
- `GET /api/v1/rentals/occupancy` – current occupancy rate

```php
// Create contract
$response = Http::post('/api/v1/rentals/contracts', [
    'space_id' => 'listing-1',
]);
```
