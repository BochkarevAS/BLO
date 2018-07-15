<?php

namespace App\Entity\Parts;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass="App\Repository\Parts\OemRepository")
 * @ORM\Table(name="oem", schema="parts")
 */
class Oem
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     */
    private $name;

    /**
     * Производитель
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Parts\Brand", inversedBy="oem")
     */
    private $brands;

    /**
     * Модель автомобиля
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Parts\Model", inversedBy="oem")
     */
    private $models;

    /**
     * Модель автомобиля
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Parts\Carcase", inversedBy="oem")
     */
    private $carcases;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Parts\Part", inversedBy="oem")
     */
    private $parts;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Region\City", inversedBy="oem")
     */
    private $citys;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Client\Vendor", inversedBy="oem")
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

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getBrands()
    {
        return $this->brands;
    }

    public function setBrands($brands)
    {
        $this->brands = $brands;
    }

    public function getModels()
    {
        return $this->models;
    }

    public function setModels($models)
    {
        $this->models = $models;
    }

    public function getCarcases()
    {
        return $this->carcases;
    }

    public function setCarcases($carcases)
    {
        $this->carcases = $carcases;
    }

    public function getParts()
    {
        return $this->parts;
    }

    public function setParts($parts)
    {
        $this->parts = $parts;
    }

    public function getCitys()
    {
        return $this->citys;
    }

    public function setCitys($citys)
    {
        $this->citys = $citys;
    }

    public function getVendors()
    {
        return $this->vendors;
    }

    public function setVendors($vendors)
    {
        $this->vendors = $vendors;
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