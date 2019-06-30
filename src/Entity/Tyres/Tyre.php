<?php

declare(strict_types=1);

namespace App\Entity\Tyres;

use App\Dto\TyreDto;
use App\Entity\ProductInterface;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Enqueue\Util\JSON;
use Fresh\DoctrineEnumBundle\Validator\Constraints as DoctrineAssert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\Tyre\TyreRepository")
 * @ORM\Table(name="tyre", schema="tyre", indexes={
 *     @ORM\Index(name="width_idx", columns={"width"}),
 *     @ORM\Index(name="height_idx", columns={"height"}),
 *     @ORM\Index(name="diameter_idx", columns={"diameter"}),
 *     @ORM\Index(name="width_in_idx", columns={"width_in"}),
 *     @ORM\Index(name="height_in_idx", columns={"height_in"}),
 *     @ORM\Index(name="diameter_in_idx", columns={"diameter_in"}),
 *     @ORM\Index(name="quantity_idx", columns={"quantity"}),
 *     @ORM\Index(name="wear_idx", columns={"wear"}),
 * })
 */
class Tyre implements ProductInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Tyres\Brand")
     */
    private $brand;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Tyres\Model")
     */
    private $model;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $width;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $height;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $diameter;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $widthIn;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $heightIn;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $diameterIn;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $quantity;

    /**
     * @ORM\Column(type="TyreTypes", nullable=true)
     * @DoctrineAssert\Enum(entity="App\DBAL\Types\TyreTypes")
     */
    private $type;

    /**
     * @ORM\Column(type="ProtectorTypes", nullable=true)
     * @DoctrineAssert\Enum(entity="App\DBAL\Types\ProtectorTypes")
     */
    private $protector;
    /**
     * в наличии/под заказ
     *
     * @ORM\Column(type="AvailabilityType", nullable=true)
     * @DoctrineAssert\Enum(entity="App\DBAL\Types\AvailabilityType")
     */
    private $availability;

    /**
     * @ORM\Column(type="ConditionType", nullable=true)
     * @DoctrineAssert\Enum(entity="App\DBAL\Types\ConditionType")
     */
    private $condition;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $wear;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $year;

    /**
     * @ORM\Column(type="text", name="text_declaration", nullable=true)
     */
    private $textDeclaration;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $deliveryCity;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $deliveryCompany;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $deliveryPost;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $address;

    /**
     * @ORM\Column(type="text", name="delivery_payment", nullable=true)
     */
    private $deliveryPayment;

    /**
     * Хэш уникальный индефекатор
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $hash;

    /**
     * Цена. Не может быть null.
     *
     * @ORM\Column(type="decimal")
     */
    private $price;

    /**
     * Код товара
     *
     * @ORM\Column(type="text", nullable=true)
     */
    private $code;

    /**
     * Количество хитов (просмотров страниц)
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    private $views;

    /**
     * Фотографии здесь будет только скаченные картинки
     *
     * @ORM\Column(type="json", nullable=true)
     */
    private $images;

    /**
     * Здесь будут хранится url на фотографии
     *
     * @ORM\Column(type="json", nullable=true)
     */
    private $links;

    /**
     * Город
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Region\City")
     */
    private $city;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Client\Company")
     */
    private $company;

    /**
     * ID пользователя
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Profile\User")
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Client\TyreFavorite", mappedBy="product")
     */
    private $favorites;

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
        $this->comments  = new ArrayCollection();
        $this->favorites = new ArrayCollection();
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

    public function getWidthIn()
    {
        return $this->widthIn;
    }

    public function setWidthIn($widthIn)
    {
        $this->widthIn = $widthIn;
    }

    public function getHeightIn()
    {
        return $this->heightIn;
    }

    public function setHeightIn($heightIn)
    {
        $this->heightIn = $heightIn;
    }

    public function getDiameterIn()
    {
        return $this->diameterIn;
    }

    public function setDiameterIn($diameterIn)
    {
        $this->diameterIn = $diameterIn;
    }

    public function getQuantity()
    {
        return $this->quantity;
    }

    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
    }

    public function getType()
    {
        return $this->type;
    }

    public function setType($type)
    {
        $this->type = $type;
    }

    public function getProtector()
    {
        return $this->protector;
    }

    public function setProtector($protector)
    {
        $this->protector = $protector;
    }

    public function getCode()
    {
        return $this->code;
    }

    public function setCode($code)
    {
        $this->code = $code;
    }

    public function getViews()
    {
        return $this->views;
    }

    public function setViews($views)
    {
        $this->views = $views;
    }

    public function getTextDeclaration()
    {
        return $this->textDeclaration;
    }

    public function setTextDeclaration($textDeclaration): void
    {
        $this->textDeclaration = $textDeclaration;
    }

    public function getWear()
    {
        return $this->wear;
    }

    public function setWear($wear): void
    {
        $this->wear = $wear;
    }

    public function getYear()
    {
        return $this->year;
    }

    public function setYear($year): void
    {
        $this->year = $year;
    }

    public function getDeliveryCity()
    {
        return $this->deliveryCity;
    }

    public function setDeliveryCity($deliveryCity)
    {
        $this->deliveryCity = $deliveryCity;
    }

    public function getDeliveryCompany()
    {
        return $this->deliveryCompany;
    }

    public function setDeliveryCompany($deliveryCompany)
    {
        $this->deliveryCompany = $deliveryCompany;
    }

    public function getDeliveryPost()
    {
        return $this->deliveryPost;
    }

    public function setDeliveryPost($deliveryPost)
    {
        $this->deliveryPost = $deliveryPost;
    }

    public function getAddress()
    {
        return $this->address;
    }

    public function setAddress($address): void
    {
        $this->address = $address;
    }

    public function getDeliveryPayment()
    {
        return $this->deliveryPayment;
    }

    public function setDeliveryPayment($deliveryPayment): void
    {
        $this->deliveryPayment = $deliveryPayment;
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

    public function getImages()
    {
        return JSON::decode($this->images);
    }

    public function setImages($images): void
    {
        $this->images = JSON::encode($images);
    }

    public function getLinks()
    {
        return $this->links;
    }

    public function setLinks($links): void
    {
        $this->links = $links;
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

    public function getFavorites()
    {
        return $this->favorites;
    }

    public function setFavorites($favorites)
    {
        $this->favorites = $favorites;
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

    public static function transform(TyreDto $dto): self
    {
        $tyre = new self();

        if (null === $dto->price) {
            $dto->price = 0;
        }

        $tyre->setBrand($dto->brand);
        $tyre->setModel($dto->model);
        $tyre->setUser($dto->user);
        $tyre->setCompany($dto->company);
        $tyre->setCity($dto->city);
        $tyre->setDiameter($dto->diameter);
        $tyre->setHeight($dto->height);
        $tyre->setWidth($dto->width);
        $tyre->setQuantity($dto->quantity);
        $tyre->setYear($dto->year);
        $tyre->setProtector($dto->protector);
        $tyre->setType($dto->type);
        $tyre->setAvailability($dto->availability);
        $tyre->setWear($dto->wear);
        $tyre->setTextDeclaration($dto->textDeclaration);
        $tyre->setAddress($dto->address);
        $tyre->setDeliveryCity($dto->deliveryCity);
        $tyre->setDeliveryCompany($dto->deliveryCompany);
        $tyre->setDeliveryPost($dto->deliveryPost);
        $tyre->setDeliveryPayment($dto->deliveryPayment);
        $tyre->setPrice($dto->price);
        $tyre->setCondition($dto->condition);
        $tyre->setImages($dto->images);

        return $tyre;
    }

    public function __toString()
    {
        return $this->getBrand() . ' ' . $this->getModel();
    }
}