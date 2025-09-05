<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Jobs\SyncDeliveryOrders;
use App\Jobs\GenerateReport;
use Modules\Sync\Console\SyncQueueCommand;
use App\ScheduledTask;
use App\Console\Commands\CleanActivityLog;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        SyncQueueCommand::class,
        CleanActivityLog::class,
    ];
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->job(new SyncDeliveryOrders('talabat'))->everyThirtyMinutes();
        $schedule->job(new SyncDeliveryOrders('ubereats'))->everyThirtyMinutes();
        $schedule->job(new GenerateReport('daily'))->dailyAt('02:00');

        //Check for products with low stock
        $schedule->command('pos:checkLowStock')->daily();

        //Update forecasted demand for products
        $schedule->command('pos:forecastDemand')->daily();

        //Clean old activity logs
        $schedule->command('activitylog:clean')->daily();

        $env = config('app.env');
        $email = config('mail.username');

        if ($env === 'live') {
            //Scheduling backup according to settings
            $settings = \App\Models\BackupSetting::first();
            if ($settings) {
                switch ($settings->frequency) {
                    case 'weekly':
                        $schedule->command('backup:scheduled')->weekly();
                        break;
                    case 'monthly':
                        $schedule->command('backup:scheduled')->monthly();
                        break;
                    default:
                        $schedule->command('backup:scheduled')->daily();
                        break;
                }
            }


            //Schedule to create recurring invoices
            $schedule->command('pos:generateSubscriptionInvoices')->dailyAt('23:30');
            $schedule->command('pos:updateRewardPoints')->dailyAt('23:45');

            $schedule->command('pos:autoSendPaymentReminder')->dailyAt('8:00');

        }

        if ($env === 'demo') {
            //IMPORTANT NOTE: This command will delete all business details and create dummy business, run only in demo server.
            $schedule->command('pos:dummyBusiness')
                    ->cron('0 */3 * * *')
                    //->everyThirtyMinutes()
                    ->emailOutputTo($email);
        }

        ScheduledTask::where('enabled', true)->each(function ($task) use ($schedule) {
            $schedule->command($task->command)->cron($task->frequency);
        });
    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');
        require base_path('routes/console.php');
    }
}
