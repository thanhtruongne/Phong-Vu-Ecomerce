<?php 
namespace App\Trait;

use Flasher\Laravel\Http\Request;
use Illuminate\Support\Facades\File;

trait UploadImage {
    public function UploadSingleImage($dataInput,$pathUpload) {
      $image = time().'_'.$dataInput->getClientOriginalName();
      $dataInput->move(public_path($pathUpload),$image);
      return '/'.$pathUpload.'/'.$image ;

    }

    public function UploadUpdateSingleImage($dataInput,$imageAlready,$pathUpload) {
      if(File::exists(public_path($imageAlready))) {
         File::delete(public_path($imageAlready));
      }
      $image = time().'_'.$dataInput->getClientOriginalName();
      $dataInput->move(public_path($pathUpload),$image);
      return '/'.$pathUpload.'/'.$image ;

    }
}