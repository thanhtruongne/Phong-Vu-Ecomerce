<?php

namespace Modules\Order\Jobs;

use App\Enums\Enum\StatusReponse;
use App\Http\Controllers\Controller;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;

class OrderSync extends Controller implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $order;
    public $data;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($order,$data)
    {
        $this->order = $order;
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            $carts = $this->data;
            if(isset($carts) && count($carts) == 0){
                return response()->json(['message' => "Có lỗi xảy ra", 'status' => StatusReponse::ERROR]);
            }
            $id = $this->order->id;
            $item = [];
            foreach($carts as $key => $cart){
                //check quantity
                if($cart->qty) {
                    $vertify_id = $cart->sku_id ? $cart->sku_id : $cart->id;
                    $name = !is_null($cart->sku_id) ? 'SkuVariants' : 'Products';
                    $count = $name == 'SkuVariants' ? 'stock' : 'quantity';
                    $instance = $this->handleMadeClass('Products',$name,'Modules');
                    $check = $instance::findOrFail($vertify_id);
                    if($check->{$count} < $cart->qty) {
                        \Log::error('Lỗi số lượng vượt quá Mã: '.$this->order->code.'_ product_id_'.$vertify_id);
                        return response()->json(['message' => "Có lỗi xảy ra", 'status' => StatusReponse::ERROR,'code' => 2241]);
                    }
                    $check->decrement($count,$cart->qty);
                }

                $item[] = [
                    'order_id' => $id,
                    'product_id' => $cart->id,
                    'product_image' => $cart->options->image,
                    'product_brand' => $cart->options->brand,
                    'product_price' => $cart->options->price_after_discount ? $cart->options->price_after_discount : $cart->price,
                    'quantity' => $cart->qty,
                    'sku_id' => $cart->options->image,
                    'product_category_id' => $cart->options->product_category_id,
                    'promotion_name' => $cart->options->promotion_name,
                    'promotion_amount' => $cart->options->promotion_amount,
                    'sku_code' => $cart->options->code,
                    'product_attribute' => $cart->options->sku_idx,
                ];
            }
            $this->order->order_items()->createMany($item);
        } catch (\Throwable $th) {
            \Log::error('Có lỗi tạo order item Mã: '.$this->order->code);
            return response()->json(['message' => $th->getMessage(), 'status' => StatusReponse::ERROR]);
        }


    }

    // private functio



    public function delay()
    {
        return now()->addSeconds(5); // Delay 5 giây
    }
}
