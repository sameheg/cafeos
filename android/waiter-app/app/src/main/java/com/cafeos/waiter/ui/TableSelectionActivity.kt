package com.cafeos.waiter.ui

import android.content.Intent
import android.os.Bundle
import android.widget.ArrayAdapter
import android.widget.ListView
import androidx.appcompat.app.AppCompatActivity
import com.cafeos.waiter.R

class TableSelectionActivity : AppCompatActivity() {
    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        setContentView(R.layout.activity_table_selection)

        val tables = (1..20).map { "Table $it" }
        val listView: ListView = findViewById(R.id.tableList)
        listView.adapter = ArrayAdapter(this, android.R.layout.simple_list_item_1, tables)

        listView.setOnItemClickListener { _, _, position, _ ->
            val intent = Intent(this, OrderEntryActivity::class.java)
            intent.putExtra("table", tables[position])
            startActivity(intent)
        }
    }
}
