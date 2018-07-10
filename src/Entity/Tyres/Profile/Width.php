<?php

namespace App\Entity\Tyres\Profile;

use Doctrine\ORM\Mapping as ORM;

/**
 * Ширина профиля
 *
 * @ORM\Entity
 * @ORM\Table(name="width", schema="tyres")
 */
class Width
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
     * @ORM\OneToMany(targetEntity="App\Entity\Tyres\Tyre", mappedBy="widths")
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
}