package com.cafeos.kds

import android.os.Bundle
import androidx.activity.ComponentActivity
import androidx.activity.compose.setContent
import androidx.compose.material.MaterialTheme
import androidx.compose.material.Surface
import com.cafeos.kds.ui.TicketBoardScreen
import okhttp3.OkHttpClient
import retrofit2.Retrofit
import retrofit2.converter.moshi.MoshiConverterFactory

class MainActivity : ComponentActivity() {
    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)

        // Load configuration (placeholder uses defaults)
        val config = KdsConfig.default()

        val client = OkHttpClient.Builder()
            .addInterceptor(AuthInterceptor(config.token))
            .build()

        val api = Retrofit.Builder()
            .baseUrl(config.baseUrl)
            .addConverterFactory(MoshiConverterFactory.create())
            .client(client)
            .build()
            .create(KdsApiService::class.java)

        val viewModel = TicketBoardViewModel(api)

        setContent {
            MaterialTheme {
                Surface { TicketBoardScreen(viewModel) }
            }
        }
    }
}

data class KdsConfig(val baseUrl: String, val token: String) {
    companion object {
        fun default() = KdsConfig("https://pos.example.com/", "chef-token-placeholder")
    }
}
