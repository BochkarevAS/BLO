<?php

namespace App\Entity\Part;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\Part\ModelRepository")
 * @ORM\Table(name="model", schema="part")
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
     * @ORM\ManyToOne(targetEntity="App\Entity\Part\Brand", inversedBy="models")
     */
    private $brands;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Part\Engine", inversedBy="models")
     * @ORM\JoinTable(name="model_engine", schema="part")
     */
    private $engines;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Part\Part", inversedBy="models")
     * @ORM\JoinTable(name="model_part", schema="part")
     */
    private $parts;

    public function __construct()
    {
        $this->engines = new ArrayCollection();
        $this->parts = new ArrayCollection();
    }

    public function addEngine(Engine $engine)
    {
        if ($this->engines->contains($engine)) {
            return;
        }

        $this->engines->add($engine);
        $engine->addModel($this);
    }

    public function addPart(Part $part)
    {
        if ($this->parts->contains($part)) {
            return;
        }

        $this->parts->add($part);
        $part->addModel($this);
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getEngines()
    {
        return $this->engines;
    }

    public function setEngines($engine)
    {
        $this->engines = $engine;
    }

    public function getParts()
    {
        return $this->parts;
    }

    public function setParts($parts)
    {
        $this->parts = $parts;
    }

    public function getBrands()
    {
        return $this->brands;
    }

    public function setBrands($brands)
    {
        $this->brands = $brands;
    }
}