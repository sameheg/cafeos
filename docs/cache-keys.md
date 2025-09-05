# Cache Keys and TTL

The application caches frequently accessed restaurant order queries to reduce repeated database load.

## All Orders
- **Key pattern:** `restaurant_all_orders_{businessId}_{filterHash}`
- **TTL:** `CACHE_TTL_RESTAURANT_ALL_ORDERS` (default 60s)
- **Source:** `RestaurantUtil::getAllOrders`

## Line Orders
- **Key pattern:** `restaurant_line_orders_{businessId}_{filterHash}`
- **TTL:** `CACHE_TTL_RESTAURANT_LINE_ORDERS` (default 60s)
- **Source:** `RestaurantUtil::getLineOrders`

Caches are cleared automatically by observers on `Transaction` and `TransactionSellLine` whenever related records are saved or deleted.
