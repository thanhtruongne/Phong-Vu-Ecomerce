<?php

namespace App\Http\Controllers\Backend\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\StoreUserAdmin;
use App\Repositories\Interfaces\ProvinceRepositoriesInterfaces as ProvinceRepositoreis;
use App\Repositories\Interfaces\UserRepositoriesInterfaces as UserReposirtories;
use App\Repositories\UserCatalogeRepositories;

;
use App\Services\Interfaces\UserServiceInterfaces as UserServices;
use Carbon\Carbon;
use Illuminate\Http\Request;



class UserController extends Controller
{

    protected $userServices;
    protected $provinceRepositories;
    protected $userRepositories;

    protected $userCatalogeRepositories;

    public function __construct(
        UserServices $userService,
        ProvinceRepositoreis $province,
        UserReposirtories $userRepositories,
        UserCatalogeRepositories $userCataloge
        )
    {
        $this->userServices = $userService;
        $this->provinceRepositories = $province;
        $this->userRepositories  = $userRepositories;
        $this->userCatalogeRepositories = $userCataloge;
    }
    public function index(Request $request) 
    {
        $users = $this->userServices->paginate($request);
        $filter = config('apps.user.filter_user');
        $trashedCount = $this->userServices->trashed();
        $config = [
            'links_link' => [
                'https://cdnjs.cloudflare.com/ajax/libs/switchery/0.8.2/switchery.css'
            ],
            'js_link' => [
                'https://cdnjs.cloudflare.com/ajax/libs/switchery/0.8.2/switchery.js'
            ]
        ];
        return view('backend.Page.User.index',compact('users','trashedCount','filter','config'));
    }
  
    public function create() {
        $provinces = $this->provinceRepositories->all();
        $userCataloge = $this->userCatalogeRepositories->all();
        $title = config('apps.user.user.create');
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
        return view('backend.Page.User.create',compact('title','config','provinces','userCataloge'));
    }
    
    public function store(StoreUserAdmin $request) {
        // dd($request->all());
        if($this->userServices->create($request) == true) {
            return redirect()->route('private-system.management.table-user')->with('success','Tạo user thành công');
        }
        return redirect()->route('private-system.management.table-user')->with('error','Có lỗi đã xảy ra');
    }

    public function edit(int $id) {
        $provinces = $this->provinceRepositories->all();
        $user = $this->userRepositories->findByid($id);
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
        if($this->userServices->update($id,$request) == true) {
            return redirect()->route('private-system.management.table-user')->with('success','Cập nhật user thành công');
        }
        return redirect()->route('private-system.management.table-user')->with('error','Có lỗi đã xảy ra');
    }

    public function delete(int $id) {
        
        if($this->userServices->deleteSoft($id) == true) {
            return response(['status' => 'success','message' => 'Xóa thành công']);
        }
        return response(['status' => 'error','message' => 'Có lỗi xảy ra']);
    }

}
