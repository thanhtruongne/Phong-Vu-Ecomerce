<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\StoreUserAdmin;
use App\Http\Requests\StoreCustomer;
use App\Repositories\CustomerCatelogeRepositories;
use App\Repositories\CustomerRepositories;
use App\Repositories\Interfaces\ProvinceRepositoriesInterfaces as ProvinceRepositoreis;
use App\Services\CustomerService;
use Carbon\Carbon;
use Illuminate\Http\Request;



class CustomerController extends Controller
{

    protected $customerServices;
    protected $provinceRepositories;
    protected $customerRepositories;

    protected $customerCatelogeRepositories;

    public function __construct(
        CustomerService $customerServices,
        ProvinceRepositoreis $provinceRepositories,
        CustomerRepositories $customerRepositories,
        CustomerCatelogeRepositories $customerCatelogeRepositories
        )
    {
        $this->customerServices = $customerServices;
        $this->provinceRepositories = $provinceRepositories;
        $this->customerRepositories  = $customerRepositories;
        $this->customerCatelogeRepositories = $customerCatelogeRepositories;
    }
    public function index(Request $request) 
    {
        $customer = $this->customerServices->paginate($request);
        $filter = config('apps.search');
        $trashedCount = $this->customerServices->trashed();
        $config = [
            'links_link' => [
                'https://cdnjs.cloudflare.com/ajax/libs/switchery/0.8.2/switchery.css'
            ],
            'js_link' => [
                'https://cdnjs.cloudflare.com/ajax/libs/switchery/0.8.2/switchery.js'
            ]
        ];
        return view('backend.Page.Customer.index',compact('customer','trashedCount','filter','config'));
    }
  
    public function create() {
        $provinces = $this->provinceRepositories->all();
        $CustomerCateloge = $this->customerCatelogeRepositories->all();
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
        return view('backend.Page.Customer.create',compact('config','provinces','CustomerCateloge'));
    }
    
    public function store(StoreCustomer $request) {
        if($this->customerServices->create($request) == true) {
            return redirect()->route('private-system.management.customer')->with('success','Tạo khách hàng thành công');
        }
        return redirect()->route('private-system.management.customer')->with('error','Có lỗi đã xảy ra');
    }

    public function edit(int $id) {
        $provinces = $this->provinceRepositories->all();
        $user = $this->customerRepositories->findByid($id);
        $title = config('apps.user.user.update');
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
        return view('backend.Page.User.edit',compact('title','config','provinces','user'));
    }

    public function update(int $id, Request $request) { 
        if($this->customerServices->update($id,$request) == true) {
            return redirect()->route('private-system.management.table-user')->with('success','Cập nhật user thành công');
        }
        return redirect()->route('private-system.management.table-user')->with('error','Có lỗi đã xảy ra');
    }

    public function delete(int $id) {
        
        if($this->customerServices->deleteSoft($id) == true) {
            return response(['status' => 'success','message' => 'Xóa thành công']);
        }
        return response(['status' => 'error','message' => 'Có lỗi xảy ra']);
    }

    public function trashed() {
        $dataRestore = $this->customerServices->trashed();
        $filter = config('apps.user.filter_user');
        $title = config('apps.user.user.trashed');
        return view('backend.Page.User.Trashed.index',compact('dataRestore','title','filter'));
    }


    public function deleteForce(int $id) {
        if($this->customerServices->deleteForce($id) == true) {
            return response(['status' => 'success','message' => 'Xóa thành công']);
        }
        
        return response(['status' => 'error','message' => 'Có lỗi xảy ra']);
    }


    public function restore(int $id) {
        if($this->customerServices->restoreUser($id) == true) {
            toastr()->success('Khôi phục thành công','Thông báo');
            return redirect()->route('private-system.management.table-user.trashed');
        }
        toastr()->error('Có lỗi xảy ra','Thông báo');
        return redirect()->route('private-system.management.table-user.trashed');
    }
}
