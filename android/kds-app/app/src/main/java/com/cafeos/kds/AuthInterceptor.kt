package com.cafeos.kds

import okhttp3.Interceptor
import okhttp3.Response
import org.json.JSONObject
import java.util.Base64

/**
 * Adds the Authorization header and validates that the bearer token contains a
 * role compatible with CHEF or KITCHEN_MANAGER.
 */
class AuthInterceptor(private val token: String) : Interceptor {

    private val allowedRoles = setOf("CHEF", "KITCHEN_MANAGER")

    override fun intercept(chain: Interceptor.Chain): Response {
        require(validateToken(token)) { "Token missing required role" }
        val request = chain.request()
            .newBuilder()
            .addHeader("Authorization", "Bearer $token")
            .build()
        return chain.proceed(request)
    }

    private fun validateToken(token: String): Boolean {
        return try {
            val parts = token.split('.')
            if (parts.size < 2) return false
            val payload = String(Base64.getUrlDecoder().decode(parts[1]))
            val role = JSONObject(payload).optString("role")
            role in allowedRoles
        } catch (e: Exception) {
            false
        }
    }
}
