<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCustomerCateloge;
use App\Http\Requests\UpdateCustomerCateloge;
use App\Repositories\CustomerCatelogeRepositories;
use App\Repositories\CustomerRepositories;
use App\Repositories\Interfaces\ProvinceRepositoriesInterfaces as ProvinceRepositoreis;
use App\Services\Interfaces\CustomerCatelogeServiceInterfaces as CustomerCatelogeService;
use Carbon\Carbon;
use Illuminate\Http\Request;



class CustomerCatelogeController extends Controller
{

    protected $customerCatelogeServices;
    protected $provinceRepositories;
    protected $customerRepositories;

    protected $customerCatelogeRepositories;

    public function __construct(
        CustomerCatelogeService $customerCatelogeServices,
        ProvinceRepositoreis $province,
        CustomerRepositories $customerRepositories,
        CustomerCatelogeRepositories $customerCatelogeRepositories
        )
    {
        $this->customerCatelogeServices = $customerCatelogeServices;
        $this->provinceRepositories = $province;
        $this->customerRepositories  = $customerRepositories;
        $this->customerCatelogeRepositories = $customerCatelogeRepositories;
    }
    public function index(Request $request) 
    {
        $customerCateloge = $this->customerCatelogeServices->paginate($request);
        $filter = config('apps.search');
        $config = [
            'links_link' => [
                'https://cdnjs.cloudflare.com/ajax/libs/switchery/0.8.2/switchery.css'
            ],
            'js_link' => [
                'https://cdnjs.cloudflare.com/ajax/libs/switchery/0.8.2/switchery.js'
            ]
        ];
        return view('backend.Page.Customer.Cateloge.index',compact('customerCateloge','filter','config'));
    }
  
    public function create() {
        $provinces = $this->provinceRepositories->all();
        $customerCateloge = $this->customerCatelogeRepositories->all();
        $config = [
                'links_link' => [
                    'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css',
                   
                    ''
                ],
                'link' => [
                    'backend/css/plugins/dropzone/dropzone.css',
                    'backend/css/plugins/jasny/jasny-bootstrap.min.css'
                ],
                'js_link' => [
                    'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js',
                    'https://cdn.jsdelivr.net/momentjs/latest/moment.min.js',
            
                ],
                'js' => [
                    'backend/library/location.js',
                    'backend/js/plugins/dropzone/dropzone.js',
                    'backend/js/plugins/jasny/jasny-bootstrap.min.js',
                    'backend/library/location.js'
                ]
            ];
        return view('backend.Page.Customer.Cateloge.create',compact('config','provinces','customerCateloge'));
    }
    
    public function store(StoreCustomerCateloge $request) {
        if($this->customerCatelogeServices->create($request) == true) {
            return redirect()->route('private-system.management.customer.cateloge')->with('success','Tạo nhóm khách hàng thành công');
        }
        return redirect()->route('private-system.management.customer.cateloge')->with('error','Có lỗi đã xảy ra');
    }

    public function edit(int $id) {
        $customerCateloge = $this->customerCatelogeRepositories->findByid($id);
        $config = [
                'links_link' => [
                    'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css',
                   
                ],
                'link' => [
                    'backend/css/plugins/dropzone/dropzone.css',
                    'backend/css/plugins/jasny/jasny-bootstrap.min.css'
                ],
                'js_link' => [
                    'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js',
                    'https://cdn.jsdelivr.net/momentjs/latest/moment.min.js',
                
                ],
                'js' => [
                    'backend/library/location.js',
                    'backend/js/plugins/dropzone/dropzone.js',
                    'backend/js/plugins/jasny/jasny-bootstrap.min.js',
                    'backend/library/location.js'
                ]
            ];
        return view('backend.Page.Customer.Cateloge.edit',compact('config','customerCateloge'));
    }

    public function update(int $id, UpdateCustomerCateloge $request) { 
        if($this->customerCatelogeServices->update($id,$request) == true) {
            return redirect()->route('private-system.management.customer.cateloge')->with('success','Cập nhật nhóm khách hàng thành công');
        }
        return redirect()->route('private-system.management.customer.cateloge')->with('error','Có lỗi đã xảy ra');
    }

    // public function delete(int $id) {
        
    //     if($this->customerCatelogeServices->deleteSoft($id) == true) {
    //         return response(['status' => 'success','message' => 'Xóa thành công']);
    //     }
    //     return response(['status' => 'error','message' => 'Có lỗi xảy ra']);
    // }




   
}
