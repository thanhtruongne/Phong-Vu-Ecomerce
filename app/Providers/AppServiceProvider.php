<?php

namespace App\Providers;

use App\Helpers\Tracking;
use Illuminate\Support\ServiceProvider;
class AppServiceProvider extends ServiceProvider
{

    /**
     * Register any application services.
     */
    public function register(): void
    { 
        // dùng debug các raw sql file query builder
        \Illuminate\Database\Query\Builder::macro('toRawSql', function () {
            return array_reduce($this->getBindings(), function ($sql, $binding) {
                return preg_replace('/\?/', is_numeric($binding) ? $binding : "'" . $binding . "'", $sql, 1);
            }, $this->toSql());
        });
        // dùng debug các raw sql file eloquent
        \Illuminate\Database\Eloquent\Builder::macro('toRawSql', function () {
            return ($this->getQuery()->toRawSql());
        });
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
        view()->composer('Frontend.layout.component.mainMenu','App\Http\ViewComposers\MenuComposer');

        $modules =\Module::all();
        foreach ($modules as $module) {
            $this->loadMigrationsFrom([$module->getPath() . '/Database/Migrations']);
        }

        \Validator::extend('string_vertify',function($attribute,$value) {
            return $value === filter_var($value,FILTER_SANITIZE_STRING);
        });

        //lưu log các câu truy vấn và thời gian thực thi
        if (
            config('app.debug', false)
            && config('app.enable_logging', false)
        )
            \DB::listen(function ($query) {
                $rawQuery = $query->sql;
                if (
                    is_array($query->bindings)
                    && count($query->bindings) > 0
                ) {
                    foreach ($query->bindings as $val) {
                        $rawQuery = preg_replace('[\?]', "'" . $val . "'", $rawQuery, 1);
                    }
                }

                Tracking::put((object) ['sql' => $rawQuery, 'time' => $query->time], 'db', false);
            });

    }
}
