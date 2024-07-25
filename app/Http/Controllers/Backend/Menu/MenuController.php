<?php

namespace App\Http\Controllers\Backend\Menu;

use App\Http\Controllers\Controller;
use App\Http\Requests\MenuStoreName;
use App\Http\Requests\ChildrenMenuCateloge;
use App\Http\Requests\UpdatePost;
use App\Repositories\LanguageRepositories;
use App\Repositories\MenuCatelogeRepositories;
use App\Repositories\MenuRepositories;
use App\Services\Interfaces\MenuCatelogeServiceInterfaces as MenuCatelogeService;
use App\Services\Interfaces\MenuServiceInterfaces as MenuService;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    protected $menuService , $menuRepositories , $menuCatelogeRepositories , $menuCatelogeService;

    public function __construct(
        MenuService $menuService , 
        MenuRepositories $menuRepositories,
        MenuCatelogeRepositories $menuCatelogeRepositories,
        MenuCatelogeService $menuCatelogeService,
        ) {
        $this->menuService = $menuService;
        $this->menuCatelogeRepositories = $menuCatelogeRepositories;
        $this->menuCatelogeService = $menuCatelogeService;
        $this->menuRepositories = $menuRepositories;
   }
  
    
    public function index(Request $request)
    {  
        $menuCateloge = $this->menuCatelogeService->paginate($request);
        $filter = config('apps.search');
        $config = [
            'links_link' => [
                'https://cdnjs.cloudflare.com/ajax/libs/switchery/0.8.2/switchery.css'
            ],
            'js_link' => [
                'https://cdnjs.cloudflare.com/ajax/libs/switchery/0.8.2/switchery.js'
            ]
        ];
        return view('backend.Page.menu.menu.index',compact('config','filter','menuCateloge'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() 
    {
        $title = config('apps.menu.create');
        $menuCateloge = $this->menuCatelogeRepositories->findCondition(
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
                'backend/plugin/ckfinder/ckfinder.js',        
                'backend/plugin/ckeditor/config.js',
                'backend/plugin/ckeditor/ckeditor.js',
                'backend/library/Ckfinder.js',                  
            ],
            'js_link' => [
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js',
                'https://cdn.jsdelivr.net/momentjs/latest/moment.min.js',            
            ],
        ];
        return view('backend.Page.menu.menu.create',compact('title','config','menuCateloge'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MenuStoreName $request)
    {
        if($this->menuService->create($request) == true) {
            return redirect()->route('private-system.management.menu.index')->with('success','Tạo menu thành công');
        }
        return redirect()->route('private-system.management.menu.indexx')->with('error','Có lỗi đã xảy ra');
    }



    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $menuCateloge = $this->menuCatelogeRepositories->findByid($id,['*'],
        [
            'menu' => function($query) {
                return $query->where('parent','=',null)->withDepth()->with('children')->get()->toFlatTree();
            }
        ]);
        $filter = config('apps.menu.update');
        $config = [
            'links_link' => [
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css',
               
            ],
            'js' => [
                'backend/js/plugins/jasny/jasny-bootstrap.min.js',  
                'backend/js/jquery-nice-select-1.1.0/js/jquery.nice-select.min.js',  
                'backend/library/library.js',               
            ],
            'js_link' => [
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js',
                'https://cdn.jsdelivr.net/momentjs/latest/moment.min.js',            
            ],
        ];

        return view('backend.Page.menu.menu.edit',compact('filter','config','menuCateloge'));
    }

    public function children(int $id) {
        $title = config('apps.menu.create');
        $menu = $this->menuRepositories->findByid($id,['*'],[]);
        $config = [
            'links_link' => [
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css',
               
            ],
            'js' => [
                'backend/js/plugins/jasny/jasny-bootstrap.min.js',  
                'backend/js/jquery-nice-select-1.1.0/js/jquery.nice-select.min.js',        
                'backend/plugin/ckfinder/ckfinder.js',        
                'backend/plugin/ckeditor/config.js',
                'backend/plugin/ckeditor/ckeditor.js',
                'backend/library/Ckfinder.js',         
            ],
            'js_link' => [
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js',
                'https://cdn.jsdelivr.net/momentjs/latest/moment.min.js',            
            ],
        ];
       return view('backend.Page.menu.menu.component.children',compact('title','config','menu'));
    }

    public function saveChildren(ChildrenMenuCateloge $request)
    {
        if($this->menuService->saveChildren($request) == true) {
            return redirect()->route('private-system.management.menu.index')->with('success','Tạo menu thành công');
        }
        return redirect()->route('private-system.management.menu.index')->with('error','Có lỗi đã xảy ra');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePost $request, string $id)
    {
        if($this->menuService->update($id,$request) == true) {
            return redirect()->route('private-system.management.post.index')->with('success','Tạo user thành công');
        }
        return redirect()->route('private-system.management.post.index')->with('error','Có lỗi đã xảy ra');
    }

    public function nestedTable(Request $request) {
       $menu_cateloge_id = +$request->input('menu_cateloge_id');
       $json = json_decode($request->input('data_json'),true);
    //    dd($json , $menu_cateloge_id);
       $flag = $this->menuService->SaveTheNestedTableListDynamic( $json ,null, $menu_cateloge_id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function remove(string $id)
    {   
        
    }

    public function trashed() {
        $trashedCount = $this->menuRepositories->trashed();
        $title = config('apps.post.post-cataloge');
        $filter = config('apps.post.filter');
        $config = [
            'links_link' => [
                'https://cdnjs.cloudflare.com/ajax/libs/switchery/0.8.2/switchery.css'
            ],
            'js_link' => [
                'https://cdnjs.cloudflare.com/ajax/libs/switchery/0.8.2/switchery.js'
            ]
        ];
        return view('backend.Page.Post.Trashed.index',compact('trashedCount','config','filter','title'));
    }
}
