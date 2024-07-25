<?php

namespace App\Listeners;

use App\Events\OrderSendMail;
use App\Mail\OrderMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class OrderSendListener
{

    /**
     * Create the event listener.
     */
    public function __construct()
    {
        
    }

    /**
     * Handle the event.
     */
    public function handle(OrderSendMail $event): void
    {
        $order = $event->data;
        Mail::to($order->email)->later(now()->addMinutes(6),new OrderMail($order));
    }
}
