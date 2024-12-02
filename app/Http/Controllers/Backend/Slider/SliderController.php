<?php
namespace App\Http\Controllers\Backend\Slider;

use App\Enums\Enum\StatusReponse;
use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;
use Carbon\Carbon;
class SliderController extends Controller
{
    public function index(Request $request){
           
        return view('backends.pages.slider.slider');
    }

    public function getData(Request $request) {
        $search = $request->input('search');
        $sort = $request->input('sort','id');
        $order = $request->input('order','desc');
        $offset = $request->input('offset',0);
        $limit = $request->input('limit',20);

        $query = Slider::query();
        $query->whereNotNull('name');
        if($search) {
            $query->where('name','like',$search.'%');
            $query->orWhere('keyword','like',$search.'%');
        }
        $query->orderBy($sort,$order);
        $query->offset($offset);
        $query->limit($limit);
        $count = $query->count();
        $rows = $query->get();
        foreach($rows as $row) {
            $row->edit_url = route('private-system.slider.edit',['id' => $row->id]);
            // $row->created_at = Carbon::createFromFormat('d/m/Y H:i:s',$row->created_at);
        } 
        return response()->json(['rows' => $rows,'count' => $count]);
    }

    public function save(Request $request) {
        $this->validateRequest([
            'name' => 'required',
            'keyword' => 'required',
            'content' => 'required',
            'slider' => 'required'
        ],$request,Slider::getAttributeName());
        $model = Slider::firstOrNew(['id' => $request->id]);
        $model->fill($request->all());
        $item = [];
        $slider = $request->slider;
        foreach($slider['thumbnail'] as $key => $value) {
            $item[] = [
                'image' => $value,
                'content' => $slider['desc'][$key],
                'url' => $slider['canonical'][$key]
            ];
        }
        $model->item = $item;
        if($model->save()){
           return response()->json(['status' => StatusReponse::SUCCESS,'message' => trans('admin.message_success'),'redirect' => route('private-system.slider')]);
        }
        return response()->json(['status' => StatusReponse::ERROR,'message' => trans('admin.message_error')]);
    
    }



    public function remove(Request $request) {

    }

    public function form(Request $request,$id = null) {
        $model = Slider::firstOrNew(['id' => $id]);
        return view('backends.pages.slider.form',['model' => $model]);
    }
}
