<?php
namespace App\Http\Controllers\Frontend\Ajax;


use Illuminate\Http\Request;

interface InterfaceAjax {
    public function getProductByCategoryParams(Request $request);
}