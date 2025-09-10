<?php

namespace Modules\TableReservations\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Notifications\Services\NotificationService;
use Modules\TableReservations\Models\WaitlistEntry;

class WaitlistController extends Controller
{
    public function index()
    {
        return WaitlistEntry::all();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'customer_name' => 'required',
            'phone' => 'required',
            'party_size' => 'required|integer',
        ]);
        $data['status'] = 'waiting';

        return WaitlistEntry::create($data);
    }

    public function update(Request $request, WaitlistEntry $waitlist, NotificationService $notifications)
    {
        $waitlist->update($request->only(['status']));
        $notifications->send('Waitlist update for '.$waitlist->customer_name, ['sms', 'push']);

        return $waitlist;
    }
}
