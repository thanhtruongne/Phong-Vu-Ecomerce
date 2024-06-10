<?php
namespace App\Services;

use App\Repositories\LanguageRepositories;
use App\Repositories\ProductRepositories;
use App\Repositories\ProductVariantAttributeRepositories;
use App\Repositories\ProductVariantsRepositories;
use App\Repositories\ProductVariantTranslateRepositories;
use App\Repositories\PromotionRepositories;
use App\Repositories\RouterRepositories;
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
     $languageRepositories ,
     $productVariantAttributeRepositories , 
     $productVariantTranslateRepositories,
     $promotionRepositories,
     $productVariantsRepositories;

    public function __construct(
            ProductRepositories $productRepositories,
            LanguageRepositories $languageRepositories,
            RouterRepositories $routerRepositories,
            ProductVariantAttributeRepositories $productVariantAttributeRepositories,
            ProductVariantsRepositories $productVariantsRepositories,
            PromotionRepositories $promotionRepositories,
            ProductVariantTranslateRepositories $productVariantTranslateRepositories
        ) 
         {
            $this->productRepositories = $productRepositories;
            $this->productVariantsRepositories = $productVariantsRepositories;
            $this->languageRepositories = $languageRepositories;
            $this->productVariantAttributeRepositories = $productVariantAttributeRepositories;
            $this->productVariantTranslateRepositories = $productVariantTranslateRepositories;
            $this->promotionRepositories = $promotionRepositories;
            parent::__construct($routerRepositories);
        }
    public function paginate($request) 
    {
        $condition = [];
        $condition['search'] = $request->search ?? '';
        $record = $request->input('record') ?: 6;
        $condition['where'] = [
          ['pct.languages_id' ,'=',$this->languageRepositories->getCurrentLanguage()->id], 
          ['status','=',$request->status ?? 1],
        ];

        $product = $this->productRepositories->paganation(
        $this->getPaginateIndex(),
        $condition,
        //sử dụng mảng 4 để load join vào table
        [
            ['product_translate as pct' , 'pct.product_id','=','product.id'],
            ['product_cateloge_product as pcsp','product.id','=','pcsp.product_id'],
           
        ],
        $record,
        $this->getPaginateIndex(),
        [],[],$this->whereRawCondition($request) ?? []
        );
        // dd($post);
       return $product;
    }


    public function create($request) {
        DB::beginTransaction();
        try {
            $product = $this->createProductService($request);
            if($product->id > 0)  {
                $this->createTranslatePivotProductService($request,$product);
                $this->createRouter($request->input('meta_link'),$product,'ProductController',$this->languageRepositories->getCurrentLanguage()->id);
                
                //tạo các product_variant
                $this->createProductVariant($product , $request , $this->languageRepositories->getCurrentLanguage()->id);
            }
            DB::commit();
            return true;
        } catch (Exception $e) {
            // DB::rollBack();
            echo new Exception($e->getMessage()); die();
            // return false;
        }
    }

    public function update(int $id ,$request) {
        DB::beginTransaction();
        try {
            $product = $this->productRepositories->findByid($id);      
            $check = $this->updateProductService($request,$product);    
            if($check == true) {
                $this->updateProducTranslatetService($request,$product);
                $product->product_variant()->each(function($variant) {
                     dd(123);
                    $variant->languages()->detach();
                    $variant->attributes()->detach();
                    $variant->delete();
                });
                $this->createProductVariant($product,$request,$this->languageRepositories->getCurrentLanguage()->id);
            }
            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollBack();
            echo new Exception($e->getLine());die();
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
        return ['follow','status','image','product_cateloge_id','attribute','variants','attributeCateloge','album','code_product','form','price'];
    }
    private function requestOnlyProductCatalogeTranslate() {
        return ['language_id','name','desc','content','meta_title','meta_desc','meta_keyword','meta_link'];
    }

    private function getPaginateIndex() {
        // return ['status','image','pct.name','id','pcp.product_id','pcp.product_cateloge_id'];
        return ['pct.name','product.image','product.status','product.id','product.product_cateloge_id'];
    }

    private function whereRawCondition($request) {
        if($request->integer('categories') > 0 && $request->input('categories') != 'none' ) {
            return [
                [
                    'pcsp.product_cateloge_id IN (
                        SELECT pc.id  FROM product_cateloge 
                        WHERE `LEFT` >= (SELECT `LEFT` from product_cateloge as cat  where cat.id = ?)
                        AND `RIGHT` <= (SELECT `RIGHT` from product_cateloge as cat  where cat.id = ?)
                    )',
                    [$request->integer('categories'),$request->integer('categories')]
                ]
            ];
        }
    }

    private function createProductService($request) {;
        $data = $request->only($this->requestOnlyProductCataloge());
        $data['album'] = !empty($request->input('album')) ? json_encode($request->input('album')) : '';
        $data['user_id'] = Auth::user()->id;
        $data['attribute'] = !empty($request->input('attribute')) ? json_encode($data['attribute']) : '';
        $data['attributeCateloge'] = !empty($request->input('attributeCateloge')) ? json_encode($data['attributeCateloge']) : '';
        $data['variant'] = !empty($request->input('variants')) ? json_encode($data['variants']) : '';
        $product = $this->productRepositories->create($data);  
        return $product;
    }

    private function createTranslatePivotProductService($request,$product) {
        $payloadTranslate = $request->only($this->requestOnlyProductCatalogeTranslate());
        $payloadTranslate['languages_id'] = $this->languageRepositories->getCurrentLanguage()->id;
        $payloadTranslate['product_id'] = $product->id;
        $payloadTranslate['meta_link'] = Str::slug($payloadTranslate['meta_link']);
        $translate = $this->productRepositories->createTranslatePivot($product,$payloadTranslate,'languages');
        $catalogeSublist = $this->handleProductCataloge($request); 
        $product->product_cateloge_product()->sync($catalogeSublist);
    }
    
    private function updateProductService($request,$product) {
        $data = $request->only($this->requestOnlyProductCataloge()); 
        $data['album'] = json_encode($request->input('album')) ?? $product->album;
        $data['user_id'] = Auth::user()->id;
        $check = $this->productRepositories->update($product->id,$data);
        return $check;
    }

    private function updateProducTranslatetService($request,$product) {
        $payloadTranslate = $request->only($this->requestOnlyProductCatalogeTranslate());
        $payloadTranslate['languages_id'] = $this->languageRepositories->getCurrentLanguage()->id;
        $payloadTranslate['product_id'] = $product->id;
        $payloadTranslate['meta_link'] = Str::slug( $payloadTranslate['meta_link']);
        // tách ra khỏi bảng trung gian
        $detach = $product->languages()->detach([ $payloadTranslate['languages_id'],$product->id]);
        // tạo bảng mới trug gian ghi đè 
        $translate = $this->productRepositories->createTranslatePivot($product,$payloadTranslate,'languages'); 
        $catalogeSublist = $this->handleProductCataloge($request); 
        $product->product_cateloge_product()->sync($catalogeSublist);
    }

    private function createProductVariant($product ,$request , $language_id) {
        $data = $request->only(['variants','productVariants','attribute']);
        $array = $this->createArrayDataProductVariants($data);
        // ta sẽ xóa các variant tồn tại trong product này sau dó tạo lại bảng3 mới
        $variants =  $product->product_variant()->createMany($array);
        $product_vartiant_attribute = [];
        $product_variant_translate = [];
        //     5 => array:2 [▼
    //     0 => "8"
    //     1 => "9"
    //   ]
    //   3 => array:2 [▼
    //     0 => "6"
    //     1 => "4"
    //   ]
    // ]
    //sắp xếp ra = đệ qui thành ex : [ [6,8], [6,9] ,[4,8] ,[4,9] ]
    $productVariantAttribute =  $this->makeCombineAttribute(array_values($data['attribute']));
        foreach($variants->pluck('id') as $key => $val) {
           
            $product_variant_translate[] = [
                'product_variant_id' => $val ,
                'languages_id' => $language_id,
                'name' => $data['productVariants']['name'][$key] 
            ];
            
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
        $this->productVariantTranslateRepositories->createByInsert($product_variant_translate);

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
                $variants[] = [
                    'qualnity' => $data['variants']['qualnity'][$key] ?? 0,
                    'price' => $data['variants']['price'][$key] ?? 0,
                    'sku' => $data['variants']['sku'][$key] ?? '',
                    'code' => $data['productVariants']['id'][$key] ?? 0,
                    'barcode' => $data['variants']['code'][$key] ?? '',
                    'file_name' => $data['variants']['file_name'][$key] ?? '',
                    'file_url' => $data['variants']['file_url'][$key] ?? '',
                    'album' => $data['variants']['album'][$key] ?? '',
                    'user_id' => Auth::user()->id
                ];
            }
        }
        return $variants;
    }


    public function CombineArrayProductHavePromotionByWhereIn(array $id = [] , $products) {
        //tìm các promotion chứa các product
        $promotions = $this->promotionRepositories->findByProductPromotion($id);
       
        //gán từng promotion vào product chứa các id
        foreach($products as $key => $product) {
            foreach($promotions as $index => $promo) {
                if($promo['product_id'] == $product->id) {
                    $products[$key]->promotions = $promo;
                }
            }
        }
        return $products;
    }

}
