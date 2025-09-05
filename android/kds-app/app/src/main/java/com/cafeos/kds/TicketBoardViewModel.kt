package com.cafeos.kds

import androidx.lifecycle.ViewModel
import androidx.lifecycle.viewModelScope
import kotlinx.coroutines.flow.MutableStateFlow
import kotlinx.coroutines.flow.StateFlow
import kotlinx.coroutines.launch

/**
 * Holds ticket state and exposes refresh/update actions for the UI.
 */
class TicketBoardViewModel(private val api: KdsApiService) : ViewModel() {

    private val _tickets = MutableStateFlow<List<Ticket>>(emptyList())
    val tickets: StateFlow<List<Ticket>> = _tickets

    fun refresh() {
        viewModelScope.launch {
            runCatching { api.getTickets() }
                .onSuccess { _tickets.value = it }
        }
    }

    fun updateStatus(id: String, status: String) {
        viewModelScope.launch {
            runCatching { api.updateTicketStatus(id, StatusUpdateRequest(status)) }
                .onSuccess { refresh() }
        }
    }
}
