<?php

use Illuminate\Support\Facades\Route;
use Modules\Kds\Models\KitchenTicket;

Route::get('tickets', function () {
    return KitchenTicket::where('approved', true)
        ->get()
        ->map(fn (KitchenTicket $ticket) => [
            'id' => $ticket->id,
            'order_id' => $ticket->order_id,
            'status' => $ticket->status,
            'status_color' => $ticket->status_color,
        ]);
});
