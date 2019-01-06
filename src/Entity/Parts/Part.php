<?php

namespace App\Entity\Parts;

use App\DBAL\Types\AvailabilityType;
use App\DBAL\Types\ConditionType;
use App\DBAL\Types\FrontRearType;
use App\DBAL\Types\RightLeftType;
use App\DBAL\Types\UpDownType;
use App\Entity\ProductInterface;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinTable;
use Enqueue\Util\JSON;
use Fresh\DoctrineEnumBundle\Validator\Constraints as DoctrineAssert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\Part\PartRepository")
 * @ORM\Table(name="part", schema="part", indexes={
 *     @ORM\Index(name="availability_idx", columns={"availability"}),
 *     @ORM\Index(name="condition_idx", columns={"condition"}),
 *     @ORM\Index(name="delivery1_idx", columns={"delivery1"}),
 *     @ORM\Index(name="delivery2_idx", columns={"delivery2"}),
 *     @ORM\Index(name="delivery3_idx", columns={"delivery3"})
 * })
 */
class Part implements ProductInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * Название запчасти
     *
     * @ORM\Column(type="text")
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Parts\Brand")
     */
    private $brand;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Parts\Model")
     * @JoinTable(name="parts_models", schema="part")
     */
    private $models;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Parts\Frame")
     * @JoinTable(name="parts_frames", schema="part")
     */
    private $frames;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Parts\Engine")
     * @JoinTable(name="parts_engines", schema="part")
     */
    private $engines;

    /**
     * ОЕМ запчасти
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $oem;

    /**
     * Номер маркировки
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $marking;

    /**
     * @ORM\Column(name="slug", type="string", length=255)
     * @Gedmo\Slug(fields={"name"}, unique=false)
     */
    private $slug;

    /**
     * в наличии/под заказ
     *
     * @ORM\Column(type="AvailabilityType", nullable=true)
     * @DoctrineAssert\Enum(entity="App\DBAL\Types\AvailabilityType")
     */
    private $availability;

    /**
     * контрак/бу
     *
     * @ORM\Column(type="ConditionType", nullable=true)
     * @DoctrineAssert\Enum(entity="App\DBAL\Types\ConditionType")
     */
    private $condition;

    /**
     * верх/низ
     *
     * @ORM\Column(type="UpDownType", nullable=true)
     * @DoctrineAssert\Enum(entity="App\DBAL\Types\UpDownType")
     */
    private $ud;

    /**
     * перед/зад
     *
     * @ORM\Column(type="FrontRearType", nullable=true)
     * @DoctrineAssert\Enum(entity="App\DBAL\Types\FrontRearType")
     */
    private $fr;

    /**
     * лев/прав
     *
     * @ORM\Column(type="RightLeftType", nullable=true)
     * @DoctrineAssert\Enum(entity="App\DBAL\Types\RightLeftType")
     */
    private $rl;

    /**
     * Хэш уникальный индефекатор
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $hash;

    /**
     * Цена
     *
     * @ORM\Column(type="decimal", nullable=true)
     */
    private $price;

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
     * Текст объявления
     *
     * @ORM\Column(type="text", name="text_declaration", nullable=true)
     */
    private $textDeclaration;

    /**
     * Год выпуска
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    private $year;

    /**
     * Доставка и оплата: По городу
     *
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $delivery1;

    /**
     * Доставка и оплата: До транспортной компании
     *
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $delivery2;

    /**
     * Доставка и оплата: Почтой России
     *
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $delivery3;

    /**
     * Адрес самовывоза
     *
     * @ORM\Column(type="text", nullable=true)
     */
    private $address;

    /**
     * Условия доставки и оплаты
     *
     * @ORM\Column(type="text", name="delivery_payment", nullable=true)
     */
    private $deliveryPayment;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Parts\Comment", mappedBy="product", fetch="EXTRA_LAZY", orphanRemoval=true)
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
        $this->models   = new ArrayCollection();
        $this->frames   = new ArrayCollection();
        $this->engines  = new ArrayCollection();
    }

    public function getSlug()
    {
        return $this->slug;
    }

    public function setSlug($slug): void
    {
        $this->slug = $slug;
    }

    public function getBrand()
    {
        return $this->brand;
    }

    public function setBrand($brand): void
    {
        $this->brand = $brand;
    }

    public function getModels()
    {
        return $this->models;
    }

    public function setModels($model): void
    {
        $this->models = $model;
    }

    public function addModel(Model $model)
    {
        if ($this->models->contains($model)) {
            return;
        }

        $this->models[] = $model;
    }

    public function removeModel(Model $model)
    {
        if (!$this->models->contains($model)) {
            return;
        }

        $this->models->removeElement($model);
    }

    public function getFrames()
    {
        return $this->frames;
    }

    public function setFrames($frames): void
    {
        $this->frames = $frames;
    }

    public function addFrame(Frame $frame)
    {
        if ($this->frames->contains($frame)) {
            return;
        }
        $this->frames[] = $frame;
    }

    public function removeFrame(Frame $frame)
    {
        if (!$this->frames->contains($frame)) {
            return;
        }
        $this->frames->removeElement($frame);
    }

    public function getEngines()
    {
        return $this->engines;
    }

    public function setEngines($engines): void
    {
        $this->engines = $engines;
    }

    public function addEngine(Engine $engine)
    {
        if ($this->engines->contains($engine)) {
            return;
        }
        $this->engines[] = $engine;
    }

    public function removeEngine(Engine $engine)
    {
        if (!$this->engines->contains($engine)) {
            return;
        }
        $this->engines->removeElement($engine);
    }

    public function getOem()
    {
        return $this->oem;
    }

    public function setOem($oem): void
    {
        $this->oem = $oem;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name): void
    {
        $this->name = $name;
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

    public function getComments()
    {
        return $this->comments;
    }

    public function setComments($comments): void
    {
        $this->comments[] = $comments;
    }

    public function getUd()
    {
        return $this->ud;
    }

    public function setUd($ud): void
    {
        $this->ud = $ud;
    }

    public function getFr()
    {
        return $this->fr;
    }

    public function setFr($fr): void
    {
        $this->fr = $fr;
    }

    public function getRl()
    {
        return $this->rl;
    }

    public function setRl($rl): void
    {
        $this->rl = $rl;
    }

    public function getDelivery1()
    {
        return $this->delivery1;
    }

    public function getYear()
    {
        return $this->year;
    }

    public function setYear($year): void
    {
        $this->year = $year;
    }

    public function setDelivery1($delivery1): void
    {
        $this->delivery1 = $delivery1;
    }

    public function getDelivery2()
    {
        return $this->delivery2;
    }

    public function setDelivery2($delivery2): void
    {
        $this->delivery2 = $delivery2;
    }

    public function getDelivery3()
    {
        return $this->delivery3;
    }

    public function setDelivery3($delivery3): void
    {
        $this->delivery3 = $delivery3;
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

    public function getTextDeclaration()
    {
        return $this->textDeclaration;
    }

    public function setTextDeclaration($textDeclaration): void
    {
        $this->textDeclaration = $textDeclaration;
    }

    public function getMarking()
    {
        return $this->marking;
    }

    public function setMarking($marking)
    {
        $this->marking = $marking;
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

    public function getNameSuggest()
    {
        return [
            'input' => explode(' ', $this->getName())
        ];
    }

    public function getOutput()
    {
        return $this->getName();
    }

    /**
     * Здесь будут хранится OEM только содержащие цифры или буквы. Например было kb-35 стало kb35.
     */
    public function getOemSymbol()
    {
        $list = [];
        $oems = explode(',', $this->getOem());

        foreach ($oems as $oem) {
            $list[] = preg_replace('![^A-Za-z0-9]+!', '', mb_strtolower($oem));
        }

        $result = implode(', ', $list);

        return $result;
    }

    public static function createFromDto($dto): self
    {
        $part = new self();

        $dto->availability = AvailabilityType::$availability[$dto->availability];
        $dto->condition    = ConditionType::$condition[$dto->condition];
        $dto->ud           = UpDownType::$locations[$dto->ud];
        $dto->fr           = FrontRearType::$locations[$dto->fr];
        $dto->rl           = RightLeftType::$locations[$dto->rl];

        $part->setBrand($dto->brand);
        $part->setModels($dto->models);
        $part->setFrames($dto->frames);
        $part->setEngines($dto->engines);
        $part->setName($dto->name);
        $part->setOem($dto->oem);
        $part->setMarking($dto->marking);
        $part->setUd($dto->ud);
        $part->setFr($dto->fr);
        $part->setRl($dto->rl);
        $part->setUser($dto->user);
        $part->setCompany($dto->company);
        $part->setCity($dto->city);
        $part->setYear($dto->year);
        $part->setAvailability($dto->availability);
        $part->setTextDeclaration($dto->textDeclaration);
        $part->setAddress($dto->address);
        $part->setDelivery1($dto->delivery1);
        $part->setDelivery2($dto->delivery2);
        $part->setDelivery3($dto->delivery3);
        $part->setDeliveryPayment($dto->deliveryPayment);
        $part->setPrice($dto->price);
        $part->setCondition($dto->condition);
        $part->setImages($dto->images);

        return $part;
    }

    public function updateFromDto($dto): self
    {
        $this->setBrand($dto->brand);
        $this->setModels($dto->models);
        $this->setFrames($dto->frames);
        $this->setEngines($dto->engines);
        $this->setName($dto->name);
        $this->setOem($dto->oem);
        $this->setMarking($dto->marking);
        $this->setUd($dto->ud);
        $this->setFr($dto->fr);
        $this->setRl($dto->rl);
        $this->setCity($dto->city);
        $this->setYear($dto->year);
        $this->setAvailability($dto->availability);
        $this->setTextDeclaration($dto->textDeclaration);
        $this->setAddress($dto->address);
        $this->setDelivery1($dto->delivery1);
        $this->setDelivery2($dto->delivery2);
        $this->setDelivery3($dto->delivery3);
        $this->setDeliveryPayment($dto->deliveryPayment);
        $this->setPrice($dto->price);
        $this->setCondition($dto->condition);
        $this->setImages($dto->images);

        return $this;
    }
}