<?php

namespace App\Entity\Tyres;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="thorn", schema="tyres")
 */
class Thorn
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
     * @ORM\OneToMany(targetEntity="App\Entity\Tyres\Tyre", mappedBy="thorns")
     */
    private $tyre;

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getTyre()
    {
        return $this->tyre;
    }

    public function setTyre($tyre)
    {
        $this->tyre = $tyre;
    }
}