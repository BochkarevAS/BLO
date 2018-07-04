<?php

namespace App\Entity\Tyres;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Производитель
 *
 * @ORM\Entity
 * @ORM\Table(name="vendor", schema="tyres")
 */
class Vendor
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
     * @ORM\ManyToMany(targetEntity="App\Entity\Tyres\Tyre", mappedBy="vendors")
     */
    private $tyres;

    public function __construct()
    {
        $this->tyres = new ArrayCollection();
    }

    public function getTyres()
    {
        return $this->tyres;
    }

    public function addTyres(Tyre $tyres): self
    {
        if (!$this->tyres->contains($tyres)) {
            $this->tyres->add($tyres);
        }

        return $this;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function __toString()
    {
        return (string) $this->getName();
    }
}