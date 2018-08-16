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

    public function removeUpload()
    {
        if ($file = $this->getAbsolutePath()) {
            unlink($file);
        }
    }
}