<?php

namespace App\Entity\Parts;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinTable;

/**
 * @ORM\Entity(repositoryClass="App\Repository\Part\CarcaseRepository")
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
     * @ORM\ManyToMany(targetEntity="App\Entity\Parts\Engine")
     * @JoinTable(name="carcases_engines", schema="part")
     */
    private $engines;

    public function __construct()
    {
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
     * @return ArrayCollection|Engine[]
     */
    public function getEngines()
    {
        return $this->engines;
    }

    public function addEngines(Engine $engine)
    {
        if ($this->engines->contains($engine)) {
            return;
        }

        $this->engines[] = $engine;
    }

    public function removeEngines(Engine $engine)
    {
        if (!$this->engines->contains($engine)) {
            return;
        }

        $this->engines->removeElement($this);
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

    public function getId()
    {
        return $this->id;
    }

    public function __toString()
    {
        return (string) $this->getName();
    }
}