# POS Module (Extended with Tables)

## Tables Integration
- Migration: `pos_tables` (maps floorplan furniture to POS orders)
- Model: `PosTable`
- Controller: `TableController`

## API
- GET /api/v1/pos/table/{id} → table + current order
- POST /api/v1/pos/table/{id}/order/start → start new order on table
- POST /api/v1/pos/order/{id}/items → add item
- PATCH /api/v1/pos/order/{id}/close → close order + free table
