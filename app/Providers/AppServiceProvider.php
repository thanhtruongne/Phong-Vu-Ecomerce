<?php

namespace App\Providers;

use App\Http\Controllers\Backend\SystemController;
use App\Http\ViewComposers\MenuComposer;
use App\Http\ViewComposers\SystemComposer;
use Carbon\Carbon;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Validator;
use Laravel\Sanctum\PersonalAccessToken;
use Laravel\Sanctum\Sanctum;

class AppServiceProvider extends ServiceProvider
{

    /**
     * Register any application services.
     */
    public function register(): void
    { 

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
   
        \Schema::defaultStringLength(191);
        if (explode(':', config('app.url'))[0] == 'https') {
            $this->app['request']->server->set('HTTPS', 'on');
            \URL::forceScheme('https');
        }

        view()->composer('backends.layouts.aside','App\Http\ViewComposers\LeftMenuComposer');

        $modules =\Module::all();
        foreach ($modules as $module) {
            $this->loadMigrationsFrom([$module->getPath() . '/Database/Migrations']);
        }

    }
}
