<?php
namespace App\Http\Controllers\Backend;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAttributeCateloge;
use App\Http\Requests\UpdateAttributeCateloge;
use App\Repositories\AttributeCatelogeRepositories;
use App\Services\Interfaces\AttributeCatelogeServiceInterfaces as AttributeCatelogeService ;
use Illuminate\Http\Request;

class AttributeCatelogeController extends Controller
{
    protected $attributeCatelogeService , $attributeCatelogeRepositories ;

    public function __construct(
        AttributeCatelogeService $attributeCatelogeService , 
        AttributeCatelogeRepositories $attributeCatelogeRepositories
        ) {
        $this->attributeCatelogeService = $attributeCatelogeService;
        $this->attributeCatelogeRepositories = $attributeCatelogeRepositories;
    }
  
    
    public function index(Request $request)
    {  
        $trashedCount = $this->attributeCatelogeRepositories->trashed()->count();
        $title = config('apps.post.post-cataloge');
        $filter = config('apps.post.filter');
        $attributeCateloge = $this->attributeCatelogeRepositories->getAllCategories();
        $config = [
            'links_link' => [
                'https://cdnjs.cloudflare.com/ajax/libs/switchery/0.8.2/switchery.css'
            ],
            'js_link' => [
                'https://cdnjs.cloudflare.com/ajax/libs/switchery/0.8.2/switchery.js'
            ]
        ];
        return view('backend.Page.attribute.cateloge.index',compact('trashedCount','config','filter','title','attributeCateloge'));
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
        return view('backend.Page.attribute.cateloge.create',compact('filter','config','categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAttributeCateloge $request)
    {
        if( $this->attributeCatelogeService->create($request) == true) {
            return redirect()->route('private-system.management.post.cataloge.index')->with('success','Tạo loại thuộc tính thành công');
        }
        return redirect()->route('private-system.management.post.cataloge.index')->with('error','Có lỗi đã xảy ra');
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
        $attributeCateloge = $this->attributeCatelogeRepositories->getAttributeCatelogeById($id);
        $categories = $this->attributeCatelogeRepositories->getAllCategories();
        $filter = config('apps.post.post-cataloge');
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

        return view('backend.Page.attribute.cateloge.edit',compact('attributeCateloge','filter','config','categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAttributeCateloge $request, string $id)
    {
        if($this->attributeCatelogeService->update($id,$request) == true) {
            return redirect()->route('private-system.management.attribute.cateloge.index')->with('success','Tạo loại thuộc tính thành công');
        }
        return redirect()->route('private-system.management.attribute.cateloge.index')->with('error','Có lỗi đã xảy ra');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {   
        if(!$this->attributeCatelogeRepositories->CheckNodeChildrenDestroy($id)) {
            return response(['status' => 'error','message' => 'Danh mục cần xóa tồn tại danh mục con']);
        }
        if($this->attributeCatelogeService->destroy($id)  == true) {
            return response(['status' => 'success','message' => 'Xóa thành công']);
        }
        return response(['status' => 'error','message' => 'Có lỗi xảy ra']);
    }

    public function trashed() {
        $trashedCount = $this->attributeCatelogeRepositories->trashed();
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
        return view('backend.Page.attribute.cateloge.Trashed.index',compact('trashedCount','config','filter','title'));
    }

    public function restore(int $id) {
        if($this->attributeCatelogeService->restore($id) == true) {
            toastr()->success('Khôi phục thành công','Thông báo');
            return redirect()->route('private-system.management.attribute.cateloge.trashed');
        }
        toastr()->error('Có lỗi xảy ra','Thông báo');
        return redirect()->route('private-system.management.attribute.cateloge.trashed');
    }

    public function deleteForce(int $id) {
        if($this->attributeCatelogeService->deleteForce($id) == true) {
            toastr()->success('Xóa thành công','Thông báo');
            return redirect()->route('private-system.management.attribute.cateloge.trashed');
        }
        toastr()->error('Có lỗi xảy ra','Thông báo');
        return redirect()->route('private-system.management.attribute.cateloge.trashed');
    }
}
