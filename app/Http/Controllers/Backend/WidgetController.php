<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateSlider;
use App\Http\Requests\UpdateWidget;
use App\Http\Requests\WidgetStore;
use App\Repositories\LanguageRepositories;
use App\Repositories\WidgetRepositories;
use App\Services\Interfaces\WidgetServiceInterfaces as WidgetService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
class WidgetController extends Controller
{
    protected $widgetService , $widgetRepositories ,$languageRepositories;

    public function __construct(
        WidgetService $widgetService , 
        WidgetRepositories $widgetRepositories,
        LanguageRepositories $languageRepositories,
        ) {
        $this->widgetService = $widgetService;
        $this->widgetRepositories = $widgetRepositories;
        $this->languageRepositories = $languageRepositories;

   }
  
    
    public function index(Request $request)
    {  
        $trashedCount = $this->widgetRepositories->trashed()->count();
        $widget = $this->widgetService->paginate($request);
        $filter = config('apps.search');
        $config = [
            'links_link' => [
                'https://cdnjs.cloudflare.com/ajax/libs/switchery/0.8.2/switchery.css'
            ],
            'js' => [
                'backend/plugin/ckfinder/ckfinder.js',        
                'backend/plugin/ckeditor/config.js',
                'backend/plugin/ckeditor/ckeditor.js',
                'backend/library/Ckfinder.js',
            ],
            'js_link' => [
                'https://cdnjs.cloudflare.com/ajax/libs/switchery/0.8.2/switchery.js'
            ]
        ];
        return view('backend.Page.widget.index',compact('trashedCount','config','filter','widget'));
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
                'backend/library/widget.js',  
                'backend/js/plugins/jasny/jasny-bootstrap.min.js', 
                'backend/plugin/ckfinder/ckfinder.js',        
                'backend/plugin/ckeditor/config.js',
                'backend/plugin/ckeditor/ckeditor.js',
                'backend/library/Ckfinder.js',     
                'backend/js/jquery-nice-select-1.1.0/js/jquery.nice-select.min.js',                 
               
            ],
            'js_link' => [
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js',
                'https://cdn.jsdelivr.net/momentjs/latest/moment.min.js',            
            ],
        ];
        return view('backend.Page.widget.create',compact('config'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(WidgetStore $request)
    {
        if($this->widgetService->create($request) == true) {
            return redirect()->route('private-system.management.widget.index')->with('success','Tạo slider thành công');
        }
        return redirect()->route('private-system.management.widget.indexx')->with('error','Có lỗi đã xảy ra');
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
        $widget = $this->widgetRepositories->findByid($id);
        $instance = findClass('Repositories','Repositories',$widget->model);
        $condition  = $this->conditionEdit($this->languageRepositories->getCurrentLanguage()->id,$widget->model_id);
        $findModel = $instance->findCondition(...array_values($condition));
        $model_id = $this->combineArrayToUpdate($findModel,['name.languages','image','id','meta_link.languages']);
        $config = [
            'links_link' => [
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css',
               
            ],
            'js' => [
                'backend/library/widget.js',  
                'backend/js/plugins/jasny/jasny-bootstrap.min.js', 
                'backend/plugin/ckfinder/ckfinder.js',        
                'backend/plugin/ckeditor/config.js',
                'backend/plugin/ckeditor/ckeditor.js',
                'backend/library/Ckfinder.js',     
                'backend/js/jquery-nice-select-1.1.0/js/jquery.nice-select.min.js',                 
               
            ],
            'js_link' => [
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js',
                'https://cdn.jsdelivr.net/momentjs/latest/moment.min.js',            
            ],
        ];

        return view('backend.Page.widget.edit',compact('config','widget','model_id'));
    }

    private function combineArrayToUpdate( $data, array $fields = []){
          $temp = [];
          foreach($data as $key => $item) {
              foreach($fields as $field) {
                    if(is_array($item)) {
                        $temp[$field][] = $item[$field];
                    }
                    else {
                        $extra = explode('.',$field);
                        if(count($extra) == 2) {
                            $temp[$extra[0]][] = $item->{$extra[1]}->first()->pivot->{$extra[0]};
                        }
                        else {
                            $temp[$field][] = $item->{$field};
                        }
                       
                    }
                }
          }
          return $temp;
    }

    private function conditionEdit($language_id,$whereFileds) {
        return [
            'condition' => [],
            [  
                'whereIn' => 'id',
                'whereValues' =>$whereFileds
            ],
            'relation' => ['languages' => function($query) use($language_id) {
                $query->where('languages_id',$language_id);
            }],
            'multiple'
        ];
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateWidget $request, string $id)
    {
        if($this->widgetService->update($id,$request) == true) {
            return redirect()->route('private-system.management.widget.index')->with('success','Cập nhật slider thành công');
        }
        return redirect()->route('private-system.management.widget.index')->with('error','Lỗi server.....');
    }

   

    /**
     * Remove the specified resource from storage.
     */
    public function remove(string $id)
    {   
        
    }

    public function trashed() {
        $trashedCount = $this->widgetRepositories->trashed();
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
