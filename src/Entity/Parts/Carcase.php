<?php

namespace App\Entity\Parts;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\Parts\CarcaseRepository")
 * @ORM\Table(name="carcase", schema="parts")
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
     * @ORM\ManyToOne(targetEntity="App\Entity\Parts\Model", inversedBy="carcases")
     */
    private $model;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Parts\Part", mappedBy="carcase")
     */
    private $parts;

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getModel()
    {
        return $this->model;
    }

    public function setModel($model)
    {
        $this->model = $model;
    }

    public function getParts()
    {
        return $this->parts;
    }

    public function setParts($parts): void
    {
        $this->parts = $parts;
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