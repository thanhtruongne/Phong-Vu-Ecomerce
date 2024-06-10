<?php
namespace App\Services\Interfaces;

interface SystemServiceInterfaces {

    public function create($request,$language_id);

    public function destroy($id);
}