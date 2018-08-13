<?php

namespace App\Entity\Parts;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinTable;

/**
 * @ORM\Entity(repositoryClass="App\Repository\Parts\ModelRepository")
 * @ORM\Table(name="model", schema="parts")
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
     * @ORM\Column(type="integer")
     */
    private $rank;

    /**
     * @ORM\Column(type="string")
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Parts\Brand", inversedBy="models")
     */
    private $brand;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Parts\Carcase", mappedBy="models")
     * @JoinTable(name="models_carcases", schema="parts")
     */
    private $carcases;

    public function __construct()
    {
        $this->carcases = new ArrayCollection();
    }

    public function getRank()
    {
        return $this->rank;
    }

    public function setRank($rank): void
    {
        $this->rank = $rank;
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
     * @return ArrayCollection|Carcase[]
     */
    public function getCarcases()
    {
        return $this->carcases;
    }

    public function addCarcase(Carcase $carcase)
    {
        if ($this->carcases->contains($carcase)) {
            return;
        }

        $this->carcases[] = $carcase;
        $carcase->setModels($this);
    }

    public function removeCarcase(Carcase $carcase)
    {
        if (!$this->carcases->contains($carcase)) {
            return;
        }

        $this->carcases->removeElement($carcase);
        $carcase->setModels(null);
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