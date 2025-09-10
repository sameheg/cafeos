<?php

namespace Modules\Notifications\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Modules\Notifications\Models\Notification;
use Modules\Notifications\Services\NotificationService;

class NotificationController extends Controller
{
    public function index(Request $request): View
    {
        $query = Notification::query()->orderByDesc('created_at');
        if ($role = $request->query('role')) {
            $query->where('role', $role);
        }

        return view('notifications::index', [
            'notifications' => $query->get(),
        ]);
    }

    public function acknowledge(Notification $notification): RedirectResponse
    {
        $notification->update([
            'status' => 'acknowledged',
            'acknowledged_at' => now(),
        ]);

        return redirect()->back();
    }

    public function escalate(Notification $notification, NotificationService $service): RedirectResponse
    {
        $service->escalate($notification);

        return redirect()->back();
    }
}
