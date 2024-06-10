<?php

namespace App\Http\Controllers\Backend\Ajax;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\DistrictRepositoriesInterfaces as DistrictRepositoreis;
use App\Repositories\Interfaces\ProvinceRepositoriesInterfaces as ProvinceRepositories; 
use Illuminate\Http\Request;

class LocationController extends Controller
{
    protected $districtRepositories;
    protected $proinceRepositories;

    public function __construct(ProvinceRepositories $province,DistrictRepositoreis $district)
    {
        $this->proinceRepositories = $province;
        $this->districtRepositories = $district;
    }
    public function getLocation(Request $request) {
        $html = '' ; 
        // dd($request->all());
        if($request->target == 'districts') {
            $province = $this->proinceRepositories->findByid($request->data['location_id'],['code','full_name'],['districts']);
            $html = $this->renderHTML($province->districts);
        }
        else if($request->target == 'wards') {
            $district = $this->districtRepositories->findByid($request->data['location_id'],['code','name'],['Ward']);
            $html = $this->renderHTML($district->Ward,'Chọn huyện / xã');
        }
       
       return response()->json(['data' => $html]);  
    }

    public function renderHTML($data,$title = 'Chọn quận / huyện') {
        $html = '<option selected>'.$title.'</option>';
        foreach($data as $item) {
            // dd($item);
            $html .= '<option value="'.$item->code.'">'.$item->full_name.'</option>';
        }
        return $html;
    }
}
