<?php

namespace App\Services;

class RouteOptimizationService
{
    /**
     * Optimize the order of stops for a route.
     * For now, this returns the stops in the given order.
     *
     * @param  list<array{lat:float,lng:float}>  $stops
     * @return list<array{lat:float,lng:float}>
     */
    public function optimize(array $stops): array
    {
        // TODO: implement real route optimization
        return $stops;
    }
}
