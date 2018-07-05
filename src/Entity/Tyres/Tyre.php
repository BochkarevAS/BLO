<?php

namespace App\Entity\Tyres;

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
    private $count;

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
     * @ORM\ManyToOne(targetEntity="App\Entity\Tyres\Manufacturer", inversedBy="tyre")
     */
    private $manufacturers;

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

    public function getCount()
    {
        return $this->count;
    }

    public function setCount($count)
    {
        $this->count = $count;
    }

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
     * @return Manufacturer
     */
    public function getManufacturers()
    {
        return $this->manufacturers;
    }

    public function setManufacturers($manufacturers)
    {
        $this->manufacturers = $manufacturers;
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

    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }
}