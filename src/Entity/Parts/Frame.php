<?php

namespace App\Entity\Parts;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinTable;

/**
 * @ORM\Entity(repositoryClass="App\Repository\Part\FrameRepository")
 * @ORM\Table(name="frame", schema="part")
 */
class Frame
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
     * @ORM\ManyToMany(targetEntity="App\Entity\Parts\Model", mappedBy="frames")
     */
    private $models;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Parts\Engine", inversedBy="frames")
     * @JoinTable(name="frames_engines", schema="part")
     */
    private $engines;

    public function __construct()
    {
        $this->engines = new ArrayCollection();
        $this->models  = new ArrayCollection();
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

        $this->engines->removeElement($this);
    }

    /**
     * @return ArrayCollection|Model[]
     */
    public function getModels()
    {
        return $this->models;
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

    public function getId()
    {
        return $this->id;
    }

    public function __toString()
    {
        return (string) $this->getName();
    }
}