package com.cafeos.kds

import retrofit2.http.GET
import retrofit2.http.POST
import retrofit2.http.Path
import retrofit2.http.Body
import retrofit2.Response

// Data models
data class Metrics(val activeTickets: Int)
data class Ticket(val id: String, val status: String, val items: List<String>)
data class StatusUpdateRequest(val status: String)

/**
 * Retrofit API for communicating with the CafeOS backend KDS endpoints.
 */
interface KdsApiService {
    @GET("kds/metrics")
    suspend fun getMetrics(): Metrics

    @GET("kds/tickets")
    suspend fun getTickets(): List<Ticket>

    @POST("kds/tickets/{id}/status")
    suspend fun updateTicketStatus(
        @Path("id") id: String,
        @Body body: StatusUpdateRequest
    ): Response<Unit>
}
