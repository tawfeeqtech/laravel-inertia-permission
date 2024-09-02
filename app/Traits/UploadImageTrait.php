<?php

namespace App\Traits;

trait UploadImageTrait
{
    public function uploadFile($image, $folderName)
    {
        $imageName = time() . '.' . $image->getClientOriginalExtension();
        $image->storeAs($folderName, $imageName, 'upload');
        return $imageName;
    }
}
