<?php

namespace App\Entity\Parts;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\Parts\PartRepository")
 * @ORM\Table(name="part", schema="parts")
 */
class Part
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
     * @ORM\ManyToMany(targetEntity="App\Entity\Parts\Engine", inversedBy="parts")
     * @ORM\JoinTable(name="parts_engines", schema="parts")
     */
    private $engines;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Parts\Oem", mappedBy="parts")
     */
    private $oem;

    public function __construct()
    {
        $this->models  = new ArrayCollection();
        $this->engines = new ArrayCollection();
    }

    public function addEngine(Engine $engine): self
    {
        if (!$this->engines->contains($engine)) {
            $this->engines->add($engine);
            $engine->addPart($this);
        }

        return $this;
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

    public function setEngines($engines)
    {
        $this->engines = $engines;
    }

    /**
     * @return Oem
     */
    public function getOem()
    {
        return $this->oem;
    }

    public function setOem($oem)
    {
        $this->oem = $oem;
    }

    public function getId()
    {
        return $this->id;
    }
}