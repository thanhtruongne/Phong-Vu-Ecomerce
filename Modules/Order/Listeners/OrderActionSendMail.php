<?php

namespace Modules\Order\Listeners;

use Modules\Order\Events\OrderSendmail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Modules\Order\Jobs\SendMailSync;

class OrderActionSendMail
{
    public function handle(OrderSendmail $event)
    {
        SendMailSync::dispatch($event)->delay(\Carbon::now()->addMinutes(2));
    }
}
