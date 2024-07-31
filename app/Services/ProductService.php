<?php
namespace App\Services;

use App\Repositories\AttributeCatelogeRepositories;
use App\Repositories\AttributeRepositories;
use App\Repositories\ProductRepositories;
use App\Repositories\ProductVariantAttributeRepositories;
use App\Repositories\ProductVariantsRepositories;
use App\Repositories\ProductVariantTranslateRepositories;
use App\Repositories\PromotionRepositories;
use App\Repositories\RouterRepositories;
use App\Services\Interfaces\ProductCatelogeServiceInterfaces as ProductCatelogeService;
use App\Services\Interfaces\ProductServiceInterfaces;
use App\Trait\UploadImage;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Exception;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
class ProductService extends BaseService implements ProductServiceInterfaces
{
    protected 
     $productRepositories,
     $productVariantAttributeRepositories , 
     $productVariantTranslateRepositories,
     $promotionRepositories,
     $productVariantsRepositories,
     $attributeCatelogeRepositories,
     $attributeRepositories,
     $productCatelogeService;

    public function __construct(
            ProductRepositories $productRepositories,
            AttributeCatelogeRepositories $attributeCatelogeRepositories,
            AttributeRepositories $attributeRepositories,
            ProductVariantAttributeRepositories $productVariantAttributeRepositories,
            ProductVariantsRepositories $productVariantsRepositories,
            PromotionRepositories $promotionRepositories,
            ProductVariantTranslateRepositories $productVariantTranslateRepositories,
            ProductCatelogeService $productCatelogeService
        ) 
         {
            $this->productRepositories = $productRepositories;
            $this->attributeRepositories = $attributeRepositories;
            $this->attributeCatelogeRepositories = $attributeCatelogeRepositories;
            $this->productVariantsRepositories = $productVariantsRepositories;
            $this->productVariantAttributeRepositories = $productVariantAttributeRepositories;
            $this->productVariantTranslateRepositories = $productVariantTranslateRepositories;
            $this->promotionRepositories = $promotionRepositories;
            $this->productCatelogeService = $productCatelogeService;
            parent::__construct();
        }
    public function paginate($request,$ProductCateloge = null,string $variant = '',string $promotion = '') 
    {
        $condition = [];
        $condition['search'] = $request->search ?? '';
        $record = $request->input('record') ?: 14;
        if($request->has('status')){
            $condition['where'] = [
                ['status','=',$request->status],
              ];
        }
       

        $products = $this->productRepositories->paganation(
        $this->getPaginateIndex(),
        $condition,
        //sử dụng mảng 4 để load join vào table
        [
            ['product_cateloge_product as pcsp','product.id','=','pcsp.product_id'],
           
        ],
        $record,
        $this->getPaginateIndex(),
        ['product_variant'],[],$this->whereRawCondition($request,$ProductCateloge) ?? []);
        if($products && $variant =='variant' && $promotion == 'promotion'){
           foreach($products as $key => $product){
                $product_variant_id = $product->product_variant->pluck('id')->toArray() ?? []; 
                if(!empty($product_variant_id)) {
                    $product->variant = $this->CombineArrayProductHavePromotionByWhereIn($product_variant_id,$product->product_variant,'variant'); 
                }      
            }  
        }
        return $products;
    }

    public function create($request) {
        DB::beginTransaction();
        try {
            $product = $this->createProductService($request); 
            if($product->id > 0)  {
                $catalogeSublist = $this->handleProductCataloge($request); 
                $product->product_cateloge_product()->sync($catalogeSublist);
                $this->createRouter($request->input('canonical'),$product,'ProductController');
                if(!empty($request->input('attribute')) && !empty($request->input('productVariants')) && !empty($request->input('variants'))) {
                    //tạo các product_variant
                    $this->createProductVariant($product , $request,'create');     
                }
                // set attribute
                $this->productCatelogeService->OverrideAttribute($product); 
            }
            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollBack();
            echo new Exception($e->getMessage()); die();
            // return false;
        }
    }

    public function update(int $id ,$request) {
        DB::beginTransaction();
        try {
            $check = $this->updateProductService($request,$id);  
            $product = $this->productRepositories->findByid($id);      
            if($check) {       
                //tạo lại product_catelgoe_product
                $product->product_cateloge_product()->detach($product->id);
                // ta sẽ xóa các variant tồn tại trong product này sau dó tạo lại bảng3 mới
                $product->product_variant()->delete();
                $catalogeSublist = $this->handleProductCataloge($request); 
                $product->product_cateloge_product()->sync($catalogeSublist);
                //tạo lại variant
                $this->createProductVariant($product,$request,'update');
                // set attribute
                $this->productCatelogeService->OverrideAttribute($product); 
               
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
            $this->productRepositories->update($request['id'], $status );  
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
          $this->productRepositories->UpdateByWhereIn($data['id'],'id',$status) ;

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
            $this->productRepositories->deleteSoft($id);  
            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollBack();
            return false;
        }
    }

    public function restore(int $id) {
        DB::beginTransaction();
        try {
            $this->productRepositories->restore($id);  
            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollBack();
            return false;
        }
    }

    public function deleteForce(int $id) {
        DB::beginTransaction();
        try {
            $this->productRepositories->deleteForce($id);  
            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollBack();
            return false;
        }
    }
    
    private function handleProductCataloge($request) {
        return array_unique(array_merge($request->categories_sublist ?? [],[$request->product_cateloge_id]));
    }

    private function requestOnlyProductCataloge() {
        return ['follow','status','image','product_cateloge_id','attribute','variants','attributeCateloge','album','code_product','form','price'
     ,'name','desc','content','meta_title','meta_desc','meta_keyword','canonical'
    ];
    }

    private function getPaginateIndex() {
        // return ['status','image','pct.name','id','pcp.product_id','pcp.product_cateloge_id'];
        return ['image','status','id','product.product_cateloge_id','price','code_product',
    'name','desc','content','meta_title','meta_desc','meta_keyword','canonical'
    ];
    }

    private function whereRawCondition($request,$ProductCateloge = null) {
      
        if(($request->integer('categories') > 0 && $request->input('categories') != 'none') || !is_null($ProductCateloge) ) {
            $id = $request->integer('categories') > 0 ? $request->integer('categories')  : $ProductCateloge['id'];
            return [
                [
                    'pcsp.product_cateloge_id IN (
                        SELECT  id  FROM product_cateloge 
                        WHERE `LEFT` >= (SELECT `LEFT` from product_cateloge as cat  where cat.id = ?)
                        AND `RIGHT` <= (SELECT `RIGHT` from product_cateloge as cat  where cat.id = ?)
                    )',
                    [$id ,$id]
                ]
            ];
        }
    }

    private function createProductService($request) {;
        $data = $request->only($this->requestOnlyProductCataloge());
        $data['album'] = !empty($request->input('album')) ? json_encode($request->input('album')) : '';
        $data['attribute'] = !empty($request->input('attribute')) ? json_encode($data['attribute']) : null;
        $data['attributeCateloge'] = !empty($request->input('attributeCateloge')) ? json_encode($data['attributeCateloge']) : null;
        $data['variant'] = !empty($request->input('variants')) ? json_encode($data['variants']) : null;
        $data['canonical'] = Str::slug($data['canonical']);
        $product = $this->productRepositories->create($data);  
        return $product;
    }

    
    private function updateProductService($request,$id) {
        $data = $request->only($this->requestOnlyProductCataloge()); 
        $data['album'] = json_encode($request->input('album')) ?? '';
        $data['attribute'] = !empty($request->input('attribute')) ? json_encode($data['attribute']) : null;
        $data['attributeCateloge'] = !empty($request->input('attributeCateloge')) ? json_encode($data['attributeCateloge']) : null;
        $data['variant'] = !empty($request->input('variants')) ? json_encode($data['variants']) : null;
        $data['canonical'] = Str::slug($data['canonical']);

        $check = $this->productRepositories->update($id,$data);
        
        return $check;
    }

    private function createProductVariant($product ,$request,$type = 'create') {
        $data = $request->only(['variants','productVariants','attribute']);
        $array = $this->createArrayDataProductVariants($data);
        $variants =  $product->product_variant()->createMany($array); 
        $product_vartiant_attribute = [];

    $productVariantAttribute =  $this->makeCombineAttribute(array_values($data['attribute']));
        foreach($product->product_variant()->pluck('id') as $key => $val) {
            
            if(count($productVariantAttribute)) {
               foreach($productVariantAttribute[$key] as $item) {
                    $product_vartiant_attribute[] = [
                        'product_variant_id' => $val ,
                        'attribute_id' => $item
                    ];
               }
            }
        }
        $this->productVariantAttributeRepositories->createByInsert($product_vartiant_attribute);
        // $this->productVariantTranslateRepositories->createByInsert($product_variant_translate);

    }


    //sử dũng đệ qui
    private function makeCombineAttribute($attributes , int $index = 0 ) {
        //dieu92 kiện thoát đệ qui
        if(count($attributes) == $index) return [[]];
       
        //gọi lại chính nó 
        $subCombine = $this->makeCombineAttribute($attributes , $index + 1);
        $combine = [];
       
        foreach($attributes[$index] as $key => $val) {
            
            foreach( $subCombine as $keySub => $item) {
               $combine[] = array_merge([$val], $item);
            }
        }
        // sau khi merge xong gọi lại hàm để merge mảng3 tiếp
        return $combine;
    }

    private function createArrayDataProductVariants(array $data = []):array 
    {
        $variants = [];
        if(isset($data['variants']['sku']) && !empty($data['variants']['sku'])) {
            foreach($data['variants']['sku'] as $key => $val) {
              
                $sorting = array_map('intval', explode(', ',$data['productVariants']['id'][$key]));
                sort($sorting,SORT_NUMERIC);
                // dd($data['productVariants']['id'][$key],$sorting);
                $variants[] = [
                    'qualnity' => $data['variants']['qualnity'][$key] ?? 0,
                    'price' => $data['variants']['price'][$key] ?? 0,
                    'sku' => $data['variants']['sku'][$key] ?? '',
                    'code' => implode(', ',$sorting) ?? 0,
                    'barcode' => $data['variants']['code'][$key] ?? '',
                    'file_name' => $data['variants']['file_name'][$key] ?? '',
                    'file_url' => $data['variants']['file_url'][$key] ?? '',
                    'album' => $data['variants']['album'][$key] ?? '',
                     'name' => $data['productVariants']['name'][$key] ?? ''
                ];
            }
        }
        return $variants;
    }


    public function CombineArrayProductHavePromotionByWhereIn(array $id = [] , $products,string $subject = 'product') {
        //tìm các promotion chứa các product
        if($subject == 'product') $promotions = $this->promotionRepositories->findByProductPromotion($id);
        else if($subject == 'variant') $promotions = $this->promotionRepositories->getProductVariantPromotion($id);
        //gán từng promotion vào product chứa các id
        // dd($products,$promotions);
        // dd($promotions);
        foreach($products as $key => $product) {
            foreach($promotions as $index => $promo) {
                
                if($subject === 'product' && $promo['product_id'] === $product->id) {
                  
                    $products[$index]->promotions = $promo;
                }
                if($subject === 'variant' && $promo['product_variant_id'] === $product->id) {

                   $products[$index]->promotions = $promo; 
               
                }       
            }
        }
        
        return $products;
    }   


    public function getAttribute($product) {
        //lấy các attribute cateloge
        $attributeJson = json_decode($product->attribute,true);
        $attributeCatelogeId = array_keys($attributeJson);
        $attributeCateloge = $this->attributeCatelogeRepositories->findCondition(
            [
                ['status','=',1]
            ],
            [
                'whereIn' => 'id',
                'whereValues' => $attributeCatelogeId
            ],
            [],'multiple',[]
        );
        $attributeId = array_merge(...$attributeJson);
        $attribute = $this->attributeRepositories->getAttributeByWhereIn($attributeId);
       
     
        foreach($attributeCateloge as $key => $attribute_cateloge) {
            $temp =[];
            foreach($attribute as $index => $attribute_attribute) {
                  if($attribute_attribute->attribute_cateloge_id == $attribute_cateloge->id ) {
                    $temp[] = $attribute_attribute;
                  }
            }
           $attribute_cateloge->object = $temp;
        }
        return $attributeCateloge;
    }

    public function ComplieCartService($carts) {
       $cartID = $carts->pluck('id');
     
       $data = [];
       $obj = [];
       if(!is_null($cartID)) {
           foreach($cartID as $cart_id) {
            // dd(explode('_',$cart_id));
               if(count(explode('_',$cart_id)) == 2) {
                  $data['variant'][] = explode('_',$cart_id)[1];
               } 
               else {
                $data['product'][] = explode('_',$cart_id)[0];
               }
            }
       }
       if(isset($data['variant'])) {
         $obj['variant'] = $this->productVariantsRepositories->findCondition(
            [['status','=',1]],['whereIn' => 'id','whereValues' => $data['variant']],[],'multiple',[])->keyBy('id');
       }
       if(isset($data['product'])) {
        $obj['product'] = $this->productRepositories->findCondition(
            [['status','=',1]],['whereIn' => 'id','whereValues' => $data['product']],[],'multiple',[])->keyBy('id');
       }    
       $total = 0;
    //    dd($carts);
       foreach($carts as $key => $cart) {
            $item = explode('_',$cart->id);
            $obj_id = $item[1] ?? $item[0];
            if(isset($obj['variant'][$obj_id])) {
              $variant_item = $obj['variant'][$obj_id];
              $slug = $this->gettingSlugCanonical($variant_item->name);
              $url = config('apps.apps.url').'/'.Str::slug($variant_item->product->name);
              $cart->thumb = explode(',',$variant_item->album)[0];
              $cart->price_previous = $variant_item->price;
              $cart->sku = $variant_item->sku;
              $cart->canonical = $url.'---'.$slug.'?sku='.$variant_item->sku;
              $cart->quantity = $cart->qualnity;
              $total += ($cart->options->priceSale ?? $cart->price) * $cart->qty;
            }
            else if(isset($obj['product'][$obj_id])) {
                $variant_item = $obj['product'][$obj_id];
                $cart->thumb = $variant_item->image;
                $cart->price_previous = $variant_item->price;
                $cart->quantity = $cart->qualnity;  
                $cart->sku = $variant_item->code_product;
                $cart->canonical = config('apps.apps.url').'/'.$variant_item->canonical;
                $total += ($cart->options->priceSale ?? $cart->price) * $cart->qty;
            }
       }
       $carts->total = $total;
       $carts->itemCount = count($carts);
       return $carts;
       
    }

    private function gettingSlugCanonical($slug) {
        if(is_null($slug)) return false;
        $data = [];
        foreach(explode(', ',$slug) as $item) {
            $data[] = Str::slug($item);
        }

        $data = implode('--',$data);
        return $data;
    }

}
