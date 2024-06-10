<?php

namespace App\Services;

use App\Repositories\CategoriesRepositories;
use App\Services\Interfaces\GenerateModuleServiceInterfaces;
use App\Trait\UploadImage;
use Carbon\Carbon;
use Exception;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
/**
 * Class UserService.
 */
class GenerateModuleService implements GenerateModuleServiceInterfaces
{
    protected $CategoiresRepositories;

    public function __construct() {
       
    }
    public function paginate($request) 
    {
       $condition = [];
       $condition['status'] = $request->status;
       $condition['search'] = $request->search;
       $record = $request->input('record') ?: 6;
       $userCataloge = $this->CategoiresRepositories->paganation(['*'],$condition,[],$record,[]);
       return $userCataloge;
    }

    public function create($request) {
        DB::beginTransaction();
        try {
            //tạo database
            $this->createDatabase($request);
            // //tạo controller
            $this->makeController($request);

            // // //tạo model
            $this->makeModel($request);

            // // //tạo Repositories
            $this->makeRepositories($request);

            // // //tạo Service
            $this->makeService($request);

            // // //tạo provider config cả 2 service và repositories;
            $this->makeProvider($request);

            // // //tạo request
            $this->makeRequest($request); 
 
            // //tạo View
            $this->makeView($request);//success

            // //tạo route
            $this->makeRouter($request); //success
            return true;
        } catch (Exception $e) {
            DB::rollBack(); 
            echo new Exception($e->getMessage());die();
            return false;
        }
    }


    public function update(int $id ,$request) {
        DB::beginTransaction();
        try {
            $data = $request->only(['name','parent_id']);;
            $this->CategoiresRepositories->UpdateCategoriesByNode($id,$data);   
            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollBack();
            echo new Exception($e->getMessage());die();
            return false;
        }
    }   

    public function destroy(int $id) {
        DB::beginTransaction();
        try {
           
            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollBack();
            echo new Exception($e->getMessage());die();
            return false;
        }
    }
    


    //tạo router
    private function makeRouter($request) {
        try {
            $name = $request->input('name');
            $module = $this->convertNameSchemaMigration($name);
            $basepath = base_path('routes/admin.php');
            $content = file_get_contents($basepath);
            $extract = explode('_',$module);
            $option = [
                'module_view' => (count($extract) == 2) ? "$extract[0]/$extract[1]" : "$extract[0]",
                'module' => ucfirst($name),
                'module_name' => (count($extract) == 2) ? "$extract[0].$extract[1]" : "$extract[0]",
            ];
        $lineRoute  = <<<ROUTE
Route::get('{$option['module_view']}',[{$option['module']}Controller::class,'index'])->name('management.{$option['module_name']}.index');
Route::get('{$option['module_view']}/edit/{id}',[{$option['module']}Controller::class,'edit'])->name('management.{$option['module_name']}.edit');
Route::post('{$option['module_view']}/store',[{$option['module']}Controller::class,'store'])->name('management.{$option['module_name']}.store');
Route::get('{$option['module_view']}/create',[{$option['module']}Controller::class,'create'])->name('management.{$option['module_name']}.create');
Route::put('{$option['module_view']}/update/{id}',[{$option['module']}Controller::class,'update'])->name('management.{$option['module_name']}.update');
Route::delete('{$option['module_view']}/remove/{id}',[{$option['module']}Controller::class,'destroy'])
->where(['id' => '[0-9]+'])
->name('management.{$option['module_name']}.remove'); 
//@!new-controller-module
ROUTE;
        $linePlugin = <<<ROUTE
use App\Http\Controllers\Backend\\{$option['module']}Controller;
//@@route-plugin@@
ROUTE;        
        $content = str_replace('//@!new-controller-module',$lineRoute,$content);
        $content = str_replace('//@@route-plugin@@',$linePlugin,$content);
        File::put($basepath , $content);
        return true;

        } catch (\Throwable $th) {
            DB::rollBack();
            return false;
        }
    }

    //tạo Request
    private function makeRequest($request) {
        try {
            $name = $request->input('name');
            //tạo request array
            $requestArray = ['Store'.$name ,'Update'.$name];
            $templateArray = ['TemplateStoreRequest','TemplateUpdateRequest'];
            foreach($templateArray as $key => $val) {
                $path = base_path('app/Template/'.$val.'.php');
                $content = '<?php'. file_get_contents($path);
                $content = str_replace('{moduleTemplate}',$name,$content);
                $pathContent = base_path('app/Http/Requests/'.$requestArray[$key].'.php');
                File::put($pathContent,$content); 
            }
            //validate phần module_type
            return true;
        } catch (\Throwable $th) {
            DB::rollBack();
            return false;
        }
    }

    //tạo view
    private  function makeView($request) {
        try {
            $name = $request->input('name');
            $module = $this->convertNameSchemaMigration($name);
            $extract = explode('_',$module);
            // tạo dường dẫn mặc định
            $basepath = resource_path("views/backend/Page/{$extract[0]}");
            // dd($basepath);
            //tập tin
            $folderPath = (count($extract) == 2) ? "$basepath/{$extract[1]}" :  "$basepath/{$extract[0]}";
            //gán thêm folder component vào
            $componentPath = "$folderPath/component";
    
            //check tồn tại file
            if(!File::exists($folderPath)) {
                //tạo ra thư mục file
                File::makeDirectory($folderPath,775 , true);
            }
    
            if(!File::exists($componentPath)) {
                File::makeDirectory($componentPath,775 , true);
            }
    
            $sourcePath = base_path('app/Template/view/'.((count($extract) == 2) ? 'cateloge' : 'post').'/');
            $viewpath = (count($extract) == 2) ? "{$extract[0]}.{$extract[1]}" : "{$extract[0]}"; 
            $option = [
                'view' => $viewpath,
                'module' => lcfirst($name),
                'Module' => $name,
                'module_translate' => $module.'_translate',
                'module_model' => ucfirst($name),
                
            ];
            // sau đó tạo ra các array template
            $arrayTemplate = [
                'index.blade.php',
                'create.blade.php',
                'edit.blade.php'
            ];
            foreach($arrayTemplate as $key => $val) {
                $sourceFile = $sourcePath.$val;
                $promo = explode('.',$val);
                
                //điểm path vào
                $destination = "{$folderPath}/{$val}";
                $content = file_get_contents($sourceFile);
                //add breadcrumb
                $content = str_replace('{module_breadcrumb}',$viewpath.'.'.$promo[0],$content);
                foreach($option as $keyOption => $valueOption) {
                    $content = str_replace('{'.$keyOption.'}',$valueOption,$content);
                }
                if(!File::exists($destination)) {
                     //create breadcrumb
                    $this->createNewBreadCrumb($request, $promo[0], $viewpath);
                    File::put($destination,$content);
                }
            }
    
            $conponentFile = ['filter.blade.php','status.blade.php','record.blade.php'];
            foreach($conponentFile as $key => $compo) {
                $sourceFile = $sourcePath.'component/'.$compo;
                //điểm path vào
                $destination = "{$componentPath}/{$compo}";
               
                $content = file_get_contents($sourceFile);
                if(!File::exists($destination)) {
                    File::put($destination,$content);
                }
            }
            return true;
        } catch (\Throwable $th) {
            DB::rollBack();
            return false;
        }

        
    }

    //tạo Provider
    private function makeProvider($request) {
        try {
            $moduleName = $request->input('name');
            //tạo các option provider
            $provider = [
                'providerPath' => base_path('app/Providers/AppServiceProvider.php'),
                'repositoriesPath' => base_path('app/Providers/RepositoryServiceProvider.php')
            ];
            foreach($provider as $key => $val) {
                $content = file_get_contents($val);
                $line = $key === 'providerPath' ? "'App\\Services\\Interfaces\\{$moduleName}ServiceInterfaces' => 
                'App\\Services\\{$moduleName}Service'," 
                : "'App\\Repositories\\Interfaces\\{$moduleName}RepositoreisInterfaces' => 'App\\Repositories\\{$moduleName}Repositoreis',";
                //tìm kiếm vị trí cuối để pus vào
                $position = strpos($content,'];');
                if($position !== false) {
                    $getContent = substr_replace($content," ".$line." ",$position,0);
                }
                File::put($val,$getContent);
            }
            return true;
        } catch (\Throwable $th) {
            DB::rollBack();
            return false;
        } 
    }

    //tạo repositories
    private function makeRepositories($request) {
        try {
            $name = $request->input('name');
            $extract = explode('_',$this->convertNameSchemaMigration($name));
            $option = [
                'module_class' => ucfirst($name),
                'module' => lcfirst($extract[0])
            ];
            $pathTemplateServices = (count($extract) == 2) ? 'app/Template/repositories/Cateloge.php' : 'app/Template/repositories/Post.php';
            $pathInterfaces = base_path('app/Repositories/Interfaces/'.$option['module_class'].'RepositoriesInterfaces.php');
            $pathTemplateInterfaces = base_path('app/Template/repositories/TemplateInterfaces.php');
            $contentInterfaces ='<?php'. file_get_contents($pathTemplateInterfaces);
            foreach($option as $key => $val) {
                $contentInterfaces = str_replace('{'.$key.'}',$val ,$contentInterfaces);
            }          ;
            File::put($pathInterfaces,$contentInterfaces);
            $templateService ='<?php'. file_get_contents(base_path($pathTemplateServices));
            $desnation = base_path('app/Repositories/'.$option['module_class'].'Repositories.php');
            foreach($option as $key => $val) {
                $templateService = str_replace('{'.$key.'}',$val,$templateService);
            }
            File::put($desnation,$templateService);
            return true;
        } catch (\Throwable $th) {
            DB::rollBack();
            return false;
        }
       

        
    }
    //tạo services
    private function makeService($request) {
        try {
            $name = $request->input('name');
            $extract = explode('_',$this->convertNameSchemaMigration($name));
            $option = [
                'module_class' => ucfirst($name),
                'module' => lcfirst($name),  
                'module_pivot' => lcfirst($extract[0])  
            ];
            $layerInterfaceReading = base_path('app/Services/Interfaces/'.$option['module_class'].'ServiceInterfaces'.'.php');
            $templateLayerInterfaces = base_path('app/Template/services/TemplateServiceInterfaces.php');
            $contentInterfaces ='<?php'.file_get_contents($templateLayerInterfaces);
            $contentInterfaces = str_replace('{module_class}',$option['module_class'], $contentInterfaces);
            File::put($layerInterfaceReading, $contentInterfaces);
            // //Tạo phần interfaces
            $templatePathService = (count($extract) == 2) ? 'app/Template/services/Cateloge.php' : 'app/Template/services/PostService.php';
            $layerService = base_path($templatePathService);
            $pathService = base_path('app/Services/'.$option['module_class'].'Service.php');
            $contentService ='<?php'.file_get_contents($layerService);
        
            foreach($option as $key => $val) {
                $contentService = str_replace('{'.$key.'}',$val ,$contentService);
            }          
            File::put($pathService,$contentService);
            return true;
        } catch (\Throwable $th) {
            DB::rollBack();
            return false;
        }
    }

    private function makeController($request) {
       $payload = $request->only(['name','module_type']);
    //    dd($payload);die();
       switch($payload['module_type']) {
        case 'detail' :
            
            $this->makeTemplateController($payload['name']);
            break;
        case 'node_categories' :
            $this->makeTemplateController($payload['name'],'controller');
            break;
        default: 
            $this->createSingleController();    
            break;
       }
    }

    private function makeModel($request) {
        try {
            $modelName = $request->input('name');
            $extract = explode('_' , $this->convertNameSchemaMigration($modelName));
            $config = [
                'module' => lcfirst($extract[0]),
                'moduleTable' =>  $this->convertNameSchemaMigration(lcfirst($request->input('name'))),
                'module_class' => ucfirst($extract[0]),
            ];
            $pathOrgirinal = (count($extract) == 2 ) ? 'app/Template/models/Cateloge.php' :  'app/Template/models/Post.php';
            $templatepath = base_path($pathOrgirinal);
            $content = '<?php'.file_get_contents($templatepath);
            $path = base_path('app/Models/'.$modelName.'.php');
            foreach($config as $key => $val) {
                $content = str_replace('{'.$key.'}', $val  ,$content);
            }
            File::put($path,$content);
            //create_translate
            if($request->module_type != 3) {
               $this->createModelTranslatePivot($request);
            }
            return true;
        } catch (\Throwable $th) {
            DB::rollBack();
            return false;
        }
       

    }


    private function createDatabase($request) {
        $payload = $request->only(['name','schema','module_type']);
        $name = $this->convertNameSchemaMigration($payload['name']);
        $moduleExtract = explode('_',$this->convertNameSchemaMigration($payload['name']));
        //Tạo tên migration
        $migrationFileName = date('Y_m_d_His').'_create_'.$this->convertNameSchemaMigration($payload['name']).'s_table.php';
        // Tạo đường dẫn chứa
        $migrationPath = database_path('migrations/'.$migrationFileName);
        // Tạo template 
        $migrationTemplate = $this->createMigrationTempalte($payload,$name);
        //Tạo bảng mới
        File::put($migrationPath,$migrationTemplate);

        if($payload['module_type'] != 'another') {
            //tạo bản dịch ra cho table
            $this->createPivotLanguageDatabase($payload);
            // theo quy tắc nhập tên đơn sẽ tự tạo ra bảng attach //cd : post_cataloge_post
            if(count($moduleExtract) == 1) {
             
                $this->createRelationPivotTable($payload , $moduleExtract);
            }           
        } 
        Artisan::call('migrate');
    }

    private function createRelationPivotTable(array $payload = [] , array $extract = []) {
        $module = Str::lower($extract[0].'_cateloge_'.$extract[0]); //vd : post_cateloge_post;
        $migrationPivotName = date('Y_m_d_His',time() + 12).'_create_'.$module.'s_table.php';
        $pivotSchema = $this->migrationPivotRelationSchema([
            'module' => $module,
            'module_forgeinkey' => Str::lower("$extract[0]_cateloge"),
            'module_primary' => lcfirst($payload['name'])
        ]);
        $migrationTemplatePivot = $this->createMigrationTempalte(
            [
            'schema' => $pivotSchema ,
            ],
            $module
        );
        $migrationPathPivot = database_path('migrations/'.$migrationPivotName);
        File::put($migrationPathPivot,$migrationTemplatePivot);
    } 

    private function createPivotLanguageDatabase( array $payload = [] ) {
        $forgeinKey = $this->convertNameSchemaMigration($payload['name']).'_id';
        $migrationPivotName = date('Y_m_d_His',time() + 12).'_create_'.$this->convertNameSchemaMigration($payload['name']).'s_table.php';
        $tableNamePivot = $this->convertNameSchemaMigration($payload['name']).'_translate';
        $pivotSchema = $this->createPivotSchema([
            'name' => $this->convertNameSchemaMigration($payload['name']),
            'forgein_key' => $forgeinKey,
            'table' => $tableNamePivot
        ]);
        $migrationTemplatePivot = $this->createMigrationTempalte(
            [
            'schema' => $pivotSchema ,
            ],
            $tableNamePivot
       );
        $migrationPathPivot = database_path('migrations/'.$migrationPivotName);
        File::put($migrationPathPivot,$migrationTemplatePivot);
    }

    private function makeTemplateController($name,$type = 'CatalogeController') {
        try {
            $controllerName = $name.'Controller';
            if($type == 'CatalogeController') $template = base_path('app/Template/controllers/TemplateCatelogeController.php');
            else if($type == 'controller')  $template = base_path('app/Template/controllers/TemplateController.php');
        
            $getContentThis = '<?php'. file_get_contents($template);
           
            $config = [
                'ModuleTemplate' =>  ucfirst($name) ,
                'ModuleName' => lcfirst($name),
                'ModuleView' => str_replace('_','.',$this->convertNameSchemaMigration($name)),
            ];
           
            $ControllerPath = base_path('app/Http/Controllers/Backend/'.$controllerName.'.php');
            $getContentThis = str_replace('{ModuleName}',$config['ModuleName'],$getContentThis);
            $getContentThis = str_replace('{ModuleView}',$config['ModuleView'],$getContentThis);
            $getContentThis = str_replace('{ModuleTemplate}',$config['ModuleTemplate'],$getContentThis);
           
            File::put($ControllerPath,$getContentThis);
            return true;
        } catch (\Throwable $th) {
            DB::rollBack();
            return false;
        }


       
    }      

    private function createSingleController() {

    }

    private function createMigrationTempalte( array $payload = [] ,string $dropdown = '') {
        $migrationTemplate = <<<MIGRATION
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Kalnoy\Nestedset\NestedSet;
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        {$payload['schema']}
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('{$dropdown}');
    }
};
MIGRATION;
        return $migrationTemplate;
    }

    private function createPivotSchema($payload) {
        $templatePivot = <<<MIGRATION
Schema::create('{$payload['table']}', function (Blueprint \$table) {
    \$table->unsignedBigInteger('{$payload['forgein_key']}')->nullable();
    \$table->unsignedBigInteger('languages_id')->nullable();
    \$table->foreign('{$payload['forgein_key']}')->references('id')->on('{$payload['name']}')->onDelete('cascade');
    \$table->foreign('languages_id')->references('id')->on('languages')->onDelete('cascade');
    \$table->string('name');
    \$table->longText('content');
    \$table->text('desc');
    \$table->string('meta_title');
    \$table->string('meta_keyword');
    \$table->text('meta_desc');
    \$table->string('meta_link');
    \$table->timestamps();
});    
MIGRATION;
      return  $templatePivot;
    }

    private function migrationPivotRelationSchema(array $payload = []) {
        return <<<MIGRATION
Schema::create('{$payload['module']}', function (Blueprint \$table) {
    \$table->unsignedBigInteger('{$payload['module_forgeinkey']}_id');
    \$table->unsignedBigInteger('{$payload['module_primary']}_id');
    \$table->foreign('{$payload['module_forgeinkey']}_id')->references('id')->on('{$payload['module_forgeinkey']}')->onDelete('cascade');
    \$table->foreign('{$payload['module_primary']}_id')->references('id')->on('{$payload['module_primary']}')->onDelete('cascade');
});
MIGRATION;        
    }

    private function convertNameSchemaMigration($name) {
        $model = strtolower(preg_replace('/(?<!^)[A-Z]/','_$0',$name));
        return $model;
    }
    
    private function createNewBreadCrumb($request,string $val = '',$viewpath) {
        $breadcrumbPath = base_path('routes/breadcrumbs.php');
        $breadCrumbContent = file_get_contents($breadcrumbPath);
        $position = strpos($breadCrumbContent, "']';");
        $option = [
            'moduleBreadCrumb' => $viewpath.'.'.$val,
            'moduleNameBC' => $request->input('function_name')
        ];
        $line =
        'Breadcrumbs::for("'.$option['moduleBreadCrumb'].'", function ($trail) {
            $trail->parent("dashboard");
            $trail->push("'.$option['moduleNameBC'].'");
        });';
        $breadCrumbContent = substr_replace($breadCrumbContent,$line."   ",$position,0);
        return File::put( $breadcrumbPath,$breadCrumbContent);
    }
    
    private function createModelTranslatePivot($request) {
        $templatepathPivot = base_path('app/Template/models/TemplateModelTranslate.php');
        $contentPivot = '<?php'.file_get_contents($templatepathPivot);
        $option = [
            'module_class' => ucfirst($request->input('name')),
            'module_convert' => $this->convertNameSchemaMigration($request->input('name'))
        ];
        $pathPivot = base_path('app/Models/'.ucfirst($request->input('name')).'Translate.php');
        foreach($option as $key => $val) {
            $contentPivot = str_replace('{'.$key.'}', $val ,$contentPivot);
        }
        File::put($pathPivot,$contentPivot);
    }
}
