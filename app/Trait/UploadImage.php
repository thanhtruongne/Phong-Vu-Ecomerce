<?php

namespace App\Trait;

use Flasher\Laravel\Http\Request;
use Illuminate\Support\Facades\File;
use Cloudinary\Api\Upload\UploadApi;

trait UploadImage
{
    protected string $folderCloudinary = 'Ecomerce/Images';

    public function UploadSingleImage($dataInput, $pathUpload)
    {
        $image = time() . '_' . $dataInput->getClientOriginalName();
        $dataInput->move(public_path($pathUpload), $image);
        return '/' . $pathUpload . '/' . $image;
    }

    public function UploadUpdateSingleImage($dataInput, $imageAlready, $pathUpload)
    {
        if (File::exists(public_path($imageAlready))) {
            File::delete(public_path($imageAlready));
        }
        $image = time() . '_' . $dataInput->getClientOriginalName();
        $dataInput->move(public_path($pathUpload), $image);
        return '/' . $pathUpload . '/' . $image;
    }





    public function UploadCloudinarySingle(\Illuminate\Http\UploadedFile $file): string
    {


        $uploadedFileUrl =  (new UploadApi())->upload($file->getRealPath(), [
            'folder' => $this->folderCloudinary,
            'public_id' => \Str::slug($this->folderCloudinary) . '_' . time(),
            'eager_async' => true,
            'transformation' => [
                'quality' => 'auto',
                'fetch_format' => 'auto'
            ]
        ]);


        return $uploadedFileUrl['secure_url'];
    }

    public function UploadCloudinaryMultiple(\Illuminate\Http\UploadedFile $files, array $options = []): array
    {
        $results = [];
        $defaultOptions = [
            'resource_type' => 'image',
            'folder' => $this->folderCloudinary,
            'chunk_size' => 6000000,
            'eager_async' => true,
            'transformation' => [
                'quality' => 'auto',
                'fetch_format' => 'auto'
            ]
        ];


        foreach ($files as $index => $file) {
            try {
                $fileOptions = array_merge($defaultOptions, $options);
                $fileOptions['public_id'] = \Str::slug($this->folderCloudinary) . '_' . time() . '_' . $index;

                $result = (new UploadApi())->uploadAsync($file->getRealPath(), $fileOptions);

                $results[] = $result['secure_url'];
            } catch (\Exception $e) {
                $results[] = [
                    'success' => false,
                    'error' => $e->getMessage()
                ];
            }
        }

        return $results;
    }
}
