<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Repositories\LanguageRepositories;
use Illuminate\Http\Request;

class BaseController extends Controller
{
   protected $language;

   public function __construct($language) 
   {

        $this->language = $language;
   }
}
