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
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     */
    private $name;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Parts\Model", mappedBy="engines")
     */
    private $models;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Parts\Frame", mappedBy="engines")
     */
    private $frames;

    public function __construct()
    {
        $this->models = new ArrayCollection();
        $this->frames = new ArrayCollection();
    }

    /**
     * @return ArrayCollection|Model[]
     */
    public function getModels()
    {
        return $this->models;
    }

    /**
     * @return ArrayCollection|Frame[]
     */
    public function getFrames()
    {
        return $this->frames;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getId()
    {
        return $this->id;
    }

    public function __toString()
    {
        return (string) $this->getName();
    }

    public function getNameSuggest()
    {
        return [
            'input' => trim($this->getName())
        ];
    }

    public function getOutput()
    {
        return trim($this->getName());
    }
}