<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileUploader
{
    public function upload(UploadedFile $file = null, $targetDirectory)
    {
        $fileName = md5(uniqid()).'.'.$file->guessExtension();
        $file->move($targetDirectory, $fileName);

        return $fileName;
    }
}