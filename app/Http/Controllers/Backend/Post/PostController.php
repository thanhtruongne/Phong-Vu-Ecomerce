<?php

namespace App\Http\Controllers\Backend\Post;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostValidate;
use App\Http\Requests\UpdatePost;
use App\Repositories\LanguageRepositories;
use App\Repositories\PostCatelogeRepositories;
use App\Repositories\PostRepositories;
use App\Services\Interfaces\PostServiceInterfaces as PostServices;
use Illuminate\Http\Request;

class PostController extends Controller
{
    protected $postService , $postRepositories ,$languageRepositories , $postCatelogeRepositories;

    public function __construct(
        PostServices $postService , 
        PostRepositories $postRepositories,
        LanguageRepositories $languageRepositories,
        PostCatelogeRepositories $postCatelogeRepositories,
        ) {
        $this->postService = $postService;
        $this->postRepositories = $postRepositories;
        $this->languageRepositories = $languageRepositories;
        $this->postCatelogeRepositories = $postCatelogeRepositories;

   }
  
    
    public function index(Request $request)
    {  
        $trashedCount = $this->postRepositories->trashed()->count();
        $title = config('apps.post.post');
        $filter = config('apps.post.filter');
        $post = $this->postService->paginate($request);
        $categories = $this->postCatelogeRepositories->getAllCategories();
        $config = [
            'links_link' => [
                'https://cdnjs.cloudflare.com/ajax/libs/switchery/0.8.2/switchery.css'
            ],
            'js_link' => [
                'https://cdnjs.cloudflare.com/ajax/libs/switchery/0.8.2/switchery.js'
            ]
        ];
        return view('backend.Page.Post.index',compact('trashedCount','config','filter','title','post','categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $filter = config('apps.post.post');
        $categories = $this->postCatelogeRepositories->getAllCategories();
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
        return view('backend.Page.Post.create',compact('filter','config','categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostValidate $request)
    {
        if($this->postService->create($request) == true) {
            return redirect()->route('private-system.management.post.index')->with('success','Tạo user thành công');
        }
        return redirect()->route('private-system.management.post.index')->with('error','Có lỗi đã xảy ra');
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
        $post = $this->postRepositories->getPostById($id, $this->languageRepositories->getCurrentLanguage()->id);
        $categories = $this->postCatelogeRepositories->getAllCategories();
        $filter = config('apps.post.post');
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

        return view('backend.Page.Post.edit',compact('post','filter','config','categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePost $request, string $id)
    {
        if($this->postService->update($id,$request) == true) {
            return redirect()->route('private-system.management.post.index')->with('success','Tạo user thành công');
        }
        return redirect()->route('private-system.management.post.index')->with('error','Có lỗi đã xảy ra');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {   
        
    }
}
