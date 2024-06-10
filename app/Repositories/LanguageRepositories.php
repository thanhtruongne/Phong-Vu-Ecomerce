<?php
 namespace App\Repositories;

use App\Models\Languages;
use App\Repositories\Interfaces\LanguageRepositoriesInterfaces;
use Illuminate\Support\Facades\App;

 class LanguageRepositories extends BaseRepositories implements LanguageRepositoriesInterfaces  {
    
    public function __construct(Languages $model)
    {
        $this->model = $model;
    }

    public function getAllLanguage() {
        return $this->model->where('status',1)->get();
    }

    public function getCurrentLanguage() {
        return $this->model->where(['status' => 1,'current' => 1,'canonical' => App::getLocale()])->first();
    }
 }