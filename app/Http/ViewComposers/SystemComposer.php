<?php

namespace App\Http\ViewComposers;

use App\Repositories\SystemRepositories;
use Illuminate\View\View;

class SystemComposer {
    protected $language,$systemRepositories;

    public function __construct($language , SystemRepositories $systemRepositories)
    {
        $this->language = $language;
        $this->systemRepositories = $systemRepositories;
    }
    /**
     * Bootstrap any application services.
     */
    public function compose(View $view)
    {
        $system = $this->systemRepositories->findCondition([
            ['languages_id','=',$this->language]
        ],[],[],'multiple');
        $renderSystem = conbineArraySystem($system,'keyword','content');
        $view->with('system',$renderSystem);
    }
}
