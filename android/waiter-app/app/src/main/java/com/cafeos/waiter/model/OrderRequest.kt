package com.cafeos.waiter.model

data class OrderItem(
    val product_id: Long,
    val quantity: Int
)

data class OrderRequest(
    val table: String,
    val items: List<OrderItem>
)
