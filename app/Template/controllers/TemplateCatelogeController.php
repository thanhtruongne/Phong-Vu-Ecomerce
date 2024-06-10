
namespace App\Http\Controllers\Backend;
use App\Http\Controllers\Controller;
use App\Http\Requests\Store{ModuleTemplate};
use App\Http\Requests\Update{ModuleTemplate};
use App\Repositories\{ModuleTemplate}Repositories;
use App\Services\Interfaces\{ModuleTemplate}ServiceInterfaces as {ModuleTemplate}Service ;
use Illuminate\Http\Request;

class {ModuleTemplate}Controller extends Controller
{
    protected ${ModuleName}Service , ${ModuleName}Repositories;

    public function __construct(
        {ModuleTemplate}Service ${ModuleName}Service , 
        {ModuleTemplate}Repositories ${ModuleName}Repositories,
        ) {
        $this->{ModuleName}Service = ${ModuleName}Service;
        $this->{ModuleName}Repositories = ${ModuleName}Repositories;
    }
  
    
    public function index(Request $request)
    {  
        $trashedCount = $this->{ModuleName}Repositories->trashed()->count();
        $title = config('apps.post.post-cataloge');
        $filter = config('apps.post.filter');
        ${ModuleName} = $this->{ModuleName}Repositories->getAllCategories();
        $config = [
            'links_link' => [
                'https://cdnjs.cloudflare.com/ajax/libs/switchery/0.8.2/switchery.css'
            ],
            'js_link' => [
                'https://cdnjs.cloudflare.com/ajax/libs/switchery/0.8.2/switchery.js'
            ]
        ];
        return view('backend.Page.{ModuleView}.index',compact('trashedCount','config','filter','title','{ModuleName}'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $filter = config('apps.post.post-cataloge');
        $categories = $this->{ModuleName}Repositories->getAllCategories();
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
        return view('backend.Page.{ModuleView}.create',compact('filter','config','categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Store{ModuleTemplate} $request)
    {
        if( $this->{ModuleName}Service->create($request) == true) {
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
        ${ModuleName} = $this->{ModuleName}Repositories->get{ModuleTemplate}ById($id);
        $categories = $this->{ModuleName}Repositories->getAllCategories();
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

        return view('backend.Page.{ModuleView}.edit',compact('{ModuleName}','filter','config','categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Update{ModuleTemplate} $request, string $id)
    {
        if($this->{ModuleName}Service->update($id,$request) == true) {
            return redirect()->route('private-system.management.{ModuleView}.index')->with('success','Tạo user thành công');
        }
        return redirect()->route('private-system.management.{ModuleView}.index')->with('error','Có lỗi đã xảy ra');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {   
        if(!$this->{ModuleName}Repositories->CheckNodeChildrenDestroy($id)) {
            return response(['status' => 'error','message' => 'Danh mục cần xóa tồn tại danh mục con']);
        }
        if($this->{ModuleName}Service->destroy($id)  == true) {
            return response(['status' => 'success','message' => 'Xóa thành công']);
        }
        return response(['status' => 'error','message' => 'Có lỗi xảy ra']);
    }

    public function trashed() {
        $trashedCount = $this->{ModuleName}Repositories->trashed();
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
        return view('backend.Page.{ModuleView}.Trashed.index',compact('trashedCount','config','filter','title'));
    }

    public function restore(int $id) {
        if($this->{ModuleName}Service->restore($id) == true) {
            toastr()->success('Khôi phục thành công','Thông báo');
            return redirect()->route('private-system.management.{ModuleView}.trashed');
        }
        toastr()->error('Có lỗi xảy ra','Thông báo');
        return redirect()->route('private-system.management.{ModuleView}.trashed');
    }

    public function deleteForce(int $id) {
        if($this->{ModuleName}Service->deleteForce($id) == true) {
            toastr()->success('Xóa thành công','Thông báo');
            return redirect()->route('private-system.management.{ModuleView}.trashed');
        }
        toastr()->error('Có lỗi xảy ra','Thông báo');
        return redirect()->route('private-system.management.{ModuleView}.trashed');
    }
}
