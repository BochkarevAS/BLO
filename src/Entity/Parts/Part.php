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
     * @ORM\Column(type="string")
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
     * @ORM\ManyToMany(targetEntity="App\Entity\Parts\Brand", inversedBy="parts")
     * @JoinTable(name="parts_brands", schema="parts")
     */
    private $brands;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Parts\Model", inversedBy="parts")
     * @JoinTable(name="parts_models", schema="parts")
     */
    private $models;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Parts\Carcase", inversedBy="parts")
     * @JoinTable(name="parts_carcases", schema="parts")
     */
    private $carcases;

    /**
     * Здесь будут данные с фильтра
     */
    private $parts;

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
        $this->brands   = new ArrayCollection();
        $this->models   = new ArrayCollection();
        $this->carcases = new ArrayCollection();
    }

    public function getBrands()
    {
        return $this->brands;
    }

    public function addBrand(Brand $brand)
    {
        if ($this->brands->contains($brand)) {
            return;
        }

        $this->brands[] = $brand;
        $brand->setParts($this);
    }

    public function removeBrand(Brand $brand)
    {
        if (!$this->brands->contains($brand)) {
            return;
        }

        $this->brands->removeElement($brand);
        $brand->setParts(null);
    }

    public function getModels()
    {
        return $this->models;
    }

    public function addModel(Model $model)
    {
        if ($this->models->contains($model)) {
            return;
        }

        $this->models[] = $model;
        $model->setParts($this);
    }

    public function removeModel(Model $model)
    {
        if (!$this->models->contains($model)) {
            return;
        }

        $this->models->removeElement($model);
        $model->setParts(null);
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

    public function getParts()
    {
        return $this->parts;
    }

    public function setParts($parts): void
    {
        $this->parts = $parts;
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