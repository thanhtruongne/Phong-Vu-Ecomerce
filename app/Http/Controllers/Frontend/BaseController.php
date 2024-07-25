<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Repositories\LanguageRepositories;
use App\Repositories\SystemRepositories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class BaseController extends Controller
{
   protected $systemRepositories,$Seo;

   public function __construct() 
   {     
     //    $this->language = resolve(LanguageRepositories::class)->getCurrentLanguage()->id;
        // lấy phần system hệ thống trang chủ
       
         $system = Redis::get('system');
         if(!$system){
            $this->systemRepositories = resolve(SystemRepositories::class)->findCondition(
               [],[],[],'multiple',[]
            );
            Redis::set('system',json_encode(conbineArraySystem($this->systemRepositories ,'keyword','content')));
         } 
         $system = json_decode(Redis::get('system'),true);
         $this->Seo = [
             'title' => $system['seo_meta_title'],
             'desc' => $system['seo_meta_desc'],
             'keyword' => $system['seo_meta_keyword'],
             'image' => $system['seo_meta_images'],
             'canonical' => config('apps.apps.url')
         ];
   }
}
