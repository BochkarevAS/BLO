<?php

namespace App\Entity\Parts;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\Parts\PartRepository")
 * @ORM\Table(name="part_name", schema="parts")
 */
class PartName
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
     * @ORM\OneToMany(targetEntity="App\Entity\Parts\Part", mappedBy="part")
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
}