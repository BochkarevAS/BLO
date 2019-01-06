<?php

namespace App\Dto;

use App\Entity\Parts\Part;

class PartDto
{
    public $id;

    public $brand;

    public $models;

    public $engines;

    public $frames;

    public $oem;

    public $name;

    public $marking;

    public $city;

    public $availability;

    public $condition;

    public $price;

    public $images;

    public $ud;

    public $fr;

    public $rl;

    public $textDeclaration;

    public $address;

    public $delivery1;

    public $delivery2;

    public $delivery3;

    public $deliveryPayment;

    public $declaration;

    public $company;

    public $year;

    public $priceFrom;

    public $priceTo;

    public static function createFromEntity(Part $part): self
    {
        $dto = new self();

        $dto->brand           = $part->getBrand();
        $dto->models          = $part->getModels();
        $dto->frames          = $part->getFrames();
        $dto->engines         = $part->getEngines();
        $dto->city            = $part->getCity();
        $dto->oem             = $part->getOem();
        $dto->name            = $part->getName();
        $dto->marking         = $part->getMarking();
        $dto->ud              = $part->getUd();
        $dto->fr              = $part->getFr();
        $dto->rl              = $part->getRl();
        $dto->year            = $part->getYear();
        $dto->availability    = $part->getAvailability();
        $dto->textDeclaration = $part->getTextDeclaration();
        $dto->address         = $part->getAddress();
        $dto->delivery1       = $part->getDelivery1();
        $dto->delivery2       = $part->getDelivery2();
        $dto->delivery3       = $part->getDelivery3();
        $dto->deliveryPayment = $part->getDeliveryPayment();
        $dto->price           = $part->getPrice();
        $dto->condition       = $part->getCondition();
        $dto->images          = $part->getImages();

        return $dto;
    }
}

