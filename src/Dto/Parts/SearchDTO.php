<?php

namespace App\Dto\Parts;

class SearchDTO
{
    private $oem;

    private $engine;

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