<?php

namespace App\Listeners;

use App\Events\OrderPayment;
use App\Events\OrderSendMail;
use App\Mail\OrderMail;
use App\Mail\PaymentMail;
use App\Repositories\OrderRepositories;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class PaymentInvoice
{
    protected $orderRepositories;

    /**
     * Create the event listener.
     */
    public function __construct(OrderRepositories $orderRepositories)
    {
        $this->orderRepositories = $orderRepositories;
    }

    /**
     * Handle the event.
     */
    public function handle(OrderPayment $event): void
    {
        $order = $event->data;
        $this->orderRepositories->UpdateWhere([
            ['code','=',$order->code]
        ],['is_send_mail' => $order->is_send_mail + 1 ]);
        Mail::to($order->email)->later(now()->addMinutes(6),new PaymentMail($order));
    }
}
