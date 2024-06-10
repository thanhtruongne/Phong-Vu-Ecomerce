<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{

    public $bindings = [
        
        'App\Repositories\Interfaces\PostRepositoriesInterfaces' => 'App\Repositories\PostRepositories',
        'App\Repositories\Interfaces\BaseRepositoriesInterfaces' => 'App\Repositories\BaseRepositories',
        'App\Repositories\Interfaces\DistrictRepositoriesInterfaces' => 'App\Repositories\DistrictRepositoreis',
        'App\Repositories\Interfaces\WardRepositoriesInterfaces' => 'App\Repositories\WardRepositoreis',
        'App\Repositories\Interfaces\ProvinceRepositoriesInterfaces' => 'App\Repositories\ProvinceRepositoreis',
        'App\Repositories\Interfaces\GenerateModuleRepositoriesInterfaces' => 'App\Repositories\GenerateModuleRepositories',
        'App\Repositories\Interfaces\UserRepositoriesInterfaces' => 'App\Repositories\UserRepositories',
        'App\Repositories\Interfaces\PermissionsRepositoriesInterfaces' => 'App\Repositories\PermissionsRepositories',
        'App\Repositories\Interfaces\UserCatalogeRepositoriesInterface' => 'App\Repositories\UserCatalogeRepositories',
        'App\Repositories\Interfaces\PostCatalogeRepositoriesInterfaces' => 'App\Repositories\PostCatelogeRepositories',
        'App\Repositories\Interfaces\LanguageRepositoriesInterfaces' => 'App\Repositories\LanguageRepositories',
        'App\Repositories\Interfaces\ProductCatelogeRepositoreisInterfaces' => 'App\Repositories\ProductCatelogeRepositoreis',  
        'App\Repositories\Interfaces\ProductRepositoreisInterfaces' => 'App\Repositories\ProductRepositoreis', 
        'App\Repositories\Interfaces\RouterRepositoriesInterfaces' => 'App\Repositories\RouterRepositories',
        'App\Repositories\Interfaces\AttributeCatelogeRepositoreisInterfaces' => 'App\Repositories\AttributeCatelogeRepositoreis', 
        'App\Repositories\Interfaces\AttributeRepositoriesInterfaces' => 'App\Repositories\AttributeRepositories', 
        'App\Repositories\Interfaces\ProductVariantAttributeRepositoriesInterfaces' => 'App\Repositories\ProductVariantAttributeRepositories', 
        'App\Repositories\Interfaces\SystemRepositoriesInterfaces' => 'App\Repositories\SystemRepositories', 
        'App\Repositories\Interfaces\MenuCatelogeRepositoriesInterfaces' => 'App\Repositories\MenuCatelogeRepositories', 
        'App\Repositories\Interfaces\MenuRepositoriesInterfaces' => 'App\Repositories\MenuRepositories', 
        'App\Repositories\Interfaces\SliderRepositoriesInterfaces' => 'App\Repositories\SliderRepositories', 
        'App\Repositories\Interfaces\WidgetRepositoriesInterfaces' => 'App\Repositories\WidgetRepositories',
         'App\Repositories\Interfaces\PromotionRepositoriesInterfaces' => 'App\Repositories\PromotionRepositories', 
         'App\Repositories\Interfaces\SourceRepositoriesInterfaces' => 'App\Repositories\SourceRepositories', 
         'App\Repositories\Interfaces\CustomerRepositoriesInterfaces' => 'App\Repositories\CustomerRepositories', 
         'App\Repositories\Interfaces\CustomerCatelogeRepositoriesInterfaces' => 'App\Repositories\CustomerCatelogeRepositories', 
         'App\Repositories\Interfaces\PromotionProductVariantRepositoriesInterfaces' => 'App\Repositories\PromotionProductVariantRepositories', 
    ];
        /**
     * Register services.
     */
    public function register(): void
    {
        foreach($this->bindings as $key => $val) {
            $this->app->bind($key,$val);
        }
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
