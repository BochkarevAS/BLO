<?php

namespace App\Entity\Parts;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinTable;
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
     * @ORM\ManyToOne(targetEntity="App\Entity\Parts\Brand", inversedBy="parts")
     */
    private $brand;

//    /**
// * @ORM\ManyToMany(targetEntity="App\Entity\Parts\Model", inversedBy="parts")
// * @JoinTable(name="parts_models", schema="parts")
// */
//    private $models;


    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Parts\Model", inversedBy="parts")
     */
    private $model;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Parts\Carcase", inversedBy="parts")
     * @JoinTable(name="parts_carcases", schema="parts")
     */
    private $carcases;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Parts\Engine", inversedBy="parts")
     * @JoinTable(name="parts_engines", schema="parts")
     */
    private $engines;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Parts\Oem", inversedBy="parts")
     * @JoinTable(name="parts_oems", schema="parts")
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
     * @ORM\JoinColumn(referencedColumnName="id")
     */
    private $city;

    /**
     * Компания продавец
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Client\Company")
     * @ORM\JoinColumn(referencedColumnName="id")
     */
    private $company;

    /**
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
        $carcase->setParts($this);
    }

    public function removeCarcase(Carcase $carcase)
    {
        if (!$this->carcases->contains($carcase)) {
            return;
        }

        $this->carcases->removeElement($carcase);
        $carcase->setParts(null);
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
        $engine->setParts($this);
    }

    public function removeEngine(Engine $engine)
    {
        if (!$this->engines->contains($engine)) {
            return;
        }

        $this->engines->removeElement($engine);
        $engine->setParts(null);
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
        $oem->setParts($this);
    }

    public function removeOem(Oem $oem)
    {
        if (!$this->engines->contains($oem)) {
            return;
        }

        $this->oems->removeElement($oem);
        $oem->setParts(null);
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