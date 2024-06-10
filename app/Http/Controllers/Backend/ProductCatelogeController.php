<?php
namespace App\Http\Controllers\Backend;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductCateloge;
use App\Http\Requests\UpdateProductCateloge;
use App\Repositories\ProductCatelogeRepositories;
use App\Services\Interfaces\ProductCatelogeServiceInterfaces as ProductCatelogeService ;
use Illuminate\Http\Request;

class ProductCatelogeController extends Controller
{
    protected $productCatelogeService , $productCatelogeRepositories;

    public function __construct(
        ProductCatelogeService $productCatelogeService , 
        ProductCatelogeRepositories $productCatelogeRepositories,
        ) {
        $this->productCatelogeService = $productCatelogeService;
        $this->productCatelogeRepositories = $productCatelogeRepositories;
    }
  
    
    public function index(Request $request)
    {  
        $trashedCount = $this->productCatelogeRepositories->trashed()->count();
        $title = config('apps.post.post-cataloge');
        $filter = config('apps.post.filter');
        $productCateloge = $this->productCatelogeRepositories->getAllCategories();
        $config = [
            'links_link' => [
                'https://cdnjs.cloudflare.com/ajax/libs/switchery/0.8.2/switchery.css'
            ],
            'js_link' => [
                'https://cdnjs.cloudflare.com/ajax/libs/switchery/0.8.2/switchery.js'
            ]
        ];
        return view('backend.Page.product.cateloge.index',compact('trashedCount','config','filter','title','productCateloge'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $filter = config('apps.post.post-cataloge');
        $categories = $this->productCatelogeRepositories->getAllCategories();
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
        return view('backend.Page.product.cateloge.create',compact('filter','config','categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductCateloge $request)
    {
        if( $this->productCatelogeService->create($request) == true) {
            return redirect()->route('private-system.management.product.cateloge.index')->with('success','Tạo user thành công');
        }
        return redirect()->route('private-system.management.product.cateloge.index')->with('error','Có lỗi đã xảy ra');
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
        $productCateloge = $this->productCatelogeRepositories->getProductCatelogeById($id);
        $categories = $this->productCatelogeRepositories->getAllCategories();
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

        return view('backend.Page.product.cateloge.edit',compact('productCateloge','filter','config','categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductCateloge $request, string $id)
    {
        if($this->productCatelogeService->update($id,$request) == true) {
            return redirect()->route('private-system.management.product.cateloge.index')->with('success','Tạo user thành công');
        }
        return redirect()->route('private-system.management.product.cateloge.index')->with('error','Có lỗi đã xảy ra');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {   
        if(!$this->productCatelogeRepositories->CheckNodeChildrenDestroy($id)) {
            return response(['status' => 'error','message' => 'Danh mục cần xóa tồn tại danh mục con']);
        }
        if($this->productCatelogeService->destroy($id)  == true) {
            return response(['status' => 'success','message' => 'Xóa thành công']);
        }
        return response(['status' => 'error','message' => 'Có lỗi xảy ra']);
    }

    public function trashed() {
        $trashedCount = $this->productCatelogeRepositories->trashed();
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
        return view('backend.Page.product.cateloge.Trashed.index',compact('trashedCount','config','filter','title'));
    }

    public function restore(int $id) {
        if($this->productCatelogeService->restore($id) == true) {
            toastr()->success('Khôi phục thành công','Thông báo');
            return redirect()->route('private-system.management.product.cateloge.trashed');
        }
        toastr()->error('Có lỗi xảy ra','Thông báo');
        return redirect()->route('private-system.management.product.cateloge.trashed');
    }

    public function deleteForce(int $id) {
        if($this->productCatelogeService->deleteForce($id) == true) {
            toastr()->success('Xóa thành công','Thông báo');
            return redirect()->route('private-system.management.product.cateloge.trashed');
        }
        toastr()->error('Có lỗi xảy ra','Thông báo');
        return redirect()->route('private-system.management.product.cateloge.trashed');
    }
}
