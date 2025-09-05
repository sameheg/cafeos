package com.cafeos.waiter.ui

import android.os.Bundle
import android.widget.ArrayAdapter
import android.widget.Button
import android.widget.ListView
import androidx.appcompat.app.AppCompatActivity
import androidx.lifecycle.lifecycleScope
import com.cafeos.waiter.R
import com.cafeos.waiter.model.OrderItem
import com.cafeos.waiter.model.OrderRequest
import com.cafeos.waiter.model.Product
import com.cafeos.waiter.network.ApiClient
import com.cafeos.waiter.network.AuthTokenStore
import kotlinx.coroutines.launch

class OrderEntryActivity : AppCompatActivity() {
    private val products = mutableListOf<Product>()
    private lateinit var listView: ListView

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        setContentView(R.layout.activity_order_entry)

        val table = intent.getStringExtra("table") ?: ""
        val api = ApiClient.create { AuthTokenStore.token }

        listView = findViewById(R.id.productList)

        lifecycleScope.launch {
            try {
                val response = api.getProducts()
                products.addAll(response)
                val adapter = ArrayAdapter(this@OrderEntryActivity, android.R.layout.simple_list_item_multiple_choice, products.map { it.name })
                listView.choiceMode = ListView.CHOICE_MODE_MULTIPLE
                listView.adapter = adapter
            } catch (e: Exception) {
                // handle error appropriately in production
            }
        }

        findViewById<Button>(R.id.submitOrder).setOnClickListener {
            val items = mutableListOf<OrderItem>()
            for (i in 0 until listView.count) {
                if (listView.isItemChecked(i)) {
                    val product = products[i]
                    items.add(OrderItem(product.id, 1))
                }
            }
            lifecycleScope.launch {
                try {
                    api.submitOrder(OrderRequest(table, items))
                } catch (e: Exception) {
                    // handle error
                }
            }
        }
    }
}
