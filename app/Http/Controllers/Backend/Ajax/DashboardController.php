<?php

namespace App\Http\Controllers\Backend\Ajax;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DashboardController extends Controller

{

   public function __construct()
   {

   }
   public function changeStatus(Request $request) {

      $data = $request->input();
      $instance = $this->handleMadeClass('Services','Service',$data['model']);
      if($instance->changeStatus($data)) {
        return response(['status' => 'success' , 'message' => 'Cập nhật thành công']);
      }
      else return response(['status' => 'error' , 'message' => 'Có lỗi xảy ra']);
   }

   public function changeStatusAll(Request $request) {
      $data = $request->input();
      $instance = $this->handleMadeClass('Services','Service',$data['model']);
      if($instance->ChangeStatusAll($data)) {
        return response(['status' => 'success' , 'message' => 'Cập nhật thành công']);
      }
      else return response(['status' => 'error' , 'message' => 'Có lỗi xảy ra']);
   }

   public function getModelWidgetSearch(Request $request) {
      $instance = $this->handleMadeClass('Repositories','Repositories',$request->input('model'));
      $find = $instance->findCondition([
         ['name','like','%'.$request->input('keyword').'%']
      ],[],[],'multiple',[]);
      foreach($find as $key => $val) {
         $data[] =  [
            'id' => $val->id,
            'name' => $val->name,
            'image' => $val->image,
            'canonical' => $val->canonical
         ];
      }
      return $data ?? [];
   }

   //sale
   public function makeDataGetByClassPromotion(Request $request) {
      $instance = $this->handleMadeClass('Repositories','Repositories',$request->input('model'));
      $payload = $instance->all();
      $data = [];
      if(count($payload) > 0) {
         foreach($payload as $key => $item) {
            $data[] = [
               'name' => $item->name,
               'id' => $item->id
            ];
         }
      }
      return $data;
   }

   public function makePromotionCustomerCateloge(Request $request) {
      $name  = $request->input('name');
      $label =  $request->input('label');
      // dd($type,array_pop($type));
      $payload = [];
      if(!is_null($name)) {     
         $payload[$label] = $this->SwitchCasePromotionType($name);
      }
      return $payload;
    
   }


   // load variant
   public function loadProductVariant(Request $request) {
      dd($request->all());
   }

   private function SwitchCasePromotionType(string $type = '') {
         $data = '';
         switch($type) {
               case 'staff_take_care' : 
                     $instance = $this->handleMadeClass('Repositories','Repositories','User');
                    $data =  $instance->all()->toArray();
                  break;
               case 'customer_group' : 
                     $instance = $this->handleMadeClass('Repositories','Repositories','CustomerCateloge');
                     $data =  $instance->all()->toArray();
                  break;
               case 'customer_birthday' : 
                  $data= __('model.day');
                  break;
               case 'customer_gender' : 
                  $data =  __('model.gender');
                  break;
               default : 
                  break;
         }
         $payload = [];
         if(!empty($data) && count($data) > 0) {
            foreach($data as $key => $val) {
               $payload[] = [
                  'name' => $val['name'],
                  'id' => $val['id']
               ];
            }
         }
         return $payload;
   }

   private function handleMadeClass(string $app = '',string $dot = '',string $model = '') {
      $nameSpace = "\App\\".$app.'\\'.ucfirst($model).$dot;
      if(class_exists($nameSpace)) {
         $instance = app($nameSpace);
      }
      return $instance;
   }


}
