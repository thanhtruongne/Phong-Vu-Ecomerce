<?php

namespace Modules\Order\Jobs;

use App\Enums\Enum\StatusReponse;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Mail;
use Modules\Order\Entities\Orders;

class SendMailSync implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    
    public $order;

    public function __construct($order)
    {
        $this->order = $order;
    }

    public function handle()
    {
        $order = Orders::find($this->order->id);
        if(!$order) {
         \Log::error('Không tìm thấy đơn hàng_'.time());
          return response()->json(['message' => 'Không tìm thấy đơn hàng_'.time(),'status' => StatusReponse::ERROR]);
        }
        $mailer = 'smtp';
        $email = $this->order->receiver_email;
        $subject = 'Thanh toán thành công. Mã đơn hàng '.$this->order->code;
        Mail::mailer($mailer)->send('mail.default', [
            'order' => $this->order
        ], function ($message) use ($email, $subject) {
            $message->to($email)->subject($subject);
        });

        $order->mail_completed = 1;
        $order->save();
    }
}
