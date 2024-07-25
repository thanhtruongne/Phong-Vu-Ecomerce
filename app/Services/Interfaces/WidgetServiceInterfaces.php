<?php 

namespace App\Services\Interfaces;

interface WidgetServiceInterfaces {
    public function paginate($request);

    public function create($request);

    public function destroy($id);

    public function update(int $id ,$request);

    // public function findTheWidgetByService(string $keyword = '' , $language_id = 0,$params);

    public function foundTheWidgetByKeyword(array $payload );
}