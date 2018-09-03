<?php

namespace App\Entity\Drives;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass="App\Repository\Drive\DriveRepository")
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
     * @ORM\ManyToOne(targetEntity="App\Entity\Drives\Model")
     */
    private $model;

    /**
     * Диамитер
     *
     * @ORM\Column(type="float", nullable=true)
     */
    private $diameter;

    /**
     * Вылет
     *
     * @ORM\Column(type="float", nullable=true)
     */
    private $departure;

    /**
     * Сверловка
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $drilling;

    /**
     * Ширина
     *
     * @ORM\Column(type="float", nullable=true)
     */
    private $width;

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
     * Хэш уникальный индефекатор шины
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $hash;

    /**
     * Город
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Region\City")
     */
    private $city;

    /**
     * Стоимость диска
     *
     * @ORM\Column(type="decimal")
     */
    private $price;

    /**
     * Фотографии
     *
     * @ORM\Column(type="json", nullable=true)
     */
    private $image;

    /**
     * ID пользователя
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Auth\User")
     */
    private $user;

    /**
     * Компания продавец
     * ID может отсутствовать это значит, что объявление подано частным лицом
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Client\Company")
     */
    private $company;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Drives\Comment", mappedBy="drive", fetch="EXTRA_LAZY")
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

    public function getHash()
    {
        return $this->hash;
    }

    public function setHash($hash): void
    {
        $this->hash = $hash;
    }

    public function getAvailability()
    {
        return $this->availability;
    }

    public function setAvailability($availability): void
    {
        $this->availability = $availability;
    }

    public function getCondition()
    {
        return $this->condition;
    }

    public function setCondition($condition): void
    {
        $this->condition = $condition;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function setPrice($price): void
    {
        $this->price = $price;
    }

    public function getImage()
    {
        return $this->image;
    }

    public function setImage($image): void
    {
        $this->image = $image;
    }

    public function getCity()
    {
        return $this->city;
    }

    public function setCity($city): void
    {
        $this->city = $city;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function setUser($user): void
    {
        $this->user = $user;
    }

    public function getCompany()
    {
        return $this->company;
    }

    public function setCompany($company): void
    {
        $this->company = $company;
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