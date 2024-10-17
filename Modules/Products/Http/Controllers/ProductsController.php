<?php

namespace Modules\Products\Http\Controllers;

use App\Models\Categories;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

class ProductsController extends Controller
{
    public function index(){
        return view('products::products.index');
    }
    
    public function getData(Request $request){
        return response()->json(['rows' => [] , 'total' =>0]);
    }


    public function form(Request $request){
        $data = Categories::whereNotNull('name')->get()->toTree()->toArray();
        $categories = Categories::rebuildTree($data);
        if($request->id){
           
        }
        return view('products::products.form',['categories' => $categories]);
    }



}
