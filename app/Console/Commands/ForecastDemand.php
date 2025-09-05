<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\Inventory\DemandForecastService;

class ForecastDemand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pos:forecastDemand';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Updates forecasted demand for products';

    /**
     * Execute the console command.
     */
    public function handle(DemandForecastService $service)
    {
        $service->updateForecastedDemands();
        $this->info('Forecasted demands updated');

        return 0;
    }
}
