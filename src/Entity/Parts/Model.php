<?php

namespace App\Entity\Parts;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\Parts\ModelRepository")
 * @ORM\Table(name="model", schema="parts")
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
     * @ORM\ManyToOne(targetEntity="App\Entity\Parts\Brand", inversedBy="model")
     */
    private $brands;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Parts\Carcase", mappedBy="models")
     */
    private $carcase;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Parts\Part", mappedBy="models")
     */
    private $parts;

    public function __construct()
    {
        $this->parts = new ArrayCollection();
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function addPart(Part $parts): self
    {
        if (!$this->parts->contains($parts)) {
            $this->parts->add($parts);
        }

        return $this;
    }

    public function getBrands()
    {
        return $this->brands;
    }

    public function setBrands($brands)
    {
        $this->brands = $brands;
    }

    public function getCarcase()
    {
        return $this->carcase;
    }

    public function setCarcase($carcase)
    {
        $this->carcase = $carcase;
    }

    public function getId()
    {
        return $this->id;
    }

    public function __toString()
    {
        return (string) $this->getName();
    }
}