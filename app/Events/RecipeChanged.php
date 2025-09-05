<?php

namespace App\Events;

use App\MfgRecipe;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class RecipeChanged
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public MfgRecipe $recipe;

    /**
     * Create a new event instance.
     */
    public function __construct(MfgRecipe $recipe)
    {
        $this->recipe = $recipe;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn(): Channel
    {
        return new PrivateChannel('recipes');
    }
}

