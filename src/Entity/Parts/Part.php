<?php

namespace App\Entity\Parts;

use App\Entity\Region\City;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

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
     * @ORM\ManyToMany(targetEntity="App\Entity\Parts\Model", inversedBy="parts")
     * @ORM\JoinTable(name="parts_models", schema="parts")
     */
    private $models;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Parts\Oem", mappedBy="parts")
     */
    private $oem;

    private $city;

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
        $this->models   = new ArrayCollection();
        $this->engines  = new ArrayCollection();
    }

    public function addModel(Model $model): self
    {
        if (!$this->models->contains($model)) {
            $this->models->add($model);
            $model->addPart($this);
        }

        return $this;
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
     * @return ArrayCollection|Model[]
     */
    public function getModels()
    {
        return $this->models;
    }

    public function setModels($models)
    {
        $this->models = $models;
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
     * @return ArrayCollection|Oem
     */
    public function getOem()
    {
        return $this->oem;
    }

    public function setOem($oem)
    {
        $this->oem = $oem;
    }

    /**
     * @return City
     */
    public function getCity()
    {
        return $this->city;
    }

    public function setCity($city)
    {
        $this->city = $city;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }
}