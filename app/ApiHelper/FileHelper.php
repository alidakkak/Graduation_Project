<?php

namespace App\ApiHelper;

class FileHelper
{
    public static function handlingImageName($File)
    {
        $originalFilename = $File->getClientOriginalName();
        $fileExtension = $File->getClientOriginalExtension();
        $randomNumber = mt_rand(10000, 99999);
        $filenameWithoutExtension = pathinfo($originalFilename, PATHINFO_FILENAME);
        $modifiedFilename = str_replace(' ', '_', $filenameWithoutExtension).'_'.$randomNumber;
        $generatedFilename = $modifiedFilename.'.'.$fileExtension;
        $destinationPath = public_path('Files');
        $File->move($destinationPath, $generatedFilename);

        return '/Files/'.$generatedFilename;
    }

    public static function handlingPhotoName($File, $pathName)
    {
        $originalFilename = $File->getClientOriginalName();
        $fileExtension = $File->getClientOriginalExtension();
        $randomNumber = mt_rand(10000, 99999);
        $filenameWithoutExtension = pathinfo($originalFilename, PATHINFO_FILENAME);
        $modifiedFilename = str_replace(' ', '_', $filenameWithoutExtension).'_'.$randomNumber;
        $generatedFilename = $modifiedFilename.'.'.$fileExtension;
        $destinationPath = public_path($pathName);
        $File->move($destinationPath, $generatedFilename);

        return $pathName.$generatedFilename;
    }
}
