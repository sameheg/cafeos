# Cache Keys and TTL

The application caches frequently accessed queries to reduce repeated database load.

## All Orders
- **Key pattern:** `restaurant_all_orders_{businessId}_{filterHash}`
- **TTL:** `CACHE_TTL_RESTAURANT_ALL_ORDERS` (default 60s)
- **Source:** `RestaurantUtil::getAllOrders`

## Line Orders
- **Key pattern:** `restaurant_line_orders_{businessId}_{filterHash}`
- **TTL:** `CACHE_TTL_RESTAURANT_LINE_ORDERS` (default 60s)
- **Source:** `RestaurantUtil::getLineOrders`

## Invoice Schemes
- **Key pattern:** `invoice_scheme_{businessId}_{locationId}`
- **TTL:** `CACHE_TTL_INVOICE_SCHEME` (default 86400s)
- **Source:** `TransactionUtil::getInvoiceScheme`

Caches are cleared automatically by observers on `Transaction`, `TransactionSellLine`, `InvoiceScheme`, and `BusinessLocation` whenever related records are saved or deleted.
