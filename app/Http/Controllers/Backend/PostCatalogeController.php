<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostCataloges;
use App\Http\Requests\UpdatePostCataloges;
use App\Repositories\PostCatelogeRepositories;
use App\Services\Interfaces\PostCatalogeServiceInterfaces as PostCatalogeService ;
use Illuminate\Http\Request;

class PostCatalogeController extends Controller
{
    protected $postCatalogeService , $postCatalogeRepositories;

    public function __construct(
        PostCatalogeService $postCatalogeService , 
        PostCatelogeRepositories $postCatalogeRepositories,
        ) {
        $this->postCatalogeService = $postCatalogeService;
        $this->postCatalogeRepositories = $postCatalogeRepositories;
    }
  
    
    public function index(Request $request)
    {  
        $trashedCount = $this->postCatalogeRepositories->trashed()->count();
        $title = config('apps.post.post-cataloge');
        $filter = config('apps.post.filter');
        $postCataloge = $this->postCatalogeRepositories->getAllCategories();
        $config = [
            'links_link' => [
                'https://cdnjs.cloudflare.com/ajax/libs/switchery/0.8.2/switchery.css'
            ],
            'js_link' => [
                'https://cdnjs.cloudflare.com/ajax/libs/switchery/0.8.2/switchery.js'
            ]
        ];
        return view('backend.Page.Post.Cataloge.index',compact('trashedCount','config','filter','title','postCataloge'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $filter = config('apps.post.post-cataloge');
        $postCataloge = $this->postCatalogeRepositories->getAllCategories();
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
        return view('backend.Page.Post.Cataloge.create',compact('filter','config','postCataloge'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostCataloges $request)
    {
        if( $this->postCatalogeService->create($request) == true) {
            return redirect()->route('private-system.management.post.cataloge.index')->with('success','Tạo user thành công');
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
        $postCataloge = $this->postCatalogeRepositories->getPostCatelogeById($id);
        $categories = $this->postCatalogeRepositories->getAllCategories();
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

        return view('backend.Page.Post.Cataloge.edit',compact('postCataloge','filter','config','categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostCataloges $request, string $id)
    {
        if($this->postCatalogeService->update($id,$request) == true) {
            return redirect()->route('private-system.management.post.cataloge.index')->with('success','Tạo user thành công');
        }
        return redirect()->route('private-system.management.post.cataloge.index')->with('error','Có lỗi đã xảy ra');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {   
        if(!$this->postCatalogeRepositories->CheckNodeChildrenDestroy($id)) {
            return response(['status' => 'error','message' => 'Danh mục cần xóa tồn tại danh mục con']);
        }
        if($this->postCatalogeService->destroy($id)  == true) {
            return response(['status' => 'success','message' => 'Xóa thành công']);
        }
        return response(['status' => 'error','message' => 'Có lỗi xảy ra']);
    }

    public function trashed() {
        $trashedCount = $this->postCatalogeRepositories->trashed();
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
        return view('backend.Page.Post.Cataloge.Trashed.index',compact('trashedCount','config','filter','title'));
    }

    public function restore(int $id) {
        if($this->postCatalogeService->restore($id) == true) {
            toastr()->success('Khôi phục thành công','Thông báo');
            return redirect()->route('private-system.management.post.cataloge.trashed');
        }
        toastr()->error('Có lỗi xảy ra','Thông báo');
        return redirect()->route('private-system.management.post.cataloge.trashed');
    }

    public function deleteForce(int $id) {
        if($this->postCatalogeService->deleteForce($id) == true) {
            toastr()->success('Xóa thành công','Thông báo');
            return redirect()->route('private-system.management.post.cataloge.trashed');
        }
        toastr()->error('Có lỗi xảy ra','Thông báo');
        return redirect()->route('private-system.management.post.cataloge.trashed');
    }
}
