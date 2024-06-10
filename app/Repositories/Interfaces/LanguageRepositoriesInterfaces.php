<?php 

namespace App\Repositories\Interfaces;

interface LanguageRepositoriesInterfaces {
    public function all();
    public function getAllLanguage();

    public function getCurrentLanguage();
    public function findByid(int $modeId,array $column=['*'],array $relation = []);
}