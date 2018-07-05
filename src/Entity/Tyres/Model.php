<?php

namespace App\Entity\Tyres;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="model", schema="tyres")
 */
class Model
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
     * @ORM\ManyToOne(targetEntity="App\Entity\Tyres\Manufacturer", inversedBy="model")
     */
    private $manufacturers;

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getManufacturers()
    {
        return $this->manufacturers;
    }

    public function setManufacturers($manufacturers)
    {
        $this->manufacturers = $manufacturers;
    }
}