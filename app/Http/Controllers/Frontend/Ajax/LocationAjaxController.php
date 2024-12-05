<?php

namespace App\Http\Controllers\Frontend\Ajax;

use App\Http\Controllers\Controller;
use App\Models\District;
use App\Models\Province;
use App\Models\Ward;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class LocationAjaxController extends Controller
{
   
    public function getProvinces(Request $request) {
        $search = $request->search;
        $query = Province::query();
        $query->select('code as id', 'name AS text');
        if ($search) {
          $query->where('name', 'like',  $search .'%');
        }
        $query->orderBy('code', 'ASC');
        $result = $query->paginate(10);
        if ($result->nextPageUrl()) {
            $data['pagination'] = ['more' => true];
        }
        $data['results'] = $result->getCollection();
        return json_result($data); 
    }

    public function getLocation(Request $request) {
        $html = '' ; 
        if($request->target == 'districts') {
            $districts = District::where('province_code',$request->data['location_id'])->get(['code','full_name']);
            $html = $this->renderHTML($districts);
        }
        else if($request->target == 'wards') {
            $wards = Ward::where('district_code',$request->data['location_id'])->get(['code','full_name']);
            $html = $this->renderHTML($wards,'Chọn huyện / xã');
        }
       
       return response()->json(['data' => $html]);  
    }

    public function renderHTML($data,$title = 'Chọn quận / huyện') {
        $html = '<option selected value="none">'.$title.'</option>';
        foreach($data as $item) {
            $html .= '<option value="'.$item->code.'">'.$item->full_name.'</option>';
        }
        return $html;
    }
}
