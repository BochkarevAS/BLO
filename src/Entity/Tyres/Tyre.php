<?php

namespace App\Entity\Tyres;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass="App\Repository\Tyres\TyresRepository")
 * @ORM\Table(name="tyre", schema="tyres", indexes={
 *     @ORM\Index(name="width_idx", columns={"width"}),
 *     @ORM\Index(name="height_idx", columns={"height"}),
 *     @ORM\Index(name="diameter_idx", columns={"diameter"}),
 *     @ORM\Index(name="quantity_idx", columns={"quantity"})
 * })
 */
class Tyre
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * Ширина профиля (мм)
     *
     * @ORM\Column(type="integer")
     */
    private $width;

    /**
     * Высота профиля (%)
     *
     * @ORM\Column(type="integer")
     */
    private $height;

    /**
     * Посадочный диаметр (мм)
     *
     * @ORM\Column(type="float")
     */
    private $diameter;

    /**
     * Количество
     *
     * @ORM\Column(type="integer")
     */
    private $quantity;

    /**
     * Шипы
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Tyres\Thorn")
<<<<<<<<< Temporary merge branch 1
     * @ORM\JoinColumn(referencedColumnName="id")
=========
>>>>>>>>> Temporary merge branch 2
     */
    private $thorn;

    /**
     * Сезонность
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Tyres\Seasonality")
<<<<<<<<< Temporary merge branch 1
     * @ORM\JoinColumn(referencedColumnName="id")
=========
>>>>>>>>> Temporary merge branch 2
     */
    private $seasonality;

    /**
     * Производитель
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Tyres\Brand", inversedBy="tyres")
     */
    private $brand;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Tyres\Model")
<<<<<<<<< Temporary merge branch 1
     * @ORM\JoinColumn(referencedColumnName="id")
=========
>>>>>>>>> Temporary merge branch 2
     */
    private $model;

    /**
     * Город
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Region\City")
<<<<<<<<< Temporary merge branch 1
     * @ORM\JoinColumn(referencedColumnName="id")
=========
>>>>>>>>> Temporary merge branch 2
     */
    private $city;

    /**
     * Компания продавец
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Client\Company")
<<<<<<<<< Temporary merge branch 1
     * @ORM\JoinColumn(referencedColumnName="id")
=========
>>>>>>>>> Temporary merge branch 2
     */
    private $company;

    /**
     * Хэш уникальный индефекатор шины
     *
     * @ORM\Column(type="string")
     */
    private $hash;

    /**
     * Стоимость шины
     *
     * @ORM\Column(type="decimal")
     */
    private $price;

    /**
<<<<<<<<< Temporary merge branch 1
=========
     * Состояние
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Client\Availability")
     */
    private $availability;

    /**
     * Наличие
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Client\Condition")
     */
    private $condition;

    /**
>>>>>>>>> Temporary merge branch 2
     * Фотографии
     *
     * @ORM\Column(type="json")
     */
    private $picture;

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

    public function getWidth()
    {
        return $this->width;
    }

    public function setWidth($width)
    {
        $this->width = $width;
    }

    public function getHeight()
    {
        return $this->height;
    }

    public function setHeight($height)
    {
        $this->height = $height;
    }

    public function getDiameter()
    {
        return $this->diameter;
    }

    public function setDiameter($diameter)
    {
        $this->diameter = $diameter;
    }

    public function getQuantity()
    {
        return $this->quantity;
    }

    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
    }

<<<<<<<<< Temporary merge branch 1
    /**
     * @return Seasonality
     */
=========
>>>>>>>>> Temporary merge branch 2
    public function getSeasonality()
    {
        return $this->seasonality;
    }

    public function setSeasonality($seasonality)
    {
        $this->seasonality = $seasonality;
    }

<<<<<<<<< Temporary merge branch 1
    /**
     * @return Thorn
     */
=========
>>>>>>>>> Temporary merge branch 2
    public function getThorn()
    {
        return $this->thorn;
    }

    public function setThorn($thorn)
    {
        $this->thorn = $thorn;
    }

    public function getModel()
    {
        return $this->model;
    }

    public function setModel($model): void
    {
        $this->model = $model;
    }

<<<<<<<<< Temporary merge branch 1
    /**
     * @return Brand
     */
=========
>>>>>>>>> Temporary merge branch 2
    public function getBrand()
    {
        return $this->brand;
    }

    public function setBrand($brand)
    {
        $this->brand = $brand;
    }

    public function getHash()
    {
        return $this->hash;
    }

    public function setHash($hash)
    {
        $this->hash = $hash;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function setPrice($price)
    {
        $this->price = $price;
    }

<<<<<<<<< Temporary merge branch 1
=========
    public function getAvailability()
    {
        return $this->availability;
    }

    public function setAvailability($availability)
    {
        $this->availability = $availability;
    }

    public function getCondition()
    {
        return $this->condition;
    }

    public function setCondition($condition)
    {
        $this->condition = $condition;
    }

>>>>>>>>> Temporary merge branch 2
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

    public function getPicture()
    {
        return $this->picture;
    }

    public function setPicture($picture): void
    {
        $this->picture = $picture;
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