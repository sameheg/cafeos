package com.cafeos.waiter.ui

import android.os.Bundle
import android.widget.ArrayAdapter
import android.widget.ListView
import androidx.appcompat.app.AppCompatActivity
import com.cafeos.waiter.R

class OrderStatusActivity : AppCompatActivity() {
    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        setContentView(R.layout.activity_order_status)

        val listView: ListView = findViewById(R.id.statusList)
        val messages = listOf("Order submitted", "Awaiting kitchen...")
        listView.adapter = ArrayAdapter(this, android.R.layout.simple_list_item_1, messages)
    }
}
