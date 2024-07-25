<?php
namespace App\Http\Controllers\Backend\Products;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAttribute;
use App\Http\Requests\UpdateAttribute;
use App\Repositories\AttributeCatelogeRepositories;
use App\Repositories\AttributeRepositories;
use App\Services\Interfaces\AttributeServiceInterfaces as AttributeService ;
use Illuminate\Http\Request;

class AttributeController extends Controller
{
    protected $attributeService , $attributeRepositories , $attributeCatelogeRepositories;

    public function __construct(
        AttributeService $attributeService , 
        AttributeRepositories $attributeRepositories,
        AttributeCatelogeRepositories $attributeCatelogeRepositories
        ) {
        $this->attributeService = $attributeService;
        $this->attributeRepositories = $attributeRepositories;
        $this->attributeCatelogeRepositories = $attributeCatelogeRepositories;
    }
  
    
    public function index(Request $request)
    {  
        $title = config('apps.post.post-cataloge');
        $filter = config('apps.post.filter');
        $categories = $this->attributeCatelogeRepositories->getAllCategories();
        $attribute =  $this->attributeService->paginate($request);
        $config = [
            'links_link' => [
                'https://cdnjs.cloudflare.com/ajax/libs/switchery/0.8.2/switchery.css'
            ],
            'js_link' => [
                'https://cdnjs.cloudflare.com/ajax/libs/switchery/0.8.2/switchery.js'
            ]
        ];
        return view('backend.Page.attribute.attribute.index',compact('config','filter','title','attribute','categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $filter = config('apps.post.post-cataloge');
        $categories = $this->attributeCatelogeRepositories->getAllCategories();
        $config = [
            'link' => [
                'backend/css/plugins/jasny/jasny-bootstrap.min.css'
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
                  
            ],
            'js_link' => [
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js',
                'https://cdn.jsdelivr.net/momentjs/latest/moment.min.js',
            
            ],
        ];
        return view('backend.Page.attribute.attribute.create',compact('filter','config','categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAttribute $request)
    {
        if( $this->attributeService->create($request) == true) {
            return redirect()->route('private-system.management.attribute.index')->with('success','Tạo user thành công');
        }
        return redirect()->route('private-system.management.attribute.index')->with('error','Có lỗi đã xảy ra');
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
        $attribute = $this->attributeRepositories->getAttributeById($id);
        $categories = $this->attributeCatelogeRepositories->getAllCategories();
        $title = config('apps.attribute.attribute.update');
        $config = [
            'link' => [
                'backend/css/plugins/jasny/jasny-bootstrap.min.css'
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
                  
            ],
            'js_link' => [
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js',
                'https://cdn.jsdelivr.net/momentjs/latest/moment.min.js',
            
            ],
        ];

        return view('backend.Page.attribute.attribute.edit',compact('attribute','title','config','categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAttribute $request, string $id)
    {
        if($this->attributeService->update($id,$request) == true) {
            return redirect()->route('private-system.management.attribute.index')->with('success','Tạo user thành công');
        }
        return redirect()->route('private-system.management.attribute.index')->with('error','Có lỗi đã xảy ra');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {   
        if(!$this->attributeRepositories->CheckNodeChildrenDestroy($id)) {
            return response(['status' => 'error','message' => 'Danh mục cần xóa tồn tại danh mục con']);
        }
        if($this->attributeService->destroy($id)  == true) {
            return response(['status' => 'success','message' => 'Xóa thành công']);
        }
        return response(['status' => 'error','message' => 'Có lỗi xảy ra']);
    }

    public function trashed() {
        $trashedCount = $this->attributeRepositories->trashed();
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
        return view('backend.Page.attribute.attribute.Trashed.index',compact('trashedCount','config','filter','title'));
    }

    
}
