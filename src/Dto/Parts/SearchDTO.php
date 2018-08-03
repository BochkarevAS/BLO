<?php

namespace App\Dto\Parts;

class SearchDTO
{
    private $model;

    private $carcase;

    private $company;

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

    public function getCity()
    {
        return $this->city;
    }

    public function setCity($city): void
    {
        $this->city = $city;
    }

    public function getCompany()
    {
        return $this->company;
    }

    public function setCompany($company): void
    {
        $this->company = $company;
    }
}