<?php

namespace App\Entity\Drives;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity
 * @ORM\Table(name="drive", schema="drives")
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
     * Диамитер
     *
     * @ORM\Column(type="float")
     */
    private $diameter;

    /**
     * Вылет
     *
     * @ORM\Column(type="float")
     */
    private $departure;

    /**
     * Сверловка
     *
     * @ORM\Column(type="string")
     */
    private $drilling;

    /**
     * Ширина
     *
     * @ORM\Column(type="float")
     */
    private $width;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Drives\Brand", inversedBy="drive")
     */
    private $brands;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Drives\Brand", inversedBy="drive")
     */
    private $models;


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

    public function getBrands()
    {
        return $this->brands;
    }

    public function setBrands($brands): void
    {
        $this->brands = $brands;
    }

    public function getModels()
    {
        return $this->models;
    }

    public function setModels($models): void
    {
        $this->models = $models;
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