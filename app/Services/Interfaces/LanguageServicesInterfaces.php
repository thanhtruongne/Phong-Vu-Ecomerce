<?php 

namespace App\Services\Interfaces;

interface LanguageServicesInterfaces {
    public function paginate($request);

    public function create($request);
    
    public function SwitchLanguage( int $id);
    public function update(int $id ,$request);

    public function transltateDynamicLanguages($request,array $option = []);
}