# POS Module

The POS module handles order creation and payment for EliteSaaS.

## API
- `POST /api/v1/pos/orders` create order
- `GET /api/v1/pos/orders/{id}` fetch order

## Events
- `pos.order.paid@v1` emitted when an order is paid.

## Tests
Run `composer test` to execute module tests.
