<?php 

namespace App\Services\Interfaces;

interface PermissionsServiceInterfaces {

  public function paginate($request);

    public function create($request);

    public function destroy($id);

    public function ChangeRoles($request);

    public function update(int $id ,$request);

}