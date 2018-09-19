<?php

namespace App\Console;

use App\Http\Controllers\PospalController;
use App\Product;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Collection;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        /* fetch new and hot products in collection */
        $schedule->call(function(){
            Log::debug("running auto update for new and hot collections...");
            $hot_collection = Collection::where('search_name','hot')->first();
            $hot_collection->products()->detach();
            $hot_products = Product::orderBy('sale','desc')->take(20)->get();
            $hot_collection->products()->saveMany($hot_products);

            $new_collection = Collection::where('search_name','new')->first();
            $new_collection->products()->detach();
            $new_products = Product::orderBy('created_at','desc')->take(20)->get();
            $new_collection->products()->saveMany($new_products);
        })->timezone('Australia/Melbourne')->daily();

        /* for queue listeners */
        $schedule->command('queue:restart')->everyMinute();
        $schedule->command('queue:work')->everyMinute();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
