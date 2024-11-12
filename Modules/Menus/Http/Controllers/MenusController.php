<?php

namespace Modules\Menus\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Menus\Entities\Menu;
use Modules\Menus\Entities\MenuCateloge;

class MenusController extends Controller
{
    public function form(Request $request){
        $menu_cateloge = MenuCateloge::find($request->cateloge);
        return view('menus::form',['model' => $menu_cateloge]);
    }

    public function create(){
        $menu_cateloge = MenuCateloge::whereNotNull('name')->where('status',1)->get();
        return view('menus::create',['menu_cateloge' => $menu_cateloge]);
    }

    public function save(Request $request){
        $this->validateRequest([
            'menu_cateloge_id' => 'required',
            'menu' => 'required'
        ],$request,[
            'menu_cateloge_id' => 'Danh mục menus',
            'menu' => 'Menus sản phẩm'
        ]);

        $menus = $request->input('menu');
        $data = [];
        foreach($menus['url'] as $key => $menu){
            if( Menu::where('url','=',$menu)->orWhere('name',$menus['name'][$key])->exists()){
               return response()->json(['message' => 'URL hoặc tên menus trùng với data menu','status' => 'error']);
            }
            if(!str_contains($menu,'/')) {
                return response()->json(['message' => 'URL '.$menu.' không hợp lệ','status' => 'error']);
            }
            $data[] = [
                'menu_cateloge_id' => $request->menu_cateloge_id,
                'name' => $menus['name'][$key],
                'image' => $menus['image'][$key],
                'status' => 1,
                'url' => $menu
            ];
        }
        if($data && is_array($data)){
            foreach($data as $item){
                // tạo dạng này --> khởi tạo nestedset
               $model = new Menu();
               $model->fill($item);
               $model->save();
            }
            return response()->json(['message' => 'Tạo dữ liệu thành công','status' => 'success','redirect' => route('private-system.menus.cateloge.children',['id' => $request->menu_cateloge_id])]);
        }
        return response()->json(['message' => 'Có lỗi xảy ra','status' => 'error']);
       

    }

    public function childSave(Request $request){
       $this->validateRequest([
        'value' => 'required'
       ],$request,[
        'value' => 'Menu child'
       ]);
       $menus = json_decode($request->input('value'),true);
       \DB::beginTransaction();
       try {
            $item = $this->childDynamicSave($menus,null);
            \DB::commit();
            if($item) {
                return response()->json(['message' => 'Lưu dữ liệu thành công','status' => 'success']);
            }
       }catch (\Throwable $th) {
          \DB::rollBack();
          throw $th;
       } 
     
    }


    
    private function childDynamicSave($data,$parent_id = null){
        if(is_array($data) && count($data)) {
            foreach($data as $key => $val) {
                $node = Menu::find($val['id']);
                $node->parent_id = $parent_id ?? null;
                $node->save();
                if(!empty($val['children']) && count($val['children'])) {
                    self::childDynamicSave($val['children'],$val['id']);
                }
            }   
        }
        return true;
    }
}
