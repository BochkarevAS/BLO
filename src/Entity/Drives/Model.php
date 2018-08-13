<?php

namespace App\Entity\Drives;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="model", schema="drives")
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
     * @ORM\OneToMany(targetEntity="App\Entity\Drives\Drive", mappedBy="models")
     */
    private $drive;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Drives\Brand", inversedBy="model")
     */
    private $brands;

    public function getName()
    {
        return $this->name;
    }

    public function setName($name): void
    {
        $this->name = $name;
    }

    public function getDrive()
    {
        return $this->drive;
    }

    public function setDrive($drive): void
    {
        $this->drive = $drive;
    }

    public function getBrands()
    {
        return $this->brands;
    }

    public function setBrands($brands): void
    {
        $this->brands = $brands;
    }
}