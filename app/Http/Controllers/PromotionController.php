<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Notifications\PromotionNotification;
use App\Services\PromotionService;

class PromotionController extends Controller
{
    public function show(User $user, PromotionService $service)
    {
        $promotions = $service->getPromotionsForCustomer($user);

        foreach ($promotions as $promotion) {
            $user->notify(new PromotionNotification($promotion));
        }

        return response()->json(['promotions' => $promotions]);
    }
}
