<?php

namespace App\Entity\Tyres;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity
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
     * @ORM\Column(type="integer")
     */
    private $width;

    /**
     * @ORM\Column(type="integer")
     */
    private $height;

    /**
     * @ORM\Column(type="integer")
     */
    private $diameter;

    /**
     * @ORM\Column(type="integer")
     */
    private $count;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Tyres\Thorn", inversedBy="tyre"))
     */
    private $thorns;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Tyres\Seasonality", inversedBy="tyre")
     */
    private $seasonalitys;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Tyres\Manufacturer", inversedBy="tyre")
     */
    private $manufacturers;

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

    public function getThorns()
    {
        return $this->thorns;
    }

    public function setThorns($thorns)
    {
        $this->thorns = $thorns;
    }

    public function getManufacturers()
    {
        return $this->manufacturers;
    }

    public function setManufacturers($manufacturers)
    {
        $this->manufacturers = $manufacturers;
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