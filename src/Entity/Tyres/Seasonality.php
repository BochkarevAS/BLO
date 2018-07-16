<?php

namespace App\Entity\Tyres;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="seasonality", schema="tyres")
 */
class Seasonality
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
     * @ORM\OneToMany(targetEntity="App\Entity\Tyres\Tyre", mappedBy="seasonality")
     */
    private $tyres;

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getTyres()
    {
        return $this->tyres;
    }

    public function setTyre($tyres)
    {
        $this->tyres = $tyres;
    }

    public function getId()
    {
        return $this->id;
    }
}