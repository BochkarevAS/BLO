<?php

namespace App\Dto\Parts;

class SearchDTO
{
    private $model;

    private $carcase;

    public function getModel()
    {
        return $this->model;
    }

    public function setModel($model): void
    {
        $this->model = $model;
    }

    public function getCarcase()
    {
        return $this->carcase;
    }

    public function setCarcase($carcase): void
    {
        $this->carcase = $carcase;
    }
}