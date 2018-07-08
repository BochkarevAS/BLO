<?php

namespace App\Entity\Parts;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\Parts\CarcaseRepository")
 * @ORM\Table(name="carcase", schema="parts")
 */
class Carcase
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
     * @ORM\ManyToOne(targetEntity="App\Entity\Parts\Model", inversedBy="carcase")
     */
    private $models;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Parts\Part", mappedBy="carcases")
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

    public function getModels()
    {
        return $this->models;
    }

    public function setModels($models)
    {
        $this->models = $models;
    }

    public function addPart(Part $parts): self
    {
        if (!$this->parts->contains($parts)) {
            $this->parts->add($parts);
        }

        return $this;
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