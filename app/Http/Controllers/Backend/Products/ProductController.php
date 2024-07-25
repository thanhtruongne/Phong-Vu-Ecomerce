<?php
namespace App\Http\Controllers\Backend\Products;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProduct;
use App\Http\Requests\UpdateProduct;
use App\Repositories\AttributeCatelogeRepositories;
use App\Repositories\ProductCatelogeRepositories;
use App\Repositories\ProductRepositories;
use App\Services\Interfaces\ProductServiceInterfaces as ProductService ;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    protected $productService , 
        $productRepositories, 
        $postCatelogeRepositories,
        $attributeCatelogeRepositories,
        $productCatelogeRepositories;

    public function __construct(
        ProductService $productService , 
        ProductRepositories $productRepositories,
        ProductCatelogeRepositories $productCatelogeRepositories,
        ProductCatelogeRepositories $postCatelogeRepositories,
        AttributeCatelogeRepositories $attributeCatelogeRepositories,
        ) {
        $this->productService = $productService;
        $this->productCatelogeRepositories = $productCatelogeRepositories;
        $this->productRepositories = $productRepositories;
        $this->postCatelogeRepositories = $postCatelogeRepositories;
        $this->attributeCatelogeRepositories = $attributeCatelogeRepositories;
    }
  
    
    public function index(Request $request)
    {  
        // $trashedCount = $this->productRepositories->trashed()->count();
        $title = config('apps.product.product');
        $filter = config('apps.post.filter');
        $product = $this->productService->paginate($request,null);
        $productCateloge = $this->productCatelogeRepositories->getAllCategories();
        $config = [
            'links_link' => [
                'https://cdnjs.cloudflare.com/ajax/libs/switchery/0.8.2/switchery.css'
            ],
            'js_link' => [
                'https://cdnjs.cloudflare.com/ajax/libs/switchery/0.8.2/switchery.js'
            ]
        ];
        return view('backend.Page.product.product.index',compact('config','filter','title','product','productCateloge'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = config('apps.product.product.create');
        $categories = $this->postCatelogeRepositories->getAllCategories();
        $attributeCateloge = $this->attributeCatelogeRepositories->AllCateloge();
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
    public function store(StoreProduct $request)
    {
        if( $this->productService->create($request) == true) {
            return redirect()->route('private-system.management.product.index')->with('success','Tạo user thành công');
        }
        return redirect()->route('private-system.management.product.index')->with('error','Có lỗi đã xảy ra');
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
        $product = $this->productRepositories->getProductById($id);
        $categories = $this->postCatelogeRepositories->getAllCategories();
        $attributeCateloge = $this->attributeCatelogeRepositories->AllCateloge();
        $filter = config('apps.product.product');
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

        return view('backend.Page.product.product.edit',compact('product','filter','config','categories','attributeCateloge'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProduct $request, string $id)
    {
        if($this->productService->update($id,$request) == true) {
            return redirect()->route('private-system.management.product.index')->with('success','Tạo user thành công');
        }
        return redirect()->route('private-system.management.product.index')->with('error','Có lỗi đã xảy ra');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {   
        if(!$this->productRepositories->CheckNodeChildrenDestroy($id)) {
            return response(['status' => 'error','message' => 'Danh mục cần xóa tồn tại danh mục con']);
        }
        if($this->productService->destroy($id)  == true) {
            return response(['status' => 'success','message' => 'Xóa thành công']);
        }
        return response(['status' => 'error','message' => 'Có lỗi xảy ra']);
    }

    public function trashed() {
        $trashedCount = $this->productRepositories->trashed();
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
        return view('backend.Page.product.product.Trashed.index',compact('trashedCount','config','filter','title'));
    }
}
