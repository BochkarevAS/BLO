<?php

namespace App\Entity\Parts;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinTable;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass="App\Repository\Parts\PartRepository")
 * @ORM\Table(name="part", schema="part")
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
     * Название запчасти
     *
     * @ORM\Column(type="text")
     */
    private $name;

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
     * @ORM\ManyToOne(targetEntity="App\Entity\Parts\Brand")
     */
    private $brand;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Parts\Model")
     */
    private $model;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Parts\Carcase", inversedBy="parts")
     * @JoinTable(name="parts_carcases", schema="part")
     */
    private $carcases;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Parts\Engine", inversedBy="parts")
     * @JoinTable(name="parts_engines", schema="part")
     */
    private $engines;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Parts\Oem", inversedBy="parts")
     * @JoinTable(name="parts_oems", schema="part")
     */
    private $oems;

    /**
     * @ORM\Column(name="slug", type="string", length=255)
     * @Gedmo\Slug(fields={"name"}, unique=false)
     */
    private $slug;

    /**
     * Город
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Region\City")
     */
    private $city;

    /**
     * Компания продавец
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Client\Company")
     */
    private $company;

    /**
     * Фотографии
     *
     * @ORM\Column(type="json")
     */
    private $picture;

    /**
     * ID пользователя
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Auth\User")
     */
    private $user;

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
        $this->carcases = new ArrayCollection();
        $this->engines  = new ArrayCollection();
        $this->oems     = new ArrayCollection();
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

    public function getModel()
    {
        return $this->model;
    }

    public function setModel($model): void
    {
        $this->model = $model;
    }

    public function getCarcases()
    {
        return $this->carcases;
    }

    public function addCarcase(Carcase $carcase)
    {
        if ($this->carcases->contains($carcase)) {
            return;
        }

        $this->carcases[] = $carcase;
        $carcase->addParts($this);
    }

    public function removeCarcase(Carcase $carcase)
    {
        if (!$this->carcases->contains($carcase)) {
            return;
        }

        $this->carcases->removeElement($carcase);
        $carcase->addParts($this);
    }

    public function getEngines()
    {
        return $this->engines;
    }

    public function addEngine(Engine $engine)
    {
        if ($this->engines->contains($engine)) {
            return;
        }

        $this->engines[] = $engine;
        $engine->addParts($this);
    }

    public function removeEngine(Engine $engine)
    {
        if (!$this->engines->contains($engine)) {
            return;
        }

        $this->engines->removeElement($engine);
        $engine->addParts($this);
    }

    public function getOems()
    {
        return $this->oems;
    }

    public function addOem(Oem $oem)
    {
        if ($this->oems->contains($oem)) {
            return;
        }

        $this->oems[] = $oem;
        $oem->addParts($this);
    }

    public function removeOem(Oem $oem)
    {
        if (!$this->engines->contains($oem)) {
            return;
        }

        $this->oems->removeElement($oem);
        $oem->addParts($this);
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name): void
    {
        $this->name = $name;
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

    public function getUser()
    {
        return $this->user;
    }

    public function setUser($user): void
    {
        $this->user = $user;
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

    public function getPicture()
    {
        return $this->picture;
    }

    public function setPicture($picture): void
    {
        $this->picture = $picture;
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