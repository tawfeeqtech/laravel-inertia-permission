<?php

namespace App\Utils;

class MediaUpload
{
    public static function uploadFile($image, $folderName)
    {
        $imageName = time() . '.' . $image->getClientOriginalExtension();
        $image->storeAs($folderName, $imageName, 'upload');
        return $imageName;
    }
}
