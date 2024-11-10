<?php

namespace Modules\Menus\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
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
            'menu_cateloge_id' => 'required'
        ],$request,[
            'menu_cateloge_id' => 'Danh mục menus'
        ]);

        $menu = $request->input('menu');
        

        

    }
}
