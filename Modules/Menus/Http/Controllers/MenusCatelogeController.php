<?php

namespace Modules\Menus\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Menus\Entities\MenuCateloge;

class MenusCatelogeController extends Controller
{
    public function index()
    {

        return view('menus::cateloge.index');

    }


    public function getData(Request $request){
        $search = $request->input('search');
        $sort = $request->input('sort','id');
        $order = $request->input('order','desc');
        
        $query = MenuCateloge::query();
        if($search){
            $query->where('name','like','%'.$search.'%');
        }
        $query->orderBy($sort,$order);
        $count = $query->count();
        $rows = $query->get();
        foreach($rows as $row){
            $row->edit_child_url = route('private-system.menus.form',['cateloge' => $row->id]);
        }
        return response()->json(['rows' => $rows , 'total' => $count]);
    }

    public function save(Request $request){
       $this->validateRequest([
        'name' => 'required',
        'keyword' => 'required',
        'status' => 'required'
       ],$request,MenuCateloge::getAttributeName());
       $model = MenuCateloge::firstOrNew(['id' => $request->id]);
       $model->fill($request->all());
       $model->save();

       return response()->json(['message' => 'Thêm dữ liệu thành công','status' => 'success']);
    }   

    public function remove(Request $request){

    }

}
