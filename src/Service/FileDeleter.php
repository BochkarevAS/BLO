<?php

namespace App\Service;

interface FileDeleter
{
    public function delete($pathToFile);
}