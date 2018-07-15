<?php

namespace App\Entity\Parts;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass="App\Repository\Parts\OemRepository")
 * @ORM\Table(name="oem", schema="parts")
 */
class Oem
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     */
    private $name;

    /**
     * Производитель
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Parts\Brand", inversedBy="oems")
     */
    private $brand;

    /**
     * Модель автомобиля
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Parts\Model", inversedBy="oems")
     */
    private $model;

    /**
     * Модель автомобиля
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Parts\Carcase", inversedBy="oems")
     */
    private $carcase;

    /**
     * Запчасть
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Parts\Part", inversedBy="oems")
     */
    private $part;

    /**
     * Двигатель
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Parts\Engine", inversedBy="oems")
     */
    private $engine;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Region\City", inversedBy="oems")
     */
    private $city;

    /**
     * Продавец
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Client\Vendor", inversedBy="oems")
     */
    private $vendor;

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

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

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
        $this->models = $model;
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

    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }
}