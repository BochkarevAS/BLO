<?php

namespace App\Entity\Tyres\Profile;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="diameter", schema="tyres")
 */
class Diameter
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="float")
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Tyres\Tyre", mappedBy="diameters")
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

    public function setTyres($tyres)
    {
        $this->tyres = $tyres;
    }

    public function getId()
    {
        return $this->id;
    }
}