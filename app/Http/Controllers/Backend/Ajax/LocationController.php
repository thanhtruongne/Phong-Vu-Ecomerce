<?php

namespace App\Http\Controllers\Front\Ajax;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function getLocation(Request $request) {
        $html = '' ; 
       
        if($request->target == 'districts') {
            $province = $this->proinceRepositories->findByid($request->data['location_id'],['code','full_name'],['districts']);
            $html = $this->renderHTML($province->districts);
        }
        else if($request->target == 'wards') {
            $district = $this->districtRepositories->findByid(
                isset($request->data['district_id']) ? $request->data['district_id'] : $request->data['location_id']
                ,['code','name'],['Ward']);
            $html = $this->renderHTML($district->Ward,'Chọn huyện / xã');
        }
       
       return response()->json(['data' => $html]);  
    }

    public function renderHTML($data,$title = 'Chọn quận / huyện') {
        $html = '<option selected value="none">'.$title.'</option>';
        foreach($data as $item) {
            // dd($item);
            $html .= '<option value="'.$item->code.'">'.$item->full_name.'</option>';
        }
        return $html;
    }
}
