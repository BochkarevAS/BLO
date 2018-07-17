<?php

namespace App\Entity\Parts;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="oem", schema="parts")
 */
class Oem
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
     * @ORM\OneToMany(targetEntity="App\Entity\Parts\Part", mappedBy="oem")
     */
    private $parts;

    public function getName()
    {
        return $this->name;
    }

    public function setName($name): void
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
}