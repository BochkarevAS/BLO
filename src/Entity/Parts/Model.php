<?php

namespace App\Entity\Parts;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinTable;

/**
 * @ORM\Entity(repositoryClass="App\Repository\Part\ModelRepository")
 * @ORM\Table(name="model", schema="part")
 */
class Model
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
     * @ORM\ManyToOne(targetEntity="App\Entity\Parts\Brand", inversedBy="models")
     */
    private $brand;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Parts\Frame", inversedBy="models")
     * @JoinTable(name="models_frames", schema="part")
     */
    private $frames;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Parts\Engine", inversedBy="models")
     * @JoinTable(name="models_engines", schema="part")
     */
    private $engines;

    public function __construct()
    {
        $this->frames  = new ArrayCollection();
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

    public function getBrand()
    {
        return $this->brand;
    }

    public function setBrand($brand)
    {
        $this->brand = $brand;
    }

    /**
     * @return ArrayCollection|Frame[]
     */
    public function getFrames()
    {
        return $this->frames;
    }

    public function addFrame(Frame $frame)
    {
        if ($this->frames->contains($frame)) {
            return;
        }

        $this->frames[] = $frame;
    }

    public function removeFrame(Frame $frame)
    {
        if (!$this->frames->contains($frame)) {
            return;
        }

        $this->frames->removeElement($frame);
    }

    /**
     * @return ArrayCollection|Model[]
     */
    public function getEngines()
    {
        return $this->engines;
    }

    public function addEngine(Engine $engine)
    {
        if ($this->engines->contains($engine)) {
            return;
        }

        $this->engines[] = $engine;
    }

    public function removeEngine(Engine $engine)
    {
        if (!$this->engines->contains($engine)) {
            return;
        }

        $this->engines->removeElement($engine);
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