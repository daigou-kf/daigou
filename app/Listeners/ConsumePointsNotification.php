<?php

namespace App\Listeners;

use App\Events\PointsConsumed;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ConsumePointsNotification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  PointsConsumed  $event
     * @return void
     */
    public function handle(PointsConsumed $event)
    {
        //
    }
}
