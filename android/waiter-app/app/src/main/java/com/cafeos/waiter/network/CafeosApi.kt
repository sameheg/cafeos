package com.cafeos.waiter.network

import com.cafeos.waiter.model.OrderRequest
import com.cafeos.waiter.model.OrderResponse
import com.cafeos.waiter.model.Product
import retrofit2.http.Body
import retrofit2.http.GET
import retrofit2.http.POST

interface CafeosApi {
    @GET("products")
    suspend fun getProducts(): List<Product>

    @POST("orders")
    suspend fun submitOrder(@Body order: OrderRequest): OrderResponse
}
