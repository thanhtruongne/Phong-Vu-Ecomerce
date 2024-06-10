<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePermissionRole;
use App\Http\Requests\StorePermissionsCreate;
use App\Repositories\PermissionsRepositories;
use App\Repositories\UserCatalogeRepositories;
use App\Services\Interfaces\PermissionsServiceInterfaces as PermissionsServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class PermissionController extends Controller
{
    //sử dụng phân quyền cho các nhóm ngươi dùng
    protected $permissionServices,$userCatalogeRepositories,$permissionRepositories;
    
    public function __construct(
        PermissionsServices $permissionService , 
        UserCatalogeRepositories $userCatalogeRepositories,
        PermissionsRepositories $permissionRepositories
    ) 
    {
      $this->permissionServices = $permissionService;
      $this->userCatalogeRepositories = $userCatalogeRepositories;
      $this->permissionRepositories = $permissionRepositories;
    }

    public function index(Request $request) {
        $this->authorize('modules','permissions.index');
        $title = config('apps.permissions.permissions');
        $filter = config('apps.permissions.filter');
        $permissions = $this->permissionServices->paginate($request);
        $userCataloge = $this->userCatalogeRepositories->all();
        return view('backend.Page.Permissions.index',compact('title','filter','permissions','userCataloge'));
    }

    public function edit(int $id) {
        $this->authorize('modules','permissions.edit');
        $permission = $this->permissionRepositories->findByid($id);
        $title = config('apps.permissions.permissions');
        return view('backend.Page.Permissions.edit',compact('title','permission'));
    }

    public function create() {
        $this->authorize('modules','permissions.create');
        $title = config('apps.permissions.permissions');
        return view('backend.Page.Permissions.create',compact('title'));
    }

    public function store(StorePermissionsCreate $request) {
        $this->authorize('modules','permissions.index');
        if( $this->permissionServices->create($request) == true) {
            return redirect()->route('private-system.management.configuration.permissions.index')->with('success','Tạo phân quyền thành công');
        }
        return redirect()->route('private-system.management.configuration.permissions.index')->with('error','Có lỗi đã xảy ra');
    }

    public function update(int $id, Request $request) {
        dd($request->all(),$id);
        if( $this->permissionServices->update($id,$request) == true) {
            return redirect()->route('private-system.management.configuration.permissions.index')->with('success','Tạo phân quyền thành công');
        }
        return redirect()->route('private-system.management.configuration.permissions.index')->with('error','Có lỗi đã xảy ra');
    }
    

    public function changePermision(Request $request) {
        $this->authorize('modules','permissions.change');
        if( $this->permissionServices->ChangeRoles($request) == true) {
            return redirect()->back()->with('success','Tạo vai trò thành công');
        }
        return redirect()->back()->with('error','Có lỗi đã xảy ra');
    }
    


  
    
}
