<?php

namespace App\Entity\Tyres;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="model", schema="tyres")
 */
class Model
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
     * @ORM\ManyToOne(targetEntity="App\Entity\Tyres\Brand", inversedBy="models")
     */
    private $brand;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Tyres\Tyre", mappedBy="models")
     */
    private $tyres;

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getBrand()
    {
        return $this->brand;
    }

    public function setBrand($brand)
    {
        $this->brand = $brand;
    }

    public function getTyres()
    {
        return $this->tyres;
    }

    public function setTyres($tyres)
    {
        $this->tyres = $tyres;
    }

    public function getId()
    {
        return $this->id;
    }
}