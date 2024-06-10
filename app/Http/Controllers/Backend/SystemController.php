<?php
namespace App\Http\Controllers\Backend;

use App\Classes\System;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProduct;
use App\Http\Requests\UpdateProduct;
use App\Repositories\LanguageRepositories;
use App\Repositories\SystemRepositories;
use App\Services\Interfaces\SystemServiceInterfaces as SystemService;
use Illuminate\Http\Request;

class SystemController extends Controller
{
    protected $languageRepositories , $system , $systemService , $systemRepositories;

    public function __construct(
        System $system,
        LanguageRepositories $languageRepositories,
        SystemService $systemService,
        SystemRepositories $systemRepositories
        ) {
        $this->system = $system;
        $this->languageRepositories = $languageRepositories;
        $this->systemService = $systemService;
        $this->systemRepositories = $systemRepositories;
    }
  
    
    public function index(Request $request)
    {  
        $language_id = $this->languageRepositories->getCurrentLanguage()->id;
        $system = $this->system->config();
        $systemAll = $this->systemRepositories->findCondition([
            ['languages_id' ,'=', $language_id]
        ],[],[],'multiple');
        $combineArraySystem = conbineArraySystem($systemAll , 'keyword' , 'content');
        $config = [
            'links_link' => [
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css',
            ],
            'js_link' => [
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js',
            ],
            'js' => [
                'backend/plugin/ckfinder/ckfinder.js'   ,        
                'backend/js/jquery-nice-select-1.1.0/js/jquery.nice-select.min.js',    
                'backend/library/Ckfinder.js',
                'backend/library/library.js',
            ]
        ];
        return view('backend.Page.System.index',compact('config','system','combineArraySystem','language_id'));
    }
    public function translate(Request $request)
    {  
        $language_id = +$request->language_id;
        $system = $this->system->config();
        $systemAll = $this->systemRepositories->findCondition(
            [
                ['languages_id' ,'=', $language_id]
            ],[],[],'multiple');
        
        $combineArraySystem = conbineArraySystem($systemAll , 'keyword' , 'content');
        $config = [
            'links_link' => [
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css',
            ],
            'js_link' => [
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js',
            ],
            'js' => [
                'backend/plugin/ckfinder/ckfinder.js'   ,        
                'backend/js/jquery-nice-select-1.1.0/js/jquery.nice-select.min.js',    
                'backend/library/Ckfinder.js',
                'backend/library/library.js',
            ]
        ];
        return view('backend.Page.System.index',compact('config','system','combineArraySystem','language_id'));
    }
    public function Savetranslate(Request $request , $language_id) {
        if( $this->systemService->create($request,+$language_id)) {
            return redirect()->route('private-system.management.configuration.setting.translate',['language_id' => $request->language_id])->with('success','Tạo user thành công');
        }
        return redirect()->route('private-system.management.configuration.setting.translate',['language_id' => $request->language_id])->with('error','Có lỗi đã xảy ra');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = config('apps.product.product.create');
       
        $config = [
            'link' => [
                'backend/css/style.css',
                'backend/css/plugins/jasny/jasny-bootstrap.min.css',
                'backend/js/jquery-nice-select-1.1.0/css/nice-select.css'
                
            ],
            'links_link' => [
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css',
                'https://cdnjs.cloudflare.com/ajax/libs/switchery/0.8.2/switchery.css'
               
            ],
            'js' => [
                'backend/js/plugins/jasny/jasny-bootstrap.min.js',  
                'backend/plugin/ckfinder/ckfinder.js'   ,        
                'backend/plugin/ckeditor/config.js',
                'backend/plugin/ckeditor/ckeditor.js',
                'backend/library/Ckfinder.js',
                'backend/js/jquery-nice-select-1.1.0/js/jquery.nice-select.min.js',    
                'backend/library/variants.js',                 
            ],
            'js_link' => [
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js',
                'https://cdn.jsdelivr.net/momentjs/latest/moment.min.js',
                'https://cdnjs.cloudflare.com/ajax/libs/switchery/0.8.2/switchery.js'
            
            ],
        ];
        return view('backend.Page.product.product.create',compact('title','config','categories','attributeCateloge'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if( $this->systemService->create($request, $this->languageRepositories->getCurrentLanguage()->id) == true) {
            return redirect()->route('private-system.management.configuration.setting.index')->with('success','Tạo user thành công');
        }
        return redirect()->route('private-system.management.configuration.setting.index')->with('error','Có lỗi đã xảy ra');
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
      
        $filter = config('apps.product.product');
        $config = [
            'link' => [
                'backend/css/plugins/jasny/jasny-bootstrap.min.css',
                'backend/js/jquery-nice-select-1.1.0/css/nice-select.css'
            ],
            'links_link' => [
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css',
               
            ],
            'js' => [
                'backend/js/plugins/jasny/jasny-bootstrap.min.js',  
                'backend/plugin/ckfinder/ckfinder.js'   ,        
                'backend/plugin/ckeditor/config.js',
                'backend/plugin/ckeditor/ckeditor.js',
                'backend/library/Ckfinder.js',
                'backend/js/jquery-nice-select-1.1.0/js/jquery.nice-select.min.js',    
                'backend/library/variants.js',                 
            ],
            'js_link' => [
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js',
                'https://cdn.jsdelivr.net/momentjs/latest/moment.min.js',
            
            ],
        ];

        return view('backend.Page.product.product.edit',compact('product','filter','config','categories','attributeCateloge'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProduct $request, string $id)
    {
        // if($this->productService->update($id,$request) == true) {
        //     return redirect()->route('private-system.management.product.index')->with('success','Tạo user thành công');
        // }
        // return redirect()->route('private-system.management.product.index')->with('error','Có lỗi đã xảy ra');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {   
        // if(!$this->productRepositories->CheckNodeChildrenDestroy($id)) {
        //     return response(['status' => 'error','message' => 'Danh mục cần xóa tồn tại danh mục con']);
        // }
        // if($this->productService->destroy($id)  == true) {
        //     return response(['status' => 'success','message' => 'Xóa thành công']);
        // }
        // return response(['status' => 'error','message' => 'Có lỗi xảy ra']);
    }

}
