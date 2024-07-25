<?php

namespace App\Http\ViewComposers;

use App\Models\Province;
use App\Repositories\SystemRepositories;
use Illuminate\Redis\Connections\PredisConnection;
use Illuminate\Support\Facades\Redis;
use Illuminate\View\View;

class SystemComposer {
    protected $systemRepositories;

    public function __construct(SystemRepositories $systemRepositories)
    {  
        $this->systemRepositories = $systemRepositories;
    }
    /**
     * Bootstrap any application services.
     */
    public function compose(View $view)
    {   
        $redis = Redis::connection();
        $system = $redis->get('renderSystem');
        $province = $redis->get('province');
        if(!$province)  $province = $redis->set('province',Province::all());
        if(!$system) {
            $systemField = $this->systemRepositories->findCondition([],[],[],'multiple');
            $renderSystem = conbineArraySystem($systemField,'keyword','content');
            $system = $redis->set('renderSystem',json_encode($renderSystem));
           
        } 
        $data = $redis->get('renderSystem'); 
        $temping = $redis->get('province');
        $view->with('system',$data);
        $view->with('province',$temping);
    }
}
