<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileUploader
{
    public function upload(UploadedFile $file, $targetDirectory)
    {
        $fileName = md5(uniqid()).'.'.$file->guessExtension();
        $file->move($targetDirectory, $fileName);

        return $fileName;
    }

    public function uploadMultiple(array $files, $targetDirectory)
    {
        $fileArray = [];

        foreach ($files as $file) {
            $fileName = md5(uniqid()).'.'.$file->guessExtension();
            $fileArray[] = $fileName;
            $file->move($targetDirectory, $fileName);

            unset($file);
        }

        return $fileArray;
    }
}