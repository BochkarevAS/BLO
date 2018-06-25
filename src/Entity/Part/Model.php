<?php

namespace App\Entity\Part;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

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
     * @ORM\ManyToOne(targetEntity="App\Entity\Part\Brand", inversedBy="models", cascade={"persist"}, fetch="EAGER")
     */
    private $brand;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Part\Carcase", inversedBy="models", fetch="EAGER")
     * @ORM\JoinTable(name="model_carcase", schema="part")
     */
    private $carcases;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Part\Engine", inversedBy="models", fetch="EAGER")
     * @ORM\JoinTable(name="model_engine", schema="part")
     */
    private $engines;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Part\Part", inversedBy="models", fetch="EAGER")
     * @ORM\JoinTable(name="model_part", schema="part")
     */
    private $parts;

    /**
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime", name="created_at")
     */
    private $createdAt;

    /**
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime", name="updated_at")
     */
    private $updatedAt;

    public function __construct()
    {
        $this->engines  = new ArrayCollection();
        $this->carcases = new ArrayCollection();
        $this->parts    = new ArrayCollection();
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

    public function addCarcase(Carcase $carcase)
    {
        if ($this->carcases->contains($carcase)) {
            return;
        }

        $this->carcases->add($carcase);
        $carcase->addModel($this);
    }

    public function removeEngine(Engine $engine)
    {
        $this->engines->removeElement($engine);
    }

    public function removePart(Part $part)
    {
        $this->parts->removeElement($part);
    }

    public function removeCarcase(Carcase $carcase)
    {
        $this->carcases->removeElement($carcase);
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

    public function setEngines($engine)
    {
        $this->engines = $engine;
    }

    /**
     * @return ArrayCollection|Part[]
     */
    public function getParts()
    {
        return $this->parts;
    }

    public function setParts($parts)
    {
        $this->parts = $parts;
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
     * @return ArrayCollection|Carcase[]
     */
    public function getCarcases()
    {
        return $this->carcases;
    }

    public function setCarcases($carcases)
    {
        $this->carcases = $carcases;
    }

    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function getUpdatedAt()
    {
        return $this->updatedAt;
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