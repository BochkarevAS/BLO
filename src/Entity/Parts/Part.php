<?php

namespace App\Entity\Parts;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass="App\Repository\Parts\PartRepository")
 * @ORM\Table(name="part", schema="parts")
 */
class Part
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * Производитель
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Parts\Brand", inversedBy="parts")
     */
    private $brand;

    /**
     * Модель автомобиля
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Parts\Model", inversedBy="parts")
     */
    private $model;

    /**
     * Модель автомобиля
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Parts\Carcase", inversedBy="parts")
     */
    private $carcase;

    /**
     * Запчасть
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Parts\PartName", inversedBy="parts")
     */
    private $part;

    /**
     * Двигатель
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Parts\Engine", inversedBy="parts")
     */
    private $engine;

    /**
     * OEM, артикул
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Parts\Oem", inversedBy="parts")
     */
    private $oem;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Region\City", inversedBy="parts")
     */
    private $city;

    /**
     * Продавец
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Parts\Vendor", inversedBy="parts")
     */
    private $vendor;

    /**
     * Хэш уникальный индефекатор шины
     *
     * @ORM\Column(type="string")
     */
    private $hash;

    /**
     * Стоимость запчасти
     *
     * @ORM\Column(type="decimal")
     */
    private $price;

    /**
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime", name="created_at")
     */
    private $createdAt;

    /**
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime", name="updated_at")
     */
    private $updatedAt;


    public function getBrand()
    {
        return $this->brand;
    }

    public function setBrand($brand)
    {
        $this->brand = $brand;
    }

    public function getModel()
    {
        return $this->model;
    }

    public function setModel($model)
    {
        $this->model = $model;
    }

    public function getCarcase()
    {
        return $this->carcase;
    }

    public function setCarcase($carcase)
    {
        $this->carcase = $carcase;
    }

    public function getPart()
    {
        return $this->part;
    }

    public function setPart($part)
    {
        $this->part = $part;
    }

    public function getEngine()
    {
        return $this->engine;
    }

    public function setEngine($engine)
    {
        $this->engine = $engine;
    }

    public function getOem()
    {
        return $this->oem;
    }

    public function setOem($oem): void
    {
        $this->oem = $oem;
    }

    public function getCity()
    {
        return $this->city;
    }

    public function setCity($city)
    {
        $this->city = $city;
    }

    public function getVendor()
    {
        return $this->vendor;
    }

    public function setVendor($vendor)
    {
        $this->vendor = $vendor;
    }

    public function getHash()
    {
        return $this->hash;
    }

    public function setHash($hash): void
    {
        $this->hash = $hash;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function setPrice($price): void
    {
        $this->price = $price;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }
}