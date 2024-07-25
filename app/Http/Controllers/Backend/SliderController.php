<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\SliderStore;
use App\Http\Requests\UpdatePost;
use App\Http\Requests\UpdateSlider;
use App\Repositories\SliderRepositories;
use App\Services\Interfaces\SliderServiceInterfaces as SliderService;
use Illuminate\Http\Request;

class SliderController extends Controller
{
    protected $sliderService , $sliderRepositories ;

    public function __construct(
        SliderService $sliderService , 
        SliderRepositories $sliderRepositories,
        ) {
        $this->sliderService = $sliderService;
        $this->sliderRepositories = $sliderRepositories;

   }
  
    
    public function index(Request $request)
    { 
        $slider = $this->sliderService->paginate($request);
        $filter = config('apps.search');
        $config = [
            'links_link' => [
                'https://cdnjs.cloudflare.com/ajax/libs/switchery/0.8.2/switchery.css'
            ],
            'js_link' => [
                'https://cdnjs.cloudflare.com/ajax/libs/switchery/0.8.2/switchery.js'
            ]
        ];
        return view('backend.Page.slider.index',compact('config','filter','slider'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() 
    {

        $config = [
            'links_link' => [
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css',
               
            ],
            'js' => [
                'backend/js/plugins/jasny/jasny-bootstrap.min.js', 
                'backend/plugin/ckfinder/ckfinder.js',        
                // 'backend/plugin/ckeditor/config.js', 
                // 'backend/plugin/ckeditor/ckeditor.js',
                'backend/js/jquery-nice-select-1.1.0/js/jquery.nice-select.min.js',                 
                'backend/library/slider.js',   
            ],
            'js_link' => [
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js',
                'https://cdn.jsdelivr.net/momentjs/latest/moment.min.js',            
            ],
        ];
        return view('backend.Page.slider.create',compact('config'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SliderStore $request)
    {
        if($this->sliderService->create($request) == true) {
            return redirect()->route('private-system.management.slider.index')->with('success','Tạo slider thành công');
        }
        return redirect()->route('private-system.management.slider.indexx')->with('error','Có lỗi đã xảy ra');
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
        $slider = $this->sliderRepositories->findByid($id);
        $config = [
            'links_link' => [
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css',
               
            ],
            'js' => [
                'backend/js/plugins/jasny/jasny-bootstrap.min.js', 
                'backend/plugin/ckfinder/ckfinder.js',        
                'backend/js/jquery-nice-select-1.1.0/js/jquery.nice-select.min.js',                 
                'backend/library/slider.js',   
            ],
            'js_link' => [
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js',
                'https://cdn.jsdelivr.net/momentjs/latest/moment.min.js',            
            ],
        ];

        return view('backend.Page.slider.edit',compact('config','slider'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSlider $request, string $id)
    {
        if($this->sliderService->update($id,$request) == true) {
            return redirect()->route('private-system.management.slider.index')->with('success','Cập nhật slider thành công');
        }
        return redirect()->route('private-system.management.slider.index')->with('error','Lỗi server.....');
    }

   

    /**
     * Remove the specified resource from storage.
     */
    public function remove(string $id)
    {   
        
    }

    public function trashed() {
        $trashedCount = $this->sliderRepositories->trashed();
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
