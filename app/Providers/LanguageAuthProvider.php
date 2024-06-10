<?php

namespace App\Providers;

use App\Repositories\Interfaces\LanguageRepositoriesInterfaces;
use App\Repositories\LanguageRepositories;
use Illuminate\Support\Facades;
use Illuminate\Support\ServiceProvider;
use Illuminate\View\View;
class LanguageAuthProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // Khai báo LanguageRepositire vào lấy data qua Interfaces
        $this->app->bind(LanguageRepositoriesInterfaces::class,LanguageRepositories::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {  
        Facades\View::composer('*', function ( View $view) {
            $languageRepositories = $this->app->make(LanguageRepositoriesInterfaces::class);
            $languages = $languageRepositories->all();
            return  $view->with('languages',$languages);
        });      
    }
}
