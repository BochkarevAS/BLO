<?php

namespace App\Entity\Tyres;

use App\Entity\Tyres\Profile\Count;
use App\Entity\Tyres\Profile\Diameter;
use App\Entity\Tyres\Profile\Height;
use App\Entity\Tyres\Profile\Width;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass="App\Repository\Tyres\TyresRepository")
 * @ORM\Table(name="tyre", schema="tyres")
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
     * @ORM\Column(type="integer")
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
     * @ORM\ManyToOne(targetEntity="App\Entity\Tyres\Thorn", inversedBy="tyre"))
     */
    private $thorns;

    /**
     * Сезонность
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Tyres\Seasonality", inversedBy="tyre")
     */
    private $seasonalitys;

    /**
     * Модель шины
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Tyres\Model", inversedBy="tyres")
     */
    private $models;

    /**
     * Производитель
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Tyres\Brand", inversedBy="tyres")
     */
    private $brands;

    /**
     * Производитель
     *
     * @ORM\ManyToMany(targetEntity="App\Entity\Tyres\Vendor", inversedBy="tyres")
     * @ORM\JoinTable(name="tyre_vendor", schema="tyres")
     */
    private $vendors;

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
        $this->vendors = new ArrayCollection();
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

    /**
     * @return Seasonality
     */
    public function getSeasonalitys()
    {
        return $this->seasonalitys;
    }

    public function setSeasonalitys($seasonalitys)
    {
        $this->seasonalitys = $seasonalitys;
    }

    /**
     * @return Thorn
     */
    public function getThorns()
    {
        return $this->thorns;
    }

    public function setThorns($thorns)
    {
        $this->thorns = $thorns;
    }

    /**
     * @return Model
     */
    public function getModels()
    {
        return $this->models;
    }

    public function setModels($models)
    {
        $this->models = $models;
    }

    /**
     * @return Brand
     */
    public function getBrands()
    {
        return $this->brands;
    }

    public function setBrands($brands)
    {
        $this->brands = $brands;
    }

    public function addVendors(Vendor $vendor): self
    {
        if (!$this->vendors->contains($vendor)) {
            $this->vendors->add($vendor);
            $vendor->addTyres($this);
        }

        return $this;
    }

    /**
     * @return ArrayCollection|Vendor[]
     */
    public function getVendors()
    {
        return $this->vendors;
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

    public function setId($id)
    {
        $this->id = $id;
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