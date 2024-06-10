<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreModuleGenerate;
use App\Models\Categories;
use App\Repositories\CategoriesRepositories;
use App\Services\Interfaces\GenerateModuleServiceInterfaces as GenerateModuleService;
use Illuminate\Http\Request;

class GenerateModuleController extends Controller
{
    protected $generateService;

    public function __construct(GenerateModuleService $generateService) {
       $this->generateService = $generateService;
    }
    
    public function index(Request $request)
    {  
        $filter = config('apps.categories.categories');
        $config = [
            'links_link' => [
                'https://cdnjs.cloudflare.com/ajax/libs/switchery/0.8.2/switchery.css'
            ],
            'js_link' => [
                'https://cdnjs.cloudflare.com/ajax/libs/switchery/0.8.2/switchery.js'
            ]
        ]; 
        return view('backend.Page.ModuleGenerate.index',compact('filter','config'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $filter = config('apps.generate');
        $config =[
            'links_link' => [
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css',  
            ],
            'js_link' => [
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js',
            
            ]
        ];
       
        return view('backend.Page.ModuleGenerate.create',compact('filter','config'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreModuleGenerate $request)
    {
       if($this->generateService->create($request) == true) {
            return redirect()->route('private-system.management.module.index')->with('success','Tạo module thành công');
       }
       return redirect()->route('private-system.management.module.index')->with('error','Có lỗi xảy ra');
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

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
      
    }
}
