<?php

namespace App\Services;

use App\Enums\Enum\PromotionEnum;
use App\Models\PromotionProductVariant;
use App\Repositories\PromotionProductVariantRepositories;
use App\Repositories\PromotionRepositories;
use App\Services\Interfaces\PromotionServiceInterfaces;
use App\Trait\UploadImage;
use Carbon\Carbon;
use Exception;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
class PromotionService extends BaseService implements PromotionServiceInterfaces
{
    protected $promotionRepositories,$promotionProductVariantRepositories;

    public function __construct(
         PromotionRepositories $promotionRepositories,
         PromotionProductVariantRepositories $promotionProductVariantRepositories
         ) {
        parent::__construct();
        $this->promotionRepositories = $promotionRepositories;
        $this->promotionProductVariantRepositories = $promotionProductVariantRepositories;
    }
    public function paginate($request) 
    {
        $condition = [];
        $condition['search'] = $request->search ?? '';
        $condition['status'] = +$request->status ?? 1;
        $record = $request->input('record') ?: 6;
        $promotion = $this->promotionRepositories->paganation(
        ['*'],
        $condition,[],$record,[],[],[],[]
        );
       return $promotion;
    }


    public function create($request ) {
        DB::beginTransaction();
        try {
            $payload = $request->only(['name','code','desc','startDate','endDate','promotionMethod','neverEndDate']);
            $payload['startDate'] = Carbon::createFromFormat('d/m/Y H:i',$payload['startDate']);
            $payload['method'] = $request->input('discountMethodProduct');
            if($request->input('neverEndDate') == null && isset($payload['endDate'])) {
                $payload['endDate'] = Carbon::createFromFormat('d/m/Y H:i',$payload['endDate']);
            }
            $payload['maxDiscountValue'] = $request->input(PromotionEnum::EXTREMELYMETHODDISCOUNTPRODUCT.'.price');
            $payload['discountValue'] = $request->input(PromotionEnum::EXTREMELYMETHODDISCOUNTPRODUCT.'.promotion');
            $payload['discountType'] = $request->input(PromotionEnum::EXTREMELYMETHODDISCOUNTPRODUCT.'.type');
           
            switch($payload['promotionMethod']) {
                case PromotionEnum::ORDERRANGEAMOUNT : 
                    $payload['info'] = $this->OrderRangeAmount($request);
                    break;
                case PromotionEnum::PRODUCTANDQUANITY : 
                    $payload['info'] = $this->ProductQuanity($request);
                    break;
                default : 
                    break;    
            }
        
            $promotion = $this->promotionRepositories->create($payload);
            if($promotion->id > 0) {
                
                $theme = [];
                if($request->input('discountMethodProduct') == PromotionEnum::PRODUCTDISCOUNT && !is_null($request->input('product_id'))) {
                    foreach($request->input('product_id') as $key => $item) {
                        $theme[] = [
                            // 'promotion_id' => $promotion->id,
                            'product_id' => $item,
                            'product_variant_id' => $request->input('product_variant_id')[$key],
                            'model' =>$request->input('model')[$key]
                        ];
                    }
                    //sử dụng relation sync của promotionRepositories 
                    // vì sync k dc thg2 ..cateloge đã thử nhiều cách
                    $promotion->products()->sync($theme);
                }
                else if($request->input('discountMethodProduct') == PromotionEnum::PRODUCTCATELOGEDISCOUNT) {
                    foreach($request->input('product_id') as $key => $item) {
                        $theme[] = [
                            // 'promotion_id' => $promotion->id,
                            'product_cateloge_id' => $item,
                            'model' =>$request->input('model')[$key]
                        ];
                    }
                    $promotion->product_cateloge()->sync($theme);
                }
                    
            }  
            
            DB::commit();   
            return true;
        } catch (Exception $e) {
            DB::rollBack();
            echo new Exception($e->getMessage()); die();
            return false;
        }
    }

    private function handleMakeInfoData($request) {
        $data =  [
            'source' => [
                'status' => $request->input('apply'),
                'data' => $request->input('applyValue')
            ],
            'apply' => [
                'status' => $request->input('Customer'),
                'data' => $request->input('CustomerValue')
            ],
        ];
        if(!is_null($data['apply']['data'])) {
            foreach($data['apply']['data'] as $key => $item) {
                $data['apply']['condition'][$item] = $request->input($item);
            }
        }
       
        return $data;
    }
    
    private function OrderRangeAmount($request) {
        $data['info'] = $request->input('promotion_order');
        return $data + $this->handleMakeInfoData($request) ;
    }

    private function ProductQuanity($request) {
        $data['info'] = $request->input('product_quanity_promotion');
        return $data + $this->handleMakeInfoData($request) ;
    }

    public function update(int $id ,$request)  {
        DB::beginTransaction();
        try {
            $payload = $request->only(['name','code','desc','startDate','endDate','promotionMethod','neverEndDate']);
            $payload['startDate'] = Carbon::createFromFormat('d/m/Y H:i',$payload['startDate']);
            $payload['method'] = $request->input('discountMethodProduct');
            if($request->input('neverEndDate') == null && isset($payload['endDate'])) {
                $payload['endDate'] = Carbon::createFromFormat('d/m/Y H:i',$payload['endDate']);
                $payload['neverEndDate'] = null;
            }
            $payload['maxDiscountValue'] = $request->input(PromotionEnum::EXTREMELYMETHODDISCOUNTPRODUCT.'.price');
            $payload['discountValue'] = $request->input(PromotionEnum::EXTREMELYMETHODDISCOUNTPRODUCT.'.promotion');
            $payload['discountType'] = $request->input(PromotionEnum::EXTREMELYMETHODDISCOUNTPRODUCT.'.type');
            switch($payload['promotionMethod']) {
                case PromotionEnum::ORDERRANGEAMOUNT : 
                    $payload['info'] = $this->OrderRangeAmount($request);
                    break;
                case PromotionEnum::PRODUCTANDQUANITY : 
                    $payload['info'] = $this->ProductQuanity($request);
                    break;
                default : 
                    break;    
            }
            $promotion = $this->promotionRepositories->update($id,$payload);       
            $found = $this->promotionRepositories->findByid($id);
            if($promotion == true && $found->id  > 0) {
                $theme = [];
                $model = $request->input('discountMethodProduct');
                $found->products()->detach();
               
                if(!is_null($request->input('product_id'))) {
                    foreach($request->input('product_id') as $key => $item) {
                        $theme[] = [
                            'product_id' => $item,
                            'product_variant_id' => $request->input('product_variant_id')[$key] ?? 0,
                            'model' => $model
                        ];
                    }
                    $found->products()->sync($theme);
                }
            }
           
            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollBack();
            echo new Exception($e->getMessage());die();
            // return false;
        }
    }

    public function changeStatus($request) {
        DB::beginTransaction();
        try {
            $status = [
                'status' => $request['status'] 
            ];
            $this->promotionRepositories->update($request['id'], $status );  
            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollBack();
            // echo new Exception($e->getMessage());
            return false;
        }
    }

    public function ChangeStatusAll(array $data) {
        DB::beginTransaction();
        try {
            $status = [
                'status' => $data['value']
            ];
          $this->promotionRepositories->UpdateByWhereIn($data['id'],'id',$status) ;

            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollBack();
            echo new Exception($e->getMessage());
            // return false;
        }
    }

    public function destroy($id) {
        DB::beginTransaction();
        try {
            $this->promotionRepositories->deleteSoft($id);  
           
;            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollBack();
            return false;
        }
    } 

}
