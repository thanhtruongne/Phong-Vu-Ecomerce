<?php

namespace Modules\Products\Http\Controllers;

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
        if($request->id){

        }
        return view('products::products.form');
    }



}
