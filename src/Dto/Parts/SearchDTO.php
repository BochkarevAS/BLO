<?php

namespace App\Dto\Parts;

class SearchDTO
{
    private $model;

    private $carcase;

    private $company;

    private $oem;

    private $engine;

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

    public function getCompany()
    {
        return $this->company;
    }

    public function setCompany($company): void
    {
        $this->company = $company;
    }

    public function getOem()
    {
        return $this->oem;
    }

    public function setOem($oem): void
    {
        $this->oem = $oem;
    }

    public function getEngine()
    {
        return $this->engine;
    }

    public function setEngine($engine): void
    {
        $this->engine = $engine;
    }
}