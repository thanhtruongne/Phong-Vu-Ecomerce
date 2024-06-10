<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreLanguages;
use App\Http\Requests\TranslateLanguage;
use App\Repositories\LanguageRepositories;
use App\Services\Interfaces\LanguageServicesInterfaces;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class LanguagesController extends Controller
{
    protected $languageService , $languageRepositories;

    public function __construct(LanguageServicesInterfaces $languageService , LanguageRepositories $languageRepositories) {
        $this->languageService = $languageService;
        $this->languageRepositories = $languageRepositories;
    }
  
    
    public function index(Request $request)
    {  
        $data = $this->languageService->paginate($request);
        $trashedCount = $this->languageRepositories->trashed()->count();
        $filter = config('apps.language.language');
        $config = [
            'links_link' => [
                'https://cdnjs.cloudflare.com/ajax/libs/switchery/0.8.2/switchery.css'
            ],
            'js_link' => [
                'https://cdnjs.cloudflare.com/ajax/libs/switchery/0.8.2/switchery.js'
            ]
        ];

       return view('backend.Page.Language.index',compact('trashedCount','data','filter','config'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $filter = config('apps.language.language');

        $config = [
            'link' => [
                'backend/css/plugins/jasny/jasny-bootstrap.min.css'
            ],
            'js' => [
                'backend/js/plugins/dropzone/dropzone.js',  
                'backend/js/plugins/jasny/jasny-bootstrap.min.js',  
                'backend/plugin/ckfinder/ckfinder.js'   ,
                'backend/library/Ckfinder.js',
                  
            ]
        ];
        return view('backend.Page.Language.create',compact('filter','config'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreLanguages $request)
    {
        // dd($request->all());
        if($this->languageService->create($request) == true) {
            return redirect()->route('private-system.management.configuration.language.index')->with('success','Tạo user thành công');
        }
        return redirect()->route('private-system.management.configuration.language.index')->with('error','Có lỗi đã xảy ra');
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
        $language = $this->languageRepositories->findByid($id);
        $filter = config('apps.language.language');
      
        $config = [
            'link' => [
                'backend/css/plugins/jasny/jasny-bootstrap.min.css'
            ],
            'js' => [
                'backend/js/plugins/jasny/jasny-bootstrap.min.js',  
                'backend/plugin/ckfinder/ckfinder.js'   ,
                'backend/library/Ckfinder.js',
                  
            ]
        ];

        return view('backend.Page.Language.edit',compact('language','filter','config'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreLanguages $request, string $id)
    {
        if($this->languageService->update($id,$request) == true) {
            return redirect()->route('private-system.management.configuration.language.index')->with('success','Tạo user thành công');
        }
        return redirect()->route('private-system.management.configuration.language.index')->with('error','Có lỗi đã xảy ra');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    
    public function ChangeLanguageTemplate( int $id) {
        $language = $this->languageRepositories->findByid($id);
        $this->languageService->SwitchLanguage($id);
        if (! in_array($language->canonical, ['en', 'vn'])) {
            abort(400);
        }
        Session::put('app.locale',$language->canonical);
        App::setLocale($language->canonical);  
        return back();
    }

    public function translateDynamic(string $model = '', int $id = 0 , int $language_id = 0) {
       
        $this->authorize('modules','language.translate');
        $repositoriesIntance = '\App\Repositories\\'.ucfirst($model).'Repositories';
        if(class_exists($repositoriesIntance)) {
           $instanceController = app($repositoriesIntance);
        }
        //Tìm bản dịch mac95 đĩnh đã chọn global
        $currentLanguage = $this->languageRepositories->findCondition([
            ['canonical','=',App::currentLocale()]
        ]);
        $serviceMethodname = 'get'.$model.'ById';
        $currentPost = $instanceController->{$serviceMethodname}($id,$currentLanguage->id);
        //tìm thấy bản post chưa dịch 
        $postTranslated = $instanceController->{$serviceMethodname}($id,$language_id);  
        
        $title = config('apps.language.language');
        $option = [
            'model' => $model,
            'languages_id' => $language_id,
            'id' => $id 
        ];
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

        return view('backend.Page.Language.translate',compact('config','title','currentPost','postTranslated','option'));
        
    }

    public function translate(TranslateLanguage $request) {
       $option = $request->input('option');
       if($this->languageService->transltateDynamicLanguages($request,$option)) {
           return redirect()->back()->with('success','Tạo bản dịch thành công');
       }
       return redirect()->back()->with('error','Có lỗi xảy ra');
    }
}
