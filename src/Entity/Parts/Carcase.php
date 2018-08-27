<?php

namespace App\Entity\Parts;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\Parts\CarcaseRepository")
 * @ORM\Table(name="carcase", schema="part")
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
     * @ORM\ManyToMany(targetEntity="App\Entity\Parts\Model", mappedBy="carcases")
     */
    private $models;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Parts\Model", mappedBy="carcases")
     */
    private $engines;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Parts\Part", mappedBy="carcases", fetch="EXTRA_LAZY")
     */
    private $parts;

    public function __construct()
    {
        $this->parts   = new ArrayCollection();
        $this->models  = new ArrayCollection();
        $this->engines = new ArrayCollection();
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return ArrayCollection|Model[]
     */
    public function getModels()
    {
        return $this->models;
    }

    public function addModels(Model $models): void
    {
        if ($this->models->contains($models)) {
            return;
        }

        $this->models[] = $models;
    }

    public function removeModels(Model $model)
    {
        if (!$this->models->contains($model)) {
            return;
        }

        $this->models->removeElement($this);
    }

    /**
     * @return ArrayCollection|Part[]
     */
    public function getParts()
    {
        return $this->parts;
    }

    public function addParts(Part $part)
    {
        if ($this->parts->contains($part)) {
            return;
        }

        $this->parts[] = $part;
    }

    public function removeParts(Part $part)
    {
        $this->parts->removeElement($part);
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