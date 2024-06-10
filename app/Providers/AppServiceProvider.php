<?php

namespace App\Providers;

use App\Http\Controllers\Backend\SystemController;
use App\Http\ViewComposers\MenuComposer;
use App\Http\ViewComposers\SystemComposer;
use Carbon\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Validator;
class AppServiceProvider extends ServiceProvider
{

    public $bindings = [
       
       'App\Services\Interfaces\UserServiceInterfaces' => 'App\Services\UserService',
       'App\Services\Interfaces\PostCatalogeServiceInterfaces' => 'App\Services\PostCatelogeService',
       'App\Services\Interfaces\LanguageServicesInterfaces' => 'App\Services\LanguageService',
       'App\Services\Interfaces\UserCatalogeServiceInteface' => 'App\Services\UserCatalogeService',
       'App\Services\Interfaces\PostServiceInterfaces' => 'App\Services\PostService',
       'App\Services\Interfaces\PermissionsServiceInterfaces' => 'App\Services\PermissionsService',
       'App\Services\Interfaces\GenerateModuleServiceInterfaces' => 'App\Services\GenerateModuleService',
       'App\Services\Interfaces\ProductCatelogeServiceInterfaces' => 'App\Services\ProductCatelogeService',
       'App\Services\Interfaces\ProductServiceInterfaces' => 'App\Services\ProductService',
       'App\Services\Interfaces\BaseServiceInterfaces' => 'App\Services\BaseService',
       'App\Services\Interfaces\AttributeCatelogeServiceInterfaces' => 'App\Services\AttributeCatelogeService',
       'App\Services\Interfaces\AttributeServiceInterfaces' => 'App\Services\AttributeService',
       'App\Services\Interfaces\SystemServiceInterfaces' => 'App\Services\SystemService',
       'App\Services\Interfaces\MenuCatelogeServiceInterfaces' => 'App\Services\MenuCatelogeService',
       'App\Services\Interfaces\MenuServiceInterfaces' => 'App\Services\MenuService',
       'App\Services\Interfaces\SliderServiceInterfaces' => 'App\Services\SliderService',
       'App\Services\Interfaces\WidgetServiceInterfaces' => 'App\Services\WidgetService',
       'App\Services\Interfaces\PromotionServiceInterfaces' => 'App\Services\PromotionService',
       'App\Services\Interfaces\SourceServiceInterfaces' => 'App\Services\SourceService',
       'App\Services\Interfaces\CustomerServiceInterfaces' => 'App\Services\CustomerService',
       'App\Services\Interfaces\CustomerCatelogeServiceInterfaces' => 'App\Services\CustomerCatelogeService',
    ];
    /**
     * Register any application services.
     */
    public function register(): void
    { 
        foreach($this->bindings as $key => $val) {
            $this->app->bind($key,$val);
        }
        //bind phần repositories
        $this->app->register(RepositoryServiceProvider::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $locale = App::getLocale();
        $language = \App\Models\Languages::where('canonical',$locale)->first();


        view()->composer('Frontend.layout.layout',function($view) use($language) {
            $composerClass = [
                SystemComposer::class , MenuComposer::class
            ];
            foreach($composerClass as $key => $item) {
                $composer = App::make($item,['language' => $language->id ]);
                $composer->compose($view);
            } 
           
        });

    }
}
