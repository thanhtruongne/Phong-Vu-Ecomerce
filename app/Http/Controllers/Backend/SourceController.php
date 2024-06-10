<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSource;
use App\Http\Requests\Backend\StoreUserCataloge;
use App\Http\Requests\UpdateSource;
use App\Repositories\SourceRepositories;
use App\Services\Interfaces\SourceServiceInterfaces as SourceService;
use Illuminate\Http\Request;

class SourceController extends Controller
{   
    protected $sourceRepositories;
    protected $sourceServices;

    public function __construct(
        SourceRepositories $sourceRepositories,
        SourceService $sourceServices) {
        $this->sourceRepositories = $sourceRepositories;
        $this->sourceServices = $sourceServices;
    }
    public function index(Request $request) {
        $filter = config('apps.search');
        $config = [
            'links_link' => [
                'https://cdnjs.cloudflare.com/ajax/libs/switchery/0.8.2/switchery.css'
            ],
            'js_link' => [
                'https://cdnjs.cloudflare.com/ajax/libs/switchery/0.8.2/switchery.js'
            ]
        ];
        $source = $this->sourceServices->paginate($request);
        $trashedCount = $this->sourceRepositories->trashed()->count();
       
        return view('backend.Page.source.index',compact('trashedCount','filter','config','source'));
    }

    public function create() {
       return view('backend.Page.source.create');
    }

    public function store(StoreSource $request) {
        if($this->sourceServices->create($request) == true) {
            return redirect()->route('private-system.management.source')->with('success','Tạo nguồn thành công');
        }
        return redirect()->route('private-system.management.source')->with('error','Có lỗi đã xảy ra');
    }

    public function edit(int $id) {
        $source = $this->sourceRepositories->findByid($id);
        return view('backend.Page.source.edit',compact('source'));
    }

    public function update(int $id , UpdateSource $request) {
        if($this->sourceServices->update($id,$request) == true) {
            return redirect()->route('private-system.management.source')->with('success','Cập nhật nguồn thành công');
        }
        return redirect()->route('private-system.management.source')->with('error','Có lỗi đã xảy ra');
    }
}
