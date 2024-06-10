<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMenu;
use App\Repositories\MenuCatelogeRepositories;
use App\Services\Interfaces\MenuCatelogeServiceInterfaces as MenuCatelogeServices;
use Illuminate\Http\Request;

class MenuCatelogeController extends Controller
{
    //sử dụng phân quyền cho các nhóm ngươi dùng
    protected $menuService , $menuRepositories;
    
    public function __construct( MenuCatelogeServices $menuService , MenuCatelogeRepositories $menuRepositories) 
    {
        $this->menuService = $menuService;
        $this->menuRepositories = $menuRepositories;
    }

    public function index(Request $request)
    {
        $filter = config('apps.search');
        
        return view('backend.Page.menu.menu.index',compact('filter'));
    }

    public function edit(int $id) {

        return view('backend.Page.Permissions.edit',compact('title','permission'));
    }

    public function create() 
    {
        $title = config('apps.menu.create');
        $menuCateloge = $this->menuRepositories->findCondition(
            [
                ['status', '=', 1]
            ],[],[],'multiple'
        );
        $config = [
            'links_link' => [
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css',
               
            ],
            'js' => [
                'backend/js/plugins/jasny/jasny-bootstrap.min.js',  
                'backend/js/jquery-nice-select-1.1.0/js/jquery.nice-select.min.js',                 
            ],
            'js_link' => [
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js',
                'https://cdn.jsdelivr.net/momentjs/latest/moment.min.js',            
            ],
        ];
        return view('backend.Page.menu.menu.create',compact('title','config','menuCateloge'));
    }


    public function store(StoreMenu $request) {
     $menuCateloge = $this->menuService->create($request);
      if($menuCateloge != false) {
        return response()->json(
            [
                'errCode' => 0 , 
                'message' => 'Cập nhật danh sách menu thành công',
                'key' => array_keys($request->only(['name','keyword'])),
                'value' => $menuCateloge
            ]);
      }
      return response()->json(['errCode' => -2 , 'message' => 'Có lỗi xảy ra !']);
    }

    public function update(int $id, Request $request) {
       
    }
    

    


  
    
}
