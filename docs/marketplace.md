# Marketplace Module

The Marketplace module provides supplier storefronts, listings and bid workflows.

```mermaid
stateDiagram-v2
    [*] --> Open
    Open --> Bidded: bid()
    Bidded --> Awarded: award()
    Bidded --> Expired: timeout()
    Awarded --> Fulfilled: fulfill()
```

## Events
- `marketplace.bid.awarded@v1`

## API
- `POST /api/v1/marketplace/bids`
- `GET /api/v1/marketplace/stores/{supplier}`

