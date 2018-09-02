<?php

namespace App\Entity\Tyres;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass="App\Repository\Tyre\TyreRepository")
 * @ORM\Table(name="tyre", schema="tyre", indexes={
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
     * @ORM\Column(type="integer", nullable=true)
     */
    private $width;

    /**
     * Высота профиля (%)
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    private $height;

    /**
     * Посадочный диаметр (мм)
     *
     * @ORM\Column(type="float", nullable=true)
     */
    private $diameter;

    /**
     * Количество
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    private $quantity;

    /**
     * Шипы
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Tyres\Thorn")
     */
    private $thorn;

    /**
     * Сезонность
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Tyres\Seasonality")
     */
    private $seasonality;

    /**
     * Производитель
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Tyres\Brand")
     */
    private $brand;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Tyres\Model")
     */
    private $model;

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
     * ID пользователя
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Auth\User")
     */
    private $user;

    /**
     * Хэш уникальный индефекатор шины
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $hash;

    /**
     * Стоимость шины
     *
     * @ORM\Column(type="decimal", nullable=true)
     */
    private $price;

    /**
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
     * Фотографии
     *
     * @ORM\Column(type="json", nullable=true)
     */
    private $image;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Tyres\Comment", mappedBy="tyre", fetch="EXTRA_LAZY")
     */
    private $comments;

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

    public function __construct()
    {
        $this->comments = new ArrayCollection();
    }

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

    public function getSeasonality()
    {
        return $this->seasonality;
    }

    public function setSeasonality($seasonality)
    {
        $this->seasonality = $seasonality;
    }

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

    public function getUser()
    {
        return $this->user;
    }

    public function setUser($user): void
    {
        $this->user = $user;
    }

    public function getImage()
    {
        return $this->image;
    }

    public function setImage($image): void
    {
        $this->image = $image;
    }

    public function getComments()
    {
        return $this->comments;
    }

    public function setComments($comments): void
    {
        $this->comments[] = $comments;
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