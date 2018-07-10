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
     * @ORM\ManyToOne(targetEntity="App\Entity\Tyres\Profile\Width", inversedBy="tyres")
     */
    private $widths;

    /**
     * Высота профиля (%)
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Tyres\Profile\Height", inversedBy="tyres")
     */
    private $heights;

    /**
     * Посадочный диаметр (мм)
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Tyres\Profile\Diameter", inversedBy="tyres")
     */
    private $diameters;

    /**
     * Количество
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Tyres\Profile\Count", inversedBy="tyres")
     */
    private $counts;

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
     * Производитель
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Tyres\Model", inversedBy="tyres")
     */
    private $models;

    /**
     * Состояние.
     * Один из вариантов 0 => Любая, 1 => Контрактная (б/у), 2 => Новая
     *
     * @ORM\Column(type="integer")
     */
    private $status;

    /**
     * Наличие.
     * Один из вариантов 0 => Все, 1 => Под заказ, 2 => В наличии
     *
     * @ORM\Column(type="integer")
     */
    private $availability;

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

    /**
     * @return Width
     */
    public function getWidths()
    {
        return $this->widths;
    }

    public function setWidths($widths)
    {
        $this->widths = $widths;
    }

    /**
     * @return Height
     */
    public function getHeights()
    {
        return $this->heights;
    }

    public function setHeights($heights)
    {
        $this->heights = $heights;
    }

    /**
     * @return Diameter
     */
    public function getDiameters()
    {
        return $this->diameters;
    }

    public function setDiameters($diameters)
    {
        $this->diameters = $diameters;
    }

    /**
     * @return Count
     */
    public function getCounts()
    {
        return $this->counts;
    }

    public function setCounts($counts)
    {
        $this->counts = $counts;
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

    public function getStatus()
    {
        return $this->status;
    }

    public function setStatus($status)
    {
        $this->status = $status;
    }

    public function getAvailability()
    {
        return $this->availability;
    }

    public function setAvailability($availability)
    {
        $this->availability = $availability;
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