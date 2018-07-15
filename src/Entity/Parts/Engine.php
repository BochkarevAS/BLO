<?php

namespace App\Entity\Parts;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="engine", schema="parts")
 */
class Engine
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
     * @ORM\OneToMany(targetEntity="App\Entity\Parts\Oem", mappedBy="parts")
     */
    private $oem;

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getOem()
    {
        return $this->oem;
    }

    public function setOem($oem)
    {
        $this->oem = $oem;
    }

    public function __toString()
    {
        return (string) $this->getName();
    }
}