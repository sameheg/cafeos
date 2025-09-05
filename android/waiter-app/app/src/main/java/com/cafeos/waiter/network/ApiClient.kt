package com.cafeos.waiter.network

import okhttp3.Interceptor
import okhttp3.OkHttpClient
import okhttp3.Request
import retrofit2.Retrofit
import retrofit2.converter.gson.GsonConverterFactory

object ApiClient {
    private const val BASE_URL = "https://example.com/api/"

    fun create(tokenProvider: () -> String): CafeosApi {
        val authInterceptor = Interceptor { chain ->
            val original: Request = chain.request()
            val requestBuilder = original.newBuilder()
                .header("Authorization", "Bearer ${tokenProvider()}")
            val request = requestBuilder.build()
            chain.proceed(request)
        }

        val client = OkHttpClient.Builder()
            .addInterceptor(authInterceptor)
            .build()

        return Retrofit.Builder()
            .baseUrl(BASE_URL)
            .client(client)
            .addConverterFactory(GsonConverterFactory.create())
            .build()
            .create(CafeosApi::class.java)
    }
}
