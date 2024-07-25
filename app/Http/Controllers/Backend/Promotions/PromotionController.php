<?php

namespace App\Http\Controllers\Backend\Promotions;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Promotion\StorePromotion;
use App\Http\Requests\Backend\Promotion\UpdatePromotion;
use App\Repositories\CustomerCatelogeRepositories;
use App\Repositories\CustomerRepositories;
use App\Repositories\PromotionRepositories;
use App\Repositories\SourceRepositories;
use App\Services\Interfaces\PromotionServiceInterfaces as PromotionService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
class PromotionController extends Controller
{
    protected 
    $promotionService , 
    $promotionRepositories ,
    $customerRepositories ,
    $customerCatelogeRepositories,
    $soruceRepositories;

    public function __construct(
        PromotionService $promotionService , 
        PromotionRepositories $promotionRepositories,
        CustomerRepositories $customerRepositories,
        SourceRepositories $soruceRepositories,
        CustomerCatelogeRepositories $customerCatelogeRepositories
        ) {
        $this->promotionService = $promotionService;
        $this->promotionRepositories = $promotionRepositories;
        $this->customerRepositories = $customerRepositories;
        $this->soruceRepositories = $soruceRepositories;
        $this->customerCatelogeRepositories = $customerCatelogeRepositories;
   }
  
    
    public function index(Request $request)
    {  
        $filter = config('apps.search');
        $promotion = $this->promotionService->paginate($request);
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
        return view('backend.Page.sale.promotion.index',compact('config','filter','promotion'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() 
    {
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
                'backend/js/jquery-nice-select-1.1.0/js/jquery.nice-select.min.js',    
                'backend/library/promotion.js',                 
            ],
            'js_link' => [
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js',
                'https://cdn.jsdelivr.net/momentjs/latest/moment.min.js',
                'https://cdnjs.cloudflare.com/ajax/libs/switchery/0.8.2/switchery.js'
            
            ],
        ];
        return view('backend.Page.sale.promotion.create',compact('config'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePromotion $request)
    {
        if($this->promotionService->create($request) == true) {
            return redirect()->route('private-system.management.promotion')->with('success','Tạo khuyến mãi thành công');
        }
        return redirect()->route('private-system.management.promotion')->with('error','Có lỗi đã xảy ra');
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
        $promotion = $this->promotionRepositories->findByid($id);
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
                'backend/js/jquery-nice-select-1.1.0/js/jquery.nice-select.min.js',    
                'backend/library/promotion.js',                 
            ],
            'js_link' => [
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js',
                'https://cdn.jsdelivr.net/momentjs/latest/moment.min.js',
                'https://cdnjs.cloudflare.com/ajax/libs/switchery/0.8.2/switchery.js'
            
            ]
        ];

        return view('backend.Page.sale.promotion.edit',compact('config','promotion'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePromotion $request, string $id)
    {
        if($this->promotionService->update($id,$request) == true) {
            return redirect()->route('private-system.management.promotion')->with('success','Cập nhật khuyến mãi thành công');
        }
        return redirect()->route('private-system.management.promotion')->with('error','Lỗi server.....');
    }

   

    /**
     * Remove the specified resource from storage.
     */
    public function remove(string $id)
    {   
        
    }

    public function trashed() {
        $trashedCount = $this->promotionRepositories->trashed();
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
