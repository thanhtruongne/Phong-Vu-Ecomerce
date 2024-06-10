<?php 

namespace App\Repositories\Interfaces;

interface WardRepositoriesInterfaces {
    public function all();

    public function getWardByCode(string $code);
}