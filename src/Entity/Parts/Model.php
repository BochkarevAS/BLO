<?php

namespace App\Entity\Parts;

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
     * @ORM\ManyToOne(targetEntity="App\Entity\Parts\Brand", inversedBy="models")
     */
    private $brand;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Parts\Carcase", mappedBy="model")
     */
    private $carcases;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Parts\Part", mappedBy="model")
     */
    private $parts;

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

    public function setParts($parts): void
    {
        $this->parts = $parts;
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