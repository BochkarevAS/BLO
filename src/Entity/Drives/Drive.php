<?php

namespace App\Entity\Drives;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity
 * @ORM\Table(name="drive", schema="drive")
 */
class Drive
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Drives\Brand")
     */
    private $brand;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Drives\Brand")
     */
    private $model;

    /**
     * Диамитер
     *
     * @ORM\Column(type="float")
     */
    private $diameter;

    /**
     * Вылет
     *
     * @ORM\Column(type="float")
     */
    private $departure;

    /**
     * Сверловка
     *
     * @ORM\Column(type="string")
     */
    private $drilling;

    /**
     * Ширина
     *
     * @ORM\Column(type="float")
     */
    private $width;

    /**
     * Город
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Region\City")
     */
    private $city;

    /**
     * Компания продавец
     * ID может отсутствовать это значит, что объявление подано частным лицом
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Client\Company")
     */
    private $company;

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

    public function setBrand($brand): void
    {
        $this->brand = $brand;
    }

    public function getModel()
    {
        return $this->model;
    }

    public function setModel($model): void
    {
        $this->model = $model;
    }

    public function getDiameter()
    {
        return $this->diameter;
    }

    public function setDiameter($diameter)
    {
        $this->diameter = $diameter;
    }

    public function getDeparture()
    {
        return $this->departure;
    }

    public function setDeparture($departure)
    {
        $this->departure = $departure;
    }

    public function getDrilling()
    {
        return $this->drilling;
    }

    public function setDrilling($drilling)
    {
        $this->drilling = $drilling;
    }

    public function getWidth()
    {
        return $this->width;
    }

    public function setWidth($width)
    {
        $this->width = $width;
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