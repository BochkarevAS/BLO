<?php

namespace App\Entity\Parts;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\Part\EngineRepository")
 * @ORM\Table(name="engine", schema="part")
 */
class Engine
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
     * @ORM\ManyToMany(targetEntity="App\Entity\Parts\Part", mappedBy="engines")
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
        if (!$this->parts->contains($part)) {
            return;
        }

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