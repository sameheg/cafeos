package com.cafeos.kds.ui

import androidx.compose.runtime.*
import androidx.compose.foundation.layout.*
import androidx.compose.material.*
import androidx.compose.foundation.lazy.LazyColumn
import androidx.compose.foundation.lazy.items
import androidx.compose.ui.Modifier
import androidx.compose.ui.unit.dp
import com.cafeos.kds.Ticket
import com.cafeos.kds.TicketBoardViewModel

/**
 * Simple real-time ticket board.
 */
@Composable
fun TicketBoardScreen(viewModel: TicketBoardViewModel) {
    val tickets by viewModel.tickets.collectAsState()

    LaunchedEffect(Unit) { viewModel.refresh() }

    LazyColumn(modifier = Modifier.fillMaxSize().padding(16.dp)) {
        items(tickets) { ticket ->
            Card(modifier = Modifier.fillMaxWidth().padding(vertical = 8.dp)) {
                Column(modifier = Modifier.padding(16.dp)) {
                    Text("Ticket #${ticket.id}")
                    Text("Status: ${ticket.status}")
                    Row {
                        Button(onClick = { viewModel.updateStatus(ticket.id, "preparing") }) {
                            Text("Prepare")
                        }
                        Spacer(modifier = Modifier.width(8.dp))
                        Button(onClick = { viewModel.updateStatus(ticket.id, "done") }) {
                            Text("Done")
                        }
                    }
                }
            }
        }
    }
}
