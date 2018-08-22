<?php

namespace App\Entity\Parts;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinTable;

/**
 * @ORM\Entity(repositoryClass="App\Repository\Parts\CarcaseRepository")
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
     * @ORM\ManyToMany(targetEntity="App\Entity\Parts\Model", inversedBy="carcases")
     * @JoinTable(name="models_carcases", schema="part")
     */
    private $models;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Parts\Part", mappedBy="carcases", fetch="EXTRA_LAZY")
     * @JoinTable(name="parts_carcases", schema="part")
     */
    private $parts;

    public function __construct()
    {
        $this->parts = new ArrayCollection();
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getModels()
    {
        return $this->models;
    }

    public function setModels($models)
    {
        $this->models = $models;
    }

    public function getParts()
    {
        return $this->parts;
    }

    public function setParts($parts): void
    {
        $this->parts[] = $parts;
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