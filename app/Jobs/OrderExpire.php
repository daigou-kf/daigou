<?php

namespace App\Jobs;

use App\OrderProduct;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Notification;

use App\Order;
use Illuminate\Support\Facades\Log;

use App\Notifications\Report;

class OrderExpire implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $order;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $order = $this->order;
        if($order->status == 0){
            try{
                OrderProduct::where('order_id',$order->id)->delete();
                $order->delete();
                $content = "Order No ".$order->id." has expired";
                Notification::route('mail', 'paulpengwork@gmail.com')->notify(new report($content));
            } catch(\Exception $e){
                Log::debug($e);
            }
        }
    }
}
