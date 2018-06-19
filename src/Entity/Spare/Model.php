<?php

namespace App\Entity\Spare;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\Spare\ModelRepository")
 * @ORM\Table(name="model", schema="spare")
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
     * @ORM\ManyToOne(targetEntity="App\Entity\Spare\Mark", inversedBy="models")
     */
    private $mark;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Spare\Engine", inversedBy="models")
     * @ORM\JoinTable(name="model_engine", schema="spare")
     */
    private $engines;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Spare\SparePart", inversedBy="models")
     * @ORM\JoinTable(name="model_spare", schema="spare")
     */
    private $spareParts;

    public function __construct()
    {
        $this->engines = new ArrayCollection();
        $this->spareParts = new ArrayCollection();
    }

    public function addEngine(Engine $engine)
    {
        if ($this->engines->contains($engine)) {
            return;
        }

        $this->engines->add($engine);
        $engine->addModel($this);
    }

    public function addSparePart(SparePart $sparePart)
    {
        if ($this->spareParts->contains($sparePart)) {
            return;
        }

        $this->spareParts->add($sparePart);
        $sparePart->addModel($this);
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

    public function getSpareParts()
    {
        return $this->spareParts;
    }

    public function setSpareParts($spareParts)
    {
        $this->spareParts = $spareParts;
    }

    public function getMark()
    {
        return $this->mark;
    }

    public function setMark($mark)
    {
        $this->mark = $mark;
    }
}