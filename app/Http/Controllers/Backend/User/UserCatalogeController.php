<?php

namespace App\Http\Controllers\Backend\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\StoreUserCataloge;
use App\Repositories\UserCatalogeRepositories;
use App\Services\Interfaces\UserCatalogeServiceInteface as UserCatalogeServices;
use Illuminate\Http\Request;

class UserCatalogeController extends Controller
{   
    protected $userCatalogeRepositories;
    protected $userCatalogeServices;

    public function __construct(UserCatalogeRepositories $userCatalogeRepositories,UserCatalogeServices $userServicesCataloge) {
        $this->userCatalogeRepositories = $userCatalogeRepositories;
        $this->userCatalogeServices = $userServicesCataloge;
    }
    public function index(Request $request) {
        $title = config('apps.user.user_cataloge.index');
        $config = [
            'links_link' => [
                'https://cdnjs.cloudflare.com/ajax/libs/switchery/0.8.2/switchery.css'
            ],
            'js_link' => [
                'https://cdnjs.cloudflare.com/ajax/libs/switchery/0.8.2/switchery.js'
            ]
        ];
        $userCataloge = $this->userCatalogeServices->paginate($request);
        $trashedCount = $this->userCatalogeRepositories->trashed()->count();
        $filter = config('apps.user.filter_user_cataloge');
        return view('backend.Page.User.Cataloge.index',compact('title','trashedCount','filter','userCataloge','config'));
    }

    public function create() {
        $title = config('apps.user.user_cataloge.create');
       return view('backend.Page.User.Cataloge.create',compact('title'));
    }

    public function store(StoreUserCataloge $request) {
        if($this->userCatalogeServices->create($request) == true) {
            return redirect()->route('private-system.management.cataloge.index')->with('success','Tạo user thành công');
        }
        return redirect()->route('private-system.management.cataloge.index')->with('error','Có lỗi đã xảy ra');
    }

    public function edit(int $id) {
        $userCataloge = $this->userCatalogeRepositories->findByid($id);
        $title = config('apps.user.user_cataloge.update');
        return view('backend.Page.User.Cataloge.edit',compact('userCataloge','title'));
    }

    public function update(int $id , StoreUserCataloge $request) {
        if($this->userCatalogeServices->update($id,$request) == true) {
            return redirect()->route('private-system.management.cataloge.index')->with('success','Tạo user thành công');
        }
        return redirect()->route('private-system.management.cataloge.index')->with('error','Có lỗi đã xảy ra');
    }
}
